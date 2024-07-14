<?php

namespace App\Http\Livewire\Admin\CourseAssign;

use Livewire\Component;
use App\Models\Admin\ecom_course_assign;
use App\Models\Admin\ecom_admin_user;
use App\Models\Admin\ecom_department;
use App\Models\Admin\zone;
use App\Models\Admin\central_ops_city;
use App\Models\Admin\ecom_employee_time_slots;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\livewireComponentTraits\CourseAssignComponent;

class Index extends Component
{
    use WithPagination, WithFileUploads, CourseAssignComponent;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
                                'deleteCourseAlignManage' => 'deleteCourseAlign', 
                                'updateStatusOftest' => '', 
                                'selectedColumns' => 'export',
                                'LoadDataNow' => 'loadDropDownData',
                                'LoadEmployeeNowCount' => 'loadedEmployeeDataCount',
                                // 'HRCourse' => 'HandleHRCourse',
                                // 'HRRoles' => 'HandleHRRoles',
                                // 'HRInstructors' => 'HandleHRInstructors',
                                // 'HREmployee' => 'HandleHREmployee',
                                // 'HRDepartment' => 'HandleHRDepartment',
                                // 'HRSubDepartment' => 'HandleHRSubDepartment',
                                // 'HRZones' => 'HandleHRZones',
                                // 'HRCities' => 'HandleHRCities',
                                // 'HRBranches' => 'HandleHRBranches',
                                // 'HRTimeSlots' => 'HandleHRTimeSlots',
                                'UpdateValue' => 'HandleUpdateValue',
                                'RemoveValue' => 'HandleRemoveValue',
                                'saveCourseAlignEvent' => 'saveCourseAlign',
                                'CheckCourseSelectedEvent' => 'CheckCourseSelected'
                            ];

    public function mount(ecom_course_assign $ecom_course_assign, Request $request)
    {   

        // $this->zones = GetAllZones();

        // "zone_code" => "001"
        // "zone_name" => "Karachi – Zone 1"
        // "zone_short_name" => "KHI-ZN1"
        // dd($this->zones);

        // $this->instructors = GetAllInstructors();
        
        // =======================get employee data ==========================

       

        // =======================get employee data ==========================

        $this->setMountData($ecom_course_assign);
    }
    public function render()
    {   
        $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        return view('livewire.admin.course-assign.index', $this->RenderData());
    }
    public function CheckCourseSelected()
    {
        
        if($this->ecom_course_assign->course_id == null)
        {
            $this->dispatchBrowserEvent('coursevalue', ['value' => false, 'messsage' => 'Course Must be Selected For Alignment!!']);
        }
        else if($this->AtleastOneResourceToBeSelected())
        {
            $this->dispatchBrowserEvent('coursevalue', ['value' => false, 'messsage' => 'Select Atleast 1 Resource To Align Course..!!']);
        }
        else
        {
            $this->dispatchBrowserEvent('coursevalue', ['value' => true]);
        }

        $this->Collapse = "uncollapse";
    }
    public function saveCourseAlign()
    {
        $this->ecom_course_assign = ReplaceStringAttributeValuesWithNull($this->ecom_course_assign);
        
        // dd($this->ecom_course_assign);
        // $this->validate();
        // $this->resetErrorBag();
        // $this->validate([
        //     'ecom_course_assign.course_id' => 'required'
        // ]);  
        // if($this->AtleastOneResourceToBeSelected())
        // {
        //     $this->addError('saveValidation', 'Select Atleast 1 Resource To Align Course..!!');
        //     return false;
        // }

        if($this->update && !$this->csv_file)
        {
            //this is update submit and file is not uploaded, so get the last CSV and remove all those specific IDS from attributes those exists in CSV,');
            $this->ecom_course_assign->upload_csv_json_data = json_encode($this->RemoveAlreadyIDsInCSV());
        }
        elseif($this->csv_file)
        {
            $this->ecom_course_assign->upload_csv_json_data = json_encode($this->RemoveAlreadyIDsInCSV());
            $this->ecom_course_assign->upload_csv = $this->csv_file->store('CSVs', 'public');   
        }

        $this->ecom_course_assign->user_uploader_id = auth()->user()->id;
        $this->ecom_course_assign->save();
        $this->ecom_course_assign = new ecom_course_assign(); 

        session()->flash('message', $this->MainTitle.' '. $this->update ? 'Updated' : 'Added' . ' Successfully');
        $this->resetInput();
        $this->dispatchBrowserEvent('created_module', ['name' => "Course Assign"]);
        $this->Collapse = "collapse";

        if($this->update)
        {
            return redirect()->to('content-management/assign_course');
        }
    }
}
