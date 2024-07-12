<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Admin\ecom_category;
// use App\Models\Admin\ecom_student;
use Yajra\DataTables\DataTables;
use DateTime;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryController extends Controller
{   
    private $ecom_category;
    
    public function __construct(CategoryRepositoryInterface $ecom_category)
    {
        $this->ecom_category = $ecom_category;
    }
    
    public function index(Request $request)
    {

        if($request->has('id'))
        {
            $ecom_category = $this->ecom_category->find(base64_decode($request->id));

            return view('Admin/manage_category/category/index', compact('ecom_category'));
        }
        else
        {
            return view('Admin/manage_category/category/index');
        }
    }
    public function sub_category_index(Request $request)
    {
        if($request->has('id'))
        {
            $ecom_category = $this->ecom_category->find(base64_decode($request->id));   
            return view('Admin/manage_category/sub_category/index', compact('ecom_category'));
        }
        else
        {
            return view('Admin/manage_category/sub_category/index');
        }
    } 
    // public function edit(Request $request)
    // {
    //     $collapse = ($request->has('id') or $request->has('page')) ?? true;

    //     if($request->has('id'))
    //     {
    //         $ecom_category = ecom_category::find(base64_decode($request->id));
    //     }
    //     return view('Admin/manage_category/category/index', compact('ecom_category'));
    // } 
 
    // public function SubCategoryedit(Request $request)
    // {
    //     dd($request->all());

    //     // $collapse = ($request->has('id') or $request->has('page')) ?? true;

    //     if($request->has('id'))
    //     {
    //         $ecom_category = ecom_category::find(base64_decode($request->id));
    //     }
    //     return view('Admin/manage_category/sub_category/index', compact('ecom_category'));
    // }   
}
