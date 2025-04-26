<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vendor_items';

    protected $fillable = [
        'vendor_id',
        'item_name',
        'quantity',
        'rate',
        'total_amount',
    ];

    public function vendor()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'vendor_id');
    }
    // public function receiptItems()
    // {
    //     return $this->hasMany(ReceiptItem::class, 'receipt_id', 'id');
    // }
 
    // public function feedback()
    // {
    //     return $this->hasOne(Feedback::class);
    // }
}