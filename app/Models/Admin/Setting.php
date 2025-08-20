<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'Brand_name',
        'image',
        'image_path',
        'note_description',
        'employee_discount',
        'shift_starting_time',
        'shift_ending_time',
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
