<?php

namespace App\Models\Admin;

use App\Models\Admin\ecom_user_roles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class ecom_admin_user extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable, HasApiTokens;

     protected $fillable = [
        'employee_id',
        'email',
        'username',
        'password',
        // 'first_name',
        // 'last_name',
        'full_name',
        'designation',
        'phone',
        'city_id',
        'zone_id',
        'role_id',
        'department_id',
        'sub_department_id',
        'time_slot_id',
        'otp_code',
        'otp_expires_at',
        'device_token' 
    ];
    
    protected  $table = 'ecom_admin_user';
    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => "datetime:Y-m-d H:i:s",
    ];

    public function scopeOnline(Builder $query)
    {
        return $query->where('last_activity', '>=', now()->subMinutes(5));
    }

    public function city()
    {
        // return $this->belongsTo(ecom_city::class);
        return $this->belongsTo(central_ops_city::class, 'city_id', 'city_id');
    }

    public function merchant(){
        return $this->belongsTo(ecom_merchant::class,'merchant_id','id');
    }

    // public function permissions()
    // {
    //     return $this->hasMany(ecom_module_permissions::class, 'role_id', 'role_id');
    // }

    // public function role()
    // {
    //     // return $this->belongsTo(ecom_user_roles::class);
    //     return $this->belongsToMany(ecom_user_roles::class);
    // }

    //------------------------- get all roles ---------------------------
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }
    //------------------------- get instructor role employee ---------------------------
    public function scopeInstructors($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('title', 'Instructor');
        });
    }
    //------------------------- get Admin role employee ---------------------------
    public function scopeAdmins($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('title', 'Admin');
        });
    }
    //------------------------- get all role employee ---------------------------
    public function scopeEmployees($query)
    {
        return $query->whereHas('roles', function ($q) {
            $q->where('title', 'User/Employee');
        });

        return $query->whereDoesntHave('roles');
    }
    //------------------------- get all role employee ---------------------------
    public function isAdmin()
    {
        return $this->roles()->where('title', 'Admin')->exists();
    }
    public function isSuperAdmin()
    {
        return $this->roles()->where('title', 'Super Admin')->exists();
    }
    public function isInstructor()
    {
        return $this->roles()->where('title', 'instructor')->exists();
    }
    public function city_right()
    {
        return $this->belongsToMany(ecom_city::class, 'ecom_admin_user_city_rights', 'admin_user_id', 'city_id');
    }
}
