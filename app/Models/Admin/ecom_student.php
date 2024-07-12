<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ecom_student extends Model
{

    use HasFactory;

    protected $table = 'ecom_student';

    protected $fillable = [
        'name',
        'address',
        'dob',
        'phone_number',
        'gender',
        'is_active',
        'is_deleted',
    ];
}
