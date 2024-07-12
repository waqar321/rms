<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Admin\ecom_department;
// use App\Models\Admin\ecom_student;
use Yajra\DataTables\DataTables;
use DateTime;

class DepartmentController extends Controller
{   
    protected $ecom_department;

    public function __construct()
    {
        // dd('coming');
        $this->ecom_department = new ecom_department();
    }

    public function index(Request $request)
    {
        
        if($request->has('id'))
        {
            $ecom_department = $this->ecom_department->find(base64_decode($request->id));

            return view('Admin/manage_department/department/index', compact('ecom_department'));
        }
        else
        {
            return view('Admin/manage_department/department/index');
        }
    }
    public function sub_department_index(Request $request)
    {
        // $awd = ecom_department::find(7);
        // dd($awd->parentDepartment);

        if($request->has('id'))
        {
            $ecom_department = $this->ecom_department->find(base64_decode($request->id));   
            return view('Admin/manage_department/sub_department/index', compact('ecom_department'));
        }
        else
        {
            return view('Admin/manage_department/sub_department/index');
        }
    } 
}
