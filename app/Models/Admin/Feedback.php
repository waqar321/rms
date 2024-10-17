<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'service', 'food_quality', 'suggestion'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}