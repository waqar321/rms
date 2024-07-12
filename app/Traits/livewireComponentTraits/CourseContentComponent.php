<?php


namespace App\Traits\livewireComponentTraits;

use App\Models\Admin\ecom_course;
use App\Models\Admin\ecom_category;
use App\Models\Admin\ecom_department;
use App\Models\Admin\ecom_admin_user;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
use App\Rules\EitherOrRule;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

trait CourseContentComponent
{
    use LivewireComponentsCommon;

    public $title;
    public $video;
    public $video_url;
    public $document;
    public $document_url;
    public ecom_course $ecom_course;  
    public $categories;
    public $subcategories;
    // public Collection $selectedRows; 

    public $videoSet="empty";
    public $URLvideoSet="empty";

    public function __construct()
    {       
        $this->Tablename = 'ecom_course';        
        $this->selectedRows = collect();
        $this->update = request()->has('id') == true;
        $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
    }

    protected $rules = [
        // 'ecom_course.name' => 'required|min:2',
        // 'ecom_course.description' => 'required|min:20',
        // 'ecom_course.category_id' => 'required',
        // 'ecom_course.sub_category_id' => 'required',
        // 'ecom_course.department_id' => 'required',
        // 'ecom_course.sub_department_id' => 'required',
        // 'ecom_course.instructor_id' => 'required',
        // 'ecom_course.duration' => 'required',
        // 'ecom_course.level' => 'required',
        // 'ecom_course.prerequisites' => 'required',
        // 'ecom_course.language' => 'required',
        // 'ecom_course.course_material' => 'required',
        // 'ecom_course.enrollment_limit' => 'required',
        // 'ecom_course.start_date' => 'required',
        // 'ecom_course.end_date' => 'required',
        // 'ecom_course.course_format' => 'required',
        // 'ecom_course.course_code' => 'required|unique:ecom_course',
        // 'ecom_course.tags' => 'required',
        // // 'ecom_course.storage_type' => 'required',
        // 'video' => '',
        // 'video_url' => '',
        // 'document' => '',
        // 'document_url' => '',
        // 'photo' => '',
    ];

    protected $messages = [
        // 'ecom_course.name.required' => 'The name field is required.',
        // 'ecom_course.name.min' => 'The name must be at least :min characters.',
        // 'ecom_course.description.required' => 'The description field is required.',
        // 'ecom_course.category_id.required' => 'The category field is required.',
        // 'ecom_course.sub_category_id.required' => 'The sub category field is required.',
        // 'ecom_course.instructor_id.required' => 'The instructor field is required.',
        // 'ecom_course.duration.required' => 'The duration field is required.',
        // 'ecom_course.level.required' => 'The level field is required.',
        // 'ecom_course.prerequisites.required' => 'The prerequisites field is required.',
        // 'ecom_course.language.required' => 'The language field is required.',
        // 'ecom_course.course_material.required' => 'The course material field is required.',
        // 'ecom_course.enrollment_limit.required' => 'The enrollment limit field is required.',
        // 'ecom_course.start_date.required' => 'The start date field is required.',
        // 'ecom_course.end_date.required' => 'The end date field is required.',
        // 'ecom_course.course_format.required' => 'The course format field is required.',
        // 'ecom_course.course_code.required' => 'The course code field is required.',
        // 'ecom_course.tags.required' => 'The tags field is required.',
        'photo.required' => 'The image field is required.', 
    ];
    public function resetInput($searchField=false)
    {
        if($searchField)
        {
            $this->title = '';
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
            if($value == 'title' || strpos($value, 'selectedRows') !== false)
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
        
       $this->pageTitle = 'Course Listing';
       $this->MainTitle = 'CourseListing';

        // $this->categories = GetAllCategories();
        // $this->departments = GetAllDepartments();
        // $this->instructors = GetAllInstructors();
        
        if($ecom_course->count() > 0)
        {
            $this->subcategories = ecom_category::where('parent_id', $this->ecom_course->category_id)->get();
            // $this->video = $this->ecom_course->local_video;
            // $this->document = $this->ecom_course->local_document;
            $this->video_url = $this->ecom_course->url_video;
            $this->document_url = $this->ecom_course->url_document;
        }
        // else
        // {
        //     $this->subcategories = collect();
        //     $this->sub_departments = collect();
        // }
        // $this->subcategories = $ecom_course->count() > 0 ? ecom_category::where('parent_id', $this->ecom_course->category_id)->get() : collect();

        
        return true;
    }
    protected function RenderData()
    {
        $courses = ecom_course::when($this->title !== '', function ($query) {
                                    $query->where('name', 'like', '%' . $this->title . '%');
                                }) 
                                ->orderBy('id', 'DESC')
                                ->where('is_active', 1)
                                // ->paginate(4);
                                ->get();
        
        $courses = $courses->filter(function ($course)
        {
            if($course->alignment)
            {
                if (is_null($course->alignment->employee_id) 
                    && is_null($course->alignment->department_id)
                    && is_null($course->alignment->sub_department_id)
                    && is_null($course->alignment->zone_code)
                    && is_null($course->alignment->city_id)
                    && is_null($course->alignment->branch_id)
                    && is_null($course->alignment->role_id)
                    && is_null($course->alignment->shift_time_id)
                    && is_null($course->alignment->upload_csv)
                    && is_null($course->alignment->upload_csv_json_data)
                ) 
                {
                    return true; 
                }
                else
                {
                    return CheckAlignment($course, 'course');
                }
            }
        });

        if($this->readyToLoad)
        {
        
            $perPage = 15; // Number of items per page
            $page = Paginator::resolveCurrentPage('page'); // Get the current page number
            $offset = ($page * $perPage) - $perPage;

            // Step 2: Paginate the filtered data
            $courses = new LengthAwarePaginator(
                $courses->slice($offset, $perPage)->values(), // Items for the current page
                $courses->count(), // Total items
                $perPage, // Items per page
                $page, // Current page
                ['path' => Paginator::resolveCurrentPath()] // Path for pagination links
            );
        }

        $data['coursesListing'] = $this->readyToLoad ? $courses : [];
        return $data;
    }
}