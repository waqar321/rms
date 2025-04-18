<?php


namespace App\Traits\livewireComponentTraits;


use App\Models\Admin\SideBar;
use App\Models\User;
use App\Models\Permission;

use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
//export excels
// use App\Exports\CategoriesExport;
use App\Exports\Exports;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\CommaSeparated; 

trait SidebarComponent
{
    use LivewireComponentsCommon;

    public SideBar $SideBar;  
    public $parent_SideBars;
    public $IdNames='';
    public $ClassNames='';
    public $SelectedPermissionIds=[];
    public $selectPermissions = [];
    public $SelectedPermissionId;
    public $SelectedParentId;


    public function __construct()
    {       
        $this->Tablename = 'ecom_notification';        
        $this->availableColumns = ['ID', 'Title', 'Order', 'Parent', 'Permission', 'URL', 'Icon Name', 'Element ID Names', 'Element Class Names', 'Status', 'Action'];
        // $this->update = request()->has('id') == true;
        $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
        $this->selectedRows = collect();
        $this->SideBar = new SideBar();
    }

    protected $rules = [
        'SideBar.title' => 'required',
        'SideBar.icon' => '',
        'SideBar.url' => '',
        'SideBar.order' => 'required',
        'IdNames' => '', //['required', new CommaSeparated], 
        'ClassNames' => '', //['required', new CommaSeparated], 
        'SideBar.is_active' => '',
        'SideBar.parent_id' => '',
    ];
    protected $messages = [
        'SideBar.required' => 'The Title is must required.',
        'SideBar.idNames' => 'please follow the format.',
        'SideBar.classNames' => 'please follow the format.',
    ];
    public function resetInput($searchReset=false)
    {       
        $this->searchByName = "";
    }
    public function updated($value)
    {
        if ($value == 'searchByName' || $value == 'paginateLimit')
        {
            $this->Collapse = "collapse";
        } 
        else if ($value == 'IdNames') 
        {
            if (!preg_match('/^([\w-]+,? ?)*[\w-]+$/', $this->IdNames))           
            {
                $this->addError('IdNames', 'Invalid format. Accepted format: value1, value2, value3');
            }
            $this->Collapse = "uncollapse";
        }
        else if ($value == 'ClassNames') 
        {
            if (!preg_match('/^([\w-]+,? ?)*[\w-]+$/', $this->ClassNames))           
            {
                $this->addError('ClassNames', 'Invalid format. Accepted format: value1, value2, value3');
            }
            $this->Collapse = "uncollapse";
            
        }
        else
        {
            $this->validateOnly($value);
            $this->Collapse = "uncollapse";
        }
    }
    protected function validateIdAndClassNames()
    {
        $idNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->SideBar->idNames);
        $classNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->SideBar->classNames);

        if (!$idNamesValid) {
            $this->addError('SideBar.idNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('SideBar.idNames');
        }

        if (!$classNamesValid) {
            $this->addError('SideBar.classNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('SideBar.classNames');
        }
    }
    public function setMountData($id)
    {
      
        $this->SideBar = $id != 0 ? SideBar::find($id) : new SideBar();
        
        // $this->SideBar = $SideBar ?? new SideBar();   
        $this->pageTitle = 'Sidebar Operation';
        $this->MainTitle = 'SidebarOperation';
        $this->paginateLimit = 50;
        $this->parent_SideBars = SideBar::where('is_active', 1)->where('parent_id', null)->orderBy('order')->get();
        $this->permissionLists = Permission::pluck('title', 'id');
        
        // dd($this->parent_SideBars);

        // foreach ($this->permissionLists as $key => $roles)
        // {
        //     // if(in_array($key, old('roles', [])) || (isset($user) && $user->roles->contains($key)) 
        //     if(in_array($key, old('permissions', [])) || (isset($this->role)) && $this->role->permissions->contains($key))
        //     {
        //         $this->selectPermissions[] = $key;
        //     } 
        // }
    }
    protected function RenderData()
    {
        $parent_SideBars = SideBar::when($this->searchByName !== '', function ($query) 
                                    {
                                        $query->where('title', 'like', '%' . $this->searchByName . '%');
                                    })

                                    // ->where('parent_id', null)
                                    ->orderBy('id', 'ASC')
                                    // ->where('is_active', 1)
                                    ->get();
                                    // ->paginate($this->paginateLimit);

        $data['SideBars'] = $this->readyToLoad ? $this->PaginateData($parent_SideBars) : [];
        return $data;  

    }        
    public function HandledeleteSidebarOperation(SideBar $SideBar)
    {
        $SideBar->delete();    
        // $this->emit('refreshNotificationCount');
        // $this->emit('refreshNotificationList');
        $this->emit('sidebarUpdated');
        // $this->dispatchBrowserEvent('deleted_scene', ['name' => 'Sidebar']);
    }
    public function updateStatus(SideBar $SideBar, $toggle)
    {
        $SideBar->is_active = $toggle == 0 ? 0 : 1;
        $SideBar->save();
        $this->dispatchBrowserEvent('status_updated', ['name' => $SideBar->title]);
        $this->emit('sidebarUpdated');
    }  
}