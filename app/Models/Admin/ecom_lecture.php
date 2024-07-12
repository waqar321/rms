<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTraits\CommonRelations;
use Illuminate\Database\Eloquent\SoftDeletes;

class ecom_lecture extends Model
{
    use HasFactory, SoftDeletes, CommonRelations;

    protected $table = 'ecom_lecture';
    
    protected $fillable = [
        'title',
        'description',
        'instructor_id',
        'course_id',
        'duration',
        'local_video',
        'url_video',
        'local_document',
        'url_document',
        'tags',
        'Attachments',
        'passing_ratio',
        'is_active',
        'is_deleted',
    ];

    public function QuestionLevels()
    {
        return $this->hasMany(LectureAssessmentLevel::Class, 'lecture_id', 'id');
    }
    public function AssessmentStatus()
    {
        return $this->hasMany(LectureAssessmentStatus::Class, 'lecture_id', 'id');
    }
    public function LectureUserStatus(){
        return $this->hasOne(LectureUserRecords::class, 'lecture_id', 'id');
    }

    // public function LectureUserStatus(){
    //     return $this->belongsTo(LectureUserRecords::class,'lecture_id','id');
    // }

}

