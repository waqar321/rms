<?php


namespace App\Traits\livewireComponentTraits;

use App\Models\Admin\ecom_lecture;
use App\Models\Admin\ecom_category;
use App\Models\Admin\ecom_department;
use App\Models\Admin\ecom_admin_user;
use App\Models\Admin\LectureAssessmentLevel;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
use App\Rules\EitherOrRule;
use Illuminate\Support\Facades\DB;

trait LectureComponent
{
    use LivewireComponentsCommon;


    public $title;
    public $video;
    public $video_url;
    public $document;
    public $document_url;
    public ecom_lecture $ecom_lecture;  
    public $courses;
    // public Collection $selectedRows; 

    public $videoSet="empty";
    public $URLvideoSet="empty";

    public function __construct()
    {       
        $this->Tablename = 'ecom_lecture';        
        $this->selectedRows = collect();
        $this->update = request()->has('id') == true;
        $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
    }

    protected $rules = [
        'ecom_lecture.title' => 'required|min:2',
        'ecom_lecture.description' => 'required|min:20',
        'ecom_lecture.instructor_id' => 'required',
        'ecom_lecture.course_id' => 'required',
        'ecom_lecture.duration' => 'required',
        'ecom_lecture.tags' => 'required',
        'ecom_lecture.passing_ratio' => '',
        // 'ecom_lecture.Attachments' => 'required',
        // 'ecom_lecture.tags' => 'required',
        // 'video' => '',
        // 'video_url' => '',
        // 'document' => '',
        // 'document_url' => '',
        // 'photo' => '',
        // 'local_video',
        // 'url_video',
        // 'local_document',
        // 'url_document',
            // 'Attachments',
    ];

    protected $messages = [
        'ecom_lecture.title.required' => 'The Lecture Title field is required.',
        'ecom_lecture.title.min' => 'The Lecture Title must be at least :min characters.',
        'ecom_lecture.description.required' => 'The description field is required.',
        'ecom_lecture.course_id' => 'Please Select Course To Add Lecture.',
        'ecom_lecture.instructor_id.required' => 'The instructor field is required.',
        'ecom_lecture.duration.required' => 'Please Enter duration.',
        'ecom_lecture.tags.required' => 'Please Enter Tags.',
        // 'ecom_lecture.Attachments.required' => 'The Attachments field is required.',
        // 'photo.required' => 'The image field is required.', 
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
            $this->ecom_lecture = new ecom_lecture();
            // $this->photo = null;
            $this->title = '';
            $this->photo = '';
            $this->video = '';
            $this->video_url = '';
            $this->document = '';
            $this->document_url = '';
        }
    }
    public function updated($value)
    {       
        // dd(request()->input('video_url'));
        // dd(empty(request()->input('video_url')));

        if (in_array($value, ['photo', 'video', 'document', 'video_url', 'document_url'])) 
        {
            // dd('video uploading');

            $this->Collapse = "uncollapse";

            switch ($value) 
            {
                case 'photo':
                    $this->validate(['photo' => 'image|mimes:jpg,jpeg,png,svg,gif|max:100']);
                    break;
                case 'video':
                    $this->validate([
                        'video' => 'mimetypes:video/mp4,video/webm,video/quicktime|max:500000',
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
        // if($value == 'ecom_lecture.category_id')
        // {
        //     $this->subcategories = ecom_category::where('parent_id', $this->ecom_lecture->category_id)->get();
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
    public function deleteLectureRecord(ecom_lecture $ecom_lecture)
    {
        if(isset($ecom_lecture->course_image))
        {
            deleteFile($ecom_lecture->course_image);
        }        
        if(isset($ecom_lecture->local_video))
        {
            deleteFile($ecom_lecture->local_video);
        }
        if(isset($ecom_lecture->local_document))
        {

            deleteFile($ecom_lecture->local_document);
        }
        $ecom_lecture->delete();    

        $this->dispatchBrowserEvent('deleted_scene', ['name' => $ecom_lecture->name]);
    }
    public function updateStatus(ecom_lecture $ecom_lecture, $toggle)
    {
        $ecom_lecture->is_active = $toggle == 0 ? 0 : 1;
        $ecom_lecture->save();
        $this->dispatchBrowserEvent('status_updated', ['name' => $ecom_lecture->title]);
    }
    public function setMountData($ecom_lecture)
    {

        $this->ecom_lecture = $ecom_lecture ?? new ecom_lecture();  

        // $this->pageTitle = 'Add New Lecture';
        // $this->MainTitle = 'Lecture';
        $this->pageTitle = 'Lecture Manage';
        $this->MainTitle = 'LectureManage';

        $this->instructors = GetAllInstructors();
        $this->courses = GetAllCourses();
        
        if($ecom_lecture->count() > 0)
        {
            $this->video_url = $this->ecom_lecture->url_video;
            $this->document_url = $this->ecom_lecture->url_document;
        }
              
        return true;
    }
    protected function RenderData()
    {
        $lectures = ecom_lecture::when($this->title !== '', function ($query) {
                                            $query->where('title', 'like', '%' . $this->title . '%');
                                        }) 
                                        ->orderBy('id', 'DESC')
                                        ->paginate(12);

        $data['lectures'] = $this->readyToLoad ? $lectures : [];
        return $data;
    }

    public function deleteLectureAndRelatedRecords($lectureId)
    {
        dd($lectureId);

        DB::transaction(function () use ($lectureId) {
            $lectureAssessmentLevels = LectureAssessmentLevel::where('lecture_id', $lectureId)->get();

            foreach ($lectureAssessmentLevels as $assessmentLevel) {
                foreach ($assessmentLevel->questions as $question) {
                    foreach ($question->questionLevel as $questionLevel) {
                        $questionLevel->delete();
                    }

                    foreach ($question->lectureQuestions as $lectureQuestion) {
                        $lectureQuestion->delete();
                    }

                    $question->delete();
                }

                $assessmentLevel->delete();
            }
        });
    }


}