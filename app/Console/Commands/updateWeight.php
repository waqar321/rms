<?php

namespace App\Console\Commands;

use App\Models\Admin\ecom_booking;
use App\Models\Admin\KYC\lss_ref_cash_handling_client_wise;
use App\Models\Admin\KYC\lss_ref_fuel_charges;
use App\Models\Admin\KYC\lss_ref_insurance_details;
use App\Models\Admin\KYC\lss_ref_insurance_master;
use App\Models\Admin\KYC\lss_ref_rate_matrix_corporate;
use Illuminate\Console\Command;
use DB;
use App\Models\Admin\CronJob;
class updateWeight extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'default:update_weight';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'COD Update Booking Weight';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cron_job = new CronJob();
        $cron_job->status = 1;
        $cron_job->cron_name = 'default:update_weight';
        $cron_job->created_at =  date('Y-m-d H:i:s');
        
        $days_update = 2;
        $start_date = date('Y-m-d', strtotime(date('Y-m-d') . ' -' . $days_update . ' days'));
        $end_date = date('Y-m-d');

        $bookedPacketList = array();
        $bookedPacketList2 = array();
        $bookedPacket = ecom_booking::select('booked_packet_cn')
            ->whereIn('booked_packet_status', [4, 5, 6, 7, 8, 9, 11, 12, 14, 16, 17])
            ->where('is_active', 1)
            ->where('is_deleted', 0)
            ->where(function ($query) {
                $query->whereNull('arival_dispatch_weight_date')
                    ->orWhere('arival_dispatch_weight', 0);
            })
            ->whereBetween('booked_packet_date', [$start_date, $end_date]);

        if($bookedPacket->exists()){

            $bookedPacketList = $bookedPacket->pluck('booked_packet_cn')->toArray();
            if(count($bookedPacketList) > 0){
                $weightQueryDispatch = DB::connection('oms')->table('book_dispatch')
                    ->selectRaw('MAX(weight) as arival_dispatch_weight, cn_number as booked_packet_cn')
                    ->whereIn('cn_number', $bookedPacketList)
                    ->groupBy('cn_number')
                    ->get();
                $dispatch_date = date('Y-m-d H:i:s');
                $weight_dataList = array();
                $dispatch_weight_dataArray = array();

                if ($weightQueryDispatch->count() > 0) {
                   foreach ($weightQueryDispatch as $key=>$row){
                        $data = [
                            'arival_dispatch_weight' => $row->arival_dispatch_weight,
                            'booked_packet_cn' => $row->booked_packet_cn,
                            'return_reason' => '',
                            'packet_received_by' => '',
                            'arival_dispatch_weight_date' => $dispatch_date,
                        ];
                        $dispatch_weight_dataArray[$row->booked_packet_cn] = $row->arival_dispatch_weight;
                        $weight_dataList[$row->booked_packet_cn] = $data;
                    }
                }


                $weightQueryArrival =  DB::connection('oms')->table('arival')
                    ->select('cn_number as booked_packet_cn', DB::raw('MAX(weight) as arival_dispatch_weight'), 'REASON as return_reason', 'RECEIVER_NAME as packet_received_by', 'ARVL_DATE', 'ARVL_TIME')
                    ->whereIn('cn_number',  $bookedPacketList)
                    ->groupBy('cn_number')
                    ->get();
                foreach ($weightQueryArrival as $key2=>$row){
                    $cn = $row->booked_packet_cn;
                    if (array_key_exists($cn, $dispatch_weight_dataArray)) {
                        if (!empty($weight_dataList[$cn]['arival_dispatch_weight'])) {
                            $weight_dataList[$cn]['arival_dispatch_weight'] = max($weight_dataList[$cn]['arival_dispatch_weight'], $row->arival_dispatch_weight);
                        } else {
                            $weight_dataList[$cn]['arival_dispatch_weight'] = $row->arival_dispatch_weight;
                        }
                        $weight_dataList[$cn]['packet_received_by'] = str_replace(['"', '/', "'"], '', $row->packet_received_by);
                        $weight_dataList[$cn]['arival_dispatch_weight_date'] = $row->ARVL_DATE . ' ' . $row->ARVL_TIME;
                    } else {
                        $weight_dataList[$cn]['booked_packet_cn'] = $cn;
                        $weight_dataList[$cn]['arival_dispatch_weight'] = $row->arival_dispatch_weight;
                        $weight_dataList[$cn]['packet_received_by'] = str_replace(['"', '/', "'"], '', $row->packet_received_by);
                        $weight_dataList[$cn]['arival_dispatch_weight_date'] = $row->ARVL_DATE . ' ' . $row->ARVL_TIME;
                    }
                }

                $updates = [];
                foreach ($weight_dataList as $row) {
                    $cn = $row['booked_packet_cn'];
                    $update = [
                        'arival_dispatch_weight' => max($row['arival_dispatch_weight'], 0), // Replace 0 with a default value if needed
                        'arival_dispatch_weight_date' => $row['arival_dispatch_weight_date'],
                    ];
                    if(isset($row['packet_received_by']) && !empty($row['packet_received_by'])){
                        $update['packet_received_by'] = $row['packet_received_by'];
                    }
                    if (!empty($row['return_reason'])) {
                        $update['return_reason'] = $row['return_reason'];
                    }
                    $updates[$cn] = $update;
                    ecom_booking::where('booked_packet_cn', $cn)->update($update);
                }

                if (count($weight_dataList) > 0) {
                    $ecom_booking = ecom_booking::whereIn('booked_packet_cn', $bookedPacketList)
                        ->where('arival_dispatch_weight','>','arival_dispatch_weight')
                        //whereIn('booked_packet_cn',[])
                        ->join('ecom_merchant as em', 'em.id', '=', 'ecom_bookings.merchant_id')
                        ->join('ecom_merchant_details as emd', 'emd.merchant_id', '=', 'em.id')
                        ->select('ecom_bookings.booked_packet_cn',
                            'ecom_bookings.id',
                            'ecom_bookings.origin_city',
                            'ecom_bookings.destination_city',
                            'ecom_bookings.shipment_type_id',
                            'ecom_bookings.booked_packet_status',
                            'ecom_bookings.arival_dispatch_weight',
                            'ecom_bookings.booked_packet_weight',
                            'ecom_bookings.booked_packet_collect_amount',
                            'ecom_bookings.service_code',
                            'emd.merchant_gst_per',
                            'ecom_bookings.zone_name AS rating_zone',
                            'em.merchant_account_no',
                            'ecom_bookings.booked_packet_date');

                    $cns = $ecom_booking->pluck('booked_packet_cn')->toArray();
                    $cnsId = $ecom_booking->pluck('id')->toArray();
                    $origin_city = $ecom_booking->pluck('origin_city')->toArray();
                    $destination_city = $ecom_booking->pluck('destination_city')->toArray();
                    $shipment_type_id = $ecom_booking->pluck('shipment_type_id')->toArray();
                    $service_code = $ecom_booking->pluck('service_code')->toArray();
                    $merchant_account_no = $ecom_booking->pluck('merchant_account_no')->toArray();
                    $rating_zone = $ecom_booking->pluck('rating_zone')->toArray();
                    $arival_dispatch_weight = $ecom_booking->pluck('arival_dispatch_weight')->toArray();
                    $booked_packet_weight = $ecom_booking->pluck('booked_packet_weight')->toArray();
                    $booked_packet_collect_amount = $ecom_booking->pluck('booked_packet_collect_amount')->toArray();
                    $merchant_gst_per = $ecom_booking->pluck('merchant_gst_per')->toArray();
                    $booked_packet_status = $ecom_booking->pluck('booked_packet_status')->toArray();
                    $booked_packet_date = $ecom_booking->pluck('booked_packet_date')->toArray();

                    $updated_at = date('Y-m-d H:i:s');
                    foreach ($cns as $key=>$booked_cn){
                        $rateArray = array();
                        $booked_packet_charges = 0;
                        $cash_handling_charges = 0;
                        $return_charges = 0;
                        $booked_packet_gst = 0;
                        $fuel_sercg_charges = 0;
                        $insurance_amount = 0;

                        if($service_code[$key]=="FO") $service_code[$key] = "GO";
                        //packet_charges
                        $packageMaxWeight[$key] = max($arival_dispatch_weight[$key],$booked_packet_weight[$key]);

                        $teriff = lss_ref_rate_matrix_corporate::getSpecialTariffRow($origin_city[$key],$service_code[$key],$destination_city[$key],$packageMaxWeight[$key],$merchant_account_no[$key],$booked_packet_date[$key]); //put arrival dispatch weight here
                        
                        if(empty($teriff)){
                            $teriff = lss_ref_rate_matrix_corporate::getTariffRow2($origin_city[$key],$service_code[$key],$rating_zone[$key],$packageMaxWeight[$key],$merchant_account_no[$key],$booked_packet_date[$key]); //put arrival dispatch weight here
                        }

                        if(!empty($teriff)) {
                            $parcelWeight = $packageMaxWeight[$key];
                            $toWeight = $teriff->to_weight;
                            if (isset($teriff->add_weight)) {
                                if ($teriff->add_weight == 0 || $toWeight > $parcelWeight) {
                                    $booked_packet_charges = $teriff->tarrif_rate;
                                } else {
                                    $fromWeight = $teriff->to_weight;
                                    $additionalWeight = $teriff->add_weight;
                                    $additionalWeightRate = $teriff->add_charges;
                                    $tariffRate = $teriff->tarrif_rate;

                                    $remainingWeight = $parcelWeight - $fromWeight;
                                    $remainder = $remainingWeight % $additionalWeight;
                                    if ($remainder < $additionalWeight) {
                                        $differenceWeight = $additionalWeight - $remainder;
                                        $totalWeight = $remainingWeight + $differenceWeight;
                                        $weightChunks = $totalWeight / $additionalWeight;
                                        if ($remainder == 0) {
                                            $weightChunks = $remainingWeight / $additionalWeight;
                                        }

                                        $booked_packet_charges = ($tariffRate + ($weightChunks * $additionalWeightRate)); // Setting total with weight calculation
                                    }
                                }

                                //cash handle
                                $chc = lss_ref_cash_handling_client_wise::cash_handling_charges($teriff->Id,$merchant_account_no[$key],$booked_packet_collect_amount[$key]);
                                if(!empty($chc)){
                                    if($chc->rate_type == "Fixed"){
                                        $cash_handling_charges = $chc->rate;
                                    }else{
                                        if(!empty($booked_packet_collect_amount[$key]) && !empty($chc->rate)) {
                                            $cash_handling_charges = ($chc->rate * $booked_packet_collect_amount[$key]) / 100;
                                        }
                                    }
                                }
                                else{

                                    $chc = lss_ref_cash_handling_client_wise::cash_handling_above_charges($teriff->Id,$merchant_account_no[$key],$booked_packet_collect_amount[$key]);
                                    if(!empty($chc)){
                                        if($chc->above_charges_type == "Fixed"){
                                            $cash_handling_charges = $chc->above_charges_rate;
                                        }else{
                                            if(!empty($booked_packet_collect_amount[$key]) && !empty($chc->above_charges_rate)) {
                                                $cash_handling_charges = (float)($chc->above_charges_rate * (float)$booked_packet_collect_amount[$key]) / 100;
                                            }
                                        }
                                    }

                                }
                            }

                            if($booked_packet_status[$key] == 7){
                                if (isset($teriff->add_weight)) {
                                    if ($teriff->add_weight == 0 || $toWeight > $parcelWeight) {
                                        $return_charges = $teriff->return_rate;
                                    } else {
                                        $parcelWeight = $packageMaxWeight[$key];
                                        $fromWeight = $teriff->to_weight;
                                        $additionalWeight = $teriff->add_weight;
                                        $additionalWeightRate = $teriff->add_charges;
                                        $tariffRate = $teriff->return_rate;

                                        $remainingWeight = $parcelWeight - $fromWeight;
                                        $remainder = $remainingWeight % $additionalWeight;
                                        if ($remainder < $additionalWeight) {
                                            $differenceWeight = $additionalWeight - $remainder;
                                            $totalWeight = $remainingWeight + $differenceWeight;
                                            $weightChunks = $totalWeight / $additionalWeight;
                                            if ($remainder == 0) {
                                                $weightChunks = $remainingWeight / $additionalWeight;
                                            }

                                            $return_charges = ($tariffRate + ($weightChunks * $additionalWeightRate)); // Setting total with weight calculation
                                        }
                                    }
                                }
                                $booked_packet_charges = $return_charges;
                                $cash_handling_charges = 0;
                            }



                            //insurance
                            $ins = lss_ref_insurance_master::get_insurance_value($merchant_account_no[$key],$booked_packet_collect_amount[$key]);
                            if(!empty($ins)){
                                if($ins->insurance_above_type == "Fixed"){
                                    $insurance_amount = $ins->rate;
                                }else{
                                    if(!empty($booked_packet_collect_amount[$key]) && !empty($ins->rate)) {
                                        $insurance_amount = $booked_packet_collect_amount[$key] + ($ins->rate / $booked_packet_collect_amount[$key]) * 100;
                                        }
                                    }
                                }
                                //fuel serch_charge

                            $fsc = lss_ref_fuel_charges::get_fuel_charge($merchant_account_no[$key],$teriff->Id); //223866
                            if(!empty($fsc)){
                                $fuel_sercg_charges = $fsc->fuelprice;
                                }
                        }

                        $booked_packet_gst = !empty($merchant_gst_per[$key]) ? $merchant_gst_per[$key] : 0;
                        $total = (float) $booked_packet_charges +(float) $cash_handling_charges+ (float)$insurance_amount;
                        $rateArray['booked_packet_charges'] =          $total;
                        $rateArray['packet_charges'] =          $total;
                        $rateArray['cash_handling_charges'] =   $cash_handling_charges;
                        $rateArray['return_charges'] =          $return_charges;
                        $rateArray['booked_packet_gst'] =       $booked_packet_gst;
                        $rateArray['fuel_sercg_charges'] =      $fuel_sercg_charges;
                        $rateArray['insurance_amount'] =        $insurance_amount;
                        $rateArray['updated_at'] =              $updated_at;
                        $rateArray['booked_packet_collect_amount'] =  $booked_packet_collect_amount[$key];
                        $updateRates[$cnsId[$key]] = $rateArray;
                        $update =  ecom_booking::where('id',$cnsId[$key])->update($rateArray);
                    }
                }

            }

        }

        $cron_job->updated_at =  date('Y-m-d H:i:s');
        $cron_job->save();
        echo "success";
    }
}
