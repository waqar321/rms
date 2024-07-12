DELIMITER $$

DROP FUNCTION IF EXISTS `calc_packet_charges_new`$$

CREATE FUNCTION `calc_packet_charges_new`(_company_id BIGINT(20), _booked_packet_cn VARCHAR(20), _booked_packet_status INT, _booked_packet_collect_amount FLOAT, _packet_weight FLOAT, _shipment_type_id INT, _origin_city INT, _destination_city INT, _booked_packet_date DATE) RETURNS VARCHAR(255) CHARSET latin1
BEGIN

    DECLARE __tariff_id BIGINT;
    DECLARE __origin_province INT;
    DECLARE __destination_province INT;
    DECLARE __tariff_details_id INT;
    DECLARE __tariff_to_weight FLOAT DEFAULT 0;
    DECLARE __tariff_packed_weight_rate FLOAT DEFAULT 0;
    DECLARE __return_status INT;
    DECLARE __return_fixed_charges FLOAT DEFAULT 0;
    DECLARE __additional_weight FLOAT DEFAULT 0;
    DECLARE __additional_rate FLOAT DEFAULT 0;

    DECLARE __return_amount_fix FLOAT DEFAULT 0;
    DECLARE __shipment_charges FLOAT DEFAULT 0;

    DECLARE __tariff_cash_handling_id BIGINT;
    DECLARE __cash_handling_charges_type VARCHAR(20);
    DECLARE __cash_handling_above_charges_type VARCHAR(30);
    DECLARE __cash_handling_above_charges_rate FLOAT DEFAULT 0;
    DECLARE __cash_handling_charges FLOAT DEFAULT 0;
    DECLARE __cash_handling_to_amount FLOAT DEFAULT 0;

    DECLARE __additional_return_amount FLOAT DEFAULT 0;

    DECLARE __insurance_enable VARCHAR(10) DEFAULT 'no';
    DECLARE __insurance_type VARCHAR(30);
    DECLARE __insurance_above_type VARCHAR(30);
    DECLARE __insurance_above_rate FLOAT DEFAULT 0;
    DECLARE __insurance_charges FLOAT DEFAULT 0;

    DECLARE __company_gst_per FLOAT DEFAULT 0;
    DECLARE __fuel_sercg_per FLOAT DEFAULT 0;
    DECLARE __distance_id INT;

    SET __shipment_charges = 0;
    SET __cash_handling_charges = 0;
    SET __insurance_charges = 0;
    SET __return_amount_fix = 0;
    SET __company_gst_per = 0;
    SET __fuel_sercg_per = 0;
    SET __distance_id = 3;

    -- get tariff_id
    SELECT
        tariff_id, insurance_enable, insurance_type, insurance_above_type, insurance_above_rate,
        company_gst_per, fuel_sercg_per
        INTO __tariff_id, __insurance_enable, __insurance_type,
        __insurance_above_type, __insurance_above_rate,
		__company_gst_per, __fuel_sercg_per
    FROM tbl_lcs_cod_tariff
    WHERE company_id = _company_id
    AND applicable_date <= _booked_packet_date
    ORDER BY applicable_date DESC
    LIMIT 1;

    IF __tariff_id != '' THEN

        -- if Origin and destination cities are same then fetch only one time
        IF _origin_city = _destination_city THEN

          SET __distance_id = 1;
            -- get province IDs of origin and destination cities
            SELECT
                tbl_lcs_state_state_id AS origin_pr,
                tbl_lcs_state_state_id AS destination_pr INTO __origin_province, __destination_province
            FROM tbl_lcs_city
            WHERE city_id = _origin_city;

        ELSE

            -- get origin city province
            SELECT
                tbl_lcs_state_state_id INTO __origin_province
            FROM tbl_lcs_city
            WHERE city_id = _origin_city;

            -- get destination city province
            SELECT
                tbl_lcs_state_state_id INTO __destination_province
            FROM tbl_lcs_city
            WHERE city_id = _destination_city;

            IF __origin_province = __destination_province THEN
              SET __distance_id =2;
            END IF;

        END IF;

        -- is special tariff then get tariff_details_id
        SELECT
            tariff_details_id,
            additional_weight,
            additional_rate,
            IFNULL(additional_return_amount, 0) INTO __tariff_details_id, __additional_weight, __additional_rate, __additional_return_amount
        FROM tbl_lcs_cod_tariff_details
        WHERE tariff_id = __tariff_id
        AND is_active = 1
        AND special_tariff = 1
        AND shipment_type_id = _shipment_type_id
        AND (
        (origin_city = _origin_city
        AND destination_city = _destination_city
        AND origin_province = __origin_province
        AND destination_province = __destination_province)
        OR (origin_city = _origin_city
        AND destination_city = '-1'
        AND origin_province = __origin_province
        AND destination_province = __destination_province)
        OR (origin_city = _origin_city
        AND destination_city = '-1'
        AND origin_province = __origin_province
        AND destination_province = '-1')
        OR (origin_city = '-1'
        AND destination_city = _destination_city
        AND origin_province = __origin_province
        AND destination_province = __destination_province)
        OR (origin_city = '-1'
        AND destination_city = '-1'
        AND origin_province = __origin_province
        AND destination_province = __destination_province)
        OR (origin_city = '-1'
        AND destination_city = '-1'
        AND origin_province = __origin_province
        AND destination_province = '-1'))
        ORDER BY destination_city DESC, destination_province DESC
        LIMIT 1;

        IF __tariff_details_id IS NULL THEN
            -- get tariff details id from common tariff
            SELECT
                tariff_details_id,
                additional_weight,
                additional_rate,
                additional_return_amount INTO __tariff_details_id, __additional_weight, __additional_rate, __additional_return_amount
            FROM tbl_lcs_cod_tariff_details
            WHERE tariff_id = __tariff_id AND is_active = 1
            AND shipment_type_id = _shipment_type_id
            AND distance_id = __distance_id -- get_tariff_distance(_origin_city, _destination_city)
            AND special_tariff = 0;

        END IF;


        -- get packet weight rate
        SELECT
            rate,
            return_amount INTO __tariff_packed_weight_rate, __return_fixed_charges
        FROM tbl_lcs_cod_tariff_shipment_details
        WHERE tariff_detail_id = __tariff_details_id
        AND CEIL(_packet_weight) BETWEEN from_weight AND to_weight;


        IF __tariff_packed_weight_rate != '' THEN

            SET __shipment_charges = __tariff_packed_weight_rate;

            SET @isAdditional = 0;

        ELSE
            -- each additonal weight

            SET @isAdditional = 1;

            SELECT
                MAX(to_weight) AS 'to_weight',
                rate,
                return_amount INTO __tariff_to_weight, __tariff_packed_weight_rate, __return_fixed_charges
            FROM tbl_lcs_cod_tariff_shipment_details
            WHERE tariff_detail_id = __tariff_details_id
            GROUP BY to_weight
            LIMIT 1;

            SET __shipment_charges = ((CEIL((_packet_weight - __tariff_to_weight) / __additional_weight) * __additional_rate) + __tariff_packed_weight_rate);

        END IF;


        -- return charges
        IF _booked_packet_status = 7 THEN

            SET __return_amount_fix = __return_fixed_charges;
            SET __shipment_charges = __return_fixed_charges;

            IF @isAdditional = 1 THEN

                SET __shipment_charges = ((CEIL((_packet_weight - __tariff_to_weight) / __additional_weight) * __additional_return_amount) + __return_fixed_charges);

            END IF;

        END IF;

         -- cash handling - Start

        IF _booked_packet_collect_amount > 0 AND _booked_packet_status = 12 THEN

            SELECT
                tariff_cash_handling_id,
                charges_type,
                above_charges_type,
                above_charges_rate INTO __tariff_cash_handling_id, __cash_handling_charges_type, __cash_handling_above_charges_type, __cash_handling_above_charges_rate
            FROM tbl_lcs_cod_tariff_cash_handling
            WHERE tariff_id = __tariff_id;

            SET @tariff_cash_handling_detail_id = 0;

            SELECT
                rate, tariff_cash_handling_detail_id INTO __cash_handling_charges, @tariff_cash_handling_detail_id
            FROM tbl_lcs_cod_tariff_cash_handling_details
            WHERE cash_handling_id = __tariff_cash_handling_id
            AND _booked_packet_collect_amount BETWEEN from_amount AND to_amount;

            IF (__cash_handling_charges = '' OR __cash_handling_charges = 0 OR __cash_handling_charges = NULL) AND (@tariff_cash_handling_detail_id IS NULL OR @tariff_cash_handling_detail_id = '') THEN

