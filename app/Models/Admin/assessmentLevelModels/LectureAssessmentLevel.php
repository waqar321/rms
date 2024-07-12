<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTraits\CommonRelations;
use Illuminate\Database\Eloquent\SoftDeletes;


class LectureAssessmentLevel extends Model
{
    use HasFactory, SoftDeletes, CommonRelations;
    protected $table = 'lecture_assessment_levels';
    
    protected $fillable = [
        'lecture_id',
        'assessment_level',
        'assessment_time',
        'question_level',
    ];

    public function lecture()
    {
        return $this->belongsTo(ecom_admin_user::class, 'lecture_id', 'id');
    }
    public function QuestionLevels()
    {
        return $this->belongsTo(lecture_question_levels::class, 'question_level', 'id');
    }
    
    
    // public function lecture()
    // {
    //     return $this->belongsTo(ecom_admin_user::class, 'lecture_id', 'id');
    // }

    // Schema::create('lecture_assessment_levels', function (Blueprint $table) {
    //     $table->id();
    //     $table->unsignedBigInteger('lecture_id')->nullable();
    //     $table->foreign('lecture_id')->references('id')->on('ecom_lecture')->onDelete('cascade');
    //     $table->integer('assessment_level')->nullable();
    //     $table->string('question')->nullable();
}
