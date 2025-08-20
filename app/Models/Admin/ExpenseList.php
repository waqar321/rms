<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseList extends Model
{
    use HasFactory;

    protected $table = 'expense_list';

    protected $fillable = [
        'name',
    ];

    // public function user()
    // {
    //     return $this->hasOne(\App\Models\User::class, 'id', 'user_id');
    // }
    // public function orders()
    // {
    //     return $this->hasMany(Order::class);
    // }

    // public function feedback()
    // {
    //     return $this->hasOne(Feedback::class);
    // }
}
