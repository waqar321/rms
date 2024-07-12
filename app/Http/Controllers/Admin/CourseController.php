<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Admin\ecom_category;
use App\Models\Admin\ecom_course;
use App\Models\Admin\CoursesRegistered;
use App\Models\Admin\ecom_course_content;
use App\Models\Admin\ecom_instructor;
use App\Models\Admin\ecom_lecture;
use App\Models\Admin\ecom_course_assign;
use Yajra\DataTables\DataTables;
use DateTime;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\CourseRequest;

class CourseController extends Controller
{
    protected $ecom_course;
  
    public function index(Request $request)
    {
        if($request->has('id'))
        {
            $ecom_course = ecom_course::find(base64_decode($request->id));
            return view('Admin/manage_course/course/index', compact('ecom_course'));
        }
        else
        {
            return view('Admin/manage_course/course/index');
        }
    } 
    public function AlignCourseindex(Request $request)
    {
        if($request->has('id'))
        {         
            $ecom_course_assign = ecom_course_assign::find(base64_decode($request->id));
            return view('Admin/manage_course/course_assign/index', compact('ecom_course_assign'));
        }
        else
        {
            return view('Admin/manage_course/course_assign/index');
        }
    } 
    public function courseListIndex(Request $request)
    {
        if($request->has('id'))
        {
            $ecom_course = ecom_course::find(base64_decode($request->id));
            return view('Admin/manage_course/course_content/index', compact('ecom_course'));
        }
        else
        {
            return view('Admin/manage_course/course_content/index');
        }
    }     
    public function CourseEnroll(Request $request)
    {
     
        if($request->has('id'))
        {
            $ecom_course = ecom_course::find(base64_decode($request->id));
            
            $already = CoursesRegistered::where('course_id', $ecom_course->id)->where('user_id', auth()->user()->id)->count();
            
            if($already == 0 )
            {
                $CoursesRegistered = new CoursesRegistered();
                $CoursesRegistered->course_id = $ecom_course->id; 
                $CoursesRegistered->user_id = auth()->user()->id;
                $CoursesRegistered->save();
            }

            return redirect()->route('MyCourse');
        }
    } 
    public function MyCourse()
    {
        return view('Admin/manage_course/course_content/mycourses');
    } 
    public function LecturesList(Request $request)
    {
        if($request->has('id'))
        {
            $ecom_course = ecom_course::find(base64_decode($request->id));
            return view('Admin/manage_course/course_content/courseLectures', compact('ecom_course'));
        }
    } 
    public function LectureUploadIndex(Request $request)
    {
        if($request->has('id'))
        {
            $ecom_lecture = ecom_lecture::find(base64_decode($request->id));
            return view('Admin/manage_course/lecture/index', compact('ecom_lecture'));
        }
        else
        {
            return view('Admin/manage_course/lecture/index');
        }
    } 
    public function lectureView(Request $request)
    {
        if($request->has('id'))
        {
            $ecom_lecture = ecom_lecture::find(base64_decode($request->id));
            return view('Admin/manage_course/lecture/view', compact('ecom_lecture'));
        }
    }
}
