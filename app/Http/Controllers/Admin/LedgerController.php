<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Controller;
use App\Models\Admin\ecom_admin_user;
use App\Models\Admin\Ledger;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Validator;
// use App\Models\ecom_merchant_role;

class LedgerController extends Controller
{
    public function ledger_data(Request $request)
    {
        dd($request->all());
    }
    public function index(Request $request)
    {
        if($request->has('id'))
        {
            // dd($request->url());

            $ledger = Ledger::find(base64_decode($request->id));
            return view('Admin/Ledger/index', compact('ledger'));
        }
        if($request->has('customer_id'))
        {
            $customer_id = $request->customer_id;
            $User = User::find(base64_decode($request->customer_id));
            dd($User);
            $ledger = Ledger::where('user_id', base64_decode($request->customer_id))->first();
            dd($ledger);
            return view('Admin/Ledger/index', compact('ledger'));
        }
        else
        {
            return view('Admin/Ledger/index');
        }
    }

}
