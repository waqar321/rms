<?php

namespace App\Http\Livewire\Admin\CourseContent;

use Livewire\Component;
use App\Models\Admin\ecom_course;
use App\Models\Admin\ecom_course_assign;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\CourseContentComponent;
    
class Index extends Component
{

    use WithPagination, WithFileUploads, CourseContentComponent;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['deletetest' => 'deletetestRecord', 'updateStatusOftest' => '', 'selectedColumns' => 'export'];
    public $found =false;

    public function mount(ecom_course $ecom_course)
    {
        
        $this->setMountData($ecom_course);
    }   
    public function render()
    {
             
        // ecom_course::find(7);
        // dd($this->CheckCourseAlignment(ecom_course::find(7)));

        // dd($first_ecom_course->alignment);
        // $first_ecom_course_assign = ecom_course_assign::first();
        
        
        // $ecom_course_assign_ids = ecom_course_assign::pluck('course_id')->toArray();
        // $ecom_course_ids = ecom_course::pluck('id')->toArray();
        // $not_aligned_courses_ids = array_diff($ecom_course_ids, $ecom_course_assign_ids);
        // $this->courses = ecom_course::find($not_aligned_courses_ids);
        return view('livewire.admin.course-content.index', $this->RenderData());
    }
 
}
