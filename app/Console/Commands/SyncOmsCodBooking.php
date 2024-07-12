<?php

namespace App\Console\Commands;

use App\Models\Admin\CronJob;
use Illuminate\Console\Command;
use DB;

class SyncOmsCodBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'default:sync_oms_cod_booking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserting Our booking data into OMS COD_DOWNLOAD TABLE';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cron_job = new CronJob();
        $cron_job->status = 1;
        $cron_job->cron_name = 'default:sync_oms_cod_booking';
        $cron_job->created_at =  date('Y-m-d H:i:s');

        $from_date = date('Y-m-d', strtotime('-1 day'));
        $to_date = date('Y-m-d');
        $ecom_cns = array();
        $diff = array();
        $booking_data = DB::select("CALL getBookingsBydateForCodNew(?,?,?)",[$from_date,$to_date,0]);
        // Check if $booking_data is not empty
        if (!empty($booking_data)) {
            $ecom_cns = array_column($booking_data, 'cn_number');
            $db_query_ari =  DB::connection('oms')->table('cod_download')->select('cn_number')->whereIn('cn_number',$ecom_cns);
            if($db_query_ari->exists()){
                $oms_cns = $db_query_ari->pluck('cn_number')->toArray();
                $diff = array_diff($ecom_cns,$oms_cns);

                $diff_booking_data = array_filter($booking_data, function ($booking) use ($diff) {
                    return in_array($booking->cn_number, $diff);
                });
                $i=0;

                $chunkSize = 1000;
                $totalItems = count($diff_booking_data);

                for ($offset = 0; $offset < $totalItems; $offset += $chunkSize) {
                        $chunk_all_bookings = array_slice($diff_booking_data, $offset, $chunkSize);
                        $oms_insert = array();
                        foreach ($chunk_all_bookings as $key => $value) {

                            $oms_insert[$i]['cn_number'] = $value->cn_number;
                            $oms_insert[$i]['consignment_name'] = restrictSpecialCharaters($value->consignment_name);
                            $oms_insert[$i]['consignment_phone'] = $value->consignment_phone;
                            $oms_insert[$i]['consignment_address'] = $value->consignment_address;
                            $oms_insert[$i]['shipment_name'] = restrictSpecialCharaters($value->shipment_name);
                            $oms_insert[$i]['brand_name'] = $value->brand_name;
                            $oms_insert[$i]['shipment_phone'] = $value->shipment_phone;
                            $oms_insert[$i]['shipment_address'] = $value->shipment_address;
                            $oms_insert[$i]['collect_amount'] = $value->booked_packet_collect_amount;
                            $oms_insert[$i]['book_date'] = date('Y-m-d 00:00:00', strtotime($value->date_created));
                            $oms_insert[$i]['activity'] = date('Y-m-d H:i:s', strtotime($value->date_created));
                            $oms_insert[$i]['is_sms_send'] = 0;
                            $oms_insert[$i]['dest_city_id'] = $value->destination_city_id;
                            $oms_insert[$i]['origin_city_id'] = $value->origin_city_id;
                            $oms_insert[$i]['shipment_type_id'] = $value->shipment_type_id;
                            $oms_insert[$i]['booked_packet_no_piece'] = $value->booked_packet_no_piece;
                            $oms_insert[$i]['booked_packet_weight'] = $value->booked_packet_weight;
                            $oms_insert[$i]['company_id'] = $value->company_id;
                            $oms_insert[$i]['Booked_Packet_Id'] = $value->booked_packet_id;
                            $oms_insert[$i]['client_id'] = $value->company_account_no;
                            $oms_insert[$i]['return_location'] = '';
                            $oms_insert[$i]['return_address'] = $value->return_address;
                            $oms_insert[$i]['vendor_flg'] = 0;
                            $oms_insert[$i]['order_id'] = restrictSpecialCharaters($value->booked_packet_order_id);
                            $oms_insert[$i]['short_cn'] = preg_replace("/[^0-9]/", "", $value->cn_number);;
                            $i++;
                        }
                        if (count($oms_insert) > 0) {
                            $db_query_ari = DB::connection('oms')->table('cod_download')->insert($oms_insert);
                            echo 'success';
                        }
                    }

            }
        }

        $cron_job->updated_at =  date('Y-m-d H:i:s');
        $cron_job->save();
    }
}
