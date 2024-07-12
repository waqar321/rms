import pandas as pd
from datetime import datetime, timedelta
from urllib.parse import quote_plus
import sqlalchemy
from sqlalchemy.exc import OperationalError
from concurrent.futures import ThreadPoolExecutor
import time

# Connect to the MySQL database (huawei)
password = 'Leop@4321#*'
encoded_password = quote_plus(password)
engine = sqlalchemy.create_engine(
    f'mysql+pymysql://root:{encoded_password}@94.74.92.97:3313',
    pool_recycle=3600,
    pool_timeout=3000,
    connect_args={'connect_timeout': 3000}
)

# Get the records from codlive
query = f"""SELECT
            tbl_lcs_booked_packet.booked_packet_id AS id,
            tbl_lcs_booked_packet.origin_city,
            tbl_lcs_booked_packet.destination_city,
            tbl_lcs_booked_packet.company_id AS merchant_id,
            tbl_lcs_booked_packet.consignment_id AS consignee_id,
            tbl_lcs_booked_packet.shipment_id AS shipper_id,
            tbl_lcs_booked_packet.booked_packet_order_id,
            tbl_lcs_booked_packet.added_by,
            tbl_lcs_booked_packet.tbl_lcs_admin_user_admin_user_id AS admin_user_id,
            tbl_lcs_booked_packet.cod_zone_id,
            tbl_lcs_booked_packet.booking_type_id,
            tbl_lcs_booked_packet.shipment_type_id,
            tbl_lcs_booked_packet.pickup_batch_id,
            tbl_lcs_booked_packet.courier_id,
            tbl_lcs_booked_packet.dispatch_date,
            tbl_lcs_booked_packet.booked_packet_date,
            tbl_lcs_booked_packet.booked_packet_option,
            tbl_lcs_booked_packet.booked_packet_cn,
            tbl_lcs_booked_packet.cn_short,
            tbl_lcs_booked_packet.loadsheet_weight AS pickup_weight,
            tbl_lcs_booked_packet.arival_dispatch_weight,
            tbl_lcs_booked_packet.arival_dispatch_weight_date,
            tbl_lcs_booked_packet.booked_packet_weight,
            tbl_lcs_booked_packet.booked_packet_vol_weight,
            tbl_lcs_booked_packet.booked_packet_vol_weight_cal,
            tbl_lcs_booked_packet.booked_packet_no_piece,
            tbl_lcs_booked_packet.booked_packet_collect_amount,
            tbl_lcs_booked_packet.is_cancel,
            tbl_lcs_booked_packet.is_cron_cancel,
            tbl_lcs_booked_packet.booked_packet_comments,
            tbl_lcs_booked_packet.shipper_copy_count,
            tbl_lcs_booked_packet.account_copy_count,
            tbl_lcs_booked_packet.label_count,
            tbl_lcs_booked_packet.booked_packet_status,
            #tbl_lcs_status.code,
            tbl_lcs_booked_packet.packet_received_by,
            tbl_lcs_booked_packet.cancel_reason,
            tbl_lcs_booked_packet.canceled_by,
            tbl_lcs_booked_packet.return_reason,
            tbl_lcs_booked_packet.payment_received,
            tbl_lcs_booked_packet.date_return,
            tbl_lcs_booked_packet.return_by,
            tbl_lcs_booked_packet.batch_no,
            tbl_lcs_booked_packet.is_paid,
            tbl_lcs_booked_packet.invoice_cheque_no,
            tbl_lcs_booked_packet.invoice_cheque_date,
            tbl_lcs_booked_packet.is_valid,
            tbl_lcs_booked_packet.is_duplicate,
            tbl_lcs_booked_packet.delivery_date,
            tbl_lcs_booked_packet.booked_packet_charges,
            tbl_lcs_booked_packet.packet_charges,
            tbl_lcs_booked_packet.booked_packet_gst,
            tbl_lcs_booked_packet.fuel_factor_petrol,
            tbl_lcs_booked_packet.fuel_factor_diesel,
            tbl_lcs_booked_packet.fuel_factor_jet,
            tbl_lcs_booked_packet.fuel_sercg_charges,
            tbl_lcs_booked_packet.vendor_pickup_charges,
            tbl_lcs_booked_packet.cash_handling_charges,
            tbl_lcs_booked_packet.return_charges,
            tbl_lcs_booked_packet.vendor_pickup_status,
            tbl_lcs_booked_packet.vendor_picked,
            tbl_lcs_booked_packet.vendor_flg,
            tbl_lcs_booked_packet.prepaid_cod,
            tbl_lcs_booked_packet.push_msm,
            tbl_lcs_booked_packet.reciever_relation,
            tbl_lcs_booked_packet.courier_received_amount,
            tbl_lcs_booked_packet.courier_payment_amount,
            tbl_lcs_booked_packet.deposit_slip,
            tbl_lcs_booked_packet.insurance_amount,
            tbl_lcs_booked_packet.shipper_advice,
            tbl_lcs_booked_packet.original_amount,
            tbl_lcs_booked_packet.is_child,
            tbl_lcs_booked_packet.status_update_date,
            tbl_lcs_booked_packet.amount_modified_by,
            tbl_lcs_booked_packet.amount_modified_at,
            tbl_lcs_booked_packet.amount_change_remarks,
            tbl_lcs_booked_packet.status_update_guid,
            tbl_lcs_booked_packet.current_city,
            tbl_lcs_booked_packet.is_special_tariff,
            tbl_lcs_booked_packet.return_address,
            tbl_lcs_booked_packet.return_city,
            tbl_lcs_booked_packet.pay_without_payment_received,
            tbl_lcs_booked_packet.custom_data,
            tbl_lcs_booked_packet.is_active,
            tbl_lcs_booked_packet.date_created AS created_at,
            tbl_lcs_booked_packet.date_modified AS updated_at,
            tbl_lcs_booked_packet.is_delete AS is_deleted
            FROM
            CODLive.tbl_lcs_booked_packet
            WHERE tbl_lcs_booked_packet.booked_packet_date BETWEEN '2023-06-01 00:00:00' AND '2023-12-01 00:00:00'
            AND tbl_lcs_booked_packet.booked_packet_id NOT IN(SELECT id FROM `ecom-stage`.`ecom_bookings`)
            ORDER BY tbl_lcs_booked_packet.booked_packet_date
            LIMIT 10 OFFSET 3500001"""
try:
    with engine.connect() as connection:
        df = pd.read_sql(query, connection)
        print(len(df))

except Exception as e:
    print(f"Error executing SELECT query: {e}")
    df = pd.DataFrame()