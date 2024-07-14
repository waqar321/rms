<?php

namespace App\Http\Livewire\Admin\CourseContent;

use Livewire\Component;
use App\Models\Admin\ecom_course;
use App\Models\Admin\ecom_lecture;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
// use App\Traits\livewireComponentTraits\CourseComponent;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
    
class CourseLectures extends Component
{
    use WithPagination, WithFileUploads, LivewireComponentsCommon;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['deletetest' => 'deletetestRecord', 'updateStatusOftest' => '', 'selectedColumns' => 'export'];
    public ecom_course $ecom_course;  
    // public $courseLectures;
    

    public function mount(ecom_course $ecom_course)
    {

        $lecture = ecom_lecture::where('id', 18)->first();
        // dd($lecture->LectureUserStatus->value('status'));
        // if($this->getUserLectureAssessment($lecture) != false)
        // {
        //     dd('record esists');
        // }
        // else
        // {
        //     dd('recrd does not exists');
        // }

        // dd('done');
       
        // dd($lecture);
        // Assuming $lecture->AssessmentStatus is a collection
        // $assessment1 = $lecture->AssessmentStatus->where('assessment_level', 1)->map(function ($item) {
        //     return [
        //         'question_level' => $item->question_level,
        //         'status' => $item->status,
        //     ];
        // });

        // $assessment2 = $lecture->AssessmentStatus->where('assessment_level', 2)->map(function ($item) {
        //     return [
        //         'question_level' => $item->question_level,
        //         'status' => $item->status,
        //     ];
        // });

        // $assessment3 = $lecture->AssessmentStatus->where('assessment_level', 3)->map(function ($item) {
        //     return [
        //         'question_level' => $item->question_level,
        //         'status' => $item->status,
        //     ];
        // });

        // $assessment4 = $lecture->AssessmentStatus->where('assessment_level', 4)->map(function ($item) {
        //     return [
        //         'question_level' => $item->question_level,
        //         'status' => $item->status,
        //     ];
        // });

        // if($assessment1->isNotEmpty()) 
        // {
        //     $this->GetPercentageOfAssessment($assessment1);
        // }
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";


        // if($assessment2->isNotEmpty())
        // {
        //     $this->GetPercentageOfAssessment($assessment2);
        // }
    
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";


        // if($assessment3->isNotEmpty())
        // {
        //     $this->GetPercentageOfAssessment($assessment3);
        // }

        // echo "<br>";
        // echo "<br>";
        // echo "<br>";

        // if($assessment4->isNotEmpty())
        // {
        //     $this->GetPercentageOfAssessment($assessment4);
        // }

        // dd('done');

        // $this->pageTitle = 'Show Course Lecture';
        // $this->MainTitle = 'CourseLectures';
        $this->pageTitle = 'Courses Manage';
        $this->MainTitle = 'CoursesManage';

        $this->ecom_course = $ecom_course ?? new ecom_course();
        // $this->courseLectures = $this->ecom_course->CourseLectures;
        // $this->courseLectures = collect();

        // dd( $this->courseLectures);
        // dd($this->courseLectures);
        // dd($this->courseLectures);
    }
    public function render()
    {

        $courseLectures = ecom_lecture::where('course_id', $this->ecom_course->id)->orderBy('id', 'DESC')->where('is_active', 1)->paginate(4);
        
        return view('livewire.admin.course-content.course-lectures', compact('courseLectures'));
    }
    public function SaveModel()
    {

    }
}
