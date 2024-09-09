<?php


namespace App\Traits\livewireComponentTraits\UserManagement;


use App\Models\Admin\ecom_category;
use App\Models\Admin\ecom_department;
use App\Models\Admin\ecom_user_roles;
use App\Models\Admin\ecom_course_assign;
use App\Models\Admin\central_ops_city;
use App\Models\Role;
use App\Models\Permission;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Exports\Exports;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;

trait RolesComponent
{
    use LivewireComponentsCommon;

    public Role $role;  
    public $availableColumns;
    public $ExpectedCSVHeaders;   
    public $csv_file;
    public $UpdateBulkColumns;
    public $permissionLists;
    public $SelectedPermissionIds=[];
    public $selected_city_id;
    public $password;
    public $confirm_password;
    public $selectRoles = [];
    public $selectPermissions = [];
    
    public function __construct()
    {       
        $this->Tablename = 'role';        
        $this->availableColumns = ['ID', 'Title', 'Permissions', 'Date', 'Status', 'Action'];
        $this->update = request()->has('id') == true;
        $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
        $this->selectedRows = collect();
    }
    protected $rules = [
        'role.title' => 'required',
    ];
    
    protected $messages = [
        'role.title' => 'The title is required.',
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
            $this->role = new Role();
            $this->searchByName = "";
        }
    }
    public function updated($value)
    {
        $this->emit('select2');

        if($value == 'paginateLimit' || $value == 'searchByName' || strpos($value, 'selectedRows') !== false)
        {
            $this->Collapse = "collapse";
        }
        else
        {
            $this->Collapse = "uncollapse";
            $this->validateOnly($value);
        }       
    }
    public function setMountData($role)
    {
        
        $this->role = $role ?? new role(); 
        $this->role->load('permissions'); 
        $this->pageTitle = 'Role Manage';
        $this->MainTitle = 'RoleManage';
        $this->searchByName = '';
        $this->bodyMessage = '';
        $this->paginateLimit = 20;
        $this->permissionLists = Permission::pluck('title', 'id');
        $this->cities = collect(); 
        
        foreach ($this->permissionLists as $key => $roles)
        {
            // if(in_array($key, old('roles', [])) || (isset($user) && $user->roles->contains($key)) 
            if(in_array($key, old('permissions', [])) || (isset($this->role)) && $this->role->permissions->contains($key))
            {
                $this->selectPermissions[] = $key;
            } 
        }
    }
    protected function RenderData()
    {
        $roles = Role::when($this->searchByName !== '', function ($query) 
                            {
                                $query->where('title', 'like', '%' . $this->searchByName . '%');
                            })
                            ->orderBy('id', 'ASC')
                            // ->paginate($this->paginateLimit);
                             ->get();

        $data['roleListing'] = $this->readyToLoad ? $this->PaginateData($roles) : [];
        return $data;  

    }        

    public function EditData(role $role)
    {
        $this->role = $role;
        $this->role->load('permissions');
        $this->Collapse = 'uncollapse';
        $this->Update = true;
        
        foreach ($this->permissionLists as $key => $roles)
        {
            // if(in_array($key, old('roles', [])) || (isset($user) && $user->roles->contains($key)) 
            if(in_array($key, old('permissions', [])) || (isset($this->role)) && $this->role->permissions->contains($key))
            {
                $this->selectPermissions[] = $key;
            } 
        }
        $this->dispatchBrowserEvent('updateData');
    }

    public function updateStatus(role $role, $toggle)
    {
        $role->is_active = $toggle == 0 ? 0 : 1;
        $role->save();
        $this->dispatchBrowserEvent('status_updated', ['name' => $role->title]);
    }
    public function HandleDeleteRoleManage(role $role)
    {
        $name = $role->title;
        $role->delete();    
        $this->dispatchBrowserEvent('deleted_scene', ['name' => $name]);
    }
    public function selectAll()
    {
        // // dd($this->selectAll);
        // if($this->selectAll)
        // {
        //     $this->selectedRows = role::orderBy('id', 'DESC')->paginate($this->paginateLimit)->pluck('id');  
        //     dd($this->selectedRows);
           
        //     // dd($this->selectedRows->contains(88));
        //     // dd('collection', $this->selectedRows);
        //     // dd($notificationIds);

        // }
        // else
        // {
        //     $this->selectedRows = collect();
        // }
        // // dd($this->selectedRows);
        // // $this->emit('$refresh');
        // // dd($this->selectedRows);            

    }
}