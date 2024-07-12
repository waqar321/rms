<?php

namespace App\Jobs;

use App\Models\Admin\ecom_activity_remark;
use App\Models\Admin\ecom_booked_packet_history;
use App\Models\Admin\ecom_booked_packet_model;
use App\Models\Admin\ecom_city;
use App\Models\Admin\KYC\lss_ref_city;
use App\Models\Admin\KYC\lss_ref_rate_matrix_corporate;
use App\Models\Admin\ecom_consignee;
use App\Models\Admin\ecom_files;
use App\Models\Admin\ecom_merchant;
use App\Models\Admin\ecom_saved_cn_numbers;
use App\Models\Admin\ecom_shipment_types;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DB;

class BatchBooking implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $booking;
    protected $user;
    protected $merchant;
    protected $batch;
    protected $check_cn_extra;
    protected $cnListArray;
    protected $CityIDs;
    protected $CityList;
    public function __construct($booking,array $user,array $merchant,$batch,array $check_cn_extra,array $cnListArray,array $CityIDs,array $CityList)
    {
        $this->queue = 'booking_a_packet_batch';
        $this->booking =  $booking;
        $this->user = (object) $user;
        $this->merchant = (object) $merchant;
        $this->batch =  $batch;
        $this->check_cn_extra = $check_cn_extra;
        $this->cnListArray = $cnListArray;
        $this->CityIDs = $CityIDs;
        $this->CityList = $CityList;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $date = date('Y-m-d H:i:s');
        $admin_id = $this->user->id;
        $merchant_id = $this->merchant->id;
        $merchant_city = $this->merchant->city_id;
        $merchant_account_no = $this->merchant->merchant_account_no;
        $batch_no = $this->batch;
        $additionalData = array();
        $remarks = array();
        $IssuedCnShort = array();
        foreach ($this->booking as $key =>$value){
            $cn_short = $value['cn_short'];
            $booked_packet_cn = $value['booked_packet_cn'];
            $shipperName = $value['shipperName'];
            $shipperPhone = $value['shipperPhone'];
            $shipperAddress = addslashes($value['shipperAddress']);
            $shipperEmail = $value['shipperEmail'];
            $OriginCityName = $value['OriginCityName'];
            $consigneeName = $value['consigneeName'];
            $consigneeEmail = $value['consigneeEmail'];
            $consigneePhone = $value['consigneePhone'];
            $consigneeAddress = addslashes($value['consigneeAddress']);
            $DestinationCityName = $value['DestinationCityName'];
            $bookedPacketCollectAmount = $value['bookedPacketCollectAmount'];
            $bookedpacketorderid = $value['bookedpacketorderid'];
            $ProductDescription = $value['ProductDescription'];
            $bookedPacketWeight = $value['bookedPacketWeight'];
            $shipment_type = $value['shipment_type'];
            $numberOfPieces = $value['numberOfPieces'];
            $return_city = $value['return_city'] ? $value['return_city'] : null;
            $return_address = $value['return_address'] ? addslashes($value['return_address']) : null;


            $OriginCityName =      $this->CityIDs[array_search(strtolower($OriginCityName),$this->CityList)];
            $DestinationCityName =  $this->CityIDs[array_search(strtolower($DestinationCityName),$this->CityList)];
//            $OriginCityName =      ecom_city::where('city_name', $OriginCityName)->where('is_active',1)->where('is_deleted',0)->first()->id;
//            $DestinationCityName =  ecom_city::where('city_name', $DestinationCityName)->where('is_active',1)->where('is_deleted',0)->first()->id;

//            $CnData =  ecom_saved_cn_numbers::getSingleCN($shipment_type,$OriginCityName,1);

            if ($shipment_type != 1 && $numberOfPieces >= 1) {
            } else {
                $numberOfPieces = 1;
            }

            if (!isset($return_address)) {
                $return_address = $shipperAddress;
            }
            if (!isset($return_city)) {
                $return_city = $OriginCityName;
            }else{
//                $return_city =  ecom_city::where('city_name', $return_city)->where('is_active',1)->where('is_deleted',0)->first()->id;
                $return_city =  $this->CityIDs[array_search(strtolower($return_city),$this->CityList)];
            }

            $consignee_data = array(
                'consignee_name' => $consigneeName,
                'consignee_email' => $consigneeEmail,
                'consignee_phone' => $consigneePhone,
                'consignee_address' => $consigneeAddress,
                'destination_city' => $DestinationCityName,
            );
            $shipper_data = array(
                'merchant_name' => $shipperName,
                'merchant_phone' => $shipperPhone,
                'merchant_address1' => $shipperAddress,
                'merchant_email' => $shipperEmail,
                'city_id' => $OriginCityName,
            );

            $consignment_id = ecom_consignee::add_consignee($consignee_data,$this->user);
            $shipper_id = ecom_merchant::ShipperFindAdd($shipper_data,$this->merchant,$this->user);

            $service_code = DB::table('service_view')->where('shipment_type_id',$shipment_type)->first();
            $zone_name = lss_ref_city::getCodZone($OriginCityName,$DestinationCityName,$service_code->service_code);

            $teriff = lss_ref_rate_matrix_corporate::getTariffRow($OriginCityName,$service_code->service_code,$zone_name,$bookedPacketWeight,$merchant_account_no);
            $booked_packet_charges = 0;
            if(!empty($teriff)) {
                if (isset($teriff->add_weight)) {
                    if ($teriff->add_weight == 0) {
                        $booked_packet_charges = $teriff->tarrif_rate;
                    } else {
                        $parcelWeight = $bookedPacketWeight;
                        $fromWeight = $teriff->from_weight / 1000;
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
                }
            }

            $packet_charges = $booked_packet_charges;

            $packet_data = array(
                'booked_packet_date' => $date,
                'booked_packet_option' => 1,
                'arival_dispatch_weight' => 0,
                'booked_packet_weight' => $bookedPacketWeight,
                'booked_packet_vol_weight' => 0,
                'booked_packet_vol_weight_cal' => 0,
                'booked_packet_no_piece' => ($numberOfPieces <= 0) ? 1 : $numberOfPieces,
                'booked_packet_collect_amount' => ($bookedPacketCollectAmount <= 0) ? 0 : $bookedPacketCollectAmount,
                'booked_packet_order_id' => $bookedpacketorderid,
                'origin_city' => $OriginCityName,
                'destination_city' => $DestinationCityName,
                'merchant_id' => $merchant_id,
                'shipper_id' => $shipper_id,
                'added_by' => $admin_id,
                'admin_user_id' => $admin_id,
                'booked_packet_comments' =>!empty($ProductDescription) ? addslashes($ProductDescription)  : 'Packet Comments are blank',
                'shipment_type_id' => $shipment_type,
                'booking_type_id' => 2,
                'booked_packet_charges' => $booked_packet_charges,
                'created_at' => $date,
                'updated_at' => null,
                'return_address' => $return_address,
                'return_city' => $return_city,
                'consignee_id' => $consignment_id,
                'is_valid' => 0,
                'batch_no' => $batch_no,
                'cn_short' => $cn_short,
                'booked_packet_cn' => $booked_packet_cn,
                'cod_zone_id' => null,
                'zone_name' => $zone_name,
                'service_code' => $service_code->service_code,
                'booked_packet_gst' => null,
                'vendor_pickup_charges' => null,
                'packet_charges' => $packet_charges,
                'return_charges' => null,
                'cash_handling_charges' => null,
                'booked_packet_status' => 0,
                'pickup_batch_id' => 0,
                'is_paid' => 0,
                'payment_received' => 0,
            );
            $booking_id =  ecom_booked_packet_model::insertGetId($packet_data);
            $IssuedCnShort[] =$cn_short;

            $additionalData[] = array(
                'booked_packet_id' => $booking_id,
                'cn_number' => $booked_packet_cn,
                'status' => 0,
                'reason' => '',
                'created_at' => $date,
            );

            $remarks[] = array(
                'remark_type' => 'booked_packet',
                'entity_id' => $booking_id,
                'instance_id' => $admin_id,
                'instance_type' => 0,
                'created_at' => $date,
                'remark_text' => 'Packet is Booked (CSV Import) and Auto CN # issued.'
            );

        }
        ecom_saved_cn_numbers::updateSingleCn($IssuedCnShort,1);
        ecom_booked_packet_history::insert($additionalData);
        ecom_activity_remark::insert($remarks);


        //On hold remaining cns if any
        foreach ($this->check_cn_extra as $key =>$value){
            if(isset($this->cnListArray[$value])) {
                if (count($this->cnListArray[$value]['cn_without_prefix']) > 0) {
                    $remaining_cns = (array) $this->cnListArray[$value]['cn_without_prefix'];
                    ecom_saved_cn_numbers::whereIn('cn_without_prefix',$remaining_cns)->update(['on_hold'=>0]);
                }
            }
        }

    }
}
