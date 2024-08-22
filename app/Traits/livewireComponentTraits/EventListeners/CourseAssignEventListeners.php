<?php


namespace App\Traits\livewireComponentTraits\EventListeners;


use App\Models\Admin\ecom_category;
use App\Models\Admin\ecom_admin_user;
use App\Models\Admin\ecom_department;
use App\Models\Admin\central_ops_city;
use App\Models\Admin\ecom_employee_time_slots;
use App\Models\Admin\zone;
use App\Models\testingExport\Product;
use App\Traits\livewireComponentTraits\CategoryComponent;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Exports\Exports;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;


trait CourseAssignEventListeners
{
    //-------------------------- events --------------------------

    // public function HandleRemoveValue($table, $field, $value)
    // {
    //     dd('updating value');
    // }

    public function HandleUpdateValue($table, $field, $value)
    {   
       
        if($value != null)
        {
            if($this->MainTitle == 'NotificationManage')
            {
                $this->ecom_notification->{$field} = $value;
            }
            else if($this->MainTitle == 'CourseAlignManage')
            {
                // dd($this->ecom_course_assign->{$field});
                
                $this->ecom_course_assign->{$field} = $value;               
            }

            if($field == 'department_id')
            {
                if(isset($this->ecom_notification))
                {
                    $subDepartments = GetAllDepartments(true, $this->ecom_notification->department_id);
                }
                else if(isset($this->ecom_course_assign))
                {
                    $subDepartments = GetAllDepartments(true, $this->ecom_course_assign->department_id);
                }
                // $department = ecom_department::where('department_id', $value)->first();
                // $subDepartments = ecom_department::where('parent_id', $department->id)->pluck('sub_department_id', 'name');
                $this->dispatchBrowserEvent('LoadedSubDepartments', ['subDepartment' => $subDepartments, 'subDepartmentCount' => $subDepartments->count()]);
            }
            if($field == 'zone_code')
            {                
                if(isset($this->ecom_notification))
                {
                    $cities = GetAllCities($this->ecom_notification->zone_code); 
                }
                else if(isset($this->ecom_course_assign))
                {
                    $cities = GetAllCities($this->ecom_course_assign->zone_code); 
                }
                    
                // $cities = central_ops_city::where('zone_code', $value)->pluck('city_id', 'city_name');
                $this->dispatchBrowserEvent('LoadedCities', ['cities' => $cities, 'citiesCount' => $cities->count()]);
            }
            
        }
        else
        {
            if($this->MainTitle == 'NotificationManage')
            {
                $this->ecom_notification->{$field} = $value;
            }
            else if($this->MainTitle == 'CourseAlignManage')
            {                
                $this->ecom_course_assign->{$field} = $value;               
            }

            if($field == 'department_id')
            {
                $this->ecom_course_assign->sub_department_id = $value;
            }
            if($field == 'zone_code')
            {                                
                $this->ecom_course_assign->city_id = $value;
            }

        }
        $this->Collapse = true;
    }   
    public function loadedEmployeeDataCount()
    {

        $data = [
            'total_employees' => GetAllEmployeesCount(),
            'total_Instructors' => GetAllInstructorsCount(),
            'total_Department' => GetAllDepartmentCount(),
            'total_Zones' => GetAllZonesCount(),
            'total_Branches' => GetAllBranchesCount(),
            'total_Roles' => GetAllRolesCount(),
            'total_schedules' => GetAllSchedulesCount(),
            'total_cities' => GetAllCitiesCount(),
            'total_course' => GetAllCoursesCount(),
        ];

        $this->total_employees = $data['total_employees'];
        $this->dispatchBrowserEvent('loadedEmployeeDataCount', $data); 
        // $this->dispatchBrowserEvent('loadedEmployeeData'); 
    }

    // public function HandleHRCourse($HRCourse_id)
    // {
    //     if($HRCourse_id != null)
    //     {
    //         $this->ecom_course_assign->course_id = $HRCourse_id;
    //     }
        
    //     $this->Collapse = true;
    // }
    // public function HandleHRRoles($HRRole_id)
    // {

    //     if($HRRole_id != null)
    //     {
    //         if($this->MainTitle == 'SendNotification')
    //         {
    //             $this->ecom_notification->role_id = $HRRole_id;
    //         }
    //         else if($this->MainTitle == 'CourseAlign')
    //         {
    //             $this->ecom_course_assign->role_id = $HRRole_id;
    //         }
    //     }
    //     $this->Collapse = true;
    // }
    // public function HandleHRInstructors($HRInstructor_id)
    // {
    //     if($HRInstructor_id != null)
    //     {
    //         if($this->MainTitle == 'SendNotification')
    //         {
    //             $this->ecom_notification->instructor_id = $HRInstructor_id;
    //         }
    //         else if($this->MainTitle == 'CourseAlign')
    //         {
    //             $this->ecom_course_assign->instructor_id = $HRInstructor_id;
    //         }

