<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Interfaces\CategoryInterface;

class ecom_category extends Model implements CategoryInterface
{
    use HasFactory;

    protected $table = 'ecom_category';
    protected $fillable = [
        'name',
        'image',
        'image_path',
        'is_active',
        'parent_id',
        'is_deleted',
    ];
    
    
    // Define the relationship with the parent category
    public function parentCategory()
    {
        return $this->belongsTo(ecom_category::class, 'parent_id');
    }

    // Define the relationship with the child categories
    public function childCategories()
    {
        return $this->hasMany(ecom_category::class, 'parent_id');
    }
}
