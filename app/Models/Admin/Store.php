<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = ['vendor_id', 'item_id', 'status'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}