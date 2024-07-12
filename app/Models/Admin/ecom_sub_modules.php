<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ecom_sub_modules extends Model
{

    protected  $table = 'ecom_sub_modules';
    protected $guarded = [];
    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s",
    ];


    public function submodule_screen()
    {
        return $this->hasMany(ecom_module_screen_permission::class, 'sub_module_id','id');
    }


    /**
     * Get the users by roles.
     *
     * @return array
     */


}
