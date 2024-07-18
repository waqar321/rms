<?php

namespace App\Http\Livewire\Admin\Lecture;

use Livewire\Component;
use App\Models\Admin\ecom_lecture;
use App\Models\Admin\ecom_admin_user;
// use App\Models\Admin\LectureQuestionLevel;
// use App\Models\Admin\LectureAssessmentLevel;
// use App\Models\Admin\LectureAssessmentLevelStatus;
use App\Models\Admin\LectureQuestionLevel;
use App\Models\Admin\AssessmentQuestion;
use App\Models\Admin\LectureQuestion;
use App\Models\Admin\LectureAssessmentLevel;
use App\Models\Admin\LectureAssessmentStatus;
use Illuminate\Support\Facades\DB;

use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\LectureComponent;
use Illuminate\Http\Request;

class Index extends Component
{
    use WithPagination, WithFileUploads, LectureComponent;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['deleteLectureManage' => 'deleteLectureRecord', 'updateStatusOftest' => '', 'selectedColumns' => 'export', 'lectureSubmitted' => 'saveLecture'];
    public $assessmentData=[];  

    public function mount(ecom_lecture $ecom_lecture)
    {

        // dd(auth()->user()->roles[0]->title);

        if($this->update)
        {
            if(!empty($this->getLectureDetails($ecom_lecture->id)->toArray()))
            {
                $this->assessmentData = $this->getLectureDetails($ecom_lecture->id)->toArray();
                // dd($this->assessmentData);
            }
        }
        // dd(count($this->assessmentData) > 0);
        // dd($this->assessmentData);
        // $assessmentLevels = [];

        // for ($i = 1; $i <= 4; $i++) 
        // {
        //     $childArray = [];
        //     for ($j = 1; $j <= 5; $j++) {
                
        //         if($j==5)
        //         {
        //             $childArray[$j] = ($i); 
        //         }
        //         else
        //         {
        //             $childArray[$j] = [
        //                 "question" => "Question1",
        //                 "Answer1" => "Answer1 value",
        //                 "Answer2" => "Answer2 value",
        //                 "Answer3" => "Answer3 value",
        //                 "Answer4" => "Answer4 value"
        //             ];
        //         }
        //     }
        //     $assessmentLevels[$i] = $childArray;
        // }

        // $this->insertAssessmentDetails($assessmentLevels, 2);

        // lecture_assessment_levels
        // assessment_questions
        // lecture_question_levels
        // lecture_questions

        // foreach($assessmentLevels as $assessmentLevel_key => $assessmentLevel)
        // {   

        //     // dd($assessmentLevels);
        //     // dd(end($assessmentLevel));

        //     foreach($assessmentLevel as $questionlevel_key => $questionlevel)
        //     {
        //         // dd($questionlevel);
        //         // dd($questionlevel['question']);
        //         // dd($questionlevel);
        //         // dd($questionlevel['question']);
                
        //         if(!empty($questionlevel))
        //         {                    
        //             if($questionlevel_key!=5)
        //             {
        //                 for ($i = 1; $i <= 4; $i++) 
        //                 {
        //                     // echo $key."<br>";
        //                     // echo $questionlevel['question']."<br>";
        //                     // echo $questionlevel[('Answer' . $i)]."<br>";

        //                     $LectureQuestionLevel = new LectureQuestionLevel();
        //                     $LectureQuestionLevel->question_level = $questionlevel_key;
        //                     $LectureQuestionLevel->question = $questionlevel['question'];
        //                     $LectureQuestionLevel->answer = $questionlevel[('Answer' . $i)];
        //                     $LectureQuestionLevel->save();
        //                 }
        //                 $LectureAssessmentLevel = new LectureAssessmentLevel();
        //                 $LectureAssessmentLevel->lecture_id = 2;
        //                 $LectureAssessmentLevel->assessment_level = $assessmentLevel_key;
        //                 $LectureAssessmentLevel->assessment_time = end($assessmentLevel);
        //                 $LectureAssessmentLevel->question_level = $LectureQuestionLevel->question_level;
        //                 $LectureAssessmentLevel->save();
        //             }                 
        //             // dd($LectureAssessmentLevel);
        //             // dd($LectureQuestionLevel->question_level);
        //         }
        //         // dd($LectureQuestionLevel->question_level);

        //         // $LectureAssessmentLevel = new LectureAssessmentLevel();
        //         // $LectureAssessmentLevel->lecture_id = 2;
        //         // $LectureAssessmentLevel->assessment_level = $assessmentLevel_key;
        //         // $LectureAssessmentLevel->question_level = $LectureQuestionLevel->id;
        //         // // $LectureAssessmentLevel->question_level = $LectureQuestionLevel->question_level;
        //         // $LectureAssessmentLevel->save();
                
        //         // dd($LectureAssessmentLevel);

                
        //     }
        //     // dd('first levels done');
        //     // $LectureAssessmentLevel = LectureAssessmentLevel::all();
        //     // dd($LectureAssessmentLevel);
        // } 

        // dd($this->getLectureDetails(2)->toArray());

        // dd('done testing');

        $this->setMountData($ecom_lecture);
    }
    public function render()
    {
        $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        return view('livewire.admin.lecture.index', $this->RenderData());
    }
    public function saveLecture($FormData=null)
    {  

        if(!$this->update)
        {
            $this->validate();            
        }
        
        $this->updateFiles();
        dd('done testing');
        // dd($this->ecom_lecture);

        // if(auth()->user()->role->id == 31)
        if(auth()->user()->isInstructor())
        {
            $this->ecom_lecture->instructor_id = auth()->user()->id; 
            // $this->ecom_lecture->instructor_id = auth()->user()->role->id == 31 ? auth()->user()->id : $this->ecom_lecture->instructor_id; 
        }
        
        $this->ecom_lecture->save();

        if (json_decode($FormData) !== null) 
        {
            if($this->update)
            {
                $lectureAssessmentLevels = LectureAssessmentLevel::where('lecture_id', $this->ecom_lecture->id)->get();
                if($lectureAssessmentLevels)
                {
                    DB::transaction(function() use ($lectureAssessmentLevels) 
                    {
                        foreach($lectureAssessmentLevels as $assessmentLevel)
                        {
                            foreach($assessmentLevel->questions as $question)
                            {
                                $question->questionLevel->delete();
                            }
                            $assessmentLevel->delete();
                        }
                    });              
                }

            }
            $this->insertAssessmentDetails(json_decode($FormData, true), $this->ecom_lecture->id);
        }

        $name = $this->ecom_lecture->title;
        $this->ecom_lecture = new ecom_lecture(); 

        session()->flash('message', $this->MainTitle.' '. $this->update ? 'Updated' : 'Added' . ' Successfully');
        $this->resetInput();
        $this->Collapse = "collapse";
        $this->dispatchBrowserEvent('created_module', ['name'=> $name]);

        if(request()->has('id'))
        {
            return redirect()->to('content-management/LectureUpload');
        }
    } 
    public function updateFiles()
    {


        // dd($this->video);
        if ($this->photo) 
        {
            $this->validate([
                'photo' => 'image|mimes: jpg,jpeg,png,svg,gif|max:100'
            ]);  
            $this->ecom_lecture->course_image = storeFile('lecture/photos', $this->photo);    
        }
        if ($this->video) 
        {   
            $this->validate([
                'video' => 'mimetypes:video/mp4,video/webm,video/quicktime'
            ]); 

            // dd($this->video);
            // dd($this->ecom_lecture);

            $this->ecom_lecture->local_video = storeFile('lecture/videos', $this->video);
        }
        if ($this->video_url) 
        {
            $this->validate([
                'video_url' => 'url'
            ]);  
            $this->ecom_lecture->url_video = $this->video_url;            
        }
        if ($this->document) 
        {
            $this->validate([
                'document' => 'mimes:pdf|max:5000'
            ]);  
            $this->ecom_lecture->local_document = storeFile('lecture/documents', $this->document);
        }
        if ($this->document_url) 
        {
            $this->validate([
                'document_url' => 'url'
            ]); 
            $this->ecom_lecture->url_document = $this->document_url;
        }    
    }
    public function TestingSubmission($FormData)
    {   
        $this->dispatchBrowserEvent('testingFormWorking', ['name'=> 'testig message']); 
    }
    public function insertAssessmentDetails($assessmentDetails, $lecture_id)
    {
        DB::transaction(function() use ($assessmentDetails, $lecture_id) 
        {
            foreach ($assessmentDetails as $key => $assessment) 
            {                    
                $lectureAssessment = LectureAssessmentLevel::create([
                    'lecture_id' => $lecture_id, 
                    'assessment_level' => $key,
                    'assessment_time' => end($assessment),
                ]);
      
                foreach ($assessment as $key => $questionData) 
                {
                    if($key !== 'occurrence_duration')
                    {
                        $questionLevel = LectureQuestionLevel::firstOrCreate(
                            ['level_name' => 'Level ' . $key]
                        );
                        $lectureQuestion = LectureQuestion::create([
                            'question_level_id' => $questionLevel->id,
                            'question' => $questionData['question'],
                            'answer' => json_encode([
                                'Answer1' => $questionData['Answer1'],
                                'Answer2' => $questionData['Answer2'],
                                'Answer3' => $questionData['Answer3'],
                                'Answer4' => $questionData['Answer4'],
                                'correctAnswer' => $questionData['correctAnswer'],
                            ]),
                        ]);
                        $lectureAssessment->questions()->attach($lectureQuestion->id);
                    }
                }
            }
        });
    }
    // public function getLectureDetails($lectureId)
    // {
    //     // Retrieve lecture assessment levels with their times and associated questions with answers
    //     $lectureDetails = LectureAssessmentLevel::where('lecture_id', $lectureId)
    //                                             ->with('questions.questionLevel', 'questions')
    //                                             ->get();

    //     return $lectureDetails;
    // }

}
