<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Controller;
use App\Models\Admin\ecom_admin_user;
use App\Models\Admin\ecom_merchant_module_permissions;
use App\Models\Admin\ecom_merchant_modules;
use App\Models\Admin\ecom_module_permissions;
use App\Models\Admin\ecom_module_screen_permission;
use App\Models\Admin\ecom_modules;
use App\Models\Admin\ecom_permissions;
use App\Models\Admin\ecom_user_roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Validator;
use App\Models\ecom_merchant_role;
use App\Models\Admin\ecom_merchant_module_screen_permission;

class RoleController extends Controller
{
    protected $role;
    protected $merchant_role;
    protected $branch;//express center
    protected $exportController;

    public function __construct()
    {
        $this->role = new ecom_user_roles();
        $this->merchant_role = new ecom_merchant_role();
        $this->exportController = new ExportController();
    }

    public function roles_index(Request $request)
    {

        if ($request->ajax) {
            $queryBuilder = $this->role
                ->where('ecom_user_roles.admin_user_id', auth()->user()->id)
                ->where('ecom_user_roles.is_deleted', '=', 0);

            $adminUser = ecom_admin_user::find(auth()->user()->id);

            $queryBuilder = $this->role->where('ecom_user_roles.is_deleted', '=', 0);

            if($adminUser->id != 1){
                $queryBuilder = $queryBuilder->where('ecom_user_roles.admin_user_id', auth()->user()->id);
            }
            //for status base filter condition
            if(isset($request->status) && $request->status != '' && $request->status != 2){
                $status = $request->status;
                $queryBuilder = $queryBuilder->where('ecom_admin_user.is_active', $status);
            }

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
                $queryBuilder->select('ecom_user_roles.id','ecom_user_roles.role_name','ecom_user_roles.is_deleted','ecom_user_roles.created_at');
                $data = DataTables::of($queryBuilder)
                    ->addColumn('action', function ($data) {
                        $deleteUrl = api_url('manage_user/roles/delete');
                        $table = 'ecom_user_roles';
                        $dropdown = '<a role="menuitem" data-screen-permission-id="8" tabindex="-1" href='.url_secure_api('manage_user/roles/permission?id=').base64_encode($data->id).' title="Edit"><span class="fa fa-folder btn btn-info"></span> </a>
                                    <a role="menuitem" data-screen-permission-id="8" tabindex="-1" href='.url_secure_api('manage_user/roles/edit?id=').base64_encode($data->id).' title="Edit"><span class="fa fa-edit btn btn-info"></span> </a> 
                                    <a role="menuitem" data-screen-permission-id="9" tabindex="-1" href="#" class="deletePointer" title="Delete" onclick="deleteData(`'.$deleteUrl.'`, `'.$table.'`, '.$data->id.')"><span class="fa fa-trash btn btn-danger"></span> </a>';
                        return $dropdown;
                    })->rawColumns(['action']);

                return $data = $data->toJson(true);
            }


        }

