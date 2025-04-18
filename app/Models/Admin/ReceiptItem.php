<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiptItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'receipt_items';

    protected $fillable = [
        'receipt_id',
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
    public function receipt_slip()
    {
        return $this->hasOne(\App\Models\Receipt::class, 'id', 'receipt_id');
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