<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTraits\CommonRelations;
use Illuminate\Database\Eloquent\SoftDeletes;
    
class LectureAssessmentLevel extends Model
{
    // use HasFactory, SoftDeletes, CommonRelations;
    use HasFactory, CommonRelations;

    protected $table = 'lecture_assessment_levels';

    protected $fillable = ['lecture_id', 'assessment_level', 'assessment_time'];

    public function lecture()
    {
        return $this->belongsTo(ecom_lecture::class, 'lecture_id');
    }

    // public function questions()
    // {
    //     return $this->belongsToMany(LectureQuestion::class, 'assessment_questions', 'assessment_id', 'question_id');
    // }
    
    public function questions()
    {
        return $this->belongsToMany(LectureQuestion::class, 'assessment_questions', 'assessment_id', 'question_id');
        // get data of LectureQuestion model 
                    // ->withPivot('id', 'created_at', 'updated_at');
                    //assessment_questions =>  is a pivot table , This is the name of the pivot table that joins the two related models
                    //assessment_id        => Foreign Key on Pivot Table, This is the foreign key column on the pivot table that points to the current model. 
                    //question_id          => Foreign Key on Related Table, This is the foreign key column on the pivot table that points to the related model  
                    // withPivot           => specifies which additional columns from the pivot table you want to include in the results

                    // When you call $assessment->questions, Eloquent will look into the assessment_questions pivot table to find all records 
                    // where the assessment_id matches the ID of the current Assessment model.

    }
    /*
        This method is defining a relationship between two models using Laravel's Eloquent ORM. Specifically, it defines a many-to-many 
        relationship between the current model and the LectureQuestion model through a pivot table called assessment_questions. 
        Here's a detailed explanation of each part of the method

    */
}
