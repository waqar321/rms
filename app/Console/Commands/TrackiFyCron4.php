<?php

namespace App\Console\Commands;

use App\Models\Admin\CronJob;
use App\Models\Admin\ecom_bank_cn;
use App\Models\Admin\ecom_booking;
use App\Models\Admin\ecom_courier;
use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class TrackiFyCron4 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'default:trackify4';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cron_job = new CronJob();
        $cron_job->status = 1;
        $cron_job->cron_name = 'default:trackify4';
        $cron_job->created_at =  date('Y-m-d H:i:s');

        $current_date = date('Y-m-d', strtotime('-6 day'));
        $start_date = date('Y-m-d', strtotime($current_date .'-2 day'));



        for ($current = strtotime($start_date); $current <= strtotime($current_date); $current = strtotime('+1 day', $current)) {
            $current_formatted = date('Y-m-d', $current);
            $journey_start_date = date('Y-m-d', strtotime($current_formatted .'-2 day'));

//            $end_date = date('Y-m-d', strtotime('+1 day', $current));
            $end_date = $current_formatted;


            $bookedPacketList = ecom_booking::get_Trackify_Data($current_formatted,$end_date);
            $cn_shorts = $bookedPacketList->pluck('cn_short')->toArray();

            $chunkSize = 10000;
            $totalItems = count($cn_shorts);

            for ($offset = 0; $offset < $totalItems; $offset += $chunkSize) {

                $cns = array();
                $postDataByCn = array();

                $chunk = array_slice($cn_shorts, $offset, $chunkSize);
                $postData = DB::connection('oms')->table('arival as a')
                    ->select([
                        'a.CN_NUMBER as CNNumber',
                        'a.ARVL_DEST as CityId',
                        'a.COURIER_ID as CourierCode',
                        'a.COUR_DATE',
                        'a.Cour_Time',
                        'a.DELIVERY_DATE',
                        'a.DELIVERY_TIME',
                        DB::raw("a.BH_REMARKS AS CodAmount"),
                        DB::raw("IF(a.BH_REMARKS = '*NC', 1, 0) AS CnicRequired"),
                        DB::raw("IF(a.CN_TYPE IN ('C', 'D'), 1, 2) AS ProductType"),
                        'a.PCS as Pieces',
                        'a.WEIGHT'
                    ])
                    ->where('a.COUR_DATE', '>=', $journey_start_date)
                    ->whereIn('a.SHART_CN', $chunk)
                    ->where('a.STATUS', 'AC')
                    ->whereNotIn('a.BH_REMARKS', ['RT', 'RW', 'RV'])
                    ->get();
                $orderDetails1 = $orderDetails2 = $orderDetails = $cnNumbers = $generalCns = $courier_data = [];

                $prevCourier = $prevCity = 0;
                $courier_code = $postData->pluck('CourierCode')->toArray();
                $courier_code = array_map(function ($code) {
                    return str_pad($code, 5, '0', STR_PAD_LEFT);
                }, $courier_code);
                $courier_cities = $postData->pluck('CityId')->toArray();

                $courier_data = ecom_courier::getCourierDetailsByCodeAndStationID_CODNew($courier_code,$courier_cities);
                $courier_data_rider_id = $courier_data->pluck('rider_id')->toArray();
                $courier_data_branch_id = $courier_data->pluck('branch_id')->toArray();
                $courier_data_station_id = $courier_data->pluck('station_id')->toArray();
                $courier_data_station_id2 = $courier_data->pluck('station_id2')->toArray();
                $courier_data_courier_code = $courier_data->pluck('courier_code')->toArray();
                $courier_data_courier_phone = $courier_data->pluck('courier_phone')->toArray();


                $commonKeys = null;
                foreach ($postData as $key => $row) {
                    $row = (array)$row;

                    $CourierCodekey = array_keys($courier_data_courier_code, str_pad($row['CourierCode'], 5, '0', STR_PAD_LEFT));
                    $CityIdKey = array_keys($courier_data_station_id2, $row['CityId']);
                    $commonKeys = collect(array_intersect($CourierCodekey, $CityIdKey))->first();
                    $courier_data_array = array();
                    if(isset($courier_data_rider_id[$commonKeys])) {

                        if (!key_exists("NC", $row)) {
                            $row['NC'] = 0;
                        }
                        if (!key_exists("Return", $row)) {
                            $row['Return'] = 0;
                        }
                        if (!key_exists("CnicRequired", $row)) {
                            $row['CnicRequired'] = 0;
                        }
                        if (!key_exists("ProductType", $row)) {
                            $row['ProductType'] = 1;
                        }
                        if (!key_exists("Weight", $row)) {
                            $row['Weight'] = 0;
                        }
                        if (!key_exists("Pieces", $row)) {
                            $row['Pieces'] = 1;
                        }


                        if ($prevCity != $row['CityId'] || $prevCourier != $row['CourierCode']) {
//                        $courier_data = ecom_courier::getCourierDetailsByCodeAndStationID_COD($row['CourierCode'], $row['CityId']);
//                        $courier_data_array = array('rider_id' => $courier_data->rider_id, 'branch_id' => $courier_data->branch_id, 'station_id' => $courier_data->station_id, 'courier_phone' => $courier_data->courier_phone);
                            $courier_data_array = array('rider_id' => $courier_data_rider_id[$commonKeys], 'branch_id' => $courier_data_branch_id[$commonKeys], 'station_id' => $courier_data_station_id2[$commonKeys], 'courier_phone' => $courier_data_courier_phone[$commonKeys]);

                        }

                        if (!empty($courier_data_array)) {
                            if ($row['ProductType'] == 1) {
                                $cnNumbers[] = strtoupper($row['CNNumber']);
                            } else {
                                $generalCns[] = strtoupper($row['CNNumber']);
                            }
                            $postDataByCn[strtoupper($row['CNNumber'])] = ['postData' => $row, 'courierData' => $courier_data_array];
                        }
                    }

                }

                if (isset($postDataByCn) > 0) {
                    foreach ($bookedPacketList->get()->toArray() as $packet) {
                        if (isset($postDataByCn[$packet['track_number']])) {
                            $postWeight = $postDataByCn[$packet['track_number']]['postData']['Weight'];
                            $postPieces = $postDataByCn[$packet['track_number']]['postData']['Pieces'];
                            $orderDetails1[] = array(
                                "DriverId" => $postDataByCn[$packet['track_number']]['courierData']['rider_id'],
                                "Reference1" => $postDataByCn[$packet['track_number']]['postData']['CityId'],
                                "Reference2" => $postDataByCn[$packet['track_number']]['postData']['CourierCode'],
                                'Order' => array(
                                    "BranchId" => isset($postDataByCn[$packet['track_number']]['courierData']['branch_id']) ? $postDataByCn[$packet['track_number']]['courierData']['branch_id'] : 1,
                                    "OrderNo" => $packet['track_number'],
                                    "OrderDate" => $packet['booked_packet_date'],
                                    "CreatedOn" => $packet['created_at'],
                                    "SenderName" => preg_replace('/[^\w\s]/', '', $packet['merchant_name']),
                                    "SenderAddress1" => preg_replace('/[^\w\s]/', '', $packet['shipper_address1']),
                                    "SenderAddress2" => "",
                                    "SenderCountryId" => 'Pakistan',
                                    "SenderCityId" => $packet['origin_city'],
                                    "SenderStateId" => null,
                                    "SenderZip" => "123123",
                                    "SenderPhone" => $packet['shipper_phone'],
                                    "SenderEmail" => htmlentities($packet['shipper_email']),
                                    "ReceiverName" => ($packet['consignment_name'] != "" ? addslashes(preg_replace('/[^\w\s]/', '', $packet['consignment_name'])) : "N/A"),
                                    "ReceiverAddress1" => ($packet['consignment_address'] != "" ? addslashes(preg_replace('/[^\w\s]/', '', str_replace("\r\n", '', $packet['consignment_address']))) : "N/A"),
                                    "ReceiverAddress2" => "",
                                    "ReceiverCountry" => 'Pakistan',
                                    "ReceiverCity" => $packet['destination_city'],
                                    "ReceiverStateId" => null,
                                    "ReceiverZip" => "",
                                    "ReceiverPhone" => ($packet['consignment_phone'] != "" ? $packet['consignment_phone'] : "N/A"),
                                    "ReceiverEmail" => ($packet['consignment_email'] != "" ? htmlentities($packet['consignment_email']) : "N/A"),
                                    "CODAmount" => ($packet['booked_packet_collect_amount'] != "" ? $packet['booked_packet_collect_amount'] : $postDataByCn[$packet['track_number']]['postData']['CODAmount']),
                                    "DocsNeeded" => isset($postDataByCn[$packet['track_number']]['postData']['CnicRequired']) ? $postDataByCn[$packet['track_number']]['postData']['CnicRequired'] : 0,
                                    "OrderType" => isset($postDataByCn[$packet['track_number']]['postData']['ProductType']) ? $postDataByCn[$packet['track_number']]['postData']['ProductType'] : 0,
                                    "Weight" => ($postWeight > 0 ? $postWeight : $packet['booked_packet_weight']),
                                    "Pieces" => ($postPieces > 0 ? $postPieces : $packet['booked_packet_no_piece'])
                                ),
                            );

                        }
                    }

                    if (!empty($orderDetails1)) {

                        foreach ($orderDetails1 as $key => $order) {
                            $cn_no = $order['Order']['OrderNo'];
                            $orderDetails2 = array('Orders' => array($order));
                            $apiEndPoint = "https://api.trackify.pk/task/CreateWithOrder";

                            try {
                                $response = $this->makeRequest($apiEndPoint, $orderDetails2);
                                $r = json_decode($response->body());
                                $error = false;
                                if(isset($r->HasError)){
                                    $error =$r->HasError;
                                }
                                if(isset($r->Data->Result[0]->HasError)){
                                    $error =$r->Data->Result[0]->HasError;
                                }

                                if ($error == false) {
                                    $cns[] = $order['Order']['OrderNo'];
                                    $station_id = isset($postDataByCn[$cn_no]['courierData']['station_id']) ? $postDataByCn[$cn_no]['courierData']['station_id'] : 1;
                                    $couier_phone = isset($postDataByCn[$cn_no]['courierData']['courier_phone']) ? $postDataByCn[$cn_no]['courierData']['courier_phone'] : formatToPakistanFormat($order['Order']['SenderPhone']);
                                    $COUR_DATE = isset($postDataByCn[$cn_no]['postData']['COUR_DATE']) ? $postDataByCn[$cn_no]['postData']['COUR_DATE'] . ' ' . $postDataByCn[$cn_no]['postData']['Cour_Time'] : date('Y-m-d H:i:s');
                                    $delivery_date = isset($postDataByCn[$cn_no]['postData']['DELIVERY_DATE']) ? $postDataByCn[$cn_no]['postData']['DELIVERY_DATE'] . ' ' . $postDataByCn[$cn_no]['postData']['DELIVERY_TIME'] : date('Y-m-d H:i:s');
                                    $make_sms = array(
                                        'from' => $couier_phone,
                                        'to' => formatToPakistanFormat($order['Order']['ReceiverPhone']),
                                        'time' => date('Y-m-d H:i:s'),
                                        'message' => preg_replace('/\D/', '', $order['Order']['OrderNo']),
                                        'date_created' => date('Y-m-d H:i:s'),
                                        'date_modified' => null,
                                        'remarks' => null,
                                        'user_action' => null,
                                        'user_id' => null,
                                        'sms_cn' => preg_replace('/\D/', '', $order['Order']['OrderNo']),
                                        'sms_status_id' => 38,
                                        'is_approved' => 0,
                                        'original_status' => null,
                                        'app_flag' => 1,
                                        'amount_collected' => $order['Order']['CODAmount'],
                                        'latitude' => 0,
                                        'longitude' => 0,
                                        'receiver_name' => null,
                                        'relation' => null,
                                        'station_id' => $station_id,
                                        'courier_assign_date' => $COUR_DATE,
                                        'delivery_date' => $delivery_date,
                                        'cnic' => null,
                                        'signature' => null,
                                        'oms_request_start' => null,
                                        'oms_request_end' => null,
                                        'oms_request_id' => null,
                                    );
                                    $update_sms = DB::connection('CODLive')->table('tbl_lcs_sms_details')->insert($make_sms);
                                }
                            } catch (Exception $e) {
                                if (!empty($cns)) {
                                    ecom_booking::whereIn('booked_packet_cn', $cns)->update(['is_trackify' => 1]);
                                }
                            }

                        }
                        if (!empty($cns)) {
                            ecom_booking::whereIn('booked_packet_cn', $cns)->update(['is_trackify' => 1]);
                        }
                    }

                }

            }
        }

        $cron_job->updated_at =  date('Y-m-d H:i:s');
        $cron_job->save();
        echo 'success';
    }

    private function makeRequest($apiEndPoint, $orderDetails2)
    {
        $userCredentials = base64_encode("xm23oseni296:nw423ns054nj6y9sdfh327sdfsjer932ksef:1");

        return Http::withHeaders([
            'Authorization' => 'Basic ' . $userCredentials,
        ])
            ->timeout(60)
            ->post($apiEndPoint, $orderDetails2);
    }
}



