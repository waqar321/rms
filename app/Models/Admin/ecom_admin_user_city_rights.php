<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ecom_admin_user_city_rights extends Model {

    protected $table = 'ecom_admin_user_city_rights';
    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s"
    ];

    protected $guarded =[];

}
