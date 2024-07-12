<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class central_ops_city extends Model {

    protected $table = 'central_ops_city';
    public $timestamps = false;

    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s",
        'is_active' => "boolean",
        'zone' => "integer",
    ];
    
    protected $fillable = [
        'city_id',
        'city_name',
        'City_Short_Name',
        'zone_code',
    ];
   
}
