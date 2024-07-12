<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ecom_course_content extends Model
{
    use HasFactory;

    protected $table = 'ecom_course_content'; // Define the table name if it's different from the default convention

    protected $fillable = [
        'course_id',
        // 'title',
        // 'description',
        'content',
        'storage_type',
        'video_url',
        'document_url'
    ];

    // Define the relationship with the ecom_course table
    public function course()
    {
        return $this->belongsTo(ecom_course::class, 'course_id');
    }
    
}
