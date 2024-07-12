<?php

namespace App\Console\Commands;

use App\Models\Admin\ecom_booking;
use App\Models\Admin\ecom_booked_packet_history;
use Illuminate\Console\Command;
use DB;
use App\Models\Admin\CronJob;

class updateCodBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'default:cod-live-booking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'COD Update COD Data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cron_job = new CronJob();
        $cron_job->status = 1;
        $cron_job->cron_name = 'default:cod-live-booking';
        $cron_job->save();

        $days_update = 2;
        $start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -' . $days_update . ' days'));
        $end_date = date('Y-m-d');

        $bookedPacketList = DB::select('CALL getBookingsFromNewCODForTrackify(?, ?,?)', array($start_date, $end_date,0));
        $cns = collect($bookedPacketList)->pluck('booked_packet_cn')->toArray();

        $codLiveQuery =  DB::connection('CODLive')
        ->table('ecom_bookings')
        ->whereIn('booked_packet_cn', $cns)
        ->pluck('booked_packet_cn')->toArray();

        $notMatchedObjects = array_filter($bookedPacketList, function ($item) use ($codLiveQuery) {
            return !in_array($item->booked_packet_cn, $codLiveQuery);
        });


        $bookData = array();

        foreach($notMatchedObjects as $key=>$bookingData){
            $bookData[$key]['id'] = $bookingData->id;
            $bookData[$key]['booked_packet_cn'] = $bookingData->booked_packet_cn;
            $bookData[$key]['cn_short'] = $bookingData->cn_short;
            $bookData[$key]['merchant_id'] = $bookingData->merchant_id;
            $bookData[$key]['shipper_name'] = $bookingData->shipper_name;
            $bookData[$key]['booked_packet_no_piece'] = $bookingData->booked_packet_no_piece;
            $bookData[$key]['booked_packet_collect_amount'] = $bookingData->booked_packet_collect_amount;
            $bookData[$key]['origin_city'] = $bookingData->origin_city;
            $bookData[$key]['destination_city'] = $bookingData->destination_city;
            $bookData[$key]['booked_packet_weight'] = $bookingData->booked_packet_weight;
            $bookData[$key]['booked_packet_vol_weight_cal'] = $bookingData->booked_packet_vol_weight_cal;
            $bookData[$key]['booked_packet_comments'] = $bookingData->booked_packet_comments;
            $bookData[$key]['booked_packet_status'] = $bookingData->booked_packet_status;
            $bookData[$key]['prepaid_cod'] = $bookingData->prepaid_cod;
            $bookData[$key]['shipment_type_id'] = $bookingData->shipment_type_id;
            $bookData[$key]['consignee_name'] = $bookingData->consignee_name;
            $bookData[$key]['consignee_phone'] = $bookingData->consignee_phone;
            $bookData[$key]['consignee_address'] = $bookingData->consignee_address;
            $bookData[$key]['return_address'] = $bookingData->return_address;
            $bookData[$key]['return_city'] = $bookingData->return_city;
        }
        // dd($bookData);

        $codLiveInsert =  DB::connection('CODLive')->table('ecom_bookings')->insert($bookData);
    }

}
