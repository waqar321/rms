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
use App\Models\Admin\ecom_course_assign;
use App\Models\Admin\LectureAssessmentStatus;
use App\Models\Admin\LectureUserRecords;
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
    public function UpdateUserLectureResult(Request $request)
    {
        
        $lecture = ecom_lecture::where('id', $request->lecture_id)->first();
        $LectureUserRecords = LectureUserRecords::where('lecture_id', $request->lecture_id)->where('user_id', auth()->id())->first();

        if($LectureUserRecords) 
        {
            if(!$LectureUserRecords->status == 1)
            {
                if(getUserLectureAssessment($lecture) !== false && getUserLectureAssessment($lecture) > $lecture->passing_ratio)
                {
                    $LectureUserRecords->update(['status' => 1]);
                }
                else
                {
                    $LectureUserRecords->update(['status' => 0]);
                }
            } 
        }
        else
        {                

            
            $LectureUserRecords = new LectureUserRecords();
            $LectureUserRecords->lecture_id = $request->lecture_id;
            $LectureUserRecords->user_id = auth()->id();

            //------------------------- testing -------------------------



                // get each lecture's assessment's question's statuses 
                $assessments_with_questions = collect([
                    $lecture->AssessmentStatus->where('user_id', auth()->id())->where('assessment_level', 1)->map(function ($item) 
                    {
                        return ['question_level' => $item->question_level, 'status' => $item->status];
                    }),
                    $lecture->AssessmentStatus->where('user_id', auth()->id())->where('assessment_level', 2)->map(function ($item) 
                    {
                        return ['question_level' => $item->question_level, 'status' => $item->status];
                    }),
                    $lecture->AssessmentStatus->where('user_id', auth()->id())->where('assessment_level', 3)->map(function ($item) 
                    {
                        return ['question_level' => $item->question_level, 'status' => $item->status];
                    }),
                    $lecture->AssessmentStatus->where('user_id', auth()->id())->where('assessment_level', 4)->map(function ($item) 
                    {
                        return ['question_level' => $item->question_level, 'status' => $item->status];
                    })
                ]);

                $totalPassedAssessments = 0;
                $totalFailedAssessments = 0;

                foreach ($assessments_with_questions as $assessmentQuestions) 
                {
                    if ($assessmentQuestions->isNotEmpty()) 
                    {
                        
                        // list($percentage, $isPassed) = GetPercentageOfAssessment($assessmentQuestions, $lecture->passing_ratio);
                        // dd($assessmentQuestions, 'Passing rate: '. $lecture->passing_ratio, GetPercentageOfAssessment($assessmentQuestions, $lecture->passing_ratio));
            
                        //---------------- assessment passed or not according to lecture percentage--------------------
                        $isPassed = GetPercentageOfAssessment($assessmentQuestions, $lecture->passing_ratio);
                        
                        if($isPassed)
                        {
                            $totalPassedAssessments++;
                        }
                        else
                        {
                            $totalFailedAssessments++;
                        }
            
                        // $totalQuestions += $assessmentQuestions->count();
                        // $totalCorrectAnswers += $assessmentQuestions->where('status', 1)->count();
                        // echo "<br><br><br>";
                        
                    }
                }


                if ($totalFailedAssessments > 0) 
                {
           
                    $overallPercentage = ($totalPassedAssessments / $totalFailedAssessments) * 100;
                    $AssessmentPassingRatio = $overallPercentage >= $lecture->passing_ratio;
                    
                    // echo "Overall Assessment:<br>";
                    // echo "Total Questions: $totalQuestions<br>";
                    // echo "Correct Answers: $totalCorrectAnswers<br>";
                    // echo "Overall Percentage: $overallPercentage%<br>";
                    // echo $overallPassed ? "Overall Passed<br>" : "Overall Failed<br>";
                    // return $AssessmentPassingRatio;
                }
                else
                {
                    $AssessmentPassingRatio = 'fail';
                    // echo "No assessments found.<br>";
                    // return false;
                }

                return response()->json([
                    'status' => 200, 
                    'requestData' => $AssessmentPassingRatio, 
                    'message' => 'user lecture status update successfully'
                ], 
                200
            );
            //------------------------- testing -------------------------

            
            if(getUserLectureAssessment($lecture) !== false && getUserLectureAssessment($lecture) > 50)
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
