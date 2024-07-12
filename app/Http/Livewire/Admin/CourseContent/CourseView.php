<?php

namespace App\Http\Livewire\Admin\CourseContent;

use Livewire\Component;
use App\Models\Admin\ecom_course;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\CategoryComponent;
    
class CourseView extends Component
{
    use WithPagination, WithFileUploads, CategoryComponent;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['deletetest' => 'deletetestRecord', 'updateStatusOftest' => '', 'selectedColumns' => 'export'];

    public $ecom_course;  

    public function mount(ecom_course $ecom_course)
    {
        // $this->pageTitle = 'Show Lecture';
        // $this->MainTitle = 'LectureView';
        $this->pageTitle = 'Lecture Manage';
        $this->MainTitle = 'LectureManage';

        $this->ecom_course = $ecom_course ?? new ecom_course();
        // dd($this->ecom_course);
    }
    public function render()
    {
        return view('livewire.admin.course-content.course-view');
    }
    // public function JoinNow()
    // {
    //     dd('JoinNow');
    // }
}
