<?php

namespace App\Models;

use App\Models\Admin\ecom_admin_user;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ecom_merchant_role extends Model
{
    protected  $table = "ecom_merchant_roles";
    use HasFactory;

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => "datetime:Y-m-d H:i:s",
    ];

    public function admin_user(){
        return $this->belongsTo(ecom_admin_user::class,'admin_user_id','id');
    }
}
