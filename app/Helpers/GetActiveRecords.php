<?php


use App\Models\Admin\ecom_course;
use App\Models\Admin\ecom_course_assign;
use App\Models\Admin\ecom_category;
use App\Models\Admin\ecom_department;
use App\Models\Admin\ecom_admin_user;
use App\Models\Admin\central_ops_city;
use App\Models\Admin\central_ops_branch;
use App\Models\Admin\ecom_user_roles;
use App\Models\Admin\Role;
use App\Models\Admin\Zone;
use App\Models\Admin\ecom_employee_time_slots;

function GetAllCategories($subCategory=false)
{
    
   return ecom_category::where('parent_id', $subCategory ? '!=' : '=', null)
                                    ->where('is_active', '1')
                                    ->where('is_deleted', '0')
                                    ->get();
}

// ----------------- Cities-------------------
// function GetAllCities()
// {
//     return central_ops_city::pluck('city_id', 'city_name'); // apply group  by zone column
//     // return central_ops_city::all();
// }


function GetAllCities($zone_code=null)
{
    if($zone_code != null)
    {
        return central_ops_city::where('zone_code', $zone_code)
                                ->pluck('city_id', 'city_name'); 
    }
    {
        return central_ops_city::pluck('city_id', 'city_name'); 
        // return ecom_department::where('parent_id', null)
        //                         ->where('is_active', '1')
        //                         ->pluck('name', 'department_id');
    }

}
function GetAllCitiesCount($zone_code=null)
{
    if($zone_code != null)
    {
        return central_ops_city::where('zone_code', $zone_code)
                                ->pluck('city_id', 'city_name')->count();
    }
    {
        return central_ops_city::pluck('city_id', 'city_name')->count(); 
    }

    // return central_ops_city::pluck('city_id', 'city_name') // apply group  by zone column
    // return central_ops_city::all();
}

// ----------------- Courses-------------------
function GetAllCourses()
{
    return  ecom_course::where('is_active', '1')
                            ->get();
}

function GetAllCoursesCount()
{
    return  ecom_course::where('is_active', '1')
                            ->count();
}

// ----------------- employees-------------------
function GetAllEmployees()
{
    return ecom_admin_user::where('is_active', '1')
                        ->where('is_deleted', '0')
                        ->employees()
                        // ->take(50)
                        ->get();
    // return  ecom_admin_user::where('is_active', '1')
    //                         ->where('is_deleted', '0')
    //                         ->whereHas('role', function ($query) {
    //                             $query->where('role_name', 'Employee');
    //                         })
    //                         ->take(50)
    //                         ->get();
}
function GetAllEmployeesCount()
{
    return ecom_admin_user::where('is_active', '1')
                            ->where('is_deleted', '0')
                            ->employees()
                            ->count();
                            
    // return  ecom_admin_user::where('is_active', '1')
    //                         ->where('is_deleted', '0')
    //                         ->whereHas('role', function ($query) {
    //                             $query->where('role_name', 'Employee');
    //                         })
    //                         ->count();
}
// ----------------- Admins-------------------
function GetAllAdmins()
{
    return ecom_admin_user::where('is_active', '1')
                            ->where('is_deleted', '0')
                            ->admins()
                            ->get();

}
// ----------------- Instructors-------------------
function GetAllInstructors()
{
    return ecom_admin_user::where('is_active', '1')
                            ->where('is_deleted', '0')
                            ->Instructors()
                            ->get();
}
function GetAllInstructorsCount()
{
    return  ecom_admin_user::where('is_active', '1')
                                ->where('is_deleted', '0')
                                ->instructors()
                                ->count();
    // return  ecom_admin_user::where('is_active', '1')
    //                             ->where('is_deleted', '0')
    //                             ->whereHas('role', function ($query) {
    //                                 $query->where('role_name', 'Instructor');
    //                             })
    //                             ->count();
}
// ----------------- Departments-------------------
function GetAllDepartments($subDepart=false, $Parent_id=null)
{
    if($subDepart && $Parent_id != null)
    {
        
        return ecom_department::where('parent_id', $Parent_id)
                                ->where('is_active', '1')
                                ->pluck('name', 'sub_department_id');        
    }
    if($subDepart)
    {
                                    
        return ecom_department::where('parent_id', '!=', null)
                                ->where('is_active', '1')
                                ->pluck('name', 'sub_department_id');        
    }
    else
    {
        return ecom_department::where('parent_id', null)
                                ->where('is_active', '1')
                                ->pluck('name', 'department_id');
    }
}
function GetAllDepartmentCount($subDepart=false, $Parent_id=null)
{
    if($subDepart && $Parent_id != null)
    {
        
        return ecom_department::where('parent_id', $Parent_id)
                                ->where('is_active', '1')
                                ->count();        
    }
    if($subDepart)
    {
                                    
        return ecom_department::where('parent_id', '!=', null)
                                ->where('is_active', '1')
                                ->count();        
    }
    else
    {
        return ecom_department::where('parent_id', null)
                                ->where('is_active', '1')
                                ->count();
    }

    // return ecom_department::where('parent_id', $subDepart ? '!=' : '=', null)
    //                         ->where('is_active', '1')
    //                         // ->where('is_deleted', '0')   // it is using soft delete, 
    //                         ->count();
}
// ----------------- Roles-------------------
function GetAllRoles()
{
    return  Role::where('title', '!=', 'Super Admin')->get();
}
function GetAllRolesCount()
{
    return  Role::where('title', '!=', 'Super Admin')->count();
}
// ----------------- Branches-------------------

