<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ecom_admin_pages extends Model
{
    use HasFactory;
    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s",
    ];
    protected  $table = 'ecom_admin_pages';

    protected $guarded =[];
}