--                 SELECT
--                     rate,
--                     to_amount INTO __cash_handling_charges, __cash_handling_to_amount
--                 FROM tbl_lcs_cod_tariff_cash_handling_details
--                 WHERE cash_handling_id = __tariff_cash_handling_id
--                 ORDER BY to_amount DESC LIMIT 1;
--
--                 IF __cash_handling_charges_type = 'Percentage' THEN
--                     SET __cash_handling_charges = (_booked_packet_collect_amount * __cash_handling_charges) / 100;
--                 END IF;

                -- IF __cash_handling_above_charges_type = 'Percentage' and (_booked_packet_collect_amount - __cash_handling_to_amount) > 0 THEN
                IF __cash_handling_above_charges_type = 'Percentage' AND __cash_handling_above_charges_rate > 0 THEN
                    -- SET __cash_handling_charges = __cash_handling_charges + (((_booked_packet_collect_amount - __cash_handling_to_amount) * __cash_handling_above_charges_rate) / 100);

                    SET __cash_handling_charges = (_booked_packet_collect_amount * __cash_handling_above_charges_rate) / 100;
                ELSE
                    SET __cash_handling_charges = __cash_handling_above_charges_rate;
                END IF;

            ELSE

                IF __cash_handling_charges_type = 'Percentage' AND __cash_handling_charges > 0 THEN
                    SET __cash_handling_charges = (_booked_packet_collect_amount * __cash_handling_charges) / 100;
                END IF;

            END IF;

            IF __cash_handling_charges > 0 THEN

                SET __shipment_charges = __shipment_charges + __cash_handling_charges;

            END IF;

        END IF;

        -- cash handling - END

        -- Insurance - Start

        IF __insurance_enable = 'yes' THEN

			SELECT
				rate
			INTO __insurance_charges FROM
				tbl_lcs_cod_tariff_insurance_details
			WHERE
				tariff_id = __tariff_id
					AND _booked_packet_collect_amount BETWEEN from_amount AND to_amount;

            IF (__insurance_charges = '' OR __insurance_charges = 0 OR __insurance_charges = NULL) THEN

				IF __insurance_above_type = 'Percentage' AND __insurance_above_rate > 0 THEN

					SET __insurance_charges = (_booked_packet_collect_amount * __insurance_above_rate) / 100;
				ELSE
					SET __insurance_charges = __insurance_above_rate;
				END IF;

			ELSE

				IF __insurance_type = 'Percentage' AND __insurance_charges > 0 THEN
					SET __insurance_charges = (_booked_packet_collect_amount * __insurance_charges) / 100;
				END IF;

			END IF;
        END IF;
    END IF;


    RETURN CONCAT(CEIL(__shipment_charges), "|", CEIL(__cash_handling_charges), "|", CEIL(__return_amount_fix), "|", CEIL(__insurance_charges), "|", CEIL(__company_gst_per), "|", CEIL(__fuel_sercg_per));
END$$

DELIMITER ;
