<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Traits\ModelTraits\CommonRelations;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentQuestion extends Model
{
    use HasFactory, SoftDeletes, CommonRelations;

    protected $table = 'assessment_questions';
    
    protected $fillable = ['assessment_id', 'question_id'];
}
