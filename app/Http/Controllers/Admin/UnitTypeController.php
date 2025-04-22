<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ItemCategory;

class UnitTypeController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('id'))
        {
            $itemCategory = ItemCategory::find(base64_decode($request->id));
            return view('Admin/UnitType/index', compact('itemCategory'));
        }
        else
        {
            return view('Admin/UnitType/index');
        }
    }
}
