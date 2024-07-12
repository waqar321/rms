<?php

namespace App\Console\Commands;

use App\Models\Admin\CronJob;
use App\Models\Admin\ecom_dispatch_oms;
use App\Models\Admin\ecom_bank_cn;
use App\Models\Admin\ecom_booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OmsDispatchSync2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'default:oms-data-dispatch2';

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
        $cron_job->cron_name = 'default:oms-data-dispatch2';
        $cron_job->created_at = date('Y-m-d H:i:s');

        $result = ecom_booking::selectRaw('MIN(cn_short) as min_value, MAX(cn_short) as max_value')
            ->first();
        $start_date = date('Y-m-d', strtotime('-3 month'));
        $current_date = date('Y-m-d');
        $maxSystemTime = date('Y-m-d H:i:s', strtotime('-7 day'));
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


            // our database dispatch records
            $ourDispatchCns = ecom_dispatch_oms::whereIn('CN_NUMBER', $cnWithPrefix)->orderby('cn_short', 'asc');
            $ourDispatchCnNumber = $ourDispatchCns->pluck('CN_NUMBER')->toArray();
            $ourDispatchSystemTime = $ourDispatchCns->pluck('SysDate_Time')->toArray();

            if(count($ourDispatchCnNumber) > 0) {
                $maxSystemTime = date('Y-m-d H:i:s', strtotime(max($ourDispatchSystemTime).'-7 day'));
            }

            $difference = array_diff($cnWithPrefix, $ourDispatchCnNumber);

            $chunkSize = 10000;
            $totalItems = count($ourDispatchCnNumber);

            for ($offset = 0; $offset < $totalItems; $offset += $chunkSize) {
                $chunk = array_slice($ourDispatchCnNumber, $offset, $chunkSize);

                $dispatchData = DB::connection('oms')
                    ->table('book_dispatch')
                    ->select('book_dispatch.*')
                    ->whereIn('CN_NUMBER', $chunk)
                    ->where('SysDate_Time','>=',$maxSystemTime)
                    ->get();


                $ourDispatchData = [];
                foreach ($dispatchData as $key => $data) {
                    $keys = array_keys($ourDispatchCnNumber, $data->CN_NUMBER);
                    $SystemTime = array_intersect_key($ourDispatchSystemTime, array_flip($keys));

                    if (!in_array($data->SysDate_Time, $SystemTime)) {
                        $cnShort = substr($data->CN_NUMBER, 2);
                        $ourDispatchData[] = [
                            'CN_NUMBER' => $data->CN_NUMBER,
                            'ISSUE_DATE' => $data->ISSUE_DATE,
                            'BOOK_TYPE_CODE' => $data->BOOK_TYPE_CODE,
                            'ORIGON_CITY_ID' => $data->ORIGON_CITY_ID,
                            'DEST_CITY_ID' => $data->DEST_CITY_ID,
                            'STATUS_CODE' => $data->STATUS_CODE,
                            'BOOK_DATE' => $data->BOOK_DATE,
                            'BOOK_TIME' => $data->BOOK_TIME,
                            'UNIT_CODE' => $data->UNIT_CODE,
                            'WEIGHT' => $data->WEIGHT,
                            'NUMBER_PIECES' => $data->NUMBER_PIECES,
                            'AMNT' => $data->AMNT,
                            'COUR_ID' => $data->COUR_ID,
                            'CLNT_ID' => $data->CLNT_ID,
                            'USER_ID' => $data->USER_ID,
                            'REMARKS' => $data->REMARKS,
                            'cn_short' => $cnShort,
                            'Mail_NO' => $data->Mail_NO,
                            'Cour_Name' => $data->Cour_Name,
                            'heavy' => $data->heavy,
                            'byhand' => $data->byhand,
                            'van_no' => $data->van_no,
                            'cour_rcv_no' => $data->cour_rcv_no,
                            'Station_id' => $data->Station_id,
                            'pbag' => $data->pbag,
                            'SysDate_Time' => $data->SysDate_Time,
                        ];
                    }
                }
                if(count($ourDispatchData) > 0) {
                    ecom_dispatch_oms::insert($ourDispatchData);
                }


            }

            $totalItems = count($difference);
            for ($offset = 0; $offset < $totalItems; $offset += $chunkSize) {
                $chunk = array_slice($difference, $offset, $chunkSize);

                $dispatchData = DB::connection('oms')
                    ->table('book_dispatch')
                    ->select('book_dispatch.*')
                    ->whereIn('CN_NUMBER', $chunk)
                    ->where('SysDate_Time','>=',$maxSystemTime)
                    ->get();


                $ourDispatchData = [];
                foreach ($dispatchData as $key => $data) {
                    $cnShort = substr($data->CN_NUMBER, 2);
                    $ourDispatchData[] = [
                        'CN_NUMBER' => $data->CN_NUMBER,
                        'ISSUE_DATE' => $data->ISSUE_DATE,
                        'BOOK_TYPE_CODE' => $data->BOOK_TYPE_CODE,
                        'ORIGON_CITY_ID' => $data->ORIGON_CITY_ID,
                        'DEST_CITY_ID' => $data->DEST_CITY_ID,
                        'STATUS_CODE' => $data->STATUS_CODE,
                        'BOOK_DATE' => $data->BOOK_DATE,
                        'BOOK_TIME' => $data->BOOK_TIME,
                        'UNIT_CODE' => $data->UNIT_CODE,
                        'WEIGHT' => $data->WEIGHT,
                        'NUMBER_PIECES' => $data->NUMBER_PIECES,
                        'AMNT' => $data->AMNT,
                        'COUR_ID' => $data->COUR_ID,
                        'CLNT_ID' => $data->CLNT_ID,
                        'USER_ID' => $data->USER_ID,
                        'REMARKS' => $data->REMARKS,
                        'cn_short' => $cnShort,
                        'Mail_NO' => $data->Mail_NO,
                        'Cour_Name' => $data->Cour_Name,
                        'heavy' => $data->heavy,
                        'byhand' => $data->byhand,
                        'van_no' => $data->van_no,
                        'cour_rcv_no' => $data->cour_rcv_no,
                        'Station_id' => $data->Station_id,
                        'pbag' => $data->pbag,
                        'SysDate_Time' => $data->SysDate_Time,
                    ];
                }
                if(count($ourDispatchData) > 0) {
                    ecom_dispatch_oms::insert($ourDispatchData);
                }


            }
        }

        $cron_job->updated_at = date('Y-m-d H:i:s');
        $cron_job->save();
        echo 'success';

    }
}
