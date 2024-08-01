<?php


namespace App\Traits\livewireComponentTraits\UserManagement;


use App\Models\Admin\ecom_admin_user;
use App\Models\Admin\ecom_category;
use App\Models\Admin\ecom_department;
use App\Models\Admin\ecom_user_roles;
use App\Models\Admin\ecom_course_assign;
use App\Models\Admin\central_ops_city;
use App\Models\Admin\Role;
use Illuminate\Validation\Rule;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
//export excels
// use App\Exports\CategoriesExport;
use App\Exports\Exports;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;


trait UsersComponent
{
    use LivewireComponentsCommon;

    public ecom_admin_user $ecom_admin_user;  
    public $availableColumns;
    public $ExpectedCSVHeaders;   
    public $csv_file;
    public $UpdateBulkColumns;
    public $rolesLists;
    public $SelectedRolesIds=[];
    public $selected_city_id;
    public $password;
    public $confirm_password;
    public $selectRoles = [];
    public $selectUserIDS = [];
    public $CurrentPaginatedUsers;
    
    public function __construct()
    {       
        $this->Tablename = 'ecom_admin_user';        
        $this->availableColumns = ['Employee Code', 'Name', 'Email', 'City', 'Roles', 'Designation', 'Date', 'Status', 'Action'];
        $this->update = request()->has('id') == true;
        $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
        $this->selectedRows = collect();
        $this->ecom_course_assign = new ecom_course_assign();
    }

    public function sortBy($field)
    {
        $this->sortByRealTime = $field;
        $this->sortByCityNames = false;
        $this->sortByRoles = false;
        
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';

        if ($field === 'City')
        {
            $this->sortByCityNames = true;
        }
        if ($field === 'Roles')
        {
            // $this->sortBy = '';
            // $this->sortByRoles = true;
        }
                 
        if ($field === 'Employee Code')
        {
            $this->sortBy = 'employee_id';
        } 
        else if ($field === 'Name')
        {
            $this->sortBy = 'full_name';
        } 
        else if ($field === 'Email')
        {
            $this->sortBy = 'email';
        } 
        else if ($field === 'Designation')
        {
            $this->sortBy = 'designation';
        } 
        else if ($field === 'Date')
        {
            $this->sortBy = 'created_at';
        } 
        // else
        // {
        //     // $this->sortBy = $field;
        //     $this->sortDirection = 'asc';
        // }

        // dd($field , $this->sortBy);
        // if ($this->sortBy === $field) 
        // {
        //     $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        // }
        // else
        // {
        //     $this->sortBy = $field;
        //     $this->sortDirection = 'asc';
        // }
    }

    protected $rules = 
    [
        // 'ecom_admin_user.first_name' => 'required',
        // 'ecom_admin_user.last_name' => 'required',
        'ecom_admin_user.full_name' => 'required|regex:/^[a-zA-Z\s]+$/',
        'ecom_admin_user.username' => '',
        'ecom_admin_user.email' => 'email|unique:ecom_admin_user',
        'ecom_admin_user.phone' => '', //'required|numeric|digits_between:1,11',
        'ecom_admin_user.gender' => '',
        'ecom_admin_user.employee_id' => '',
        'password' => 'required',
        'confirm_password' => 'required|same:password',
    ];
    
    protected $messages = 
    [
        'ecom_admin_user.username.required' => 'The Username is unique required',
        'ecom_admin_user.first_name.required' => 'The First Name is required',
        'ecom_admin_user.last_name.required' => 'The Last Name is required',
        'ecom_admin_user.phone.required' => 'The phone number is required',
        'ecom_admin_user.full_name' => 'The Name Must be String',
        // 'ecom_admin_user.email' => 'The Email must be a valid email address',
    ];

