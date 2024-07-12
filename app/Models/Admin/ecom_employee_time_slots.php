<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ecom_employee_time_slots extends Model
{
    use HasFactory;

    protected $table = 'ecom_employee_time_slots';
    protected $fillable = [
        'shift_code',
        'start_time',
        'end_time',
        'day_of_week',
        // 'employee_id',
        'is_active',
        'is_deleted',
    ];
    
    public function employees()
    {
        // return $this->hasMany(ecom_admin_user::class, 'employee_id');
        return $this->hasMany(ecom_admin_user::class, 'time_slot_id')->where('role_id', 34);
    }
}


