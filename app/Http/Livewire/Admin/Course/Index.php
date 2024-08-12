<?php

namespace App\Http\Livewire\Admin\Course;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Admin\ecom_course;
use App\Models\Admin\ecom_category;
use App\Models\Admin\ecom_admin_user;
use App\Traits\livewireComponentTraits\CourseComponent;
use App\Rules\EitherOrRule;

class Index extends Component
{
    use WithPagination, WithFileUploads, CourseComponent;
    protected $paginationTheme = 'bootstrap';  
    protected $listeners = ['deleteCourseManage' => 'deleteCourseRecord', 'selectedColumns' => 'export'];

    public function mount(ecom_course $ecom_course)
    {  


        $employee_code = 41487;
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
                'instructor' => $course->Instructor->full_name,
                // ... other desired fields
            ];
        });
        
        dd($courses, $formattedCourses);
        dd($courses);
        // dd($courses12);
        // dd($courses12, $courses12[0]->instructor->full_name);

        $this->setMountData($ecom_course);
    }
    public function render()
    {
        $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        return view('livewire.admin.course.index', $this->RenderData());
    }
    public function saveCourse()
    {  

        if(!$this->update)
        {
            $this->validate();            
        }
        $this->updateFiles();
        
        if(auth()->user()->isInstructor())
        {
            $this->ecom_course->instructor_id = auth()->user()->id; 
        }
        
        // dd($this->ecom_course);
        // $this->ecom_course->instructor_id = $isInstructor ? auth()->user()->id : $this->ecom_course->instructor_id; 

        $this->ecom_course->save();
        $name = $this->ecom_course->name;
        $this->ecom_course = new ecom_course(); 

        session()->flash('message', $this->MainTitle.' '. $this->update ? 'Updated' : 'Added' . ' Successfully');
        $this->resetInput();
        $this->Collapse = "collapse";
        $this->dispatchBrowserEvent('created_module', ['name'=> $name]);

        if(request()->has('id'))
        {
            return redirect()->to('content-management/course');
        }
    } 
    public function updateFiles()
    {
        // if ($this->video && $this->video_url)
        // {
        //     $this->addError('video_error', 'Either upload a video or provide a URL, but not both.');
        //     return false;
        // }
        // elseif($this->document && $this->document_url) 
        // {
        //     $this->addError('document_error', 'Either upload a document or provide a URL, but not both.');
        //     return false;
        // }   

        if ($this->photo) 
        {
            $this->validate([
                'photo' => 'image|mimes: jpg,jpeg,png,svg,gif|max:100'
            ]);  
            $this->ecom_course->course_image = storeFile('course/photos', $this->photo);    
        }
        if ($this->video) 
        {
            $this->validate([
                'video' => 'mimetypes:video/mp4,video/webm,video/quicktime'
            ]); 
            $this->ecom_course->local_video = storeFile('course/videos', $this->video);
        }
        if ($this->video_url) 
        {
            $this->validate([
                'video_url' => 'url'
            ]);  
            $this->ecom_course->url_video = $this->video_url;            
        }
        if ($this->document) 
        {
            $this->validate([
                'document' => 'mimes:pdf|max:5000'
            ]);  
            $this->ecom_course->local_document = storeFile('course/documents', $this->document);
        }
        if ($this->document_url) 
        {
            $this->validate([
                'document_url' => 'url'
            ]); 
            $this->ecom_course->url_document = $this->document_url;
        }    


    }
   
}
