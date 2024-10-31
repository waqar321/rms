<?php


namespace App\Traits\livewireComponentTraits;

use App\Models\Admin\ecom_lecture;
use App\Models\Admin\ecom_category;
use App\Models\Admin\ecom_department;
use App\Models\User;
use App\Models\Admin\LectureAssessmentLevel;
use App\Rules\EitherOrRule;
use Illuminate\Support\Facades\DB;

trait GlobalVariablesForComponents
{
    public $total_employees=0;
    public $total_Instructors=0;
    public $total_Department=0;
    public $total_Zones=0;
    public $total_Branches=0;
    public $total_Roles=0;
    public $total_schedules=0;
    public $total_cities=0;
    public $total_course=0;
    public $total_records=0;
    
    public $categories;
    public $subcategories;
    
    public $departments  = [];
    public $sub_departments;
    public $employees = [];
    public $instructors = [];
    public $schedules = [];
    public $courses;
    public $zones = [];
    public $cities = [];
    public $branches = [];
    public $roles = [];
    
    // public $User;
    
    public $update =false;
    public $pageTitle;
    public $MainTitle;
    
    // #[Url(as : 's')]
    public $searchByName='';
    //#[Url(as : 'st')]
    public $sortBy = '';
    public $sortByRealTime = '';
    //#[Url(as : 'st_d')]
    public $sortDirection = '';
    //#[Url(as : 'E_C')]
    public $searchByEmployeeCode = '';
    //#[Url(as : 'E_R')]
    public $searchByEmployeeRole = '';
    //#[Url(as : 'E_D')]
    public $searchByEmployeeDesignation = '';
    //#[Url(as : 'E_CY')]
    public $searchByEmployeeCity = '';
    
    public $sortByCityNames = false;
    public $sortByRoles = false;   

    public $Collapse = 'collapse'; 
    public $photo;
    public $Tablename;
    public $Exportdata = [];
    public $readyToLoad = false;
    public $selectedRows;

    //#[Url()]
    public $paginateLimit;


    // protected $queryString = [
    //     'searchByName' => ['except' => ''],
    //     'page' => ['except' => 1],
    //     'sortBy',
    //     'sortDirection',
    //     'searchByEmployeeCode',
    //     'searchByEmployeeRole',
    //     'searchByEmployeeDesignation',
    //     'searchByEmployeeCity',
    // ];


}