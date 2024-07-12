<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ecom_user_roles extends Model
{

    protected  $table = 'ecom_user_roles';
    protected $guarded = [];
    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s",
    ];


//    public function User()
//    {
//        return $this->hasMany(User::class, 'role_type','id');
//    }

    /**
     * Get the users by roles.
     *
     * @return array
     */

    public function ecom_module_permissions()
    {
        return $this->hasMany(ecom_module_permissions::class, 'role_id','id');
    }

}
