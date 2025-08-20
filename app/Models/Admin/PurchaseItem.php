<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'purchase_items';

    protected $fillable = [
        'purchase_id',
        'item_id',
        'item_qty',
        'item_price',
        'item_sub_total',
    ];

    public function item()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
    public function items()
    {
        return $this->hasMany(Item::class, 'id', 'item_id');
    }
    public function purchase_slip()
    {
        return $this->hasOne(\App\Models\Admin\Purchase::class, 'id', 'purchase_id');
    }
    // public function items()
    // {
    //     return $this->hasMany(Item::class, 'id', 'item_id');
    // }

    // public function feedback()
    // {
    //     return $this->hasOne(Feedback::class);
    // }
}
