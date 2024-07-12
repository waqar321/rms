<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelTraits\CommonRelations;

class ecom_course_assign extends Model
{
    
    use HasFactory, SoftDeletes, CommonRelations;
    
    protected $table = 'ecom_course_assign';

    protected $fillable = [
        'course_id',
        'user_uploader_id',
        'instructor_id',
        'employee_id',
        'department_id',
        'sub_department_id',
        'zone_code', //'zone_name',
        'city_id',
        'branch_id',
        'role_id',
        'shift_time_id',
        'upload_csv',
        'upload_csv_json_data'
    ];
    
    public function course()
    {
        return $this->belongsTo(ecom_course::class, 'course_id');
    }

}
