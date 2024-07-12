<?php


namespace App\Traits\livewireComponentTraits;

use App\Models\Admin\ecom_course;
use App\Models\Admin\ecom_course_assign;
use App\Models\Admin\ecom_category;
use App\Models\Admin\ecom_department;
use App\Models\Admin\ecom_admin_user;
use App\Models\Admin\central_ops_city;
use App\Exports\EmployeeIDsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;

use App\Rules\EitherOrRule;
use League\Csv\Reader;
use Illuminate\Support\Collection;

trait CourseAssignComponent
{

    use LivewireComponentsCommon;


    public $video;
    public $video_url;
    public $document;
    public $document_url;
    public ecom_course_assign $ecom_course_assign;  
    public $availableColumns;
    public $ExpectedCSVHeaders;
    public $csv_file;

    public $UpdateBulkColumns;
    public $DropDownreadyToLoad = false;
    // public Collection $selectedRows;


    public function __construct()
    {       
        $this->Tablename = 'ecom_course_assign';        
        $this->availableColumns = ['ID', 'Course', 'Aligner', 'Instructor', 'Employee', 'Department', 'Sub Department', 'Zone', 'City', 'Branch', 'Role', 'Time Slot', 'Date', 'Status', 'Action'];
        $this->update = request()->has('id') == true;
        $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
        $this->selectedRows = collect();
    }
    protected $rules = [
        'ecom_course_assign.course_id' => 'required',
        'ecom_course_assign.department_id' => '',
        'ecom_course_assign.sub_department_id' => '',
        'ecom_course_assign.instructor_id' => '',
        'ecom_course_assign.employee_id' => '',
        'ecom_course_assign.role_id' => '',
        'ecom_course_assign.zone_code' => '',
        'ecom_course_assign.city_id' => '',
        'ecom_course_assign.shift_time_id' => '',
        'ecom_course_assign.branch_id' => '',
        'csv_file' => '',
    ];

    protected $messages = [
        'ecom_course_assign.department_id' => 'The name field is required.',
        'ecom_course_assign.sub_department_id' => 'The name field is required.',
        'ecom_course_assign.course_id' => 'The Course must be select to align.',
        'ecom_course_assign.employee_id' => 'The Course must be select to align.',
    ];

    public function resetInput($searchReset=false)
    {
        
        if($searchReset)
        {
            $this->searchByName = '';
            $this->selectedRows = collect();
        }
        else
        {
            $this->ecom_course_assign = new ecom_course_assign();
            $this->sub_departments = collect();
            
            $this->cities = collect();
            $this->csv_file = null;
        }
    }
    public function updated($value)
    {
        if($value == 'ecom_course_assign.department_id')
        {
            $this->Collapse = "uncollapse";
            $this->sub_departments = ecom_department::where('parent_id', $this->ecom_course_assign->department_id)->get();
        }
        elseif($value == 'ecom_course_assign.zone_name')
        {
            $this->Collapse = "uncollapse";
            $this->cities = central_ops_city::where('zone', $this->ecom_course_assign->zone_name)->pluck('city_id', 'city_name');
        }
        elseif($value == 'csv_file')
        {
            $this->Collapse = "uncollapse";
            $this->ValidateOrGetCSVData();
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
        }   
    }
    public function setMountData($ecom_course_assign)
    { 
       $this->ecom_course_assign = $ecom_course_assign ?? new ecom_course_assign();  
       $this->ExpectedCSVHeaders = $this->GetExpectedCSVHeaderData();

        //    $this->pageTitle = 'Align Course';
        //    $this->MainTitle = 'CourseAlign';
       $this->pageTitle = 'CourseAlign Manage';
       $this->MainTitle = 'CourseAlignManage';
       $this->searchByName = '';
       $this->paginateLimit = 3;

        //    $this->sub_departments = collect();
        //    $this->cities = collect();
       
       $this->loadDropDownData(true);
        
       // ----------------- code for if already assigned course not to show --------------------

        $ecom_course_ids = ecom_course::pluck('id')->toArray();
        $ecom_course_assign_ids = ecom_course_assign::pluck('course_id')->toArray();

        if(empty($ecom_course_assign_ids))
        {
            $this->courses = ecom_course::all();
        }
        else
        {
            $not_aligned_courses_ids = array_diff($ecom_course_ids, $ecom_course_assign_ids);
            
            $this->courses = ecom_course::whereIn('id', $not_aligned_courses_ids)->get();
        }

        // $this->courses = ecom_course::all();

    }
    protected function RenderData()
    {        
        
        $assigned_courses = ecom_course_assign::when($this->searchByName !== '', function ($query) 
                                                {
                                                    $course = ecom_course::where('name', 'like', '%'.$this->searchByName.'%')->first();

                                                    if($course) 
                                                    {
                                                        $query->where('course_id', $course->id);
                                                    }                                            
                                                })
                                                ->orderBy('id', 'DESC')
                                                // ->get();
                                                ->paginate($this->paginateLimit);
                                        
         
        // dd($assigned_courses);

        $data['course_assigned'] = $this->readyToLoad ? $assigned_courses : [];
        return $data;  

    }

    public function exportTemplate($sample=false)
    {
        if($sample)
        {
            $this->Collapse = "uncollapse";
            return Excel::download(new EmployeeIDsExport(array_keys($this->GetExpectedCSVHeaderData())), 'EmployeeIDs.csv');            
        }
        else
        {
            $this->Collapse = "uncollapse";
        }
    }
    public function deleteCourseAlign(ecom_course_assign $ecom_course_assign)
    {
        if(isset($ecom_course_assign->image))
        {
            if (file_exists(public_path('storage/CSVs/') . $ecom_course_assign->upload_csv)) 
            {
                unlink(public_path('storage/CSVs/') . $ecom_course_assign->upload_csv); 
            }
            // Storage::delete('CSVs/'.$ecom_course_assign->upload_csv);
        }
        $ecom_course_assign->delete();  
        $this->dispatchBrowserEvent('deleted_scene', ['name' => 'Course Alignment ']);
    }
    public function updateStatus(ecom_course_assign $ecom_course_assign, $toggle)
    {
        $ecom_course_assign->is_active = $toggle == 0 ? 0 : 1;
        $ecom_course_assign->save();
        $this->dispatchBrowserEvent('status_updated', ['name' => 'Course Alignment ']);
    }
}