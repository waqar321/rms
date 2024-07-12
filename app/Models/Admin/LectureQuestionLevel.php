<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTraits\CommonRelations;
use Illuminate\Database\Eloquent\SoftDeletes;
 
class LectureQuestionLevel extends Model
{
    use HasFactory, CommonRelations;

    protected $table = 'lecture_question_levels';
    
    protected $fillable = ['level_name'];

    public function questions()
    {
        return $this->hasMany(LectureQuestion::class, 'question_level_id');
    }
}
