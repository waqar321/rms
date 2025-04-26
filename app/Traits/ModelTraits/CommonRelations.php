<?php


namespace App\Traits\ModelTraits;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\ecom_lecture;
use App\Models\Admin\ecom_course_assign;
use App\Models\Admin\LectureAssessmentLevel;
use App\Models\Admin\LectureAssessmentLevelStatus;
use App\Models\Admin\ecom_category;
use App\Models\Admin\ecom_admin_user;
use App\Models\Admin\Role;

use App\Models\Admin\ecom_department;
use App\Models\Admin\central_ops_city;
use App\Models\Admin\central_ops_branch;
// use App\Models\Admin\ecom_user_roles;
use App\Models\Admin\ecom_employee_time_slots;
use App\Models\Admin\ecom_course;
use App\Models\Admin\CoursesRegistered;
use App\Models\Admin\ecom_notification;
use App\Models\Admin\Zone;
use App\Models\Admin\ecom_notifications_status;
use Illuminate\Support\Collection;

trait CommonRelations 
{
    public function user()
    {
        return $this->belongsTo(ecom_admin_user::class);
    }
    public function NotificationUser()
    {
        return $this->belongsTo(ecom_admin_user::class, 'user_id', 'id');
    }
    public function Uploader()
    {
        return $this->belongsTo(ecom_admin_user::class, 'user_uploader_id', 'id');
    }
    public function Instructor()
    {
        return $this->belongsTo(ecom_admin_user::class, 'instructor_id', 'id'); 
    }
    public function Teacher()
    {
        return $this->belongsTo(ecom_admin_user::class, 'instructor_id');
    }
    public function course()
    {
        return $this->belongsTo(ecom_course::class, 'course_id');
    }
    public function RegisteredCourses()
    {
        return $this->HasMany(CoursesRegistered::class, 'course_id');
    }
    public function Notification()
    {
        return $this->belongsTo(ecom_notification::class, 'notification_id', 'id');
    }
    public function NotificationStatuses()
    {
        return $this->HasMany(ecom_notifications_status::class, 'notification_id');
    }
    public function Employee()
    {
        return $this->belongsTo(ecom_admin_user::class, 'employee_id', 'id');
    }
    public function Department()
    {
        return $this->belongsTo(ecom_department::class, 'department_id', 'department_id');
    }
    public function SubDepartment()
    {
        return $this->belongsTo(ecom_department::class, 'sub_department_id', 'sub_department_id' );
    }
    public function City()
    {
        return $this->belongsTo(central_ops_city::class, 'city_id', 'city_id' );
    }
    public function Branch()
    {
        return $this->belongsTo(central_ops_branch::class, 'branch_id', 'branch_id' );
    }
    public function Role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
    public function Zone()
    {
        return $this->belongsTo(Zone::class, 'zone_code', 'zone_code');
    }
    public function Shifttime()
    {
        return $this->belongsTo(ecom_employee_time_slots::class, 'shift_time_id', 'id');
    }
    // public function QuestionLevels()
    // {
    //     return $this->hasMany(LectureAssessmentLevel::Class, 'lecture_id', 'id');
    // }
    public function QuestionLevelStatuses()
    {
        return $this->hasMany(LectureAssessmentLevelStatus::Class, 'lecture_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(ecom_category::class, 'category_id');
    }
    public function subCategory()
    {
        return $this->belongsTo(ecom_category::class, 'sub_category_id');
    }
    public function alignment()
    {
        return $this->belongsTo(ecom_course_assign::class, 'id', 'course_id');
    }
    public function CourseLectures()
    {
        return $this->HasMany(ecom_lecture::class, 'course_id');
    }
}