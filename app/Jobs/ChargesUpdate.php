<?php

namespace App\Jobs;

use App\Models\Admin\ecom_activity_remark;
use App\Models\Admin\KYC\lss_ref_cash_handling_client_wise;
use App\Models\Admin\KYC\lss_ref_rate_matrix_corporate;
use App\Models\Admin\ecom_booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DB;

class ChargesUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $booking;
    protected $request;
    protected $user;

    public function __construct($bookingIds, $request, $userId)
    {
        $this->queue = 'charges_update';
        $this->booking =  $bookingIds;
        $this->request = $request;
        $this->user = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        dd('checking');
        foreach ($this->booking as $key => $id) {
            $bookingData = ecom_booking::where('ecom_bookings.id', $id)
                ->leftJoin('ecom_merchant as em', 'em.id', '=', 'ecom_bookings.merchant_id')
                ->leftJoin('service_view as sv', 'sv.shipment_type_id', '=', 'ecom_bookings.shipment_type_id')
                ->select(
                    'ecom_bookings.origin_city',
                    'ecom_bookings.destination_city',
                    'ecom_bookings.shipment_type_id',
                    'ecom_bookings.booked_packet_status',
                    'ecom_bookings.booked_packet_weight',
                    'ecom_bookings.arival_dispatch_weight',
                    'ecom_bookings.booked_packet_collect_amount',
                    'sv.service_code',
                    'ecom_bookings.zone_name AS rating_zone',
                    'em.merchant_account_no',
                    'ecom_bookings.booked_packet_date'
                )->first();
            if($bookingData->service_code=="FO") $bookingData->service_code = "GO";
            //packet_charges
            $packageMaxWeight = max($bookingData->arival_dispatch_weight,$bookingData->booked_packet_weight);
            $teriff = lss_ref_rate_matrix_corporate::getTariffRow2($bookingData->origin_city,$bookingData->service_code,$bookingData->rating_zone,$packageMaxWeight,$bookingData->merchant_account_no,$bookingData->booked_packet_date); //put arrival dispatch weight here
            if(!empty($teriff)) {
                $booked_packet_charges =0;
                $return_charges =0;
                if (isset($teriff->add_weight)) {
                    $toWeight = $teriff->to_weight;
                    $parcelWeight = $packageMaxWeight;
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
                    $cash_handling_charges =0;
                    $chc = lss_ref_cash_handling_client_wise::cash_handling_charges($teriff->Id,$bookingData->merchant_account_no,$bookingData->booked_packet_collect_amount);
                    if(!empty($chc)){
                        if($chc->rate_type == "Fixed"){
                            $cash_handling_charges = $chc->rate;
                        }else{
                            if(!empty($bookingData->booked_packet_collect_amount) && !empty($chc->rate)) {
                                $cash_handling_charges = ($chc->rate * $bookingData->booked_packet_collect_amount) / 100;
                            }
                        }
                    }
                    else{
                        $chc = lss_ref_cash_handling_client_wise::cash_handling_above_charges($teriff->Id,$bookingData->merchant_account_no,$bookingData->booked_packet_collect_amount);
                        // dd($chc);
                        if(!empty($chc)){
                            if($chc->above_charges_rate == "Fixed"){
                                $cash_handling_charges = $chc->above_charges_rate;
                            }else{
                                if(!empty($bookingData->booked_packet_collect_amount) && !empty($chc->above_charges_rate)) {
                                    $cash_handling_charges = (float)($chc->above_charges_rate * (float)$bookingData->booked_packet_collect_amount) / 100;
                                }
                            }
                        }
                    }
                }
                if($bookingData->booked_packet_status==7){
                    if (isset($teriff->add_weight)) {
                        if ($teriff->add_weight == 0 || $toWeight > $parcelWeight) {
                            $return_charges = $teriff->return_rate;
                        } else {
                            $parcelWeight = $packageMaxWeight;
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
                $total = (float) $booked_packet_charges+$cash_handling_charges;
                $rateArray['booked_packet_charges'] = $total;
                $rateArray['packet_charges'] = $total;
                $rateArray['return_charges'] = $return_charges;
                $rateArray['updated_at'] = date('Y-m-d H:i:s');
                ecom_booking::where('id',$id)->update($rateArray);
            }
        }

    }
}
