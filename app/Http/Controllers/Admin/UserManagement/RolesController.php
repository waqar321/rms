<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RolesController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('id'))
        {
            $role = Role::find(base64_decode($request->id));
            return view('Admin/UserManagement/Role/index', compact('role'));
        }
        else
        {
            return view('Admin/UserManagement/Role/index');
        }
    }
}


