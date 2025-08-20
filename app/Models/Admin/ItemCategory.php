<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;

    protected $table = 'item_categories';

    protected $fillable = [
        'name',
        'order',
        'is_active',
        'is_pos_product',
        'is_item_purchasing_category',
        'is_active',
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