    //     }

    //     $this->Collapse = true;
    // }
    // public function HandleHREmployee($employee_new_id)
    // {
    //     if($employee_new_id != null)
    //     {
    //         if($this->MainTitle == 'SendNotification')
    //         {
    //             $this->ecom_notification->employee_id = $employee_new_id;
    //         }
    //         else if($this->MainTitle == 'CourseAlign')
    //         {
    //             $this->ecom_course_assign->employee_id = $employee_new_id;
    //         }
    //     }

    //     $this->Collapse = true;
    // }
    // public function HandleHRDepartment($HRDepartmen_id)
    // {
        
    //     if($HRDepartmen_id != null)
    //     {
    //         if($this->MainTitle == 'SendNotification')
    //         {
    //             $this->ecom_notification->department_id = $HRDepartmen_id;
    //         }
    //         else if($this->MainTitle == 'CourseAlign')
    //         {
    //             $this->ecom_course_assign->department_id = $HRDepartmen_id;
    //         }
    //     }
        
    //     $subDepartment = ecom_department::where('parent_id', $HRDepartmen_id)->pluck('sub_department_id', 'name');
    //     $subDepartmentCount = ecom_department::where('parent_id', $HRDepartmen_id)->count();
    //     $this->Collapse = true;

    //     $this->dispatchBrowserEvent('LoadedSubDepartments', ['subDepartment' => $subDepartment, 'subDepartmentCount' => $subDepartmentCount]);
    // }
    // public function HandleHRSubDepartment($HRSubDepartmen_id)
    // {
    //     if($HRSubDepartmen_id != null)
    //     {
    //         if($this->MainTitle == 'SendNotification')
    //         {
    //             $this->ecom_notification->sub_department_id = $HRSubDepartmen_id;
    //         }
    //         else if($this->MainTitle == 'CourseAlign')
    //         {
    //             $this->ecom_course_assign->sub_department_id = $HRSubDepartmen_id;
    //         }


    //     }


    //     $this->Collapse = true;
    // }
    // public function HandleHRZones($HRZone_code)
    // {
    //     if($HRZone_code != null)
    //     {
    //         if($this->MainTitle == 'SendNotification')
    //         {
    //             $this->ecom_notification->zone_code = $HRZone_code;
    //         }
    //         else if($this->MainTitle == 'CourseAlign')
    //         {
    //             $this->ecom_course_assign->zone_code = $HRZone_code;
    //         }

    //     }

    //     $cities = central_ops_city::where('zone_code', $HRZone_code)->pluck('city_id', 'city_name');
    //     $citiesCount = central_ops_city::where('zone_code', $HRZone_code)->count();
    //     $this->Collapse = true;

    //     $this->dispatchBrowserEvent('LoadedCities', ['cities' => $cities, 'citiesCount' => $citiesCount]);
    // }
    // public function HandleHRCities($HRCitie_id)
    // {
    //     if($HRCitie_id != null)
    //     {
    //         if($this->MainTitle == 'SendNotification')
    //         {
    //             $this->ecom_notification->city_id = $HRCitie_id;
    //         }
    //         else if($this->MainTitle == 'CourseAlign')
    //         {
    //             $this->ecom_course_assign->city_id = $HRCitie_id;
    //         }

    //     }

    //     $this->Collapse = true;
    // }
    // public function HandleHRBranches($HRBranche_id)
    // {
    //     if($HRBranche_id != null)
    //     {
    //         if($this->MainTitle == 'SendNotification')
    //         {
    //             $this->ecom_notification->branch_id = $HRBranche_id;
    //         }
    //         else if($this->MainTitle == 'CourseAlign')
    //         {
    //             $this->ecom_course_assign->branch_id = $HRBranche_id;
    //         }
    //     }

    //     $this->Collapse = true;
    // }
    // public function HandleHRTimeSlots($HRTimeSlot_id)
    // {
    //     if($HRTimeSlot_id != null)
    //     {
    //         if($this->MainTitle == 'SendNotification')
    //         {
    //             $this->ecom_notification->shift_time_id = $HRTimeSlot_id;
    //         }
    //         else if($this->MainTitle == 'CourseAlign')
    //         {
    //             $this->ecom_course_assign->shift_time_id = $HRTimeSlot_id;
    //         }
            
    //     }
    //     $this->Collapse = true;
    // }



}