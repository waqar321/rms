<?php

namespace App\Http\Controllers\AdminApis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ecom_course;
use App\Models\Admin\ecom_lecture;

class CourseApiController extends Controller
{
    public function index(Request $request)
    {
        $requestData = $request->all();
        $employee_code = $requestData['employee_code'];
        // $course = ecom_course::orderBy('id', 'DESC')
        //             ->where('is_active', 1)
        //             ->where('id', 20)
        //             // ->paginate(4);
        //             // ->get();
        //             ->first();             
        
        // return response()->json([
        //     'status' => true,
        //     'message' => CheckAlignment($course, 'course', $employee_code)
        // ], 200);  

        $courses = ecom_course::orderBy('id', 'DESC')
                                ->where('is_active', 1)
                                // ->paginate(4);
                                // ->pluck('id');
                                ->get();
    
        $courses = $courses->filter(function ($course) use ($employee_code)
        {
            return CheckAlignment($course, 'course', $employee_code);
        });


        return response()->json([
            'status' => true,
            'message' => $courses
        ], 200);  

    }
    public function Lecturelist(Request $request)
    {
        $requestData = $request->all();
        $course_id = $requestData['course_id'];

        $course = ecom_course::where('id', $course_id);
                
        if($course->exists())
        {
            $courseLectures = ecom_lecture::where('course_id', $course_id)->orderBy('id', 'DESC')->where('is_active', 1)->get();
            
            if(!$courseLectures->isEmpty())
            {
                return response()->json([
                    'status' => true,
                    'message' => $courseLectures
                ], 200); 
            }
            else
            {
                return response()->json([
                    'status' => false,
                    'message' => 'No Lectures Available'
                ], 200);             
            }
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Please Enter Correct Course ID'
            ], 200);                         
        }
    }
}
