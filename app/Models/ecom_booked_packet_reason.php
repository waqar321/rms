<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ecom_booked_packet_reason extends Model
{
    use HasFactory;

    static public function getReasons(){
        return  self::orderby('id','desc')->get();
    }
}
