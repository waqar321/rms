<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelTraits\CommonRelations;
use Illuminate\Database\Eloquent\SoftDeletes;

class ecom_notification extends Model
{
    use HasFactory, SoftDeletes, CommonRelations;

    protected $table = 'notifications';

    protected $fillable = [
        'title',
        'messagebody',
        'seen',
        'read_notification',
        'multicast_id',
        'firebase_message_id',
        'user_id',
        'user_uploader_id',
        'instructor_id',
        'employee_id',
        'department_id',
        'sub_department_id',
        'zone_code', 
        'city_id',
        'branch_id',
        'role_id',
        'shift_time_id',
        'upload_csv',
        'upload_csv_json_data'       
    ];
}
