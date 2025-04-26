<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'Items';

    protected $fillable = [
        'name',
        'category_id',
        'unit_type_id',
        'description',
        'price',
        'cost_price',
        'stock_quantity',
        // 'unit',
        'is_available',
        'image',
        'order',
        'image_path',
        'created_by',
        // 'is_vendor_product',

        // 'is_active',
    ];

    public function user()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'created_by');
    }
    // public function orders()
    // {
    //     return $this->hasMany(Order::class);
    // }

    // public function feedback()
    // {
    //     return $this->hasOne(Feedback::class);
    // }
    public function Category()
    {
        return $this->hasOne(ItemCategory::class, 'id', 'category_id');
    }
    public function unit_type()
    {
        return $this->hasOne(UnitType::class, 'id', 'unit_type_id');
    }
}