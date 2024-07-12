<?php

namespace App\Http\Controllers\Status;

use App\Http\Controllers\Controller;
use App\Models\Admin\ecom_files;
use Illuminate\Http\Request;
use App\Models\ecom_status;

class StatusController extends Controller
{
    public function get_status(){
        $data['status'] =  ecom_status::getStatus();
        return response()->json(['status' => 1, 'data' => $data, 'message' => 'success'], 200);
    }
    public function batch_data(){
        $data['batch'] =  ecom_files::getBatch();
        return response()->json(['status' => 1, 'data' => $data, 'message' => 'success'], 200);
    }
}
