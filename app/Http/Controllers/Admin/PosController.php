<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Controller;
use App\Models\Admin\ecom_admin_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Validator;
// use App\Models\ecom_merchant_role;

class POSController extends Controller
{
    public function index(Request $request)
    {
       

        if($request->has('id'))
        {
            // $permission = Permission::find(base64_decode($request->id));
            // return view('Admin/post/data-entry/index', compact('permission'));
        }
        else
        {
           
            return view('Admin/POS/index');
        }
    }

}
