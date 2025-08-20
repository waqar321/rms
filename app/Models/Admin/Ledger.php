<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ledger extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ledgers';

    protected $fillable = [
        'role_id',
        'user_id',
        'item_id',
        'receipt_id',
        'purchase_id',
        'payment_type',
        'unit_price',
        'unit_qty',
        'cash_amount',
        'total_amount',
        'remaining_amount',
        'payment_detail',
        'is_paid',
        'Ledger',
    ];

    public function user()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_id');
    }
    public function receipt()
    {
        return $this->hasOne(\App\Models\Admin\Receipt::class, 'id', 'receipt_id');
    }
    public function purchase()
    {
        return $this->hasOne(\App\Models\Admin\Purchase::class, 'id', 'purchase_id');
    }
    public function role()
    {
        return $this->hasOne(\App\Models\Role::class, 'id', 'role_id');
    }
    public function item()
    {
        return $this->hasOne(\App\Models\Admin\Item::class, 'id', 'item_id');
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