    public function resetInput($searchReset=false)
    {
        // if($this->subCategory)
        // {
        //     $this->parent_category = '';
        // }
        
        if($searchReset)
        {
            $this->searchByName = '';
            $this->searchByEmployeeCode = '';
            $this->searchByEmployeeRole = '';
            $this->searchByEmployeeDesignation = '';
            $this->searchByEmployeeCity = '';
            $this->selectedRows = collect();
            // $this->dispatchBrowserEvent('ResetColumns');
        }
        else
        {
            $this->ecom_admin_user = new ecom_admin_user();
            $this->title = "";
        }
    }
    public function updated($value)
    {   
        $this->emit('select2');
        
        // return true; //stop real time validation at a time

        if($value == 'ecom_admin_user.employee_id')
        {
            $this->exists = ecom_admin_user::where('employee_id', $this->ecom_admin_user->employee_id)->exists();

            if($this->exists)
            {
                $this->addError('employee_id_error', 'Employee Id Already Exists');
                $this->ecom_admin_user->employee_id = "";
            }
            else
            {
                $this->ecom_admin_user->username = $this->ecom_admin_user->employee_id;
            }
        }
        if($value == 'csv_file')
        {
            $this->Collapse = "uncollapse";
            $this->ValidateOrGetCSVData();
        }
        else
        {
   
            // public $searchByEmployeeCode = '';
            // public $searchByEmployeeRole = '';
            // public $searchByEmployeeDesignation = '';
            // public $searchByEmployeeCity = '';

            if($value == 'paginateLimit' || 
                $value == 'searchByName' || 
                $value == 'searchByEmployeeCode' || 
                $value == 'searchByEmployeeRole' || 
                $value == 'searchByEmployeeDesignation' || 
                $value == 'searchByEmployeeCity' ||  
                strpos($value, 'selectedRows') !== false
            )
            {
                // if($value == 'paginateLimit')
                // {
                //     $this->CurrentPaginatedUsers->take($this->paginateLimit);
                // }

                $this->Collapse = "collapse";
            }
            else
            {
                // dd($value);

                $this->Collapse = "uncollapse";
                $this->validateOnly($value);
            }       
        }   
    }
    public function setMountData($ecom_admin_user)
    {
       $this->ecom_admin_user = $ecom_admin_user ?? new ecom_admin_user(); 
       //$this->ecom_admin_user->phone = '03072948013';
       //dd($this->ecom_admin_user);

       $this->ecom_admin_user->load('roles'); 

       $this->pageTitle = 'User Manage';
       $this->MainTitle = 'UserManage';
       $this->paginateLimit = 10;
       $this->sortBy = 'employee_id';
       $this->sortDirection = 'asc';
       $this->sortByRealTime = 'Employee Code';

       $this->rolesLists = Role::where('title','!=','Super Admin')->where('title','!=','User')->pluck('title', 'id');;
       $this->cities = collect(); 

       foreach ($this->rolesLists as $key => $roles)
       {
           if(in_array($key, old('roles', [])) || (isset($this->ecom_admin_user)) && $this->ecom_admin_user->roles->contains($key))
           {
               $this->selectRoles[] = $key;
           } 
       }
    }
    protected function RenderData()
    {
        // if($this->sortByCityNames// {
        //     dd('true');
        // }
        $users = ecom_admin_user::when($this->searchByName !== '', function ($query) 
                                    {
                                        $query->where('full_name', 'like', '%' . $this->searchByName . '%');
                                    })
                                    ->when($this->searchByEmployeeCode !== '', function ($query) 
                                    {
                                        $query->where('employee_id', 'like', '%' . $this->searchByEmployeeCode . '%');
                                    })
                                    ->when($this->searchByEmployeeDesignation !== '', function ($query) 
                                    {
                                        $query->where('designation', 'like', '%' . $this->searchByEmployeeDesignation . '%');
                                    })
                                    ->when($this->searchByEmployeeRole !== '', function ($query) 
                                    {
                                        $query->whereHas('roles', function ($query) 
                                        {
                                            $query->where('title', 'like', '%' . $this->searchByEmployeeRole . '%'); 
                                        });
                                    })
                                    ->when($this->searchByEmployeeCity !== '', function ($query) 
                                    {
                                        $query->whereHas('city', function ($query) 
                                        {
                                            $query->where('city_name', 'like', '%' . $this->searchByEmployeeCity . '%'); 
                                        });
                                    })
                                    ->whereHas('roles', function ($query) {
                                        $query->where('title', '!=', 'Super Admin'); // Exclude users with Super Admin role
                                    })
                                    ->when($this->sortByCityNames, function ($query) 
                                    {
                                        $query->leftJoin('central_ops_city', 'ecom_admin_user.city_id', '=', 'central_ops_city.city_id')
                                                ->select('ecom_admin_user.*', 'central_ops_city.city_name')
                                                ->orderBy('central_ops_city.city_name', $this->sortDirection);
                                    })
                                    ->when($this->sortByRoles, function ($query) 
                                    {
                                        $query->orderBy($this->sortBy, $this->sortDirection);
                                    })
                                    ->orderBy($this->sortBy, $this->sortDirection)
                                    // ->orderBy('id', 'ASC')
                                    // ->paginate($this->paginateLimit);
                                    ->get();

        $this->sortByCityNames = false;
        $this->CurrentPaginatedUsers =  $users->take($this->paginateLimit);      
        $data['userListing'] = $this->readyToLoad ? $this->PaginateData($users) : [];
        return $data;  

    }        
    public function updateStatus(ecom_admin_user $ecom_admin_user, $toggle)
    {
        $ecom_admin_user->is_active = $toggle == 0 ? 0 : 1;
        $ecom_admin_user->save();
        
        $this->dispatchBrowserEvent('status_updated', ['name' => $ecom_admin_user->full_name]);
    }
    public function HandleDeleteUserManage(ecom_admin_user $ecom_admin_user)
    {
        $name = $ecom_admin_user->full_name;
        $ecom_admin_user->delete();    
        $this->dispatchBrowserEvent('deleted_scene', ['name' => $name]);
    }
    public function deleteSelected()
    {
        if($this->getSelectedRowIDs()->isNotEmpty())
        {
            Permission::whereIn('id', $this->getSelectedRowIDs()->toArray())->delete();

            $this->dispatchBrowserEvent('deleted_scene', ['name' => 'Selected Permissions']);
        }
    }
    // public function selectAll()
    // {
    //     $this->CurrentPaginatedUsers = $this->PaginateData($this->CurrentPaginatedUsers);
    //     dd($this->CurrentPaginatedUsers);

    //     // // dd($this->selectAll);
    //     // if($this->selectAll)
    //     // {
    //     //     $this->selectedRows = ecom_admin_user::orderBy('id', 'DESC')->paginate($this->paginateLimit)->pluck('id');  
    //     //     dd($this->selectedRows);
           
    //     //     // dd($this->selectedRows->contains(88));
    //     //     // dd('collection', $this->selectedRows);
    //     //     // dd($notificationIds);

    //     // }
    //     // else
    //     // {
    //     //     $this->selectedRows = collect();
    //     // }
    //     // // dd($this->selectedRows);
    //     // // $this->emit('$refresh');
    //     // // dd($this->selectedRows);            

    // }
}