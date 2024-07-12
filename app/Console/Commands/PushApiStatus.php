<?php

namespace App\Console\Commands;

use App\Models\Admin\CronJob;
use App\Models\Admin\ecom_arrival_oms;
use App\Models\Admin\ecom_dispatch_oms;
use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Http;
use App\Models\EcomOrderJourney;
class PushApiStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'default:push-api-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Data push Successfully';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $cron_job = new CronJob();
        $cron_job->status = 1;
        $cron_job->cron_name = 'default:push-api-status';
        $cron_job->created_at =  date('Y-m-d H:i:s');

        $current = date('Y-m-d 00:00:01');
        $start = date('Y-m-d 00:00:01', strtotime($current . ' -2 day'));
        $end = date('Y-m-d 23:59:59', strtotime($current));

        $final_array = array();

        $ourArrivalCns = ecom_arrival_oms::select('ecom_bookings.custom_data', 'ecom_bookings.booked_packet_cn', 'ecom_bookings.cn_short', 'ecom_merchant.push_api_url', 'ecom_bookings.merchant_id', 'ecom_merchant.push_api_header', DB::raw("CONCAT(ecom_arrival_oms.ACTIVITY_DATE, ' ', ecom_arrival_oms.ACTIVITY_TIME) as ACTIVITY_DATE"), 'ecom_arrival_oms.REASON', 'ecom_arrival_oms.STATUS', 'ecom_bookings.booked_packet_status as status_id','ecom_arrival_oms.id as rawid','ecom_arrival_oms.RECEIVER_NAME', 'ecom_bookings.booked_packet_order_id')
            ->join('ecom_bookings', 'ecom_bookings.cn_short', 'ecom_arrival_oms.SHART_CN')
            ->join('ecom_merchant', 'ecom_merchant.id', 'ecom_bookings.merchant_id')
//            ->whereIn('ecom_arrival_oms.SHART_CN', [762652325, 762652326])
            ->where(function ($query) {
//                $query->whereNotIn('ecom_bookings.merchant_id', [2747, 560158, 605994]);
                $query->whereIn('ecom_bookings.merchant_id', [609282,607799,594157,596472]);
                $query->WhereNotNull('ecom_merchant.push_api_url');
            })
            ->where('ecom_arrival_oms.is_push', 0)
            ->whereBetween('ecom_arrival_oms.SysDate_Time', [
                date('Y-m-d 00:00:01', strtotime($start)),
                date('Y-m-d 23:59:59', strtotime($end))
            ])
            ->orderby('ecom_arrival_oms.SHART_CN', 'ASC')
            ->get()->toArray();

        $ourDispatchCns = ecom_dispatch_oms::select('ecom_bookings.custom_data', 'ecom_bookings.booked_packet_cn', 'ecom_bookings.cn_short', 'ecom_merchant.push_api_url', 'ecom_bookings.merchant_id', 'ecom_merchant.push_api_header', DB::raw("CONCAT(ecom_dispatch_oms.BOOK_DATE, ' ', ecom_dispatch_oms.BOOK_TIME) as ACTIVITY_DATE"), 'ecom_dispatch_oms.REMARKS as REASON', 'ecom_dispatch_oms.STATUS_CODE as STATUS', 'ecom_bookings.booked_packet_status as status_id','ecom_dispatch_oms.id as rawid_dispatch',DB::raw("'-' AS RECEIVER_NAME"), 'ecom_bookings.booked_packet_order_id')
            ->join('ecom_bookings', 'ecom_bookings.cn_short', 'ecom_dispatch_oms.cn_short')
            ->join('ecom_merchant', 'ecom_merchant.id', 'ecom_bookings.merchant_id')
//            ->whereIn('ecom_arrival_oms.SHART_CN', [762652325, 762652326])
            ->where(function ($query) {
//                $query->whereNotIn('ecom_bookings.merchant_id', [2747, 560158, 605994]);
                $query->whereIn('ecom_bookings.merchant_id', [609282,607799,594157,596472]);
                $query->WhereNotNull('ecom_merchant.push_api_url');
            })
            ->where('ecom_dispatch_oms.is_push', 0)
            ->whereBetween('ecom_dispatch_oms.SysDate_Time', [
                date('Y-m-d 00:00:01', strtotime($start)),
                date('Y-m-d 23:59:59', strtotime($end))
            ])
            ->orderby('ecom_dispatch_oms.cn_short', 'ASC')
            ->get()->toArray();

        $final_array = array_merge($ourArrivalCns,$ourDispatchCns);

        uasort($final_array, function($a, $b) {
            return $b['ACTIVITY_DATE'] <=> $a['ACTIVITY_DATE'];
        });


      //  https://pre-tps.lel.lazada.com/api/carriers/pk-lcs/packages/statuses?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vOiIsImlhdCI6MTU5MDU1NDk5OCwiZXhwIjoyMjIxMjc0OTk4LCJuYmYiOjE1OTA1NTQ5OTgsImp0aSI6IlVvazRyc3I2T295OGZlaWoiLCJzdWIiOiJhN2M0MGM1ZS02ZjRkLTQwY2EtYjQxNy0yNWViYWYxN2UyOGIiLCJwcnYiOiIxMGZjZWY0MzBiYmEwZDVlMmIyYzgyYzY3NzE2ZmNlMGM3ZTc1OGRlIn0.wXWMidNv6od-4qhZQue0lxIbmfLAQ2UOhBvVzZd1e1g

