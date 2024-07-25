<?php

namespace App\Http\Livewire\Admin\Lecture;

use Livewire\Component;
use App\Models\Admin\ecom_lecture;
use App\Models\Admin\LectureQuestion;
use App\Models\Admin\LectureAssessmentLevel;
use App\Models\Admin\LectureAssessmentStatus;
use App\Jobs\AsimTesting;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\CategoryComponent;
use Illuminate\Support\Facades\Log;

class LectureView extends Component
{
    use WithPagination, WithFileUploads, CategoryComponent;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
                                'submitForm' => 'handlesubmitForm', 
                                'updateStatusOftest' => '', 
                                'selectedColumns' => 'export', 
                                'lectureQuestionSubmission'=>'lectureQuestionSubmit',
                                'UpdateUserLectureResult'=>'handleUpdateUserLectureResult'
                            ];

    public $ecom_lecture;  
    public $countAssessmentForm=0;  
    public $answers=[];  
    public $assessmentData=[];  
    public $assessmentStatus=[];  

    public function mount(ecom_lecture $ecom_lecture)
    {
        // for($i=0;$i<50000;$i++)
        // {
        //         Log::info('Processing item: ' . $i); 
        // }

        // AsimTesting
        // dispatch(new AsimTesting()); 
        // dd('AsimTesting');
        // $courseLecture = ecom_lecture::where('id', 18)->first();

        if(getUserLectureAssessment($ecom_lecture) !== false && getUserLectureAssessment($ecom_lecture) > 50)
        {
            dd('pass');
        }
        else
        {
            dd('fail');
        }

        // dd('done');
        // $awd = LectureQuestion::where('id', 279)->first();
        // dd(json_decode($awd->answer));

        // dd($this->getLectureDetails(14)->toArray());
        // dd(auth()->id());
        // $this->assessmentStatus = LectureAssessmentStatus::where('lecture_id', $ecom_lecture->id)->where('user_id', auth()->id())->pluck('assessment_level', 'question_level')->toarray();
        $this->assessmentStatus = LectureAssessmentStatus::where('lecture_id', $ecom_lecture->id)->where('user_id', auth()->id())->get(['assessment_level', 'question_level', 'status'])->toarray();
        // dd($this->assessmentStatus);

        // $this->pageTitle = 'Show Lecture';
        // $this->MainTitle = 'LectureView';
        $this->pageTitle = 'Lecture Manage';
        $this->MainTitle = 'LectureManage';
        $this->ecom_lecture = $ecom_lecture ?? new ecom_lecture();
        
        if(!empty($this->getLectureDetails($ecom_lecture->id)->toArray()))
        {
            $this->assessmentData = $this->getLectureDetails($ecom_lecture->id)->toArray();
        }

        // assessmentStatus = LectureAssessmentStatus

        // dd($this->assessmentData);
        // $this->getLectureDetails($ecom_lecture->id)->toArray();

        // dd(LectureAssessmentLevel::where('lecture_id', 2)->get());
        // dd($this->ecom_lecture->QuestionLevels);
    }
    public function render()
    {
        return view('livewire.admin.lecture.lecture-view');
    }
    public function handlesubmitForm(Request $request)
    {
        $this->answers['abc'] = 'ac';
        // Handle form submission logic here
        // You can access form data using $this->answers array
        // Redirect to desired route after form submission
        return Redirect::route('content-management.MyCourse.index');
    }
    public function lectureQuestionSubmit()
    {
        dd('submitted');
    }
    
    public function handleUpdateUserLectureResult()
    {
        dd('lecture ednd');
    }
    

}
