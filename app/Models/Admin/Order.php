<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['dish_id', 'customer_id', 'cooking_time', 'price'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