//        $darazApiURL = [
//            'part1' => "https://tps.lel.lazada.com/api/carriers/",
//            'part2' => "/packages/statuses?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vOiIsImlhdCI6MTYwMzM2ODUxMCwiZXhwIjoyMjM0MDg4NTEwLCJuYmYiOjE2MDMzNjg1MTAsImp0aSI6IlZobmZ3QkVaVzRTdXJUYU4iLCJzdWIiOiI1Zjg2ODEwOC0xMzZkLTRkOGMtODI4Yi02MTEyMmFiNGU5YmMiLCJwcnYiOiIxMGZjZWY0MzBiYmEwZDVlMmIyYzgyYzY3NzE2ZmNlMGM3ZTc1OGRlIn0.gtFuvi1OY665zZhZW3xcQPbjMq9P4005PtKLkmxOqsc",
//
//        ];
        $darazApiURL = [
            'part1' => "https://pre-tps.lel.lazada.com/api/carriers/",
            'part2' => "/packages/statuses?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vOiIsImlhdCI6MTU5MDU1NDk5OCwiZXhwIjoyMjIxMjc0OTk4LCJuYmYiOjE1OTA1NTQ5OTgsImp0aSI6IlVvazRyc3I2T295OGZlaWoiLCJzdWIiOiJhN2M0MGM1ZS02ZjRkLTQwY2EtYjQxNy0yNWViYWYxN2UyOGIiLCJwcnYiOiIxMGZjZWY0MzBiYmEwZDVlMmIyYzgyYzY3NzE2ZmNlMGM3ZTc1OGRlIn0.wXWMidNv6od-4qhZQue0lxIbmfLAQ2UOhBvVzZd1e1g",

        ];
        $darazCompanyIds = [2747, 605994];
        $reasonStatuses = ["RO", "PN1", "PN2", "PN3", "RN1", "RN2", "FD"];
        $terminalStatuses = ["DV", "DS"];


        $daraz_array = array();
        $other_clients = array();

        foreach ($final_array as $ri => $parsed) {
            $posted = true;
            $seller_id = null;
            if (in_array($parsed['merchant_id'], $darazCompanyIds)) {

                $custom_data = json_decode($parsed['custom_data']);
                $slug = $custom_data[0]->slug;
                $seller_id = $custom_data[0]->seller_id;
                $url = $darazApiURL['part1'] . $slug . $darazApiURL['part2'];
                $comments = null;
                if (in_array($parsed['STATUS'], $reasonStatuses)) {
                    $comments = "[" . $seller_id . "]<" . $parsed['REASON'] . ">";
                }
                else if (in_array($parsed['STATUS'], $terminalStatuses)) {
                    $comments = "[" . $seller_id . "]<" . $parsed['RECEIVER_NAME'] . ">";
                }else{
                    $comments = "[" . $seller_id . "]<>";
                }

                $daraz_array['data'][] = array(
                    'tracking_number' => $parsed['cn_short'],
                    'timestamp' => $parsed['ACTIVITY_DATE'],
                    'comments' => $comments,
                    'status' => $parsed['STATUS'],
                );
                $daraz_array['arrival_data'][] = $parsed;
                $daraz_array['options'] = array(
                        'headers' => !empty($parsed['push_api_header']) ? $parsed['push_api_header'] : '{"Content-Type": "application/json"}',
                        'push_api_url' => !empty($parsed['push_api_url']) ? $parsed['push_api_url'] : null,
                        'push_api_key' => !empty($parsed['push_api_key']) ? $parsed['push_api_key'] : null,
                        'push_api_secret' => !empty($parsed['push_api_secret']) ? $parsed['push_api_secret'] : null,
                );

            } else {

                $other_clients[$parsed['merchant_id']]['data'][] = array(
                            'cn_number' => $parsed['booked_packet_cn'], // Change the key accordingly
                            'status' => $parsed['STATUS'], // Change the key accordingly
                            'receiver_name' => $parsed['RECEIVER_NAME'], // Change the key accordingly
                            'reason' => $parsed['REASON'], // Assuming $comments is already defined
                            'activity_date' => $parsed['ACTIVITY_DATE'], // Change the key accordingly
                );
                $other_clients[$parsed['merchant_id']]['arrival_data'][] = $parsed;
                $other_clients[$parsed['merchant_id']]['option'] = array(
                            'headers' => !empty($parsed['push_api_header']) ? $parsed['push_api_header'] : '{"Content-Type": "application/json"}',
                            'push_api_url' => !empty($parsed['push_api_url']) ? $parsed['push_api_url'] : null,
                            'push_api_key' => !empty($parsed['push_api_key']) ? $parsed['push_api_key'] : null,
                            'push_api_secret' => !empty($parsed['push_api_secret']) ? $parsed['push_api_secret'] : null,
                );
            }

        }

