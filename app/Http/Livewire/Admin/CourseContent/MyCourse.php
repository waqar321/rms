<?php

namespace App\Http\Livewire\Admin\CourseContent;

use Livewire\Component;
use App\Models\Admin\ecom_course;
use App\Models\Admin\CoursesRegistered;
use Illuminate\Pagination\LengthAwarePaginator;
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
                                ->get();
                                
        $filteredCourses = $courses->filter(function ($course) {
            return CheckAlignment($course, 'course') && $this->checkMycourse($course);
        });

        // Step 3: Paginate the filtered courses
        $perPage = 4; // Number of items per page
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $filteredCourses->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $filteredCourses = new LengthAwarePaginator($currentItems, count($filteredCourses), $perPage, $currentPage);

        // ->paginate(6);
                // if(CheckAlignment($course, 'course'))
                // {
                //     if($this->checkMycourse($course))
                //     {

                //     }
                // }   

                // dd($courses);

        $data['coursesListing'] = $this->readyToLoad ? $filteredCourses : [];
        return $data;
    }
}
