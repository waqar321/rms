<?php

namespace App\Http\Livewire\Admin\CourseContent;

use Livewire\Component;
use App\Models\Admin\ecom_course;
use App\Models\Admin\CoursesRegistered;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

use App\Traits\livewireComponentTraits\LivewireComponentsCommon;


class MyCourse extends Component
{
    use WithPagination, WithFileUploads, LivewireComponentsCommon;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['deletetest' => 'deletetestRecord', 'updateStatusOftest' => '', 'selectedColumns' => 'export'];
    

    public function mount()
    {
        // $courses = ecom_course::when($this->searchByName !== '', function ($query) {
        //         $query->where('name', 'like', '%' . $this->searchByName . '%');
        // }) 
        // ->orderBy('id', 'DESC')
        // ->where('is_active', 1)
        // ->get();

        // dd(CheckAlignment($courses[2], 'course'));
        
        // $this->pageTitle = 'Show Course Lecture';
        // $this->MainTitle = 'CourseLectures';

        $this->pageTitle = 'Courses Manage';
        $this->MainTitle = 'CoursesManage';

        $this->searchByName = '';
    }
    public function render()
    {
        return view('livewire.admin.course-content.my-course', $this->RenderData());
    }
    public function checkMycourse($course)
    {
        if($course->RegisteredCourses)
        {
            $ids = $course->RegisteredCourses->pluck('user_id')->toarray();
            
            if(in_array(auth()->user()->id, $ids))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    protected function RenderData()
    {
        $courses = ecom_course::when($this->searchByName !== '', function ($query) {
                                        $query->where('name', 'like', '%' . $this->searchByName . '%');
                                }) 
                                ->orderBy('id', 'DESC')
                                ->where('is_active', 1)
                                // ->get();
                                ->paginate(6);

        $data['coursesListing'] = $this->readyToLoad ? $courses : [];
        return $data;
    }
}
