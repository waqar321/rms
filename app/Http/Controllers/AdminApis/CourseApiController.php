<?php

namespace App\Http\Controllers\AdminApis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ecom_course;

class CourseApiController extends Controller
{
    public function index($employee_code)
    {

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
}
