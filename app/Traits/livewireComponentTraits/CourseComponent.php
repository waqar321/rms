<?php


namespace App\Traits\livewireComponentTraits;

use App\Models\Admin\ecom_course;
use App\Models\Admin\ecom_course_assign;
use App\Models\Admin\ecom_category;
use App\Models\Admin\ecom_department;
use App\Models\Admin\ecom_admin_user;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
use App\Rules\EitherOrRule;

trait CourseComponent
{
    use LivewireComponentsCommon;

    public $title;
    public $video;
    public $video_url;
    public $document;
    public $document_url;
    public ecom_course $ecom_course;  
    // public Collection $selectedRows; 
    public $availableColumns;
    public $videoSet="empty";
    public $URLvideoSet="empty";
    public $total_courses=0;

    public function __construct()
    {       
        
        // $ecom_course = ecom_course::first();
        // dd($ecom_course->alignment->delete());
        // $ecom_course_assign = ecom_course_assign::where('course_id', $ecom_course)->delete();


        // $ecom_course = ecom_course::first();
        // dd($ecom_course_assign);
        // dd($ecom_course->alignment);

        $this->availableColumns = ['S.No', 'Code', 'Title', 'Image', 'Description', 'Category', 'Sub-Category', 'Level', 'Prerequisites', 'Language', 'Tags', 'Status', 'Date', 'Action'];
       
        $this->Tablename = 'ecom_course';        
        $this->selectedRows = collect();
        $this->searchByName = '';
        $this->update = request()->has('id') == true;
        $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
    }

    protected $rules = [
        'ecom_course.name' => 'required|min:2',
        'ecom_course.description' => 'required|min:20',
        'ecom_course.category_id' => 'required',
        'ecom_course.sub_category_id' => 'required',
        // 'ecom_course.department_id' => 'required',
        // 'ecom_course.sub_department_id' => 'required',
        // 'ecom_course.instructor_id' => 'required',
        // 'ecom_course.duration' => 'required',
        'ecom_course.level' => 'required',
        // 'ecom_course.prerequisites' => 'required',
        'ecom_course.language' => 'required',
        // 'ecom_course.course_material' => 'required',
        // 'ecom_course.enrollment_limit' => 'required',
        'ecom_course.start_date' => 'required',
        'ecom_course.end_date' => 'required',
        'ecom_course.course_format' => 'required',
        'ecom_course.course_code' => 'required|unique:ecom_course',
        'ecom_course.tags' => 'required',
        // 'ecom_course.storage_type' => 'required',
        'video' => '',
        'video_url' => '',
        'document' => '',
        'document_url' => '',
        'photo' => '',
    ];

    protected $messages = [
        'ecom_course.name.required' => 'The Course Title field is required.',
        'ecom_course.name.min' => 'The Course Title must be at least :min characters.',
        'ecom_course.description.required' => 'The description field is required.',
        'ecom_course.category_id.required' => 'The category field is required.',
        'ecom_course.sub_category_id.required' => 'The sub category field is required.',
        // 'ecom_course.instructor_id.required' => 'The instructor field is required.',
        'ecom_course.duration.required' => 'The duration field is required.',
        'ecom_course.level.required' => 'The level field is required.',
        'ecom_course.prerequisites.required' => 'The prerequisites field is required.',
        'ecom_course.language.required' => 'The language field is required.',
        'ecom_course.course_material.required' => 'The course material field is required.',
        'ecom_course.enrollment_limit.required' => 'The enrollment limit field is required.',
        'ecom_course.start_date.required' => 'The start date field is required.',
        'ecom_course.end_date.required' => 'The end date field is required.',
        'ecom_course.course_format.required' => 'The course format field is required.',
        'ecom_course.course_code.required' => 'The course code field is required.',
        'ecom_course.tags.required' => 'The tags field is required.',
        'photo.required' => 'The image field is required.', 
    ];

