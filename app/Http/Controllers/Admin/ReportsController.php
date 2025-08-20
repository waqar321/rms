<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ItemCategory;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('id'))
        {
            $itemCategory = ItemCategory::find(base64_decode($request->id));
            return view('Admin/itemCategory/index', compact('itemCategory'));
        }
        else
        {
            // dd('awdawd');
            return view('Admin/report/index');
        }
    }
}
