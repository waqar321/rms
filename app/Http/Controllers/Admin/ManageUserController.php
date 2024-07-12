<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Controller;
use App\Models\Admin\ecom_admin_user;
use App\Models\Admin\ecom_admin_user_city_rights;
use App\Models\Admin\ecom_branch;
use App\Models\Admin\ecom_city;
use App\Models\Admin\ecom_country;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Validator;
use App\Models\testingExport\Product;

class ManageUserController extends Controller
{
    protected $cities;
    protected $countries;
    protected $AdminUser;
    protected $branch;//express center
    protected $exportController;

    public function __construct()
    {
        $this->AdminUser = new ecom_admin_user();
        $this->cities = new ecom_city();
        $this->countries = new ecom_country();
        $this->branch = new ecom_branch(); //express center
        $this->exportController = new ExportController();
    }

    public function userListing(Request $request)
    {


        if ($request->ajax) 
        {   

            $superAdmin = ecom_admin_user::find($request->user()->id);
            $cityRights = ecom_admin_user_city_rights::where('admin_user_id', $request->user()->id)->pluck('city_id')->toArray();

            $queryBuilder = $this->AdminUser->leftjoin('ecom_city', 'ecom_city.id', '=', 'ecom_admin_user.city_id')
                ->leftjoin('ecom_user_roles', 'ecom_user_roles.id', '=', 'ecom_admin_user.role_id')
                ->where('ecom_admin_user.is_deleted', '=', 0)
                ->where('ecom_admin_user.user_type_id', 3);

            if($superAdmin->user_type_id != 1 && $superAdmin->role_id != 8){
                    //$queryBuilder = $queryBuilder->whereIn('ecom_admin_user.city_id', $cityRights);
                $queryBuilder = $queryBuilder->where('added_by', $request->user()->id);
            }

            // for city base filter condition
            if(isset($request->city_id) && $request->city_id != ''){
                $city = $request->city_id;
                $queryBuilder = $queryBuilder->where('ecom_admin_user.city_id', $city);
            }

            // for role base filter condition
            if(isset($request->role_id) && $request->role_id != ''){
                $role = $request->role_id;
                $queryBuilder = $queryBuilder->where('ecom_admin_user.role_id', $role);
            }

            //for status base filter condition
            if(isset($request->status) && $request->status != '' && $request->status != 2){
                $status = $request->status;
                $queryBuilder = $queryBuilder->where('ecom_admin_user.is_active', $status);
            }

            // for user type filter condition
            // if(isset($request->user_type_id) && $request->user_type_id != ''){
            //     $userTypeId = $request->user_type_id;
            //     $queryBuilder = $queryBuilder->where('ecom_admin_user.user_type_id', $userTypeId);
            // }else{
            //     $queryBuilder = $queryBuilder->whereIn('ecom_admin_user.user_type_id', [3,4]);
            // }

            if(isset($_GET['excel'])){
                $selectedColumn = array();
                $header = array();
                if(isset($_GET['selectedValue']) && isset($_GET['selectedTexts']) ){
                    $selectedColumn = $request->input('selectedValue', []);
                    $header = $request->input('selectedTexts', []);
                }
                $queryData = $queryBuilder->select($selectedColumn)->get()->toArray();
                $this->exportController->FetchCsv($header,$queryData);
            }else {
                $queryBuilder->select('ecom_admin_user.id','ecom_admin_user.domain_name','ecom_user_roles.role_name','ecom_city.city_name','ecom_admin_user.username','ecom_admin_user.email','ecom_admin_user.user_type_id','ecom_admin_user.is_active','ecom_admin_user.is_deleted','ecom_admin_user.created_at');
                $data = DataTables::of($queryBuilder)
                    ->addColumn('status', function($data){
                        $statusIcon = ($data->is_active == 1) ? '<span class="fa fa-toggle-on"></span>' : '<span class="fa fa-toggle-off"></span>';
                        $statusUrl = api_url('manage_user/status');
                        $table = 'ecom_admin_user';
                        $status = '<a role="menuitem" tabindex="-1" data-screen-permission-id="3" title="Active" class="statusPointer" onclick="status(`'.$statusUrl.'`, `'.$table.'`, '.$data->id.')"> '.$statusIcon.'</a>';
                        return $status;
                    })
                    ->addColumn('action', function ($data) {
                        $deleteUrl = api_url('manage_user/delete');
                        $table = 'ecom_admin_user';
                        $dropdown = '
                                    <!-- <a role="menuitem" tabindex="-1" data-screen-permission-id="3" href='.url_secure_api('manage_user/rights?id=').base64_encode($data->id).' title="Rights"><span class="fa fa-gear btn btn-info"></span> </a> -->
                                    <a role="menuitem" tabindex="-1" data-screen-permission-id="3" href='.url_secure_api('manage_user/edit?id=').base64_encode($data->id).' title="Edit"><span class="fa fa-edit btn btn-info"></span> </a> 
                                    <a role="menuitem" tabindex="-1" data-screen-permission-id="4" href="#" class="deletePointer" title="Delete" onclick="deleteData(`'.$deleteUrl.'`, `'.$table.'`, '.$data->id.')"><span class="fa fa-trash btn btn-danger"></span> </a>';
                        return $dropdown;
                    })->rawColumns(['status', 'action']);

                return $data = $data->toJson(true);
            }
        }

        return view('Admin/manage_user/user/index');
    }

