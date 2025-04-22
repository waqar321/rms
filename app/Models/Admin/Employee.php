<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'gender', 'dob', 'address', 'salary', 'designation', 'shift'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}