<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'receipts';

    protected $fillable = [
        'total_amount',
        'entry_by',
        'vendor_id',
    ];

    public function entry_person()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'entry_by');
    }
    public function vendor()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'vendor_id');
    }
    public function receiptItems()
    {
        return $this->hasMany(ReceiptItem::class, 'receipt_id', 'id');
    }

    // public function feedback()
    // {
    //     return $this->hasOne(Feedback::class);
    // }
}
