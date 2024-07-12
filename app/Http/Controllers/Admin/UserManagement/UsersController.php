<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\ExportController;
use App\Models\Admin\ecom_admin_user;
use App\Models\Admin\ecom_admin_user_city_rights;
use App\Models\Admin\ecom_branch;
use App\Models\Admin\ecom_city;
use App\Models\Admin\ecom_country;
use Illuminate\Validation\Rule;
use Validator;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('id'))
        {
            $AdminUser = new ecom_admin_user();
            $user = $AdminUser->find(base64_decode($request->id));

            return view('Admin/UserManagement/User/index', compact('user'));
        }
        else
        {
            return view('Admin/UserManagement/User/index');
        }
    }


}
