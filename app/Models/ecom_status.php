<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ecom_status extends Model
{
    use HasFactory;

    protected $table = 'ecom_status';

    static public function getStatus(){
        return  self::where('is_active',1)->where('is_deleted',0)->orderby('id','desc')->get();
    }
}
