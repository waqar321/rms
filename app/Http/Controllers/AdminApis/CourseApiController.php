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

        // $courses = ecom_course::with(['Instructor' => function ($query) {
        //                             $query->select('full_name');
        //                         }])
        $courses = ecom_course::with('Instructor')->where('is_active', 1)
                                // ->paginate(4);
                                // ->pluck('id');
                                ->get();

        $courses = $courses->filter(function ($course) use ($employee_code)
        {
            return CheckAlignment($course, 'course', $employee_code);
        })->values();

        $formattedCourses = $courses->map(function ($course) {
            return [
                'id' => $course->id,
                'name' => $course->name,
                'description' => $course->description,
                'prerequisites' => $course->prerequisites,
                'course_image' => $course->course_image,
                'course_material' => $course->course_material,
                'start_date' => $course->start_date,
                'end_date' => $course->end_date,
                'course_format' => $course->course_format,
                'course_code' => $course->course_code,
                'tags' => $course->tags,
                'is_active' => $course->is_active,
                // Other course fields
                'instructor' => $course->Instructor->full_name ?? ' - ',
                // ... other desired fields
            ];
        });
        

        return response()->json([
            'status' => true,
            'message' => $formattedCourses
        ], 200);  

    }

}