        return view('Admin/manage_user/roles/index');
    }

    public function roles_add(Request $request)
    {
        $data = array();
        if ($request->ajax) {
            $id = $request->id;
            $data['role'] = $this->role->find($id)->toArray();
            return response()->json(['status' => 1, 'data' => $data, 'message' => 'success'], 200);
        }
        return view('Admin/manage_user/roles/add');
    }

    public function roles_submit(Request $request)
    {
        $rules=[];
        if (isset($request->id)) {
            $rules = [
                'role_name' => ['required', 'min:5', Rule::unique('ecom_user_roles', 'role_name')->ignore($request->id),],
            ];
        } else {
            $rules = [
                'role_name' => 'required|unique:ecom_user_roles,role_name',
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $data = [
                'admin_user_id' => auth()->user()->id,
                'role_name' => $request->role_name,
            ];

            if(isset($request->id)){
                $data['updated_at'] = date('Y-m-d H:i:s');
                unset($data['created_at']);
                $this->role->where('id',$request->id)->update($data);
            }else{
                $this->role->insert($data);
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

    public function setPermission(Request $request)
    {

        $data = array();
        if (Route::is('api.roles.permission') && $request->has('id') && $request->has('ajax'))
        {
            // return response()->json(['status' => 1, 'data' => '', 'message' => 'success'], 200);

            $id = $request->id;
            $data['ecom_module_permissions'] = ecom_module_permissions::with('role')->where('role_id', $id)->where('is_deleted', 0)->get()->toArray();
            $data['role'] = ecom_user_roles::where('is_deleted',0)->find($id)->toArray();
            $data['permissions_list'] = ecom_modules::with('subModule.submodule_screen')->get()->toArray();

            return response()->json(['status' => 1, 'data' => $data, 'message' => 'success'], 200);
        }
        elseif(Route::is('roles.permission') && $request->has('id')) 
        {

            return view('Admin/manage_user/roles/permissions');
        }
    }

    public function setPermissionsUpdate(Request $request)
    {
        // now creating insert data of permissions
        $screenPermissionIds = $request->get('screen_permission_id');
        $exists = ecom_module_permissions::where('role_id', $request->role_id)->where('is_deleted',0)->exists();
        if($exists){
            ecom_module_permissions::where('role_id', $request->role_id)->delete();
        }
        foreach($screenPermissionIds as $key => $permissionId){
            $permissionModule = ecom_module_screen_permission::where('id', $permissionId)->first();
            $data=[
                'role_id' => $request->get('role_id'),
                'module_id' => $permissionModule->module_id,
                'sub_module_id' => $permissionModule->sub_module_id,
                'screen_permission_id' => $permissionId
            ];
            ecom_module_permissions::create($data);
        }

        return json_encode(array('status' => 1, 'message' => 'Success'));


    }

    public function permissionUpdate(Request $request)
    {

        $user = $request->user();
        $ModuleIds = ecom_module_permissions::where('role_id', $user->role_id)
                                        ->where('is_deleted', 0)
                                        ->distinct()
                                        ->pluck('module_id')
                                        ->toArray();
        $sub_modules = ecom_module_permissions::where('role_id', $user->role_id)
                                    ->where('is_deleted', 0)
                                    ->distinct()
                                    ->pluck('sub_module_id')
                                    ->toArray();
        $screens = ecom_module_permissions::where('role_id', $user->role_id)
                                    ->where('is_deleted', 0)
                                    ->pluck('screen_permission_id')
                                    ->toArray();

        $response = [
            'status' => 1,
            'data' => $user,
            'permissions' => array('module_id'=>$ModuleIds,'sub_module_id'=>$sub_modules,'screens'=>$screens),
            'message' => 'Permission Updated',
        ];

        return response()->json($response, 200);
    }
    public function roles_merchant_index(Request $request)
    {
        if ($request->ajax) {
            $queryBuilder = $this->merchant_role
                ->where('ecom_merchant_roles.is_deleted', '=', 0);

            //for status base filter condition
            if(isset($request->status) && $request->status != '' && $request->status != 2){
                $status = $request->status;
                $queryBuilder = $queryBuilder->where('ecom_merchant_roles.is_active', $status);
            }

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
                $queryBuilder->select('ecom_merchant_roles.id','ecom_merchant_roles.role_name','ecom_merchant_roles.is_deleted','ecom_merchant_roles.created_at');
                $data = DataTables::of($queryBuilder)
                    ->addColumn('action', function ($data) {
                        $deleteUrl = api_url('manage_user/roles/delete');
                        $table = 'ecom_merchant_roles';
                        $dropdown = '<a role="menuitem" data-screen-permission-id="101" tabindex="-1" href='.url_secure_api('manage_user/roles/merchant/permission?id=').base64_encode($data->id).' title="Edit"><span class="fa fa-folder btn btn-info"></span> </a>
                                    <a role="menuitem" data-screen-permission-id="98" tabindex="-1" href='.url_secure_api('manage_user/roles/merchant/edit?id=').base64_encode($data->id).' title="Edit"><span class="fa fa-edit btn btn-info"></span> </a> 
                                    <a role="menuitem" data-screen-permission-id="99" tabindex="-1" href="#" class="deletePointer" title="Delete" onclick="deleteData(`'.$deleteUrl.'`, `'.$table.'`, '.$data->id.')"><span class="fa fa-trash btn btn-danger"></span> </a>';
                        return $dropdown;
                    })->rawColumns(['action']);

                return $data = $data->toJson(true);
            }


        }

        return view('Admin/manage_user/roles/merchant/index');
    }
    public function roles_merchant_add(Request $request)
    {
        $data = array();
        if ($request->ajax) {
            $id = $request->id;
            $data['role'] = $this->merchant_role->with('admin_user.merchant')->find($id)->toArray();
            return response()->json(['status' => 1, 'data' => $data, 'message' => 'success'], 200);
        }
        return view('Admin/manage_user/roles/merchant/add');
    }
    public function roles_merchant_submit(Request $request)
    {
        $rules=[];
        if (isset($request->id)) {
            $rules = [
                'role_name' => ['required', 'min:5', Rule::unique('ecom_merchant_roles', 'role_name')->ignore($request->id),],
            ];
        } else {
            $rules = [
                'role_name' => 'required|unique:ecom_merchant_roles,role_name',
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $data = [
                'admin_user_id' => $request->admin_user_id,
                'role_name' => $request->role_name,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            if(isset($request->id)){
                $data['updated_at'] = date('Y-m-d H:i:s');
                unset($data['created_at']);
                $this->merchant_role->where('id',$request->id)->update($data);
            }else{
                $this->merchant_role->insert($data);
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
    public function merchant_setPermission(Request $request)
    {
        $data = array();
        if (Route::is('api.roles.merchant.permission') && $request->has('id') && $request->has('ajax')) {
            $id = $request->id;
            $data['ecom_module_permissions'] = ecom_merchant_module_permissions::with('role')->where('role_id', $id)->where('is_deleted', 0)->get()->toArray();
            $data['role'] = ecom_user_roles::where('is_deleted',0)->find($id)->toArray();
            $data['permissions_list'] = ecom_merchant_modules::with('subModule.submodule_screen')->get()->toArray();
            return response()->json(['status' => 1, 'data' => $data, 'message' => 'success'], 200);
        }elseif (Route::is('merchant.roles.permission') && $request->has('id')) {
            return view('Admin/manage_user/roles/merchant/permissions');
        }
    }
    public function setPermissionsUpdateMerchant(Request $request)
    {
        // now creating insert data of permissions
        $screenPermissionIds = $request->get('screen_permission_id');

        $exists = ecom_merchant_module_permissions::where('role_id', $request->role_id)->where('is_deleted',0)->exists();
        if($exists){
            ecom_merchant_module_permissions::where('role_id', $request->role_id)->delete();
        }

        if($screenPermissionIds!=null){
            foreach($screenPermissionIds as $key => $permissionId){
                $permissionModule = ecom_merchant_module_screen_permission::where('id', $permissionId)->first();
                $data=[
                    'role_id' => $request->get('role_id'),
                    'module_id' => $permissionModule->module_id,
                    'sub_module_id' => $permissionModule->sub_module_id,
                    'screen_permission_id' => $permissionId
                ];
                ecom_merchant_module_permissions::create($data);
            }
        }


        return json_encode(array('status' => 1, 'message' => 'Success'));


    }
}
