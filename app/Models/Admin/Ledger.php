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
        'amount',
        'user_id',
        'details',
        'entry_date',
    ];
    public function vendor()
    {
        return $this->hasOne(\App\Models\User::class, 'id', 'user_id');
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