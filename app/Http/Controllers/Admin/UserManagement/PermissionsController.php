<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionsController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('id'))
        {
            $permission = Permission::find(base64_decode($request->id));
            return view('Admin/UserManagement/Permission/index', compact('permission'));
        }
        else
        {
            return view('Admin/UserManagement/Permission/index');
        }
    }
}
