<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ecom_bank_transaction;
use App\Models\Admin\ecom_booking_deposits;
use App\Models\Admin\ecom_tier_cities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActionController extends Controller
{
    public function status(Request $request)
    {
        if(isset($request->id)) {
            if (!is_array($request->id)) {
                $id = isset($request->id) ?  $request->id : $request->id;
                $table = DB::table($request->table)->find($id);
                $status = ($table->is_active === 0) ? 1 : 0;
                DB::table($request->table)->where('id', $id)->update(['is_active' => $status]);
            }
            return json_encode(array('status' => 1, 'message' => 'Success', 'response' => $table));
        }

    }

    public function destroy(Request $request)
    {
        if(isset($request->id)) {
            if (!is_array($request->id)) {
                $id = isset($request->id) ?  $request->id : $request->id;
                $table = DB::table($request->table)->find($id);
                $deleteStatus = ($table->is_deleted === 0) ? 1 : 0;


                DB::table($request->table)->where('id', $id)->update(['is_deleted' => $deleteStatus]);

                if($request->table == 'ecom_bank_transaction_detail'){
                    $totalAmount = ecom_bank_transaction::where('booking_id',$table->booking_id)->where('is_deleted', 0)->sum('amount');
                    if($totalAmount == 0){
                        ecom_booking_deposits::where('booking_id', $table->booking_id)->update(['is_deleted' => $deleteStatus]);
                    }
                    ecom_booking_deposits::where('booking_id', $table->booking_id)->update(['deposited_amount' => $totalAmount]);
                }

                if($request->table == 'ecom_tiers'){
                    ecom_tier_cities::where('tier_id', $id)->delete();
                }
            }
            return json_encode(array('status' => 1, 'message' => 'Success'));
        }
    }

    public function approve(Request $request)
    {
        if(isset($request->id)) {
            if (!is_array($request->id)) {
                $id = isset($request->id) ?  $request->id : $request->id;
                $table = DB::table($request->table)->find($id);
                $isApproved = ($table->is_approved === 0) ? 1 : 0;
                DB::table($request->table)->where('id', $id)->update(['is_approved' => $isApproved]);
            }
            return json_encode(array('status' => 1, 'message' => 'Success'));
        }
    }


}