    public function userAdd(Request $request)
    {
        $data = array();
        if ($request->ajax) {
            $id = $request->id;
            $data['user'] = $this->AdminUser->with('city', 'role', 'city.country', 'merchant')->find($id)->toArray();
            return response()->json(['status' => 1, 'data' => $data, 'message' => 'success'], 200);
        }
        return view('Admin/manage_user/user/add');
    }

    public function userRights(Request $request)
    {
        $data = array();
        if ($request->ajax) {
            $id = $request->id;
            $data['user'] = $this->AdminUser->with('city_right')->find($id)->toArray();
            $data['cities'] = ecom_city::where('is_active', 1)->where('is_deleted', 0)->get('id')->toArray();
            return response()->json(['status' => 1, 'data' => $data, 'message' => 'success'], 200);
        }
        return view('Admin/manage_user/user/city_rights');
    }

    public function userRightSubmit(Request $request)
    {
        $exists = ecom_admin_user_city_rights::where('admin_user_id', $request->id)->exists();
        if($exists){
            ecom_admin_user_city_rights::where('admin_user_id', $request->id)->delete();
        }

        if($request->city_rights != null){
            foreach($request->city_rights as $key => $cityRight){
                $data=[
                    'admin_user_id' => $request->id,
                    'city_id' => $cityRight,
                ];
                ecom_admin_user_city_rights::create($data);
            }
        }else{
            $adminCity = ecom_admin_user::find($request->id);
            $data=[
                'admin_user_id' => $request->id,
                'city_id' => $adminCity->city_id,
            ];
            ecom_admin_user_city_rights::create($data);
        }


        return json_encode(array('status' => 1, 'message' => 'Success'));
    }

    public function userSubmit(Request $request)
    {

        $rules=[];
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'role_id' => 'required',
        ];

        if($request->user_type_id == 5){
            $rules['merchant_id'] =  'required';
        }

        if (isset($request->id)) {
            $rules['username'] = ['required', Rule::unique('ecom_admin_user', 'username')->ignore($request->id),];
            $rules['email'] = ['required', Rule::unique('ecom_admin_user', 'email')->ignore($request->id),];
        } else {
            $rules['username'] = 'required|unique:ecom_admin_user,username';
            $rules['email'] = 'required|unique:ecom_admin_user,email';
            $rules['password'] = 'required|min:6|max:15';
            $rules['password_confirmation'] = 'required|same:password';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $data = [
                'user_type_id' => 3,
                'role_id' => $request->role_id,
                'merchant_id' => ($request->user_type_id == 5) ? $request->merchant_id : 0,
                'city_id' => $request->city_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile,
                // 'domain_name' => $request->domain_name,
                'employee_id' => $request->employee_id,
                'gender' => $request->gender,
                'city_rights' => 592,
                'added_by' => $request->user()->id,
            ];

            if($request->password != ''){
                $data['password'] = bcrypt($request->password);
            }

            if(isset($request->id)){
                $data['updated_at'] = date('Y-m-d H:i:s');
                unset($data['created_at']);
                $this->AdminUser->where('id',$request->id)->update($data);
            }else{
                $this->AdminUser->insert($data);
            }

            return json_encode(array('status' => 1, 'message' => 'Success'));
        } else {
            $errors = [];
            foreach ($validator->errors()->toArray() as $key => $error_array) {
                foreach ($error_array as $error) {
                    if (!isset($errors[$key])) {
                        $errors[$key] = $error;
                    }
                }
            }

            return json_encode(array('status' => 0, 'errors' => $errors));
        }
    }

    public function userTypeListing()
    {
        return view('Admin/manage_user/user_type/index');
    }

    public function userTypeAdd()
    {
        return view('Admin/manage_user/user_type/add');
    }

}
