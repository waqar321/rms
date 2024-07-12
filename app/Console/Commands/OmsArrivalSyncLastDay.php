<?php

namespace App\Console\Commands;

use App\Models\Admin\CronJob;
use App\Models\Admin\ecom_arrival_oms;
use App\Models\Admin\ecom_bank_cn;
use App\Models\Admin\ecom_booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OmsArrivalSyncLastDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'default:oms-data-arrival2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Data Sync Successfully';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cron_job = new CronJob();
        $cron_job->status = 1;
        $cron_job->cron_name = 'default:oms-data-arrival2';
        $cron_job->created_at =  date('Y-m-d H:i:s');


        $result = ecom_booking::selectRaw('MIN(cn_short) as min_value, MAX(cn_short) as max_value')
            ->first();
        $start_date = date('Y-m-d', strtotime('-3 month'));
        $current_date = date('Y-m-d');

        $CN_LIST = array();
        $maxSystemTime = date('Y-m-d H:i:s', strtotime('-15 day'));

        for ($current = strtotime($start_date); $current <= strtotime($current_date); $current = strtotime('+3 month', $current)) {
            $current_formatted = date('Y-m-d', $current);
            $end_date = date('Y-m-d', strtotime('+3 month', $current));

            $cnWithPrefix = ecom_booking::whereBetween('cn_short', [$result->min_value, $result->max_value])
                ->whereBetween('booked_packet_date', [$current_formatted, $end_date])
                ->whereIn('booked_packet_status',[2, 4, 5, 6, 8, 9,10, 14, 16, 17])
                ->where('is_deleted', 0)
                ->where('is_cancel', 0)
                ->where('merchant_id','!=',557569)
                ->pluck('booked_packet_cn')
                ->toArray();

            $ourArrivalCns = ecom_arrival_oms::whereIn('cn_number', $cnWithPrefix)->orderby('SHART_CN','ASC');

            $ourArrivalCnNumber = $ourArrivalCns->pluck('cn_number')->toArray();
            $ourArrivalSystemTime = $ourArrivalCns->pluck('SysDate_Time')->toArray();
            $ourArrivalActivityTime = $ourArrivalCns->pluck('ACTIVITY_TIME')->toArray();
            if(count($ourArrivalCnNumber) > 0) {
                $maxSystemTime = date('Y-m-d H:i:s', strtotime(max($ourArrivalSystemTime).'-15 day'));
            }

            $difference = array_diff($cnWithPrefix, $ourArrivalCnNumber);
//            dd(count($cnWithPrefix),count($ourArrivalCnNumber),count($difference));
            $chunkSize = 10000;
            $totalItems = count($ourArrivalCnNumber);
            for ($offset = 0; $offset < $totalItems; $offset += $chunkSize) {
                $chunk = array_slice($ourArrivalCnNumber, $offset, $chunkSize);

                $arrivalData = DB::connection('oms')->table('arival')
                    ->select('*')
                    ->whereIn('CN_NUMBER', $chunk)
                    ->where('SysDate_Time','>=',$maxSystemTime)
                    ->get()->toArray();
                $ourArrivalData = [];
                foreach ($arrivalData as $data) {
                    $keys = array_keys($ourArrivalCnNumber, $data->CN_NUMBER); //0 ,11, 10 ,14, 51
                    $SystemTime = array_intersect_key($ourArrivalSystemTime, array_flip($keys));
                    $ActivityTime = array_intersect_key($ourArrivalActivityTime, array_flip($keys));

                    if (!in_array($data->SysDate_Time, $SystemTime) && !(in_array($data->ACTIVITY_TIME,$ActivityTime))) {
                        $ourArrivalData[] = [
                            'CN_NUMBER' => $data->CN_NUMBER,
                            'ARVL_DATE' => $data->ARVL_DATE,
                            'ARVL_TIME' => $data->ARVL_TIME,
                            'Arvl_Origin' => $data->Arvl_Origin,
                            'ARVL_VIA' => $data->ARVL_VIA,
                            'ARVL_ZONE' => $data->ARVL_ZONE,
                            'ARVL_DEST' => $data->ARVL_DEST,
                            'CN_TYPE' => $data->CN_TYPE,
                            'PCS' => $data->PCS,
                            'WEIGHT' => $data->WEIGHT,
                            'STATUS' => $data->STATUS,
                            'REMARKS' => $data->REMARKS,
                            'SHART_CN' => $data->SHART_CN,
                            'USER_ID' => $data->USER_ID,
                            'COURIER_ID' => $data->COURIER_ID,
                            'COUR_DATE' => $data->COUR_DATE,
                            'Cour_Time' => $data->Cour_Time,
                            'BH_REMARKS' => $data->BH_REMARKS,
                            'REASON' => $data->REASON,
                            'RECEIVER_NAME' => $data->RECEIVER_NAME,
                            'ACTIVITY_DATE' => $data->ACTIVITY_DATE,
                            'ACTIVITY_TIME' => $data->ACTIVITY_TIME,
                            'DELIVERY_DATE' => $data->DELIVERY_DATE,
                            'DELIVERY_TIME' => $data->DELIVERY_TIME,
                            'Cour_Name' => $data->Cour_Name,
                            'cnic_no' => $data->cnic_no,
                            'SysDate_Time' => $data->SysDate_Time,
                            'group_status_code' => $data->group_status_code,
                            'child_status_code' => $data->child_status_code,
                            'robo_resp' => $data->robo_resp,
                            'matech_resp' => $data->matech_resp,
                            'attempt_counter' => $data->attempt_counter,
                        ];
                    }
                }
                if(count($ourArrivalData) > 0) {
                    ecom_arrival_oms::insert($ourArrivalData);
                }
            }
            $totalItems = count($difference);
            for ($offset = 0; $offset < $totalItems; $offset += $chunkSize) {
                $chunk = array_slice($difference, $offset, $chunkSize);

                $arrivalData = DB::connection('oms')->table('arival')
                    ->select('*')
                    ->whereIn('CN_NUMBER', $chunk)
                    ->where('SysDate_Time','>=',$maxSystemTime)
                    ->get()->toArray();

                $ourArrivalData = [];
                foreach ($arrivalData as $data) {
                    $ourArrivalData[] = [
                        'CN_NUMBER' => $data->CN_NUMBER,
                        'ARVL_DATE' => $data->ARVL_DATE,
                        'ARVL_TIME' => $data->ARVL_TIME,
                        'Arvl_Origin' => $data->Arvl_Origin,
                        'ARVL_VIA' => $data->ARVL_VIA,
                        'ARVL_ZONE' => $data->ARVL_ZONE,
                        'ARVL_DEST' => $data->ARVL_DEST,
                        'CN_TYPE' => $data->CN_TYPE,
                        'PCS' => $data->PCS,
                        'WEIGHT' => $data->WEIGHT,
                        'STATUS' => $data->STATUS,
                        'REMARKS' => $data->REMARKS,
                        'SHART_CN' => $data->SHART_CN,
                        'USER_ID' => $data->USER_ID,
                        'COURIER_ID' => $data->COURIER_ID,
                        'COUR_DATE' => $data->COUR_DATE,
                        'Cour_Time' => $data->Cour_Time,
                        'BH_REMARKS' => $data->BH_REMARKS,
                        'REASON' => $data->REASON,
                        'RECEIVER_NAME' => $data->RECEIVER_NAME,
                        'ACTIVITY_DATE' => $data->ACTIVITY_DATE,
                        'ACTIVITY_TIME' => $data->ACTIVITY_TIME,
                        'DELIVERY_DATE' => $data->DELIVERY_DATE,
                        'DELIVERY_TIME' => $data->DELIVERY_TIME,
                        'Cour_Name' => $data->Cour_Name,
                        'cnic_no' => $data->cnic_no,
                        'SysDate_Time' => $data->SysDate_Time,
                        'group_status_code' => $data->group_status_code,
                        'child_status_code' => $data->child_status_code,
                        'robo_resp' => $data->robo_resp,
                        'matech_resp' => $data->matech_resp,
                        'attempt_counter' => $data->attempt_counter,
                    ];
                }
                if(count($ourArrivalData) > 0) {
                    ecom_arrival_oms::insert($ourArrivalData);
                }
            }
        }
        $cron_job->updated_at =  date('Y-m-d H:i:s');
        $cron_job->save();

        echo 'success';
    }
}
