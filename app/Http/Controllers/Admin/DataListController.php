<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ecom_account_type;
use App\Models\Admin\ecom_admin_user;
use App\Models\Admin\ecom_admin_user_city_rights;
use App\Models\Admin\ecom_bank_list;
use App\Models\Admin\ecom_branch;
use App\Models\Admin\ecom_city;
use App\Models\Admin\ecom_color_zone;
use App\Models\Admin\ecom_country;
use App\Models\Admin\ecom_material;
use App\Models\Admin\ecom_merchant;
use App\Models\Admin\ecom_overland_zone;
use App\Models\Admin\ecom_shipment_types;
use App\Models\Admin\ecom_state;
use App\Models\Admin\ecom_tier_cities;
use App\Models\Admin\ecom_tiers;
use App\Models\Admin\ecom_user_roles;
use App\Models\Admin\Role;
use App\Models\Admin\ecom_zone;
use App\Models\Admin\ecom_payment_method;
use App\Models\Admin\ecom_payment_status;
use App\Models\Admin\ecom_city_areas;
use App\Models\Admin\ecom_city_subareas;
use App\Models\Admin\oms_reasons;
use App\Models\Admin\central_ops_city;
use App\Models\Admin\central_ops_branch;
use App\Models\ecom_merchant_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DataListController extends Controller
{
    public function __construct()
    {
        // $this->ip = '103.121.120.133';
        // $this->codTicketApiUrl = "http://android.leopardscourier.com/CODTicketAPI/api/Shipper/";
        // $this->username = 'cod_api_shipper';
        // $this->password = 'P@k!$t@n4601$$+-#';
    }

    public function TestingApiData()
    {
        return json_encode('ye woring');

        $data =  collect([
            [1, 'testin glabel 1'],
            [2, 'testin glabel 2'],
            [3, 'testin glabel 3'],
            
        ]);

        return response()->json([
            'status' => 200,
            'data' => $data,
            'message' => 'Record Found',
        ], 200);

    }
    public function DataList()
    {
        $countries = ecom_country::where('is_active', '=', 1)->where('is_deleted', '=', 0)->get();
        $cities = ecom_city::where('is_active', '=', 1)->where('is_deleted', '=', 0)->get();
        $states = ecom_state::where('is_active', '=', 1)->where('is_deleted', '=', 0)->get();
        $zones = ecom_zone::where('is_active', '=', 1)->where('is_deleted', '=', 0)->get();
        $overlandZones = ecom_overland_zone::where('is_active', '=', 1)->where('is_deleted', '=', 0)->get();
        $colorZones = ecom_color_zone::where('is_active', '=', 1)->where('is_deleted', '=', 0)->get();
        $shipment_types = ecom_shipment_types::where('is_active', '=', 1)->where('is_deleted', '=', 0)->get();
        return response()->json(['countries' => $countries, 'cities' => $cities, 'states' => $states, 'zones' => $zones, 'overland_zones' => $overlandZones, 'color_zones' => $colorZones]);
    }

    public function getMerchantForSearch(Request $request)
    {
        $merchant=[];
        $selectMer = ecom_merchant::where(function ($query) use($request){
            $query->where('merchant_name','like',"%$request->term%")->orWhere('merchant_account_no','like',"%$request->term%");
        })
            ->where('is_active',1)
            ->where('is_deleted', 0)
            ->orderby('id','desc')->limit(10)->get();
        if ($selectMer) {
            foreach ($selectMer as $val) {
                $merchant[] = array('id' => $val->id, 'label' => $val->merchant_name .' ('.$val->merchant_account_no.')');
            }
        }
        return $merchant;
    }
    public function getMerchantForSearchParent(Request $request)
    {
        $merchant=[];
        $selectMer = ecom_merchant::where(function ($query) use($request){
            $query->where('merchant_name','like',"%$request->term%")->orWhere('merchant_account_no','like',"%$request->term%");
        })
            ->where('is_active',1)
            ->where('is_deleted', 0)
            ->whereNull('parent_id')
            ->orderby('id','desc')
            ->limit(10)->get();
        if ($selectMer) {
            foreach ($selectMer as $val) {
                $merchant[] = array('id' => $val->id, 'label' => $val->merchant_name .' ('.$val->merchant_account_no.')');
            }
        }
        return $merchant;
    }

    public function getMaterialList(Request $request)
    {
        $material=[];
        $selectMer = ecom_material::where(function ($query) use($request){
            $query->where('material_name','like',"%$request->term%");
        })
            ->where('is_active',1)
            ->where('is_deleted', 0)
            ->orderby('id','desc')->limit(10)->get();
        if ($selectMer) {
            foreach ($selectMer as $val) {
                $material[] = array('id' => $val->id, 'label' => $val->material_name);
            }
        }
        return $material;
    }

    public function getClients(Request $request)
    {
        $merchant=[];
        $selectMer = ecom_merchant::with('admin_user')
        ->join('migrated_clients','ecom_merchant.id','migrated_clients.merchant_id')
        ->where(function ($query) use($request){
            $query->where('merchant_name','like',"%$request->term%")
                ->OrWhere('merchant_account_no','like',"%$request->term%");
        })
        // ->where('ecom_merchant.id','ecom_merchant.parent_id')
        ->where('ecom_merchant.is_active',1)
        ->where('ecom_merchant.is_deleted', 0)
        ->whereNotNull('merchant_account_no');

        if(isset($request->city_id) && !empty($request->city_id)){
            $selectMer = $selectMer->where('city_id',$request->city_id);
        }

        $selectMer = $selectMer->orderby('ecom_merchant.id','desc')->limit(10)->get(['ecom_merchant.id','merchant_name','merchant_account_no','admin_user_id']);
        if ($selectMer) {
            foreach ($selectMer as $val) {
                $merchant[] = array('id' => $val->id, 'label' => $val->merchant_name ."($val->merchant_account_no)" ,'admin_user_id'=> isset($val->admin_user->id) ? $val->admin_user->id : 0 );
            }
        }
        return $merchant;
    }

    public function getClientsParent(Request $request)
    {
        $merchant=[];
        $selectMer = ecom_merchant::select('ecom_merchant.*','ad.id as admin_user_id')
            ->leftJoin('ecom_admin_user as ad', function ($join) {
                $join->on('ad.merchant_id', '=', 'ecom_merchant.id')
                    ->where('ad.id', '=', DB::raw("(SELECT MIN(id) FROM ecom_admin_user WHERE ecom_admin_user.merchant_id = ecom_merchant.id)"));
            })
        ->where(function ($query) use($request){
            $query->where('ecom_merchant.merchant_name','like',"%$request->term%")
                ->OrWhere('ecom_merchant.merchant_account_no','like',"%$request->term%");
        })
        ->where('ecom_merchant.is_active',1)
        ->whereNull('ecom_merchant.parent_id')
        ->where('ecom_merchant.is_deleted', 0)
        ->whereNotNull('ecom_merchant.merchant_account_no');

        if(isset($request->city_id) && !empty($request->city_id)){
            $selectMer = $selectMer->where('ecom_merchant.city_id',$request->city_id);
        }

        $selectMer = $selectMer->orderby('ecom_merchant.id','desc')->limit(10)->get();
        if ($selectMer) {
            foreach ($selectMer as $val) {
                $merchant[] = array('id' => $val->id, 'label' => $val->merchant_name ."($val->merchant_account_no)" ,'admin_user_id'=> isset($val->admin_user_id) ? $val->admin_user_id : 0 );
            }
        }
        return $merchant;
    }

    public function getShippers(Request $request)
    {
        $shipper=[];
        $selectMer = ecom_merchant::leftjoin('ecom_merchant_finance','merchant_id','ecom_merchant.id')
        ->where(function ($query) use($request){
            $query->where('merchant_name','like',"%$request->term%")->OrWhere('ecom_merchant.id','like',"%$request->term%");
        })
        ->where('parent_id',$request->merchant_id)
        ->where('ecom_merchant.is_active',1)
        ->where('ecom_merchant.is_deleted', 0)
        ->whereNull('merchant_account_no');

        if(isset($request->city_id) && !empty($request->city_id)){
            $selectMer = $selectMer->where('city_id',$request->city_id);
        }

        $selectMer = $selectMer->orderby('ecom_merchant.id','desc')->limit(10)->get(['ecom_merchant.id','ecom_merchant.merchant_name']);
        if ($selectMer) {
            foreach ($selectMer as $val) {
                $shipper[] = array('id' => $val->id, 'label' => $val->merchant_name ."($val->id)" );
            }
        }
        return $shipper;
    }

    public function getCityForSearch(Request $request)
    {
        $origin=[];
        $selectOri = ecom_city::where(function ($query) use($request){
            $query->where('city_name','like',"%$request->term%");
        })
            ->where('is_active',1)
            ->orderby('id','desc')->limit(10)->get();
        if ($selectOri) {
            foreach ($selectOri as $val) {
                $origin[] = array('id' => $val->id, 'label' => $val->city_name);
            }
        }
        return $origin;
    }

    public function clientWiseCity(Request $request)
    {

        $origin=[];
        $selectOri = central_ops_city::forceIndex('client_region')
            ->join('central_ops_branch', 'city_id_pbag', '=', 'branch_id')
            ->where(function ($query) use($request){
            $query->where('central_ops_city.city_name','like',"%$request->term%");
        })
            ->where('central_ops_branch.region', $request->region)
            ->where('central_ops_city.is_deleted', 0)
            ->where('central_ops_branch.is_deleted', 0)
            ->limit(10)
            ->get();
        if ($selectOri) {
            foreach ($selectOri as $val) {
                $origin[] = array('id' => $val->city_id, 'label' => $val->city_name);
            }
        }
        return $origin;

    }

    public function getZoneForSearch(Request $request)
    {
        $origin=[];
        $selectOri = central_ops_city::join('central_ops_branch', 'city_id_pbag', '=', 'branch_id')
        ->where('central_ops_city.is_deleted', 0)
        ->where('central_ops_branch.is_deleted', 0)
        ->where(function ($query) use($request){
            $query->where('central_ops_branch.zone','like',"%$request->term%");
        })
        ->groupBy('central_ops_branch.zone')
        ->orderby('central_ops_branch.zone','asc')
        ->get(['central_ops_branch.zone']);
        if ($selectOri) {
            foreach ($selectOri as $val) {
                $origin[] = array('id' => $val->zone, 'label' => $val->zone);
            }
        }
        return $origin;
    }

    public function getRegionForSearch(Request $request)
    {
        $origin=[];
        $selectOri = central_ops_city::join('central_ops_branch', 'city_id_pbag', '=', 'branch_id')
        ->where('central_ops_city.is_deleted', 0)
        ->where('central_ops_branch.is_deleted', 0)
        ->where(function ($query) use($request){
            $query->where('central_ops_branch.region','like',"%$request->term%");
        })
        ->groupBy('central_ops_branch.region')
        ->orderby('central_ops_branch.region','asc')
        ->get(['central_ops_branch.region']);
        if ($selectOri) {
            foreach ($selectOri as $val) {
                $origin[] = array('id' => $val->region, 'label' => $val->region);
            }
        }
        return $origin;
    }

    public function getReasonForSearch(Request $request)
    {
        $reason=[];
        $selectReason = oms_reasons::where(function ($query) use($request){
            $query->where('Reason','like',"%$request->term%");
        })
            ->orderby('R_Code','desc')->get();
        if ($selectReason) {
            foreach ($selectReason as $val) {
                $reason[] = array('id' => $val->R_Code, 'label' => $val->Reason);
            }
        }
        return $reason;
    }

    public function getTierCityForSearch(Request $request)
    {
        $origin=[];
        $tierCities = ecom_tier_cities::pluck('city_id')->toArray();
        $selectOri = ecom_city::where(function ($query) use($request){
            $query->where('city_name','like',"%$request->term%");
        })
            ->whereNotIn('id', $tierCities)
            ->where('is_active',1)
            ->orderby('id','desc')->limit(10)->get();
        if ($selectOri) {
            foreach ($selectOri as $val) {
                $origin[] = array('id' => $val->id, 'label' => $val->city_name);
            }
        }
        return $origin;
    }

    public function getTierForSearch(Request $request)
    {
        $tier=[];
        $selectTier = ecom_tiers::where(function ($query) use($request){
            $query->where('label','like',"%$request->term%");
        })
            ->where('is_active',1)
            ->orderby('id','desc')->limit(10)->get();
        if ($selectTier) {
            foreach ($selectTier as $val) {
                $tier[] = array('id' => $val->id, 'label' => $val->label);
            }
        }
        return $tier;
    }

    public function getSalesPersonForSearch(Request $request)
    {
        $origin=[];
        $selectOri = ecom_admin_user::where(function ($query) use($request){
            $query->where('first_name','like',"%$request->term%");
        })
            ->where('is_active',1)
            ->where('user_type_id', 3)
            ->orderby('id','desc')->limit(10)->get();
        if ($selectOri) {
            foreach ($selectOri as $val) {
                $origin[] = array('id' => $val->id, 'label' => $val->first_name .' '. $val->last_name .' - '. $val->id);
            }
        }
        return $origin;
    }

    public function getCountryForSearch(Request $request)
    {
        $origin=[];
        $selectCountry = ecom_country::where(function ($query) use($request){
            $query->where('country_name','like',"%$request->term%");
        })
            ->where('is_active',1)
            ->orderby('id','desc')->limit(10)->get();
        if ($selectCountry) {
            foreach ($selectCountry as $val) {
                $origin[] = array('id' => $val->id, 'label' => $val->country_name);
            }
        }
        return $origin;
    }

    public function getAreas(Request $request)
    {
        $area[]=[];
        $selectArea = ecom_city_areas::where(function ($query) use($request){
            $query->where('area_title','like',"%$request->term%");
        })
            ->where('is_active',1)
            ->where('is_deleted',0)
            ->where('city_id', $request->city_id)
            ->orderby('id','desc')->limit(10)->get();
        if ($selectArea) {
            foreach ($selectArea as $val) {
                $area[] = array('id' => $val->id, 'label' => $this->uppercaseCamelCaseWithSpaces($val->area_title));
            }
        }
        return $area;
    }

    public function getBlocks(Request $request)
    {
        $subArea[]=[];
        $selectSubArea = ecom_city_subareas::where(function ($query) use($request){
            $query->where('subarea_title','like',"%$request->term%");
        })
            ->where('is_active',1)
            ->where('is_deleted',0)
            ->where('area_id', $request->area_id)
            ->orderby('id','desc')->limit(10)->get();
        if ($selectSubArea) {
            foreach ($selectSubArea as $val) {
                $subArea[] = array('id' => $val->id, 'label' => $this->uppercaseCamelCaseWithSpaces($val->subarea_title));
            }
        }
        return $subArea;
    }


    public function getBankList(Request $request)
    {
        $bankList[]=[];
        $selectBanks = ecom_bank_list::where(function ($query) use($request){
            $query->where('bank_name','like',"%$request->term%");
        })
            ->where('is_active',1)
            ->where('is_deleted',0)
            ->orderby('id','desc')->limit(10)->get();
        if ($selectBanks) {
            foreach ($selectBanks as $val) {
                $bankList[] = array('id' => $val->id, 'label' => $this->uppercaseCamelCaseWithSpaces($val->bank_name));
            }
        }
        return $bankList;

    }

    public function getAccountTypeList()
    {
        $accountTypes = ecom_account_type::where('is_active', '=', 1)->where('is_deleted', '=', 0)->get();
        return response()->json(['accountTypes' => $accountTypes]);
    }

    public function getContactPerson(Request $request) {

        $adminUsers = ecom_admin_user::where('is_deleted',0)
            ->where('is_active', 1);
        if ($request->referred_by) {
            $adminUsers = $adminUsers->where('admin_type_id', 1);
        }
        if ($request->sales_person) {
            $adminUsers = $adminUsers->where('admin_type_id', 3);
        }
        if ($request->recovery_person) {
            $adminUsers = $adminUsers->where('admin_type_id', 2);
        }

        $adminUsers = $adminUsers->orderBy('first_name', 'ASC')->get(['id', 'username']);

        return $adminUsers;
    }

    public function getExpressCentreList()
    {
        $expressCentre = ecom_branch::where('is_active', '=', 1)->where('is_deleted', '=', 0)->get();
        return response()->json(['expressCentre' => $expressCentre]);
    }

    public function get_payment_method()
    {
        $data = ecom_payment_method::where('is_active', '=', 1)->where('is_deleted', '=', 0)->get();
        return response()->json(['data' => $data]);
    }

    public function get_payment_status()
    {
        $data = ecom_payment_status::where('is_active', '=', 1)->where('is_deleted', '=', 0)->get();
        return response()->json(['data' => $data]);
    }

    public function getRoles(Request $request)
    {
        // =========== user_management -----------
        // $role=[];
        // $selectRole = ecom_user_roles::where(function ($query) use($request){
            //                                     $query->where('role_name','like',"%$request->term%");
        //                                 })
        //                                 ->where('is_deleted',0)
        //                                 ->orderby('id','desc')->limit(10)->get();

        // if ($selectRole) 
        // {
        //     foreach ($selectRole as $val) {
        //         $role[] = array('id' => $val->id, 'label' => $this->uppercaseCamelCaseWithSpaces($val->role_name));
        //     }
        // }
        // =========== user_management -----------

        $term='';
        $role=[];
        $selectRole = Role::where(function ($query) use($request){
                                            $query->where('title','like',"%$request->term%");
                                        })
                                        ->where('title', '!=', 'Super Admin')
                                        ->orderby('id','desc')->limit(10)->get();

        if ($selectRole) 
        {
            foreach ($selectRole as $val) {
                $role[] = array('id' => $val->id, 'label' => uppercaseCamelCaseWithSpaces($val->title));
            }
        }
        return $role;
    }
    public function GetEmployeeData(Request $request)
    {
        $employees=[];
        // $request = new Request();
        // $request->term = 'wa';
        // $item= 'waq';
        $selectEmployee = ecom_admin_user::where(function ($query) use($request)
                                            {
                                                $query->where('first_name', 'like', "%{$request->term}%")
                                                    ->orWhere('last_name', 'like', "%{$request->term}%");
                                            })
                                            ->employees()
                                            ->where('is_deleted', 0)
                                            ->orderby('id', 'desc')
                                            ->limit(10)
                                            ->get();

        Log::info('Query Result: ' . $selectEmployee); 

        if ($selectEmployee) 
        {
            foreach ($selectEmployee as $val) 
            {
                $employees[] = array(
                    'id' => $val->id,
                    'label' => uppercaseCamelCaseWithSpaces($val->first_name).' '.uppercaseCamelCaseWithSpaces($val->last_name).' ( '.$val->employee_id.' )',
                );
            }
        }

        return $employees;
        // dd(response()->json($employees));
        // return response()->json($employees);

    }
    public function getRolesMerchant(Request $request)
    {
        $role=[];
        $selectRole = ecom_merchant_role::where(function ($query) use($request){
            $query->where('role_name','like',"%$request->term%");
            if(isset($request->merchant_id)){
                $admin = ecom_admin_user::select(DB::raw('Min(id) as id'))
                    ->where('merchant_id', $request->merchant_id)
                    ->where('is_deleted', 0)
                    ->where('is_active', 1)
                    ->orderby('id', 'desc');
                if($admin->exists()){
                    $admin = $admin->first();
                    $query->where('admin_user_id',$admin->id);
                }

            }else{
                $query->where('admin_user_id',2);
            }
        })
        ->where('is_deleted',0)
        ->orderby('id','desc')->limit(10)->get();
        if ($selectRole) {
            foreach ($selectRole as $val) {
                $role[] = array('id' => $val->id, 'label' => $this->uppercaseCamelCaseWithSpaces($val->role_name));
            }
        }
        return $role;
    }
    public function totalRecordQuery()
    {

        //        $totalRecords = 0;
        //        $chunksRecords = [];
        //        $requestData = [];
        //        $requestData['product'] = 'COD';
        //        $requestData['status'] = 'ALL';
        //        $requestData['offset'] = 0;
        //        $requestData['limit'] = 500;
        //        $requestData['count_flag'] = 0;
        //        $requestData['company_id'] = 0;
        //        $requestData['Cn_number'] = '';
        //        $requestData['fromDate'] = "";
        //        $requestData['toDate'] = "";
        //        $requestData['origin_city_id'] = "";
        //        $requestData['destination_city_id'] = "";
        //
        //        $apiResponse = $this->CurlRequest('GetShipperAdvice', $requestData, 0);
        //        if (isset($apiResponse['http_code']) && $apiResponse['http_code'] == 200) {
        //            $decodedResponse = json_decode(json_decode($apiResponse['response']));
        //        }

        //        $totalRecords = $decodedResponse->totalrecords;

        $array = ["1-5000", "5001-10000", "10001-15000","15001-20000", "20001-25000", "25001-30000", "30001-35000","35001-40000","40001-45000","45001-50000"];

        return $array;

    }
    private function CurlRequest($method, $request = [], $bulkAction = 0)
    {
        // $CompanyId = ($this->session->userdata('admin_type') == 2 ? $this->session->userdata('member_id') : $request['company_id']);
        $base_url = "{$this->codTicketApiUrl}{$method}";

        if ($method == 'GetShipperAdvice') {
            $base_url = "{$this->codTicketApiUrl}{$method}";
        } elseif ($method == 'ActivityLog') {
            $base_url = "{$this->codTicketApiUrl}GetShipperAdvice";
        }

        $CODTicket_API_CREDS = base64_encode('cod_api_shipper:P@k!$t@n4601$$+-#');
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Basic ' . $CODTicket_API_CREDS
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $base_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if (count($request) > 0) {
            if ($method == 'UpdateShipperAdvice') {
                if ($bulkAction == 1) {
                    foreach ($request as $key => $value) {
                        $requested_data[$key]['id'] = (int)$value['id'];
                        //$requested_data[$key]['clientID'] = $CompanyId;
                        $requested_data[$key]['cn_number'] = $value['cn_number'];
                        $requested_data[$key]['shipper_advice_status'] = $value['admin_remarks'];
                        $requested_data[$key]['shipper_remarks'] = $value['advice_text'];
                    }
                } else {
                    $requested_data[0]['id'] = $request['id'];
                    //$requested_data[0]['clientID'] = $CompanyId;
                    $requested_data[0]['cn_number'] = $request['cn_number'];
                    $requested_data[0]['shipper_advice_status'] = $request['admin_remarks'];
                    $requested_data[0]['shipper_remarks'] = $request['advice_text'];
                }
            } elseif ($method == 'GetShipperAdvice') {

                $requested_data['product'] = ($request['product'] != '') ? $request['product'] : 'COD';
                $requested_data['status'] = ($request['status'] != '') ? $request['status'] : 'ALL';

        //  $requested_data['userID'] = 2747; // For testing
                // if($CompanyId > 0 ) {
                //     $requested_data['userID'] = (int) $CompanyId;
                // }
                $requested_data['userID'] = (int)$request['company_id'];
                $requested_data['origionID'] = "";
                if (isset($request['origin_city_id']) && intval($request['origin_city_id']) > 0) {
                    $requested_data['origionID'] = str_pad($request['origin_city_id'], 5, "0", STR_PAD_LEFT);
                }
                $requested_data['destinationID'] = "";
                if (isset($request['destination_city_id']) && intval($request['destination_city_id']) > 0) {
                    $requested_data['destinationID'] = str_pad($request['destination_city_id'], 5, "0", STR_PAD_LEFT);
                }
                $requested_data['dateFrom'] = (isset($request['fromDate']) && $request['fromDate'] != '') ? date('Y-m-d', strtotime($request['fromDate'])) : "";
                $requested_data['toDate'] = (isset($request['toDate']) && $request['toDate'] != '') ? date('Y-m-d', strtotime($request['toDate'])) : "";
                $requested_data['Cn_number'] = (isset($request['Cn_number']) && $request['Cn_number'] != '') ? $request['Cn_number'] : "";
                $requested_data['start'] = (int)$request['offset'];
                $requested_data['length'] = (int)$request['limit'];
            } else if ($method == 'ActivityLog') {
                $requested_data['product'] = "COD";
                $requested_data['status'] = "ALL";
                if ($this->session->userdata('admin_type') == 2) {
                    //$requested_data['userID'] = 2747; // For testing
                    $requested_data['userID'] = (int)$request['company_id'];
                }
                $requested_data['Cn_number'] = (isset($request['cn_number']) && $request['cn_number'] != '') ? $request['cn_number'] : "";
                //$requested_data['Cn_number'] = (isset($request['cn_number']) && $request['cn_number'] != '') ? $request['cn_number'] : "";
                $requested_data['start'] = 0;
                $requested_data['length'] = 100;
            } else {
                $requested_data = $request;
            }
            // dd(json_encode($requested_data));


            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requested_data));
        }

        $response = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        return [
            'http_code' => $http_code,
            'response' => $response
        ];
    }
    public function getRightsWiseCity(Request $request)
    {
        $superAdmin = ecom_admin_user::find($request->user()->id);
        $cityRights = ecom_admin_user_city_rights::where('admin_user_id', $request->user()->id)->pluck('city_id')->toArray();

        $origin=[];
        $selectOri = ecom_city::where(function ($query) use($request){
            $query->where('city_name','like',"%$request->term%");
        });

            //        if($superAdmin->user_type_id != 1 && $superAdmin->role_id != 8){
            //            $selectOri = $selectOri->whereIn('id', $cityRights);
            //        }

            $selectOri = $selectOri->where('is_active',1)
            ->orderby('id','desc')->limit(10)->get();
        if ($selectOri) {
            foreach ($selectOri as $val) {
                $origin[] = array('id' => $val->id, 'label' => $val->city_name);
            }
        }
        return $origin;
    }
    public function getStateForSearch(Request $request){
        $origin=[];
        $selectOri = ecom_state::where(function ($query) use($request){
            $query->where('state_name','like',"%$request->term%");
        })
            ->where('is_active',1)
            ->orderby('state_name','asc')->limit(10)->get();
        if ($selectOri) {
            foreach ($selectOri as $val) {
                $origin[] = array('id' => $val->id, 'label' => $val->state_name);
            }
        }
        return $origin;
    }

}
