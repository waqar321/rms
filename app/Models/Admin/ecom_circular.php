<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ecom_circular extends Model
{
    use HasFactory;

    protected $table = 'circulars';
    protected $fillable = [
        'title',
        'content',
    ];
    
    
    // Define the relationship with the parent category
    // public function parentCategory()
    // {
    //     return $this->belongsTo(ecom_category::class, 'parent_id');
    // }

    // // Define the relationship with the child categories
    // public function childCategories()
    // {
    //     return $this->hasMany(ecom_category::class, 'parent_id');
    // }
    
}
