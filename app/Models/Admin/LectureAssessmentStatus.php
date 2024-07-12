<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTraits\CommonRelations;
use Illuminate\Database\Eloquent\SoftDeletes;

class LectureAssessmentStatus extends Model
{
    use HasFactory, CommonRelations;
    
    protected $table = 'lecture_assessment_status';
    
    protected $fillable = ['lecture_id', 'assessment_level', 'question_id', 'user_id', 'status'];

    public function lecture()
    {
        return $this->belongsTo(ecom_lecture::class, 'lecture_id');
    }
    public function Assessment_levels()
    {
        return $this->belongsTo(lecture_assessment_levels::class, 'assessment_level');
    }
    public function user()
    {
        return $this->belongsTo(ecom_admin_user::class, 'id', 'user_id');
    }
}