//        if(count($daraz_array) > 0){
//            try {
//                $headers = json_decode($daraz_options['headers'], true);
//                // Use Laravel HTTP client to make a POST request
//                $response = Http::withHeaders($headers)->post($url, $daraz_array);
//                $client_response_code = $response->status();
//                $client_response = "";
//                array_push($success_push,$parsed['rawid']);
//
//            } catch (\Exception $error) {
//                if ($error->getCode() != 422) {
//                    $posted = false;
//                }
//                $result = json_decode($error->getResponse()->getBody(), true);
//                $client_response_code = $error->getCode();
//                $client_response = $result['traceId'];
//            }
//        }


        if(count($other_clients) > 0){
            foreach ($other_clients as $merchant_id=>$value) {

                $bulkInsertJourney = array();
                $success_push = array();
                $success_push_dispatch = array();

                $chunkSize = 250;
                $data = $value['data'];
                $url = $value['option']['push_api_url'];
                $parsed_value = array_column(
                    array_filter($value['arrival_data'], function ($arrival) {
                        return isset($arrival['rawid']);
                    }),
                    'rawid'
                );
                $parsed_value_dispatch = array_column(
                    array_filter($value['arrival_data'], function ($arrival) {
                        return isset($arrival['rawid_dispatch']);
                    }),
                    'rawid_dispatch'
                );

                $arrival_data = $value['arrival_data'];
                $totalItems = count($data);

                for ($offset = 0; $offset < $totalItems; $offset += $chunkSize) {
                    $client_response = "";
                    $data_chunk =  array('data' =>  array_slice($data, $offset, $chunkSize));
                    $parsed_chunk = array_slice($parsed_value, $offset, $chunkSize);
                    $parsed_dispatch_chunk = array_slice($parsed_value_dispatch, $offset, $chunkSize);
                    $arrival_chunk = array_slice($arrival_data, $offset, $chunkSize);
                    try {
                        $headers = json_decode($value['option']['headers'], true);
                        // Use Laravel HTTP client to make a POST request
                        $response = Http::withHeaders($headers)->timeout(90)->post($url, $data_chunk);
                        $client_response = json_encode($response);
                        $client_response_code = $response->status();
                        if($client_response_code == 200) {
                            $success_push = array_merge($success_push, $parsed_chunk);
                            $success_push_dispatch = array_merge($success_push_dispatch, $parsed_dispatch_chunk);
                        }

                    } catch (\Exception $error) {;
                        $client_response_code = $error->getCode();
                    }
                    foreach ($arrival_chunk as $key => $arrival) {
                        $bulkInsertJourney[] = [
                            'merchant_id' => $arrival['merchant_id'],
                            'cn_number' => $arrival['booked_packet_cn'],
                            'activity_date' => $arrival['ACTIVITY_DATE'],
                            'status_id' => $arrival['status_id'],
                            'status_code' => $arrival['STATUS'],
                            'reason' => $arrival['REASON'],
                            'receiver_name' => $arrival['RECEIVER_NAME'],
                            'booked_packet_order_id' => $arrival['booked_packet_order_id'],
                            'custom_data' => $arrival['custom_data'],
                            'attempt' => 1,
                            'pushed' => 1,
                            'pushed_at' => date('Y-m-d H:i:s'),
                            'client_response_code' => $client_response_code,
                            'client_response' => $client_response,
                            'seller_id' => $seller_id,
                            'rawid' => isset($arrival['rawid']) ? $arrival['rawid'] : $arrival['rawid_dispatch'],
                            'sqs_id' => null,
                            'request_type' => 'A',
                        ];
                    }

                }

                if (count($bulkInsertJourney) > 0) {
                    EcomOrderJourney::insert($bulkInsertJourney);
                }

                if (count($success_push) > 0) {
                    ecom_arrival_oms::whereIn('id', $success_push)->update(['is_push' => 1]);
                }
                if (count($success_push_dispatch) > 0) {
                    ecom_dispatch_oms::whereIn('id', $success_push_dispatch)->update(['is_push' => 1]);
                }
            }
        }

        $cron_job->updated_at =  date('Y-m-d H:i:s');
        $cron_job->save();

        echo 'success';



    }
}
