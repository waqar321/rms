<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expenses';

    protected $fillable = [
        'user_id',
        'item_id',
        // 'category',
        'description',
        'amount',
        'expense_date'
    ];

    public function user()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_id');
    }
    public function item()
    {
        return $this->hasOne(\App\Models\Admin\ExpenseList::class, 'id', 'item_id');
    }
    // public function ExpenseItem()
    // {
    //     return $this->hasMany(ExpenseList::class, 'item_id', 'id');
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
