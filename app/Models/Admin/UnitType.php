<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitType extends Model
{
    use HasFactory;

    protected $table = 'unit_types';

    protected $fillable = [
        'name',
        'is_active'
    ];

    // public function orders()
    // {
    //     return $this->hasMany(Order::class);
    // }

    // public function feedback()
    // {
    //     return $this->hasOne(Feedback::class);
    // }
}