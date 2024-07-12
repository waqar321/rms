<?php


namespace App\Traits\livewireComponentTraits\UserManagement;


use App\Models\Admin\Role;
use App\Models\Admin\Permission;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Exports\Exports;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;

trait PermissionsComponent
{
    use LivewireComponentsCommon;

    public Permission $Permission;  
    public $availableColumns;
    public $ExpectedCSVHeaders;   
    public $csv_file;
    public $UpdateBulkColumns;
    public $permissionLists;
    public $SelectedPermissionIds=[];
    public $selected_city_id;
    public $password;
    public $confirm_password;
    
    public function __construct()
    {       
        $this->Tablename = 'Permission';        
        $this->availableColumns = ['ID', 'Title', 'Date', 'Status', 'Action'];
        $this->update = request()->has('id') == true;
        $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
        $this->selectedRows = collect();
        $this->searchByName = '';

    }
    protected $rules = [
        'Permission.title' => 'required',
    ];
    
    protected $messages = [
        'Permission.title' => 'The title is required.',
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
            $this->Permission = new Permission();
            $this->searchByName = "";
        }
    }
    public function updated($value)
    {
        $this->emit('select2');

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
    public function setMountData($Permission)
    {
        $this->Permission = $Permission ?? new Permission(); 
        $this->pageTitle = 'Permission Manage';
        $this->MainTitle = 'PermissionManage';
        $this->searchByName = '';
        $this->paginateLimit = 10;
        $this->cities = collect();
    }
    protected function RenderData()
    {
        $permissions = Permission::when($this->searchByName !== '', function ($query) 
                                    {
                                        $query->where('title', 'like', '%' . $this->searchByName . '%');
                                    })
                                    ->orderBy('id', 'DESC')
                                    // ->get();
                                    ->paginate($this->paginateLimit);
                
        $data['PermissionListing'] = $this->readyToLoad ? $permissions : [];
        return $data;  

    }        
    public function EditData(Permission $Permission)
    {
        $this->Permission = $Permission;
        $this->Collapse = 'uncollapse';
        $this->Update = true;
        // $this->dispatchBrowserEvent('updateData');
    }
    public function updateStatus(Permission $Permission, $toggle)
    {
        $Permission->is_active = $toggle == 0 ? 0 : 1;
        $Permission->save();
        $this->dispatchBrowserEvent('status_updated', ['name' => $Permission->title]);
    }
    public function HandleDeletePermissionManage(Permission $Permission)
    {
        $name = $Permission->title;
        $Permission->delete();    
        $this->dispatchBrowserEvent('deleted_scene', ['name' => $name]);
    }
    public function selectAll()
    {
        // // dd($this->selectAll);
        // if($this->selectAll)
        // {
        //     $this->selectedRows = Permission::orderBy('id', 'DESC')->paginate($this->paginateLimit)->pluck('id');  
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