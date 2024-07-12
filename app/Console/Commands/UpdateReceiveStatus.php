<?php

namespace App\Console\Commands;

use App\Models\Admin\ecom_booking;
use Illuminate\Console\Command;
use DB;
use function Ramsey\Collection\add;
use App\Models\Admin\CronJob;
class UpdateReceiveStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'default:update-receive-status';

    protected $description = 'Update receive status as a Laravel console command';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cron_job = new CronJob();
        $cron_job->status = 1;
        $cron_job->cron_name = 'default:update-receive-status';
        $cron_job->created_at =  date('Y-m-d H:i:s');


        $days_update = 90;
        $start_date = date('Y-m-d 00:00:01', strtotime(date('Y-m-d') . ' -' . $days_update . ' days'));
        $end_date = date('Y-m-d 23:59:59');

        $booked_packetList = array();
        $cnListDispatch = array();
        $cnDataListDispatch = array();
        $cnListArival = array();
        $cnList = array();
        $ecom_booking = ecom_booking::whereIn('booked_packet_status', [2, 0])
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->whereBetween('created_at', [$start_date, $end_date]);
        if($ecom_booking->exists()){
            $booked_packetList = $ecom_booking->pluck('booked_packet_cn')->toArray();
        }
//        $booked_packetList = ['KI769945102'];
//        $booked_packetList = ['KI217641941','WZ999651618','WZ999651618','WC788314483'];
        if(count($booked_packetList) > 0){
            $omsBookDispatch = DB::connection('oms')->table('book_dispatch')
                ->select('CN_NUMBER', 'WEIGHT', 'NUMBER_PIECES', 'AMNT', 'ORIGON_CITY_ID', 'DEST_CITY_ID')
                ->whereIn('STATUS_CODE', ['DP', 'RC'])
                ->whereIn('CN_NUMBER', $booked_packetList)
                ->groupBy('CN_NUMBER');

            if($omsBookDispatch->exists()){
                $cnListDispatch = $omsBookDispatch->pluck('CN_NUMBER')->toArray();
            }

            $omsBookArrival = DB::connection('oms')->table('arival')
                ->whereIn('CN_NUMBER', $booked_packetList)
                ->groupBy('CN_NUMBER');

            if($omsBookArrival->exists()) {
                $cnListArival = $omsBookArrival->pluck('CN_NUMBER')->toArray();
            }

            $cnList = array_unique(array_merge($cnListArival, $cnListDispatch));
            $existCNArray = array();
            if(count($cnList) > 0){

                $billingDispatch = DB::connection('billing')->table('cod_dispatch')->whereIn('cn_number', $cnList);
                if($billingDispatch->exists()) {
                    $existCNArray = $billingDispatch->pluck('cn_number')->toArray();
                }
                $nonExistArrayInCod_DispatchTable = array_diff($cnList, $existCNArray);

                $bookedPacketWithDetail = ecom_booking::whereIn('booked_packet_cn',$nonExistArrayInCod_DispatchTable)
                    ->select(
                        'ecom_bookings.booked_packet_cn',
                        'ecom_bookings.booked_packet_weight',
                        'ecom_bookings.booked_packet_no_piece',
                        'ecom_bookings.booked_packet_collect_amount',
                        'oc.city_name as origin_city_name',
                        'dc.city_name as destination_city_name',
                        'ecom_bookings.booked_packet_comments',
                        'merchant_shipper.merchant_name as shipper_name',
                        'merchant_shipper.merchant_email as shipment_email',
                        'merchant_shipper.merchant_address1 as shipper_address',
                        'ecom_consignee.consignee_name as consignment_name',
                        'ecom_consignee.consignee_email as consignment_email',
                        'ecom_consignee.consignee_phone as consignment_phone',
                        'ecom_consignee.consignee_phone_two as consignment_phone_two',
                        'ecom_consignee.consignee_phone_three as consignment_phone_three',
                        'ecom_consignee.consignee_address as consignment_address'
                    )
                    ->leftjoin('ecom_merchant', 'ecom_merchant.id', '=', 'ecom_bookings.merchant_id')
                    ->leftJoin('ecom_merchant as merchant_shipper', 'ecom_bookings.shipper_id', '=', 'merchant_shipper.id')
                    ->leftjoin('ecom_consignee', 'ecom_consignee.id', '=', 'ecom_bookings.consignee_id')
                    ->leftjoin('ecom_city as oc', 'ecom_bookings.origin_city', '=', 'oc.id')
                    ->leftjoin('ecom_city as dc', 'ecom_bookings.destination_city', '=', 'dc.id');

                if($bookedPacketWithDetail->exists()) {
                    $bookedPacketsWithDetail = $bookedPacketWithDetail->get()->map(function ($row) {
                        return [
                            'cn_number' => $row->booked_packet_cn,
                            'dispatch_date' => now()->toDateString(),
                            'weight' => $row->booked_packet_weight,
                            'pcs' => $row->booked_packet_no_piece,
                            'amount' => $row->booked_packet_collect_amount,
                            'origin_city' => sprintf('%05d', $row->origin_city_name),
                            'dest_city' => sprintf('%05d', $row->destination_city_name),
                            'user_id' => '00000',
                            'activity_date' => now()->toDateString(),
                            'activity_time' => now()->format('H:i:s'),
                            'status' => 'CREATE',
                            'shipper_name' => addslashes($row->shipper_name),
                            'shipper_address' => addslashes($row->shipper_address),
                            'email_from' => $row->shipment_email,
                            'consignee_name' => addslashes($row->consignment_name),
                            'email_to' => $row->consignment_email,
                            'consigne_phone' => extractOnlyNumbers($row->consignment_phone) . ' ' . extractOnlyNumbers($row->consignment_phone_two) . ' ' . extractOnlyNumbers($row->consignment_phone_three),
                            'consignee_address' => addslashes($row->consignment_address),
                            'remarks' => addslashes($row->booked_packet_comments),
                            'client_id' => '',
                        ];
                    });

                    if (!empty($bookedPacketsWithDetail)) {
                       // $insert =  DB::connection('billing')->table('cod_dispatch')->insert($bookedPacketsWithDetail->toArray());
//                        if($insert) {
                            $parameter = implode(",", $cnList);
                            DB::select("CALL cronUpdateReceiveStatus(?)", [$parameter]);
//                        }
                    }
                }

            }

        }
        $cron_job->updated_at =  date('Y-m-d H:i:s');
        $cron_job->save();

    }
}
