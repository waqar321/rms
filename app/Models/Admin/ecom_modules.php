<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ecom_modules extends Model
{

    protected  $table = 'ecom_modules';
    protected $guarded = [];
    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s",
    ];


    public function subModule()
    {
        return $this->hasMany(ecom_sub_modules::class, 'module_id','id');
    }


    /**
     * Get the users by roles.
     *
     * @return array
     */


}
