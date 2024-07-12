<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTraits\CommonRelations;
use Illuminate\Database\Eloquent\SoftDeletes;


class ecom_course extends Model
{
    use HasFactory, CommonRelations, SoftDeletes;

    protected $table = 'ecom_course';
    
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'sub_category_id',
        'instructor_id',
        'duration',
        'level',
        // 'price',
        'prerequisites',
        'language',
        'course_image',
        'course_material',
        'enrollment_limit',
        'start_date',
        'end_date',
        'course_format',
        'course_code',
        // 'storage_type',
        // 'local_video',
        // 'url_video',
        // 'local_document',
        // 'url_document',
        'tags',
        'is_active',
        // 'is_deleted',
    ];


}
