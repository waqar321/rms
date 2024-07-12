<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTraits\CommonRelations;
use Illuminate\Database\Eloquent\SoftDeletes;
   
class LectureQuestion extends Model
{
    use HasFactory, CommonRelations;

    protected $table = 'lecture_questions';
    
    protected $fillable = ['question_level_id', 'question', 'answer'];

    public function questionLevel()
    {
        return $this->belongsTo(LectureQuestionLevel::class, 'question_level_id');
    }

    public function assessments()
    {
        return $this->belongsToMany(LectureAssessmentLevel::class, 'assessment_questions', 'question_id', 'assessment_id');
    }
    
}
