<?php

namespace App\Models\Admin;

use App\Models\Admin\ecom_merchant_finance;
use App\Models\Admin\KYC\lss_ref_client;
use App\Models\Admin\KYC\lss_ref_fuel_charges;
use App\Models\Admin\KYC\lss_ref_fuel_type;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ecom_merchant extends Model
{
    protected $table = 'ecom_merchant';
    protected $guarded = [];
    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s",
        'updated_at' => "datetime:Y-m-d H:i:s",
    ];

    public function city()
    {
        return $this->belongsTo(ecom_city::class);
    }

    public function merchantDetails()
    {
        return $this->belongsTo(ecom_merchant_details::class, 'id', 'merchant_id');
    }

    public function merchantfuelHistory()
    {
        return $this->belongsTo(ecom_merchant_fuel_history::class, 'id', 'merchant_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function recoveryCity()
    {
        return $this->belongsTo(ecom_city::class, 'recovery_city_id', 'id');
    }

    public function contactPerson()
    {
        return $this->hasMany(ecom_merchant_representative::class, 'merchant_id', 'id');
    }

    public function packingMaterialRate()
    {
//        return ecom_merchant_material::leftJoin('ecom_material', 'ecom_material.id', '=', 'ecom_merchant_material.merchant_id')
//            ->where('ecom_merchant_material.merchant_id', $this->merchant_id)
//            ->where('ecom_material.is_active', 1)
//            ->where('ecom_material.is_deleted', 0)
//            ->get(['ecom_material.id', 'ecom_material.material_name', 'ecom_merchant_material.material_value'])->toArray();
        return $this->hasMany(ecom_merchant_material::class, 'merchant_id', 'id');
    }

    public function finance()
    {
        return $this->hasOne(ecom_merchant_finance::class, 'merchant_id', 'id');
    }

    public function admin_user()
    {
        return $this->belongsTo(ecom_admin_user::class, 'id', 'merchant_id');
    }

    static function Dump($request, $admin)
    {

        $current_merchant_id = $admin->merchant_id;
        $admin_user_id = $admin->id;
        $merchantData = [
            'merchant_name' => strtoupper($request['merchant_name']),
            'merchant_email' => $request['merchant_email'],
            'merchant_phone' => $request['merchant_phone'],
            'merchant_address1' => $request['merchant_address1'],
            'admin_user_id' => $admin_user_id,
            'parent_id' => $current_merchant_id,
            'city_id' => $request['city_id'],
            'area_id' => (isset($request['area_id'])) ? $request['area_id'] : null,
            'subarea_id' => (isset($request['subarea_id'])) ? $request['subarea_id'] : null,
            'account_type_id' => 2,
            'is_settlement' => isset($request['is_settlement']) ? 1 : 0,
            'created_at' => now(),
        ];

        $merchant = new static($merchantData);
        $merchant->save();
        $merchant_id = $merchant->id;
        $bank_detail = [
            'merchant_id' => $merchant_id,
            'bank_id' => isset($request['bank_id']) ? $request['bank_id'] : null,
            'bank_branch' => isset($request['bank_branch']) ? $request['bank_branch'] : null,
            'bank_ac_title' => isset($request['bank_ac_title']) ? $request['bank_ac_title'] : null,
            'bank_ac_no' => isset($request['bank_ac_no']) ? $request['bank_ac_no'] : null,
            'iban_no' => isset($request['iban_no']) ? $request['iban_no'] : null,
            'created_at' => now(),
        ];
        ecom_merchant_finance::insert($bank_detail);

        return $merchant_id;
    }

    static function dumpClientData($request)
    {

        $admin_user_id = $request->user()->id;
        $date = date('Y-m-d H:i:s');
        $data = [
            'merchant_account_opening_date' => $request->merchant_account_opening_date,
            'is_active' => $request->is_active,
            'city_id' => $request->city_id,
            'merchant_account_no' => $request->merchant_id,
            'merchant_central_account' => $request->merchant_central_account,
            'account_type_id' => $request->account_type_id,
            'merchant_name' => $request->merchant_name,
            'company_branch' => $request->company_branch,
            'merchant_phone' => $request->merchant_phone,
            'merchant_email' => $request->merchant_email,
            'merchant_address1' => $request->merchant_address1,
            'client_type' => $request->client_type,
            'is_settlement' => isset($request->is_settlement) ? $request->is_settlement : 0,
            'admin_user_id' => $admin_user_id,
            'parent_id' => 0,
            'created_at' => $date,
        ];

        $merchant = self::create($data);

        $merchant_detail = [
            'merchant_id' => $merchant->id,
            'merchant_gst' => isset($request->merchant_gst) ? $request->merchant_gst : null,
            'merchant_ntn' => isset($request->merchant_ntn) ? $request->merchant_ntn : null,
            'merchant_gst_per' => isset($request->merchant_gst_per) ? $request->merchant_gst_per : null,
            'merchant_discount' => isset($request->merchant_discount) ? $request->merchant_discount : null,
            'referred_by' => isset($request->referred_by) ? $request->referred_by : null,
            'referred_commission' => isset($request->referred_commission) ? $request->referred_commission : null,
            'recovery_by' => isset($request->recovery_by) ? $request->recovery_by : null,
            'recovery_commission' => isset($request->recovery_commission) ? $request->recovery_commission : null,
            'sale_person' => isset($request->sale_person) ? $request->sale_person : null,
            'sale_person_commission' => isset($request->sale_person_commission) ? $request->sale_person_commission : null,
            'commissionable_month' => isset($request->commissionable_month) ? $request->commissionable_month : null,
            'pickup_start_time' => isset($request->pickup_start_time) ? $request->pickup_start_time : null,
            'pickup_end_time' => isset($request->pickup_end_time) ? $request->pickup_end_time : null,
            'created_at' => $date,
        ];

        ecom_merchant_details::create($merchant_detail);

        foreach (range(1, 3) as $key => $value) {
            $index = $value++;
            $representative = [
                'merchant_representative_name' => $request->contact_person . $index,
                'merchant_representative_des' => $request->contact_person_des . $index,
                'merchant_representative_phone' => $request->contact_person_phone . $index,
                'merchant_id' => $merchant->id,
            ];
            ecom_merchant_representative::create($representative);
        }

        if (isset($request->finance_id)) {
            foreach ($request->finance_id as $key => $financeId) {
                $bankDetail = [
                    'client_id' => $request->merchant_id,
                    'merchant_id' => $merchant->id,
                    'bank_id' => $request->bank_id[$key],
                    'bank_branch' => $request->bank_branch[$key],
                    'bank_ac_title' => $request->bank_ac_title[$key],
                    'bank_ac_no' => $request->bank_ac_no[$key],
                    'iban_no' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                ecom_merchant_finance::where('id', $financeId)->update($bankDetail);

                if ($financeId == null) {
                    ecom_merchant_finance::insert($bankDetail);
                }
            }
        }

        $admin_user = [
            'user_type_id' => 2,
            'merchant_id' => $merchant->id,
            'shipper_id' => 0,
            'is_parent' => 0,
            'city_id' => $request->city_id,
            'username' => $request->user_name,
            'first_name' => $request->merchant_name,
            'email' => $request->merchant_email,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'password' => bcrypt(123456),
            'city_rights' => 1,
        ];

        ecom_admin_user::create($admin_user);

        $material_id = $request->material_id;
        $material_value = $request->material_value;
        $make_data = null;
        foreach ($material_id as $key => $material) {
            ecom_merchant_material::create([
                'merchant_id' => $merchant->id,
                'material_id' => $material,
                'material_value' => $material_value[$key],
            ]);
        }

    }


    static function updateClientData($request)
    {

        $date = date('Y-m-d H:i:s');
        $data = [
            'merchant_account_opening_date' => $request->merchant_account_opening_date,
            'is_active' => $request->is_active,
            'city_id' => $request->city_id,
            'merchant_name' => $request->merchant_name,
            'company_branch' => $request->company_branch,
            'merchant_phone' => $request->merchant_phone,
            'merchant_email' => $request->merchant_email,
            'merchant_address1' => $request->merchant_address1,
            'client_type' => $request->client_type,
            'is_settlement' => isset($request->is_settlement) ? $request->is_settlement : 0,
            'created_at' => $date,
        ];

        ecom_merchant::where('id', $request->merchant_id)->update($data);

        $merchant_detail = [
            'merchant_id' => $request->merchant_id,
            'merchant_gst' => isset($request->merchant_gst) ? $request->merchant_gst : null,
            'merchant_ntn' => isset($request->merchant_ntn) ? $request->merchant_ntn : null,
            'merchant_gst_per' => isset($request->merchant_gst_per) ? $request->merchant_gst_per : null,
            'merchant_discount' => isset($request->merchant_discount) ? $request->merchant_discount : null,
            'commissionable_month' => isset($request->commissionable_month) ? $request->commissionable_month : null,
            'pickup_start_time' => isset($request->pickup_start_time) ? $request->pickup_start_time : null,
            'pickup_end_time' => isset($request->pickup_end_time) ? $request->pickup_end_time : null,
            'created_at' => $date,
        ];

        ecom_merchant_details::where('merchant_id', $request->merchant_id)->update($merchant_detail);

        foreach (range(1, 3) as $key => $value) {
            $index = $value++;
            $representative = [
                'merchant_representative_name' => $request->contact_person . $index,
                'merchant_representative_des' => $request->contact_person_des . $index,
                'merchant_representative_phone' => $request->contact_person_phone . $index,
                'merchant_id' => $request->merchant_id,
            ];
            ecom_merchant_representative::where('merchant_id', $request->merchant_id)->update($representative);
        }

        if (isset($request->finance_id)) {
            foreach ($request->finance_id as $key => $financeId) {
                $bankDetail = [
                    'client_id' => $request->merchant_account_no,
                    'merchant_id' => $request->merchant_id,
                    'bank_id' => $request->bank_id[$key],
                    'bank_branch' => $request->bank_branch[$key],
                    'bank_ac_title' => $request->bank_ac_title[$key],
                    'bank_ac_no' => $request->bank_ac_no[$key],
                    'iban_no' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                ecom_merchant_finance::where('id', $financeId)->update($bankDetail);
                if ($financeId == null) {
                    ecom_merchant_finance::insert($bankDetail);
                }
            }
        }

        $adminUser = ecom_admin_user::where('username', $request->user_name)->first();

        $admin_user = [
            'user_type_id' => 2,
            'merchant_id' => $request->merchant_id,
            'shipper_id' => 0,
            'is_parent' => 0,
            'city_id' => $request->city_id,
            'first_name' => $request->merchant_name,
            'email' => $request->merchant_email,
            'city_rights' => 1,
        ];


        if (!$adminUser) {
            $admin_user['user_name'] = $request->user_name;
        }

        ecom_admin_user::where('merchant_id', $request->merchant_id)->update($admin_user);

        $kycClient = lss_ref_client::where('CLNT_ID', $request->merchant_account_no)->update([
            'ADDRESS' => $request->merchant_address1,
            'NTN_NO' => $request->merchant_ntn,
            'GST_NO' => $request->merchant_gst,
            'GST' => $request->merchant_gst_per,
            'Discount' => $request->merchant_discount,
            'CONT_PERSON1' => $request->contact_person1,
            'CP1_DESIGNATION' => $request->contact_person_des1,
            'Cell1' => $request->contact_person_phone1,
            'CONT_PERSON2' => $request->contact_person2,
            'CP2_DESIGNATION' => $request->contact_person_des2,
            'Cell2' => $request->contact_person_phone2,
            'CONT_PERSON3' => $request->contact_person3,
            'CP3_DESIGNATION' => $request->contact_person_des3,
            'Cell3' => $request->contact_person_phone3,
            'commissionable_month' => $request->commissionable_month,
        ]);
    }

    static function getShippers($request)
    {

        return self::where('is_active', 1)->where('is_deleted', 0)
            ->orderby('id', 'asc')->get();
    }


    public static function getClientTariffDetails($merchantId)
    {
        return self::where('id', $merchantId)->get();
    }

    static function getShipperById($request)
    {
        $shipper_id = $request->shipper_id;
        return self::with('city')->where('is_active', 1)
            ->where('id', $shipper_id)
            ->first();
    }

    static function ShipperFindAdd($request, $merchant, $admin)
    {
        $shipper_id = null;
        $parent_id = $merchant->parent_id;
        $merchant_id = $merchant->id;
        $shipper = self::where('merchant_name', strtoupper($request['merchant_name']))
            ->where('merchant_email', $request['merchant_email'])
            ->where('merchant_phone', $request['merchant_phone'])
            ->where('is_deleted', '0')
            ->where('is_active', '1');

        if ($parent_id == $merchant_id) {
            $shipper->where('parent_id', $parent_id);
        }

        if ($shipper->exists()) {
            $shipper = $shipper->first();
            $shipper_id = $shipper->id;
        } else {
            $shipper_id = self::Dump($request, $admin);
        }
        return $shipper_id;
    }
}