    public function resetInput($searchField=false)
    {
        if($searchField)
        {
            $this->searchByName = '';
            $this->selectedRows = collect();
        }
        else
        {
            $this->ecom_course = new ecom_course();
            $this->photo = null;
            // $this->title = '';
        }
    }
    public function updated($value)
    {       
        // dd(request()->input('video_url'));
        // dd(empty(request()->input('video_url')));

        if($value == 'ecom_course.category_id')
        {
            $this->Collapse = "uncollapse";
            $this->subcategories = ecom_category::where('parent_id', $this->ecom_course->category_id)->get();
        }
        else if($value == 'ecom_course.department_id')
        {
            $this->Collapse = "uncollapse";
            $this->sub_departments = ecom_department::where('parent_id', $this->ecom_course->department_id)->get();
        }
        elseif (in_array($value, ['photo', 'video', 'document', 'video_url', 'document_url'])) 
        {
            $this->Collapse = "uncollapse";

            switch ($value) 
            {
                case 'photo':
                    $this->validate(['photo' => 'image|mimes:jpg,jpeg,png,svg,gif|max:100']);
                    break;
                case 'video':
                    $this->validate([
                        'video' => 'mimetypes:video/mp4,video/webm,video/quicktime',
                        // 'video' => [new EitherOrRule($this), 'mimetypes:video/mp4,video/webm,video/quicktime', 'max:50000']
                    ]);            
                    break;
                case 'video_url':
                    $this->validate(['video_url' =>'url']);
                    // $this->validate(['video_url' => [new EitherOrRule($this), 'url']]);
                    break;
                case 'document':
                    $this->validate(['document' => 'mimes:pdf|max:5000']);
                    break;
                case 'document_url':
                    $this->validate(['document_url' => 'url']);
                    break;
            }
            
            // if($value == 'photo')
            // {
            //     $this->validate([
            //         'photo' => 'image|mimes:jpg,jpeg,png,svg,gif|max:100'
            //     ]);            
            // }
            // if($value == 'video')
            // {
            //     $this->validate([
            //         // 'video' => 'mimetypes:video/mp4,video/quicktime|max:50000'
            //         'video' => [new EitherOrRule('video_url'), 'mimetypes:video/mp4,video/webm,video/quicktime', 'max:50000']]);            
            // }
            // if($value == 'video_url')
            // {
            //     $this->validate([
            //         'video_url' => [new EitherOrRule('video'), 'url'],
            //     ]);
            // }
            // if($value == 'document')
            // {
            //     $this->validate([
            //         'document' => 'mimes:pdf|max:5000'
            //     ]);            
            // }
            // if($value == 'document_url')
            // {
            //     $this->validate([
            //         'document_url' => 'url'
            //     ]);                        
            // }
        }
        else
        {
            if($value == 'searchByName' || strpos($value, 'selectedRows') !== false)
            {
                $this->Collapse = "collapse";
            }
            else
            {
                $this->Collapse = "uncollapse";
                $this->validateOnly($value);
            }

            // $this->Collapse = ($value == 'title') ? 'collapse' : 'uncollapse';
            // $this->validateOnly($value);
        }   
        // if($value == 'ecom_course.category_id')
        // {
        //     $this->subcategories = ecom_category::where('parent_id', $this->ecom_course->category_id)->get();
        // }
        // if($value == 'photo')
        // {
        //     $this->Collapse = "uncollapse";
        //     $this->validate([
        //         'photo' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:100'
        //     ]);            
        // }
        // else
        // {
        //     if($value == 'title')
        //     {
        //         $this->Collapse = "collapse";
        //     }
        //     else
        //     {
        //         $this->Collapse = "uncollapse";
        //     }

        //     $this->validateOnly($value);
        // }
    }
    public function deleteCourseRecord(ecom_course $ecom_course)
    {
        if(isset($ecom_course->course_image))
        {
            deleteFile($ecom_course->course_image);
        }        
        if(isset($ecom_course->local_video))
        {
            deleteFile($ecom_course->course_image);
        }
        if(isset($ecom_course->local_document))
        {
            deleteFile($ecom_course->course_image);
        }
        
        if(isset($ecom_course->alignment))
        {

            $ecom_course->alignment->delete();
            // ecom_course_assign::where('course_id', $ecom_course->id)->delete();
            // deleteFile($ecom_course->alignment);
        }

        $ecom_course->delete();    

        $this->dispatchBrowserEvent('deleted_scene', ['name' => $ecom_course->name]);
    }
    public function updateStatus(ecom_course $ecom_course, $toggle)
    {
        $ecom_course->is_active = $toggle == 0 ? 0 : 1;
        $ecom_course->save();
        $this->dispatchBrowserEvent('status_updated', ['name' => $ecom_course->name]);
    }
    public function setMountData($ecom_course)
    {
    
        $this->ecom_course = $ecom_course ?? new ecom_course();  

        //    $this->pageTitle = 'Add New Course';
        //    $this->MainTitle = 'Course';
        $this->pageTitle = 'Course Manage';
        $this->MainTitle = 'CourseManage';
        $this->paginateLimit = 10;
        $this->categories = GetAllCategories();
        // dd($this->categories->pluck('name'));

        $this->departments = GetAllDepartments();
        $this->instructors = GetAllInstructors();
        
        if($ecom_course->count() > 0)
        {
            $this->subcategories = ecom_category::where('parent_id', $this->ecom_course->category_id)->get();
            // $this->video = $this->ecom_course->local_video;
            // $this->document = $this->ecom_course->local_document;
            $this->video_url = $this->ecom_course->url_video;
            $this->document_url = $this->ecom_course->url_document;
        }
        else
        {
            $this->subcategories = collect();
            $this->sub_departments = collect();
        }
        // $this->subcategories = $ecom_course->count() > 0 ? ecom_category::where('parent_id', $this->ecom_course->category_id)->get() : collect();
        
        return true;
    }
    protected function RenderData()
    {

        // $query->where('first_name', 'like', "%{$request->term}%")
        // ->orWhere('last_name', 'like', "%{$request->term}%");

        $isInstructor = auth()->user()->roles->where('title', 'instructor')->count();   //if logged in user is admin
        $isSuperAdmin = auth()->user()->roles->where('title', 'Super Admin')->count();  //if logged in user is instructor
        $isAdmin = auth()->user()->roles->where('title', 'Admin')->count();             //if logged in user is instructor
        
        if($isSuperAdmin || $isAdmin || $isInstructor)
        {
            $courses = ecom_course::when($this->searchByName !== '', function ($query) {
                                        $query->where('name', 'like', '%' . $this->searchByName . '%');
                                    }) 
                                    //     $query->where('title', '!=', 'Super Admin')->where('title', '!=', 'instructor'); // Exclude users with Super Admin role
                                    // })
                                    ->orderBy('id', 'DESC')
                                    ->when(($isSuperAdmin || $isAdmin || $isInstructor), function ($query)  {
                                        // $query->where('instructor_id', auth()->user()->id);
                                    })
                                    // ->whereHas('roles', function ($query) {
                                    // ->where('is_active', 1)
                                    // ->paginate(8);
                                    ->get();
        }
        else
        {
            $courses = collect(); 
        }
        
        $data['coursesListing'] = $this->readyToLoad ? $this->PaginateData($courses) : [];

        // $this->total_courses = ecom_course::where('is_active', 1)->count();
        // $total_courses = $courses->count();
        // dd($courses->count());
        // ->whereHas('roles', function ($query) {
        //     $query->where('title', '!=', 'Super Admin')->where('title', '!=', 'instructor'); // Exclude users with Super Admin role
        // })

        // if($this->readyToLoad)
        // {

        //     $data['coursesListing'] = $courses;

        //     // dd($data['coursesListing']);
        // }
        // else
        // {
        //     $data['coursesListing'] = [];
        // }

        // $data['coursesListing'] = $this->readyToLoad ? $courses : [];
        return $data;
    }
}