<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'city',
        'cnic',
        'gender',
        'dob',
        'total_spent',
        'visits',
        'is_active',
    ];

    protected $casts = [
        'dob' => 'date',
        'is_active' => 'boolean',
        'total_spent' => 'decimal:2',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }
}
