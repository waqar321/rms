<?php

namespace App\Http\Controllers\AdminApis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Admin\ecom_category;
use App\Models\Admin\ecom_course;
use App\Models\Admin\CoursesRegistered;
use App\Models\Admin\ecom_course_content;
use App\Models\Admin\ecom_instructor;
use App\Models\Admin\ecom_lecture;
use App\Models\Admin\ecom_admin_user;
use App\Models\Admin\ecom_course_assign;
use App\Models\Admin\LectureAssessmentStatus;
use App\Models\Admin\LectureUserRecords;
use App\Models\Admin\LectureMobileUserRecord;
use Yajra\DataTables\DataTables;
use DateTime;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\Admin\CourseRequest;

class LectureApiController extends Controller
{
    public function index()
    {
        return response()->json(ecom_lecture::all(), 200);
    }
    public function show($id)
    {
        // Retrieve a single lecture by ID
        $lecture = ecom_lecture::find($id);

        if (is_null($lecture)) {
            return response()->json(['message' => 'Lecture Not Found'], 404);
        }

        return response()->json($lecture, 200);
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
                                    'title' => 'required|max:10',
                                    'description' => 'required|max:191',
                                    'duration' => 'required',
                                    'tags' => 'required|max:2|min:10',
                                ]);
                                
        if($validator->fails())
        {
            return response()->json([
                                        'status' => 422, 
                                        'errors' => $validator->messages()
                                    ], 
                                    422
                                );
        }     
        else
        {
            $ecom_lecture = ecom_lecture::where('id', 14)->first();
            
            if($ecom_lecture)
            {
                return response()->json([
                        'status' => 200, 
                        'message' => 'added succesfuly', 
                        'model' => $ecom_lecture
                    ], 
                    200);
            }
            else
            {
                return response()->json([
                    'status' => 422, 
                    'message' => 'something went wrong', 
                    'model' => $ecom_lecture], 
                    500
                );
            }         
        }

        // Validate and create a new lecture
        // $this->validate($request, [
        //     'title' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'instructor_id' => 'required|integer',
        //     'course_id' => 'required|integer',
        //     'duration' => 'nullable|integer',
        //     'local_video' => 'nullable|string',
        //     'url_video' => 'nullable|string',
        //     'local_document' => 'nullable|string',
        //     'url_document' => 'nullable|string',
        //     'tags' => 'nullable|string',
        //     'Attachments' => 'nullable|string',
        //     'is_active' => 'required|boolean',
        //     'is_deleted' => 'required|boolean'
        // ]);

        // $lecture = ecom_lecture::create($request->all());

        return response()->json($lecture, 201);
    }

    public function update(Request $request, $id)
    {
        // Validate and update an existing lecture
        $lecture = ecom_lecture::find($id);

        if (is_null($lecture)) {
            return response()->json(['message' => 'Lecture Not Found'], 404);
        }

        $this->validate($request, [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'instructor_id' => 'sometimes|required|integer',
            'course_id' => 'sometimes|required|integer',
            'duration' => 'nullable|integer',
            'local_video' => 'nullable|string',
            'url_video' => 'nullable|string',
            'local_document' => 'nullable|string',
            'url_document' => 'nullable|string',
            'tags' => 'nullable|string',
            'Attachments' => 'nullable|string',
            'is_active' => 'sometimes|required|boolean',
            'is_deleted' => 'sometimes|required|boolean'
        ]);

        $lecture->update($request->all());

        return response()->json($lecture, 200);
    }

    public function destroy($id)
    {
        // Delete a lecture
        $lecture = ecom_lecture::find($id);

        if (is_null($lecture)) {
            return response()->json(['message' => 'Lecture Not Found'], 404);
        }

        $lecture->delete();

        return response()->json(['message' => 'Lecture Deleted Successfully'], 200);
    }
    public function UpdateAssessment(Request $request)
    {
        $Questions = $request->LectureAssessmentDetails;

        foreach ($Questions as $Question) 
        {

            $assessmentStatus = LectureAssessmentStatus::where('lecture_id', $Question['lecture_id'])
                                                        ->where('assessment_level', $Question['assessmentlevel'])
                                                        ->where('question_level', $Question['question'])
                                                        ->where('user_id', auth()->id())
                                                        ->first();

                                                                // ->get(['assessment_level', 'question_level', 'status']);
                                                                // ->toarray();
            if($assessmentStatus) 
            {
                $assessmentStatus->update(['status' => $Question['CorrectAnswer'] == $Question['answergiven'] ? 1 : 0]);
            }
            else
            {
                $LectureAssessmentStatus = new LectureAssessmentStatus();
                $LectureAssessmentStatus->lecture_id = $Question['lecture_id'];
                $LectureAssessmentStatus->assessment_level = $Question['assessmentlevel'];
                $LectureAssessmentStatus->question_level = $Question['question']; // Assuming 'question' is the correct key
                $LectureAssessmentStatus->user_id = auth()->id();
                $LectureAssessmentStatus->status = $Question['CorrectAnswer'] == $Question['answergiven'] ? 1 : 0;
                $LectureAssessmentStatus->save();
            }
        }

        return response()->json([
                        'status' => 200, 
                        'message' => 'Assessment details saved successfully'
                    ], 
                    200
                );
    }
    public function Lecturelist(Request $request)
    {
        $course_id = $request->input('course_id');
        $userId = $request->input('user_id');
    
        // Check for required fields
        if (!$course_id || !$userId) 
        {
            return response()->json([
                'status' => false,
                'message' => 'Course ID and User ID are required',
            ], 422);
        }

        $courseExists = ecom_course::where('id', $course_id)->exists();

        if (!$courseExists) 
        {
            return response()->json([
                'status' => false,
                'message' => 'Course not found with id : '.$course_id,
            ], 404);
        }

        // Check if user exists
        $userExists = ecom_admin_user::where('employee_id', $userId)->exists();
        if (!$userExists) 
        {
            return response()->json([
                'status' => false,
                'message' => 'User not found with id: '.$userId.var_dump($userId),
            ], 404);
        }

        $courseLectures = ecom_lecture::where('course_id', $course_id)->orderBy('id', 'DESC')->where('is_active', 1)->get();
        
        if(!$courseLectures->isEmpty())
        {
            //----------------------- gett status ----------------------
                        
                $formattedlectures = $courseLectures->map(function ($lecture) use ($userId) 
                {
                    $status = 0;
                    $user = ecom_admin_user::where('employee_id', $userId)->first();
                    $LectureMobileUserRecord = LectureMobileUserRecord::where('lecture_id', $lecture->id)->where('user_id', $user->id)->first();

                    if($LectureMobileUserRecord != null)
                    {
                        $status = $LectureMobileUserRecord->status;
                    }

                    return [
                        'id' => $lecture->id,
                        'title' => $lecture->title,
                        'description' => $lecture->description,
                        'local_video' => $lecture->local_video,
                        'url_video' => $lecture->url_video,
                        'local_document' => $lecture->local_document,
                        'url_document' => $lecture->url_document,
                        'Thumbnail' => $lecture->Thumbnail,
                        'tags' => $lecture->tags,
                        'course_id' => $lecture->course_id,
                        'passing_ratio' => $lecture->passing_ratio,
                        'instructor' => $lecture->Instructor->full_name ?? ' - ',
                        'Viewstatus' => $status
                    ];
                });

            return response()->json([
                'status' => true,
                'message' => $formattedlectures
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
    public function LectureMobileViewStatus(Request $request)
    {
        $lectureId = $request->input('lecture_id');
        $userId = $request->input('user_id');
    
        // Check for required fields
        if (!$lectureId || !$userId) 
        {
            return response()->json([
                'status' => false,
                'message' => 'Lecture ID and User ID are required',
            ], 422);
        }

        // Check if lecture exists
        $lectureExists = ecom_lecture::where('id', $lectureId)->exists();
        if (!$lectureExists) 
        {
            return response()->json([
                'status' => false,
                'message' => 'Lecture not found with id : '.$lectureId,
            ], 404);
        }

        // Check if user exists
        $userExists = ecom_admin_user::where('employee_id', $userId)->exists();
        if (!$userExists) 
        {
            return response()->json([
                'status' => false,
                'message' => 'User not found with id: '.$userId.var_dump($userId),
            ], 404);
        }

        $user = ecom_admin_user::where('employee_id', $userId)->first();
        $lecture = ecom_lecture::where('id', $request->lecture_id)->first();
        $LectureMobileUserRecord = LectureMobileUserRecord::where('lecture_id', $request->lecture_id)->where('user_id', $user->id)->first();

        if($LectureMobileUserRecord != null)
        {
            $LectureMobileUserRecord->update(['status' => 1]);
            $message = 'user lecture view Updated  successfully';
        }
        else
        {
            $LectureMobileUserRecord = new LectureMobileUserRecord();
            $LectureMobileUserRecord->lecture_id = $request->lecture_id;
            $LectureMobileUserRecord->user_id = $user->id;
            $LectureMobileUserRecord->status = 1;
            $LectureMobileUserRecord->save();

            $message = 'user lecture view Created successfully';

        }


        return response()->json([
                    'status' => 200, 
                    'requestData' => $request->all(), 
                    'message' => $message
                ], 
            200
        );

    }
    public function UpdateUserLectureResult(Request $request)
    {
        
        $lecture = ecom_lecture::where('id', $request->lecture_id)->first();
        $LectureUserRecords = LectureUserRecords::where('lecture_id', $request->lecture_id)->where('user_id', auth()->id())->first();

        if($LectureUserRecords && (!$LectureUserRecords->status == 1)) 
        {
            if((getUserLectureAssessment($lecture) == 'oneAndPass') || (getUserLectureAssessment($lecture) > $lecture->passing_ratio))
            {
                $LectureUserRecords->update(['status' => 1]);                    
            }
            else
            {
                $LectureUserRecords->update(['status' => 0]);
            }
        }
        else
        {                                
            $LectureUserRecords = new LectureUserRecords();
            $LectureUserRecords->lecture_id = $request->lecture_id;
            $LectureUserRecords->user_id = auth()->id();

            // return response()->json([
            //         'status' => 200, 
            //         'requestData' => (getUserLectureAssessment($lecture) == 'oneAndPass') || (getUserLectureAssessment($lecture) > $lecture->passing_ratio), 
            //         'message' => 'user lecture status update successfully'
            //     ], 
            //     200
            // );

            if((getUserLectureAssessment($lecture) == 'oneAndPass') || (getUserLectureAssessment($lecture) > $lecture->passing_ratio))
            {
                $LectureUserRecords->status = 1;                    
            }
            else
            {
                $LectureUserRecords->status = 0;
            }

            $LectureUserRecords->save();
        }

        return response()->json([
                    'status' => 200, 
                    'requestData' => $request->all(), 
                    'message' => 'user lecture status update successfully'
                ], 
                200
            );
    }
}