function GetAllBranches()
{
    return central_ops_branch::pluck('branch_id', 'branch_name');
    // return central_ops_branch::all();
}
function GetAllBranchesCount()
{
    return central_ops_branch::pluck('branch_id', 'branch_name')->count();
}

// ----------------- Zones-------------------
function GetAllZones()
{
    // return central_ops_city::groupBy('zone_name', 'zone_code')->pluck('zone_code'); // apply group  by zone column
    return Zone::all(); // apply group  by zone column
    // return zone::pluck('zone_name', 'zone_short_name', 'zone_name'); // apply group  by zone column
}
function GetAllZonesCount()
{
    return central_ops_city::groupBy('zone_code')->pluck('zone_code')->count(); // apply group  by zone column
}

// ----------------- Time Slots-------------------
function GetAllEmployeeSchedules()
{
    return  ecom_employee_time_slots::where('is_active', '1')
                            ->get();
}
function GetAllschedulesCount()
{
    return  ecom_employee_time_slots::where('is_active', '1')
                            ->count();
}
// ----------- Filter Wise Records ------------------ 

function SpecificDepartmentEmployees($department_id=0)
{   
    return ecom_admin_user::where('department_id', $department_id)->get();
}
function SpecificDepartmentEmployeeTokens($department_id=0)
{   
    return ecom_admin_user::where('department_id', $department_id)->whereNotNull('device_token')->pluck('device_token', 'id');
}
function SpecificSubDepartmentEmployeeTokens($sub_department_id=0)
{   
    return ecom_admin_user::where('sub_department_id', $sub_department_id)->whereNotNull('device_token')->pluck('device_token', 'id');
}
function SpecificZoneEmployees($zone='')
{
    return ecom_admin_user::where('zone', $zone)->get();
}
function SpecificZoneEmployeeTokens($zone_code='')
{
    $zone_code_int = (int) $zone_code;
    return ecom_admin_user::where('zone_id', $zone_code_int)->whereNotNull('device_token')->pluck('device_token', 'id');
}
function SpecificCityEmployees($city_id=0)
{
    return ecom_admin_user::where('city_id', $city_id)->get();
}
function SpecificCityEmployeeTokens($city_id=0)
{
    return ecom_admin_user::where('city_id', $city_id)->whereNotNull('device_token')->pluck('device_token', 'id');
}
function SpecificBranchEmployees($branch_id=0)
{
    return ecom_admin_user::where('branch_id', $branch_id)->get();
}
function SpecificBranchEmployeeTokens($branch_id=0)
{
    return ecom_admin_user::where('branch_id', $branch_id)->whereNotNull('device_token')->pluck('device_token', 'id');
}
function SpecificDesignationEmployees($role_id=0)
{
    return ecom_admin_user::where('role_id', $role_id)->get();
}
function SpecificDesignationEmployeeTokens($role_id=0)
{
    return ecom_admin_user::where('role_id', $role_id)->whereNotNull('device_token')->pluck('device_token', 'id');
}
function SpecificScheduleEmployees($time_slot_id=0)
{
    return ecom_admin_user::where('time_slot_id', $time_slot_id)->get();
}
function SpecificScheduleEmployeeTokens($time_slot_id=0)
{
    return ecom_admin_user::where('time_slot_id', $time_slot_id)->whereNotNull('device_token')->pluck('device_token', 'id');
}
function SpecificInstructor($instructor_id=0)
{
    return ecom_admin_user::where('id', $instructor_id)->first();
}
function SpecificInstructorToken($instructor_id=0)
{
    return ecom_admin_user::where('id', $instructor_id)->whereNotNull('device_token')->pluck('device_token', 'id');
}
function uppercaseCamelCaseWithSpaces($str)
{
    $str = strtolower($str);
    $words = explode(' ', $str);
    $camelCase = '';

    foreach ($words as $word) {
        $camelCase .= ucfirst($word) . ' ';
    }

    return rtrim($camelCase);
}






// $this->total_employees = GetAllEmployeesCount();
// $this->total_Instructors = GetAllInstructorsCount();
// $this->total_Department = GetAllDepartmentCount();
// $this->total_Zones = GetAllZonesCount();
// $this->total_Branches = GetAllBranchesCount();
// $this->total_Roles = GetAllRolesCount();
// $this->total_schedules = GetAllschedulesCount();
// $this->total_cities = GetAllCitiesCount();
// $this->total_course = GetAllCoursesCount();



