<?php


namespace App\Traits\livewireComponentTraits;


use App\Models\Admin\ecom_admin_user;
use App\Models\Admin\ecom_category;
use App\Models\Admin\ecom_department;
use App\Models\Admin\ecom_user_roles;
use App\Models\Admin\ecom_notification;
use App\Models\Admin\ecom_course_assign;
use App\Models\Admin\central_ops_city;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
//export excels
// use App\Exports\CategoriesExport;
use App\Exports\Exports;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;

trait NotificationComponent
{
    use LivewireComponentsCommon;

    public $title;
    public $bodyMessage;
    // public $notifications;
    public $selectAll = true;

    public ecom_notification $ecom_notification;  
    public $availableColumns;
    public $ExpectedCSVHeaders;

   

    public $csv_file;
    public $UpdateBulkColumns;
    
    public function __construct()
    {       
        $this->Tablename = 'ecom_notification';        
        $this->availableColumns = ['ID', 'Title', 'Message', 'Instructor', 'Employee', 'Department', 'Sub Department', 'Zone', 'City', 'Branch', 'Role', 'Time Slot', 'Date', 'Status', 'Action'];
        $this->update = request()->has('id') == true;
        $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
        $this->selectedRows = collect();
        $this->ecom_course_assign = new ecom_course_assign();
    }

    protected $rules = [
        'ecom_notification.title' => 'required',
        'ecom_notification.messagebody' => 'required',
        'ecom_notification.user_id' => '',
        'ecom_notification.department_id' => '',
        'ecom_notification.sub_department_id' => '',
        'ecom_notification.instructor_id' => '',
        'ecom_notification.employee_id' => '',
        'ecom_notification.role_id' => '',
        'ecom_notification.zone_code' => '',
        'ecom_notification.city_id' => '',
        'ecom_notification.branch_id' => '',
        'ecom_notification.shift_time_id' => '',
        'csv_file' => '',
    ];
    
    protected $messages = [
        'title.required' => 'The Title is must required.',
        'bodyMessage.required' => 'The Notification Message is must required.',
        'ecom_notification.department_id' => 'The name field is required.',
        'ecom_notification.sub_department_id' => 'The name field is required.',
    ];
    public function resetInput($searchReset=false)
    {
        // if($this->subCategory)
        // {
        //     $this->parent_category = '';
        // }
        
        // if($searchReset)
        // {
        //     $this->searchByName = '';
        //     $this->selectedRows = collect();
        // }
        // else
        // {
            // $this->ecom_notification = new ecom_notification();
            $this->title = "";
        // }
    }
    public function updated($value)
    {
        $selectedrow = explode('.', $value);
        
        // dd($value);
        // if($value == 'ecom_notification.department_id')
        // {
        //     $this->Collapse = "uncollapse";
        //     $this->sub_departments = ecom_department::where('parent_id', $this->ecom_notification->department_id)->get();
        //     // dd($this->sub_departments);
        // }
        // elseif($value == 'ecom_notification.zone_name')
        // {
        //     $this->Collapse = "uncollapse";
        //     $this->cities = central_ops_city::where('zone', $this->ecom_notification->zone_name)->pluck('city_id', 'city_name');
        // }
        // elseif($value == 'csv_file')
        if($value == 'csv_file')
        {
            $this->Collapse = "uncollapse";
            $this->ValidateOrGetCSVData();
        }
        // else if($selectedrow[0] == 'selectedRows')
        // {
            // dd($this->selectedRows);
            // $currentPageItems = $this->items;
            // get current pagination page items i amw working on livewire withPagination
        // }
        else if($value == 'ecom_notification.department_id')
        {
            $this->sub_departments = GetAllDepartments(true, $this->ecom_notification->department_id);
        }
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
            

            // $this->dispatchBrowserEvent('loadDropDownData');
            // $this->validateOnly($value);
        }   
        $this->dispatchBrowserEvent('ApplySelect2');
    }
    public function setMountData($ecom_notification)
    {
       $this->ecom_notification = $ecom_notification ?? new ecom_notification();  
       $this->ExpectedCSVHeaders = $this->GetExpectedCSVHeaderData(true);

       //$this->pageTitle = 'Send Notification';
       //$this->MainTitle = 'SendNotification';

       $this->pageTitle = 'Notification Manage';
       $this->MainTitle = 'NotificationManage';

       $this->title = '';
       $this->bodyMessage = '';
       $this->paginateLimit = 10;

       $this->sub_departments = collect();
       $this->cities = collect(); 
       
       $this->loadDropDownData(true);
       
        //    $this->instructors = GetAllInstructors();
        //    $this->departments = GetAllDepartments();
        //    $this->zones = GetAllZones();
        //    $this->cities = collect(); 
        //    $this->sub_departments = collect(); 
        //    $this->branches = GetAllBranches();
        //    $this->roles = GetAllRoles();
        //    $this->schedules = GetAllEmployeeSchedules();   

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
        

        // $departments = ecom_department::whereNotNull('parent_id')->get();
        // foreach($departments as $department)
        // {
        //     $department_id = ecom_department::where('id', $department->parent_id)->value('department_id');
        //     $department->parent_id = $department_id;
        //     $department->save();
        // }


        // $this->ecom_notification->department_id = 4;
        // dd(GetAllDepartments(true, $this->ecom_notification->department_id));
        // dd(GetAllDepartments());
        // dd(GetAllDepartments(true));
        // dd(GetAllDepartments(true, 641));

    }
    protected function RenderData()
    {
        $notifications = ecom_notification::when($this->title !== '', function ($query) 
                                                {
                                                    $query->where('title', $this->title);
                                                })
                                                ->orderBy('id', 'DESC')
                                                ->paginate($this->paginateLimit);
        
        //================= make all seen except admin ========================
        // if(auth()->user()->role->id != 1)
        // {
            // $notificationMessages = ecom_notification::orderBy('created_at', 'desc')->get();
            // if ($notificationMessages->isNotEmpty()) 
            // {
            //     foreach($notificationMessages as $notification)
            //     {
            //         $user_status = $notification->NotificationStatuses->where('user_id', auth()->user()->id)->first();
            //         if($user_status)
            //         {
            //             $user_status->update(['read' => 1]);
            //         }
            //     }
            // }
        // }

        $data['notifications'] = $this->readyToLoad ? $notifications : [];
        return $data;  

    }        
    public function HandleDeleteSendNotification(ecom_notification $ecom_notification)
    {
        $ecom_notification->delete();    
        $this->emit('refreshNotificationCount');
        // $this->emit('refreshNotificationList');
        $this->dispatchBrowserEvent('deleted_scene', ['name' => 'Notification']);
    }
    public function selectAll()
    {
        // dd($this->selectAll);
        if($this->selectAll)
        {
            $this->selectedRows = ecom_notification::orderBy('id', 'DESC')->paginate($this->paginateLimit)->pluck('id');  
            dd($this->selectedRows);
           
            // dd($this->selectedRows->contains(88));
            // dd('collection', $this->selectedRows);
            // dd($notificationIds);

        }
        else
        {
            $this->selectedRows = collect();
        }
        // dd($this->selectedRows);
        // $this->emit('$refresh');
        // dd($this->selectedRows);            

    }
}