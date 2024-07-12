<?php

namespace App\Jobs;

use App\Models\Admin\ecom_merchant;
use App\Models\Admin\ecom_activity_remark;
use App\Models\Admin\ecom_booked_packet_history;
use App\Models\Admin\ecom_booked_packet_model;
use App\Models\Admin\ecom_city;
use App\Models\Admin\KYC\lss_ref_city;
use App\Models\Admin\KYC\lss_ref_rate_matrix_corporate;
use App\Models\Admin\ecom_consignee;
use App\Models\Admin\ecom_saved_cn_numbers;
use App\Models\Admin\ecom_state;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BookPacket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $booking;
    protected $user;

    public function __construct(array $booking,array $user)
    {
        $this->queue = 'booking_a_packet';
        $this->booking = $booking;
        $this->user = (object) $user;

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
        $merchant_id = $this->booking['client_id'];
        $merchantData = ecom_merchant::find($merchant_id);
        $merchant_city = $merchantData->city_id;
        $merchant_account_no = $merchantData->merchant_account_no;
        if(!isset($this->booking['booking_id']) && empty($this->booking['booking_id'])){
            $CnData =  ecom_saved_cn_numbers::getSingleCNHold($this->booking['shipment_type_id'],$this->booking['origin_city'],0,$this->booking);
        }
        $data['booking_type_id'] = isset($this->booking['booking_type_id'])  ? $this->booking['booking_type_id'] : 2;
        //$data['cod_zone_id'] = ecom_city::getCodZone($this->booking['origin_city'],$this->booking['destination_city']);
        $data['zone_name'] = lss_ref_city::getCodZone($this->booking['origin_city'],$this->booking['destination_city'],$this->booking['service_code']);
        $data['shipment_type_id'] = $this->booking['shipment_type_id'];
        $data['service_code'] = $this->booking['service_code'];
        $data['booked_packet_no_piece'] = $this->booking['booked_packet_no_piece'];
        $data['booked_packet_weight'] = $this->booking['booked_packet_weight'];
        $data['arival_dispatch_weight'] = 0;

        if (!empty($this->booking['booked_packet_vol_weight_w']) && !empty($this->booking['booked_packet_vol_weight_h'])  && !empty($this->booking['booked_packet_vol_weight_l'])) {
            $data['booked_packet_vol_weight'] = $this->booking['booked_packet_vol_weight_w'] . ':' . $this->booking['booked_packet_vol_weight_h'] . ':' . $this->booking['booked_packet_vol_weight_l'];
            $data['booked_packet_vol_weight_cal'] = ($this->booking['booked_packet_vol_weight_w'] * $this->booking['booked_packet_vol_weight_h'] * $this->booking['booked_packet_vol_weight_l']) / 5000;

        } else {
            $data['booked_packet_vol_weight'] = '0:0:0';
            $data['booked_packet_vol_weight_cal'] = 0;
        }

        // if (isset($this->booking['booking_type_id']) && in_array($this->booking['booking_type_id'], ['1', '4'])) {
        //     $data['booking_type_id'] = $this->booking['booking_type_id'];
        //     $data['booked_packet_charges'] = (isset($this->booking['booked_packet_charges']) ? $this->booking['booked_packet_charges'] : 0);
        // } else {
        //     $data['booking_type_id'] = 2;
        //     $data['booked_packet_charges'] = 0;
        // }
        if(isset($this->booking['consignee_id'])){
            $consignment_id = $this->booking['consignee_id'];
        }
        else{

            $consignee_data = array(
                'consignee_name' =>    isset($this->booking['consignee_name']) ?  $this->booking['consignee_name']: null,
                'consignee_email' =>   isset($this->booking['consignee_email']) ?  $this->booking['consignee_email']:  null,
                'consignee_phone' =>   isset($this->booking['consignee_phone']) ?  $this->booking['consignee_phone']: null,
                'consignee_phone_2' => isset($this->booking['consignee_phone_2']) ? $this->booking['consignee_phone_2'] : null,
                'consignee_phone_3' => isset($this->booking['consignee_phone_3']) ? $this->booking['consignee_phone_3'] : null,
                'consignee_address' => isset($this->booking['consignee_address']) ? $this->booking['consignee_address'] :  null,
                'destination_city' =>  isset($this->booking['destination_city']) ? $this->booking['destination_city'] : null,
                'postal_code' =>  isset($this->booking['postal_code']) ? $this->booking['postal_code'] : null,
                'lat' =>  isset($this->booking['lat']) ? $this->booking['lat'] : null,
                'long' =>  isset($this->booking['long']) ? $this->booking['long'] : null,
                'consignee_area_id' =>  isset($this->booking['consignee_area_id']) ? $this->booking['consignee_area_id'] : null,
                'consignee_sub_area_id' =>  isset($this->booking['consignee_sub_area_id']) ? $this->booking['consignee_sub_area_id'] : null,
                'merchant_id' =>  isset($this->booking['merchant_id']) ? $this->booking['merchant_id'] : null,
            );
            $consignment_id = ecom_consignee::add_consignee($consignee_data,$this->user);

        }


        $this->booking['vendor_pickup_status'] = 0;
        $this->booking['is_child'] = 0;

        if(isset($this->booking['booking_reversal']) && !empty($this->booking['booking_reversal'])){
            $shipper_data = array(
                'merchant_name' =>    isset($this->booking['shipper_name']) ?  $this->booking['shipper_name']: null,
                'merchant_email' =>   isset($this->booking['shipper_email']) ?  $this->booking['shipper_email']:  null,
                'merchant_phone' =>   isset($this->booking['shipper_phone']) ?  $this->booking['shipper_phone']: null,
                'merchant_address1' => isset($this->booking['shipper_address']) ? $this->booking['shipper_address'] :  null,
                'parent_id' => $merchant_id
            );
            $shipper = ecom_merchant::create($shipper_data);
            $consignee_data = array(
                'merchant_id' => $merchant_id,
                'consignee_name' =>    isset($this->booking['consignee_name']) ?  $this->booking['consignee_name']: null,
                'consignee_email' =>   isset($this->booking['consignee_email']) ?  $this->booking['consignee_email']:  null,
                'consignee_phone' =>   isset($this->booking['consignee_phone']) ?  $this->booking['consignee_phone']: null,
                'consignee_phone_2' => isset($this->booking['consignee_phone_2']) ? $this->booking['consignee_phone_2'] : null,
                'consignee_phone_3' => isset($this->booking['consignee_phone_3']) ? $this->booking['consignee_phone_3'] : null,
                'consignee_address' => isset($this->booking['consignee_address']) ? $this->booking['consignee_address'] :  null,
                'destination_city' =>  isset($this->booking['destination_city']) ? $this->booking['destination_city'] : null,
                'postal_code' =>  isset($this->booking['postal_code']) ? $this->booking['postal_code'] : null,
                'lat' =>  isset($this->booking['lat']) ? $this->booking['lat'] : null,
                'long' =>  isset($this->booking['long']) ? $this->booking['long'] : null,
                'consignee_area_id' =>  isset($this->booking['consignee_area_id']) ? $this->booking['consignee_area_id'] : null,
                'consignee_sub_area_id' =>  isset($this->booking['consignee_sub_area_id']) ? $this->booking['consignee_sub_area_id'] : null,
            );
//            dd($consignee_data);
            $consignment_id = ecom_consignee::add_consignee($consignee_data,$this->user);
            $this->booking['merchant_id'] = $shipper->id;
            $this->booking['vendor_pickup_status'] = 1;
            $this->booking['is_child'] = 1;
            $data['booked_packet_status'] = 0;
            ecom_booked_packet_model::where('booked_packet_cn',$this->booking['booked_packet_order_id'])->update(['vendor_pickup_status'=>1]);
        }


        $data['booked_packet_no_piece'] = $this->booking['booked_packet_no_piece'];
        $data['booked_packet_collect_amount'] = $this->booking['booked_packet_collect_amount'];
        $data['booked_packet_order_id'] = isset($this->booking['booked_packet_order_id']) ? $this->booking['booked_packet_order_id'] : null;
        $data['origin_city'] = $this->booking['origin_city'];
        $data['destination_city'] = $this->booking['destination_city'];
        $data['merchant_id'] = $merchant_id ;
        $data['shipper_id'] = $this->booking['merchant_id'] ;
        $data['added_by'] = $admin_id;
        $data['admin_user_id'] = $admin_id;
        $data['consignee_id'] = $consignment_id;
        $data['booked_packet_comments'] = $this->booking['booked_packet_comments'];
        $data['booked_packet_date'] = $this->booking['booked_packet_date'];
        $data['booked_packet_option'] = 1;
        $data['return_address'] = isset($this->booking['return_address']) ? $this->booking['return_address'] : null;
        $data['return_city'] = isset($this->booking['return_city']) ? $this->booking['return_city'] : null;
        /*$data['booked_packet_status'] = 0;
        $data['return_charges'] = 0;
        $data['cash_handling_charges'] = 0;
        $data['fuel_factor_petrol'] = 0;
        $data['fuel_factor_diesel'] = 0;
        $data['fuel_factor_jet'] = 0;
        $data['booked_packet_gst'] = 0;
        $data['fuel_sercg_charges'] = 0;
        $data['pickup_batch_id'] = 0;
        $data['booking_type_id'] = 2;
        $data['is_paid'] = 0;
        $data['payment_received'] = 0;*/
        $data['vendor_pickup_status'] = $this->booking['vendor_pickup_status'];
        $data['is_child'] = $this->booking['is_child'];

        $teriff = lss_ref_rate_matrix_corporate::getTariffRow($data['origin_city'],$data['service_code'],$data['zone_name'],$data['booked_packet_weight'],$merchant_account_no);
        if(!empty($teriff)) {
            if ($teriff->add_weight == 0) {
                $data['booked_packet_charges'] = $teriff->tarrif_rate;
            } else {
                $parcelWeight = $data['booked_packet_weight'];
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

                    $data['booked_packet_charges'] = ($tariffRate + ($weightChunks * $additionalWeightRate)); // Setting total with weight calculation
                }
            }
        }
        $data['packet_charges'] = isset($data['booked_packet_charges']) ? $data['booked_packet_charges'] : 0;

        if(isset($this->booking['booking_id']) && !empty($this->booking['booking_id'])){

            $data['updated_at'] = date('Y-m-d H:i:s');
            unset($data['created_at']);

            ecom_booked_packet_model::where('id',$this->booking['booking_id'])->update($data);

            $additionalData = [
                'booked_packet_id' => $this->booking['booking_id'],
                //'cn_number' => $data['booked_packet_cn'],
                //'status' => $data['booked_packet_status'],
                'reason' => 'Booked Packet Details Updated',
                'created_at' => $date,
            ];

            ecom_booked_packet_history::insert($additionalData);
            ecom_activity_remark::addNewremark('booked_packet', $this->booking['booking_id'], $admin_id, 0, 'Packet is Updated.');
            return $this->booking['booking_id'];
        }else{

            $data['booked_packet_cn'] = $CnData->cn_with_prefix;
            $data['cn_short'] = $CnData->cn_without_prefix;
            $data['created_at'] = $date;

            $booking_id = ecom_booked_packet_model::addNewBooking($data);
            $additionalData = [
                'booked_packet_id' => $booking_id->id,
                'cn_number' => $CnData->cn_with_prefix,
                'status' => 0,
                'reason' => '',
                'created_at' => $date,
            ];

            ecom_booked_packet_history::insert($additionalData);
            ecom_activity_remark::addNewremark('booked_packet', $booking_id->id, $admin_id, 0, 'Packet is Booked ' . ($data['booking_type_id'] == 4 ? '(Web Service) ' : '') . 'and Manual CN # issued.');
            return $booking_id->id;
        }


    }
}
