<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTraits\CommonRelations;
use Illuminate\Database\Eloquent\SoftDeletes;


class LectureAssessmentLevelStatus extends Model
{
    use HasFactory, SoftDeletes, CommonRelations;
    protected $table = 'lecture_assessment_level_status';
    
    protected $fillable = [
        'lecture_id',
        'user_id',
        'assessment_level',
        'question',
        'status',
    ];

}
