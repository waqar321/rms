<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTraits\CommonRelations;
use Illuminate\Database\Eloquent\SoftDeletes;


class CoursesRegistered extends Model
{

    use HasFactory, SoftDeletes, CommonRelations;
    // use HasFactory, SoftDeletes;

    protected $table = 'course_registered';
    
    protected $fillable = [
        'course_id',
        'user_id',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(ecom_admin_user::class);
    // }
    
}
