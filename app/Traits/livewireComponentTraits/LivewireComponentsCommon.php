<?php


namespace App\Traits\livewireComponentTraits;

use App\Exports\departmentsExport;
use App\Exports\Exports;
use App\Models\Admin\LectureAssessmentLevel;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

use App\Traits\livewireComponentTraits\CourseAssignCSVComponent;
use App\Traits\livewireComponentTraits\GlobalVariablesForComponents;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

trait LivewireComponentsCommon
{
    use CourseAssignCSVComponent, GlobalVariablesForComponents;
    
    public function deleteSelected($modelName)
    {
        if($this->getSelectedRowIDs()->isNotEmpty())
        {
            $modelClass = "App\\Models\\Admin\\" . $modelName;
            app($modelClass)->whereIn('id', $this->getSelectedRowIDs()->toArray())->delete();
            // ecom_admin_user::whereIn('id', $this->getSelectedRowIDs()->toArray())->delete();

            $this->dispatchBrowserEvent('deleted_scene', ['name' => 'Selected Permissions']);
        }
    }
    
    public function hydrate()
    {
        // if($this->ecom_notification)
        // {
        //     // dd($this->ecom_notification->department_id);
        //     $this->sub_departments = GetAllDepartments(true, $this->ecom_notification->department_id);
        //     // dd($this->ecom_notification->department_id, $this->sub_departments);
        // }

        $this->emit('select2');
    }
    private function hasErrors()
    {
        return count($this->getErrorBag()->all()) > 0;
    }
    public function Cleanup()
    {
        CleanCacheAndTempFiles();
        $this->dispatchBrowserEvent('clearedUp');
    }
    public function removeImage()
    {
        if($this->photo)
        {
            $this->photo = null;
        }
        elseif(isset($this->ecom_course->course_image))
        {
            deleteFile($this->ecom_course->course_image);
            $this->ecom_course->update(['course_image'=>null]); 
            $this->dispatchBrowserEvent('file_deleted', [
                                                            'name'=> $this->ecom_course->name,
                                                            'type' => 'photo'
                                                        ]);
        }
        elseif(isset($this->ecom_category->image))
        {
            deleteFile($this->ecom_category->image);
            $this->ecom_category->update(['image'=>null]); 
            $this->dispatchBrowserEvent('file_deleted', [
                                                            'name'=> $this->ecom_category->name,
                                                            'type' => 'photo'
                                                        ]);
        }
    }
    public function removeVideo()
    {
        if($this->video)
        {
            $this->video = null;
        }
    }
    private function getSelectedRowIDs()
    {
        return $this->selectedRows->filter(fn($p) => $p)->keys();
    }
    public function export($columns, $ext)
    {
        // dd($columns, $ext, $this->getSelectedRowIDs());

        $this->Exportdata = array(
            'column' => explode(', ', $columns),
            'table' => str_replace('ecom_', '', $this->Tablename),
            'model' => $this->Tablename,
            'IDs' => $this->getSelectedRowIDs(),
        );
               
        // dd($this->Exportdata);

        abort_if(!in_array($ext, ['csv', 'xlsx', 'pdf']), Response::HTTP_NOT_FOUND);
        // dd($this->Exportdata);
        return Excel::download(new Exports($this->Exportdata), $this->Exportdata['table'].'s.'. $ext);
        // return Excel::download(new Exports($this->Exportdata), str_replace('ecom_', '', $this->Tablename).'s.'. $ext);
    }
    public function TestingExportData()
    {
        $this->Tablename = 'ecom_department';        
        $IDs = Array(
                    0 => 6, 
                    1 => 7
                );

        $awd = DB::table($this->Tablename)->whereIn('id', $IDs)->get();

        var_dump($awd[0]->created_at);

        // echo "<pre>";
        // print_r($awd[0]->created_at);
        // echo "</pre>";
        echo "<br>";
        
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $awd[0]->created_at);
        var_dump($date);
        echo "<br>";
        $formattedDate = $date->format('d-m-Y H:i:s');
        echo $formattedDate;
    }
    public function pageLoaded()
    {
        // dd('coming into livewirecomponentcommon');

        $this->readyToLoad = true;
        // $this->LoadDataAndAppleSelec2();
        $this->dispatchBrowserEvent('loadDropDownData');
    }
    public function loadDropDownData($Mount=false)
    {
        if($Mount)
        {       
            $this->GetDropDownData();     
        }
        else
        {
            $this->dispatchBrowserEvent('loadedDataExcepEmployee');
        }
    }
    public function ErrorLoaded()
    {
        // dd('awdawd');
        // $this->pageLoaded();
        $this->dispatchBrowserEvent('ApplySelect2');
    }

    // public function LoadDataAndAppleSelec2()
    // {
    //     $this->readyToLoad = true;
    //     $this->dispatchBrowserEvent('loadDropDownData');
    // }
    public function getLectureDetails($lectureId)
    {


        // Retrieve lecture assessment levels with their times and associated questions with answers
        $lectureDetails = LectureAssessmentLevel::where('lecture_id', $lectureId)
                                                ->with('questions.questionLevel', 'questions')
                                                ->get();

        // $processedLectureDetails = $lectureDetails->map(function($lectureDetail) {
        //     return [
        //         'id' => $lectureDetail->id,
        //         'lecture_id' => $lectureDetail->lecture_id,
        //         'assessment_level' => $lectureDetail->assessment_level,
        //         'assessment_time' => $lectureDetail->assessment_time,
        //         'questions' => $lectureDetail->questions->map(function($question) {
        //             return [
        //                 'id' => $question->id,
        //                 'question_level_id' => $question->question_level_id,
        //                 'question' => $question->question,
        //                 'answer' => $question->answer,
        //                 'question_level' $question
        //             ];
        //         })
        //     ];
        // });
        
        // dd($processedLectureDetails);

        return $lectureDetails;
    }
    function GetDropDownData()
    {
        $this->instructors = GetAllInstructors();
        $this->departments = GetAllDepartments();
        
        if(isset($this->ecom_notification))
        {
            $this->sub_departments = GetAllDepartments(true, $this->ecom_notification->department_id);
            $this->cities = GetAllCities($this->ecom_notification->zone_code); 
        }
        else if(isset($this->ecom_course_assign))
        {

            $this->sub_departments = GetAllDepartments(true, $this->ecom_course_assign->department_id);
            $this->cities = GetAllCities($this->ecom_course_assign->zone_code);             
        }
        $this->zones = GetAllZones();
        $this->branches = GetAllBranches();
        $this->roles = GetAllRoles();
        $this->schedules = GetAllEmployeeSchedules();
        // if($field == 'department_id')
        // {
        //     $department = ecom_department::where('department_id', $value)->first();
        //     $subDepartments = ecom_department::where('parent_id', $department->id)->pluck('sub_department_id', 'name');
        //     $this->dispatchBrowserEvent('LoadedSubDepartments', ['subDepartment' => $subDepartments, 'subDepartmentCount' => $subDepartments->count()]);
        // }
        
        // if($field == 'zone_code')
        // {                
        //     $cities = central_ops_city::where('zone_code', $value)->pluck('city_id', 'city_name');
        //     $this->dispatchBrowserEvent('LoadedCities', ['cities' => $cities, 'citiesCount' => $cities->count()]);
        // }

    }
    function PaginateData($Records)
    {
        $this->total_records = $Records->count();

        if($this->readyToLoad)
        {        
            $page = Paginator::resolveCurrentPage('page'); // Get the current page number
            $offset = ($page * $this->paginateLimit) - $this->paginateLimit; // Number of items per page
            
            // Step 2: Paginate the filtered data
            $Records = new LengthAwarePaginator(
                $Records->slice($offset, $this->paginateLimit)->values(), // Items for the current page
                $Records->count(), // Total items
                $this->paginateLimit, // Items per page
                $page, // Current page
                ['path' => Paginator::resolveCurrentPath()] // Path for pagination links
            );
        }
        return $Records; 
    }

}
