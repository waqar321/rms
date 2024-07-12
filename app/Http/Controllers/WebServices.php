<?php

namespace App\Http\Controllers;

use App\Models\Admin\ecom_arrival_oms;
use App\Models\Admin\ecom_booked_packet_model;
use App\Models\Admin\ecom_courier;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Http;

class WebServices extends Controller
{
    protected $response;

    public function __construct()
    {
        $this->response = new ResponseController();
    }

    public function TrackifyPushBatch(Request $request)
    {
        $flag = true;
        $error = array();

        if (isset($request->TrackifyCns)) {
            if (count($request->TrackifyCns) > 0) {
                if (count($request->TrackifyCns) <= 500) {
                    $flag = true;
                } else {
                    $flag = false;
                    $error[] = 'Only 500 packets are allowed';
                }
            } else {
                $flag = false;
                $error[] = 'No Packet Found';
            }
        } else {
            $flag = false;
            $error[] = 'Packets are required';
        }

        if ($flag) {

            $error_log = array();
            $passed_log = array();
            $passed_message= array();
            $error_message = array();

            $batch_id =  $trakify_log_arrival_ids = DB::table('trackify_fail_api')->select([DB::raw('max(batch_id) as batch_id')])->first()->batch_id;
            $batch_id = empty($batch_id) ? 1 : $batch_id + 1;

            $cns = array_column($request->TrackifyCns,'CNNumber');
            $bookedPacketList = ecom_booked_packet_model::getTrackifyApi($cns);
            $all_booking_data = $bookedPacketList->get()->toArray();
            $all_bookings = array();
            foreach ($request->TrackifyCns as $track_packet =>$track_value) {
                $get_booking_key = array_search($track_value['CNNumber'], array_column($all_booking_data, 'track_number'));
                $all_bookings[$track_packet] = array_merge($track_value, $all_booking_data[$get_booking_key]);
            }


            $cn_shorts =  array_column($all_bookings,'SHART_CN');
            $track_number =  array_column($all_bookings,'track_number');
            $courier_code =   array_column($all_bookings,'CourierCode');
            $courier_cities =   array_column($all_bookings,'CityId');
            $SysDate_Time =   array_column($all_bookings,'SysDate_Time');
            $chunkSize = 1000;
            $totalItems = count($cn_shorts);
            if (count($all_bookings) > 0) {
                for ($offset = 0; $offset < $totalItems; $offset += $chunkSize) {

                    $postDataByCn = array();
                    $chunk_all_bookings = array_slice($all_bookings, $offset, $chunkSize);
                    $chunk_cn_shorts = array_slice($cn_shorts, $offset, $chunkSize);
                    $chunk_track_number = array_slice($track_number, $offset, $chunkSize);
                    $chunk_courier_code = array_slice($courier_code, $offset, $chunkSize);
                    $chunk_courier_cities = array_slice($courier_cities, $offset, $chunkSize);
                    $chunk_system_time = array_slice($SysDate_Time, $offset, $chunkSize);


                    $orderDetails1 = $orderDetails2 = $orderDetails = $cnNumbers = $generalCns = $courier_data = [];

                    $prevCourier = $prevCity = 0;

                    $chunk_courier_code = array_map(function ($code) {
                        return str_pad($code, 5, '0', STR_PAD_LEFT);
                    }, $chunk_courier_code);


                    $courier_data = ecom_courier::getCourierDetailsByCodeAndStationID_CODNew($chunk_courier_code, $chunk_courier_cities);
                    $courier_data_rider_id = $courier_data->pluck('rider_id')->toArray();
                    $courier_data_branch_id = $courier_data->pluck('branch_id')->toArray();
                    $courier_data_station_id = $courier_data->pluck('station_id')->toArray();
                    $courier_data_station_id2 = $courier_data->pluck('station_id2')->toArray();
                    $courier_data_courier_code = $courier_data->pluck('courier_code')->toArray();
                    $courier_data_courier_phone = $courier_data->pluck('courier_phone')->toArray();

                    $commonKeys = null;

                    foreach ($chunk_all_bookings as $key => $row) {
                        $row = (array)$row;
                        $CourierCodekey = array_keys($courier_data_courier_code, str_pad($row['CourierCode'], 5, '0', STR_PAD_LEFT));
                        $CityIdKey = array_keys($courier_data_station_id2, $row['CityId']);
                        $commonKeys = collect(array_intersect($CourierCodekey, $CityIdKey))->first();

                        $courier_data_array = array();
                        if (isset($courier_data_rider_id[$commonKeys])) {

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
                        foreach ($chunk_all_bookings as $packet) {
                            if (isset($postDataByCn[$packet['track_number']])) {

                                $shipper_address = !empty(trim($packet['shipper_address1'])) ? $packet['shipper_address1'] : $packet['merchant_address1'];
                                $shipper_phone = !empty(trim($packet['shipper_phone'])) ? $packet['shipper_phone'] : $packet['merchant_phone'];
                                $shipper_email = !empty(trim($packet['shipper_email'])) ? $packet['shipper_email'] : $packet['merchant_email'];
                                $orderDetails1[] = array(
                                    "DriverId" => $postDataByCn[$packet['track_number']]['courierData']['rider_id'],
                                    "Reference1" => $postDataByCn[$packet['track_number']]['postData']['CityId'],
                                    "Reference2" => $postDataByCn[$packet['track_number']]['postData']['CourierCode'],
                                    'Order' => array(
                                        "BranchId" => isset($postDataByCn[$packet['track_number']]['courierData']['branch_id']) ? $postDataByCn[$packet['track_number']]['courierData']['branch_id'] : 1,
                                        "OrderNo" => $packet['track_number'],
                                        "OrderDate" => $packet['booked_packet_date'],
                                        "CreatedOn" => $packet['created_at'],
                                        "SenderName" => preg_replace('/[^\p{Arabic}\w\s]/u', '', $packet['merchant_name']),
                                        "SenderAddress1" => preg_replace('/[^\p{Arabic}\w\s]/u', '', $shipper_address),
                                        "SenderAddress2" => "",
                                        "SenderCountryId" => 'Pakistan',
                                        "SenderCityId" => $packet['origin_city'],
                                        "SenderStateId" => null,
                                        "SenderZip" => "123123",
                                        "SenderPhone" => preg_replace('/\x{00A0}/u', '', $shipper_phone),
                                        "SenderEmail" => htmlentities($shipper_email),
                                        "ReceiverName" => ($packet['consignment_name'] != "" ? addslashes(preg_replace('/[^\p{Arabic}\w\s]/u', '', $packet['consignment_name'])) : "N/A"),
                                        "ReceiverAddress1" => ($packet['consignment_address'] != "" ? addslashes(preg_replace('/[^\p{Arabic}\w\s]/u', '', str_replace(["\r\n", "\n"], '', $packet['consignment_address']))) : "N/A"),
                                        "ReceiverAddress2" => "",
                                        "ReceiverCountry" => 'Pakistan',
                                        "ReceiverCity" => $packet['destination_city'],
                                        "ReceiverStateId" => null,
                                        "ReceiverZip" => "",
                                        "ReceiverPhone" => ($packet['consignment_phone'] != "" ? preg_replace('/\x{00A0}/u', '', $packet['consignment_phone']) : "N/A"),
                                        "ReceiverEmail" => ($packet['consignment_email'] != "" ? htmlentities($packet['consignment_email']) : "N/A"),
                                        "CODAmount" => ($packet['booked_packet_collect_amount'] != "" ? $packet['booked_packet_collect_amount'] : $postDataByCn[$packet['track_number']]['postData']['CODAmount']),
                                        "DocsNeeded" => isset($postDataByCn[$packet['track_number']]['postData']['CnicRequired']) ? $postDataByCn[$packet['track_number']]['postData']['CnicRequired'] : 0,
                                        "OrderType" => isset($postDataByCn[$packet['track_number']]['postData']['ProductType']) ? $postDataByCn[$packet['track_number']]['postData']['ProductType'] : 0,
                                        "Weight" => $packet['booked_packet_weight'],
                                        "Pieces" =>$packet['booked_packet_no_piece']
                                    ),
                                );
                            }
                        }
                        if (!empty($orderDetails1)) {
                            $chunkSize2 = 500;
                            $totalItems2 = count($orderDetails1);
                            for ($offset2 = 0; $offset2 < $totalItems2; $offset2 += $chunkSize2) {
                                $error_log = array();
                                $passed_log = array();
                                $make_track_array = array_slice($orderDetails1, $offset2, $chunkSize2);
                                $orderDetails2 = array('Orders' => $make_track_array);
                                $apiEndPoint = "https://api.trackify.pk/task/CreateWithOrder";
                                try {
                                    $response = $this->makeRequest($apiEndPoint, $orderDetails2);
                                    $r = json_decode($response->body());
                                    if (isset($r->Data->Result[0]->HasError)) {
                                        foreach ($make_track_array as $key3 => $order) {
                                            $error = false;
                                            $cn_no = $order['Order']['OrderNo'];
                                            $response_key = array_search($cn_no, array_column($r->Data->Result, 'OrderNo'));
                                            $error = $r->Data->Result[$response_key]->HasError;
                                            $stime = $chunk_system_time[array_search($cn_no, $chunk_track_number)];
                                            $station_id = isset($postDataByCn[$cn_no]['courierData']['station_id']) ? $postDataByCn[$cn_no]['courierData']['station_id'] : 1;
                                            $couier_phone = isset($postDataByCn[$cn_no]['courierData']['courier_phone']) ? $postDataByCn[$cn_no]['courierData']['courier_phone'] : formatToPakistanFormat($order['Order']['SenderPhone']);
                                            $COUR_DATE = isset($postDataByCn[$cn_no]['postData']['COUR_DATE']) ? $postDataByCn[$cn_no]['postData']['COUR_DATE'] . ' ' . $postDataByCn[$cn_no]['postData']['Cour_Time'] : date('Y-m-d H:i:s');
                                            $delivery_date = isset($postDataByCn[$cn_no]['postData']['DELIVERY_DATE']) ? $postDataByCn[$cn_no]['postData']['DELIVERY_DATE'] . ' ' . $postDataByCn[$cn_no]['postData']['DELIVERY_TIME'] : date('Y-m-d H:i:s');
                                            if ($error == false) {
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

                                                $passed_log[] = array_merge(
                                                    [
                                                        'DriverId' => $order['DriverId'],
                                                        'Reference1' => $order['Reference1'],
                                                        'Reference2' => $order['Reference2'],
                                                        'errors_log' => json_encode($r->Data->Result[$response_key]),
                                                        'SysDate_Time' => $stime,
                                                        'batch_id' => $batch_id,
                                                        'status' => 1,
                                                    ],
                                                    $order['Order']
                                                );

                                                $passed_message[] = array_merge((array) $r->Data->Result[$response_key],[
                                                    'StationId'=>$station_id,
                                                    'CourDate'=>$COUR_DATE,
                                                    'Amount'=>$order['Order']['CODAmount'],
                                                ]);

                                            } else {
                                                $error_log[] = array_merge(
                                                    [
                                                        'DriverId' => $order['DriverId'],
                                                        'Reference1' => $order['Reference1'],
                                                        'Reference2' => $order['Reference2'],
                                                        'errors_log' => json_encode($r->Data->Result[$response_key]),
                                                        'SysDate_Time' => $stime,
                                                        'batch_id' => $batch_id,
                                                        'status' => 0,
                                                    ],
                                                    $order['Order']
                                                );
                                                $error_message[] = array_merge((array) $r->Data->Result[$response_key],[
                                                    'StationId'=>$station_id,
                                                    'CourDate'=>$COUR_DATE,
                                                    'Amount'=>$order['Order']['CODAmount'],
                                                ]);
                                            }
                                        }
                                    }

                                } catch (Exception $e) {

                                }
                                if (count($error_log) > 0) {
                                    DB::table('trackify_fail_api')->insert($error_log);
                                }
                                if (count($passed_log) > 0) {
                                    DB::table('trackify_fail_api')->insert($passed_log);
                                }
                            }
                        }

                    }

                }
            }


            $output = array(
                'status' => 1,
                'HasError' => count($error_message) > 0 ? 1 : 0,
                'Message'=> count($error_message) == 0 ? 'SUCCESS' : 'SOME ERRORS',
                'total_packets' => count($request->TrackifyCns),
                'OrderDetail'=>$passed_message,
                'ErrorDetail'=>$error_message,
            );
        } else {
            $output = array(
                'status' => 0,
                'error' => implode(',', $error),
                'packet_list' => null,
            );
        }

        return $this->response->response($output, 200);
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
