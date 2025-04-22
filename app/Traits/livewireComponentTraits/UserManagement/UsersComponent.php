<?php


namespace App\Traits\livewireComponentTraits\UserManagement;



use App\Models\Role;
use App\Models\User;
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

    public User $User;  
    public $availableColumns;
    public $ExpectedCSVHeaders;   
    public $csv_file;
    public $UpdateBulkColumns;
    public $rolesLists;
    public $SelectedRolesIds=[];
    public $selected_city_id;
    public $password;
    // public $confirm_password;
    public $selectRoles = [];
    public $selectUserIDS = [];
    public $CurrentPaginatedUsers;
    
    public function __construct()
    {       
        $this->Tablename = 'user';        
        $this->availableColumns = ['Name', 'Email', 'Roles', 'Date', 'Status', 'Action'];
        $this->update = request()->has('id') == true;
        $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
        $this->selectedRows = collect();
        // $this->ecom_course_assign = new ecom_course_assign();
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
            $this->sortBy = 'name';
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
        // 'User.first_name' => 'required',
        // 'User.last_name' => 'required',
        'User.name' => 'required|regex:/^[a-zA-Z\s]+$/',
        'User.username' => '',
        'User.email' => '',
        'User.designation' => '',
        // 'User.phone' => '', //'required|numeric|digits_between:1,11',
        // 'User.gender' => '',
        // 'User.employee_id' => '',
        'password' => 'required',
        // 'confirm_password' => 'required|same:password',
    ];
    
    protected $messages = 
    [
        'User.username.required' => 'The Username is unique required',
        'User.first_name.required' => 'The First Name is required',
        'User.last_name.required' => 'The Last Name is required',
        'User.phone.required' => 'The phone number is required',
        'User.name' => 'The Name Must be String',
        // 'User.email' => 'The Email must be a valid email address',
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
            $this->User = new User();
            $this->title = "";
        }
    }
    public function updated($value)
    {   
        $this->emit('select2');
        
        // return true; //stop real time validation at a time

        if($value == 'User.employee_id')
        {
            $this->exists = User::where('employee_id', $this->User->employee_id)->exists();

            if($this->exists)
            {
                $this->addError('employee_id_error', 'Employee Id Already Exists');
                $this->User->employee_id = "";
            }
            else
            {
                $this->User->username = $this->User->employee_id;
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
    public function setMountData($User)
    {
       $this->User = $User ?? new User(); 
       //$this->User->phone = '03072948013';
       //dd($this->User);

       $this->User->load('roles'); 

       $this->pageTitle = 'User Manage';
       $this->MainTitle = 'UserManage';
       $this->paginateLimit = 50;
       $this->sortBy = 'employee_id';
       $this->sortDirection = 'asc';
       $this->sortByRealTime = 'Employee Code';

       $this->rolesLists = Role::where('title','!=','Super Admin')->where('title','!=','User')->pluck('title', 'id');;
       $this->cities = collect(); 

       foreach ($this->rolesLists as $key => $roles)
       {
           if(in_array($key, old('roles', [])) || (isset($this->User)) && $this->User->roles->contains($key))
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
        
        // $users = User::all();
        // dd($users);

        $users = User::when($this->searchByName !== '', function ($query) 
                                    {
                                        $query->where('name', 'like', '%' . $this->searchByName . '%');
                                    })
                                    ->when($this->searchByEmployeeRole !== '', function ($query) 
                                    {
                                        $query->whereHas('roles', function ($query) 
                                        {
                                            $query->where('title', 'like', '%' . $this->searchByEmployeeRole . '%'); 
                                        });
                                    })
                                    ->whereHas('roles', function ($query) {
                                        $query->where('title', '!=', 'Super Admin'); // Exclude users with Super Admin role
                                    })
                                    ->when($this->sortByRoles, function ($query) 
                                    {
                                        $query->orderBy($this->sortBy, $this->sortDirection);
                                    })
                                    // ->orderBy($this->sortBy, $this->sortDirection)
                                    // ->orderBy('id', 'ASC')
                                    // ->paginate($this->paginateLimit);
                                    ->get();


        $this->sortByCityNames = false;
        $this->CurrentPaginatedUsers =  $users->take($this->paginateLimit);      
        $data['userListing'] = $this->readyToLoad ? $this->PaginateData($users) : [];
        return $data;  

    }        
    public function updateStatus(User $User, $toggle)
    {
        $User->is_active = $toggle == 0 ? 0 : 1;
        $User->save();
        
        $this->dispatchBrowserEvent('status_updated', ['name' => $User->name]);
    }
    public function HandleDeleteUserManage(User $User)
    {
        $name = $User->name;
        $User->delete();    
        $this->dispatchBrowserEvent('deleted_scene', ['name' => $name]);
    }
    public function deleteSelected()
    {
        if($this->getSelectedRowIDs()->isNotEmpty())
        {
            User::whereIn('id', $this->getSelectedRowIDs()->toArray())->delete();

            $this->dispatchBrowserEvent('deleted_scene', ['name' => 'Selected Users']);
        }
    }
    // public function selectAll()
    // {
    //     $this->CurrentPaginatedUsers = $this->PaginateData($this->CurrentPaginatedUsers);
    //     dd($this->CurrentPaginatedUsers);

    //     // // dd($this->selectAll);
    //     // if($this->selectAll)
    //     // {
    //     //     $this->selectedRows = User::orderBy('id', 'DESC')->paginate($this->paginateLimit)->pluck('id');  
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