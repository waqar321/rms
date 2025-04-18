<?php


namespace App\Traits\livewireComponentTraits;


use App\Models\Admin\UnitType;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
// use App\Exports\CategoriesExport;
use App\Exports\Exports;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\CommaSeparated; 

trait UnitTypeComponent
{
    use LivewireComponentsCommon;

    public UnitType $UnitType;  
    // public $parent_SideBars;
    // public $IdNames='';
    // public $ClassNames='';
    // public $SelectedPermissionIds=[];
    // public $selectPermissions = [];
    // public $SelectedPermissionId;
    // public $SelectedParentId;
    public $Update=false;

    public function __construct()
    {       
        $this->Tablename = 'ecom_notification';        
        $this->availableColumns = ['ID', 'Title', 'Status', 'Action'];
        // $this->update = request()->has('id') == true;
        $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
        $this->selectedRows = collect();
        $this->UnitType = new UnitType();
    }

    protected $rules = [
        'UnitType.name' => 'required',
        // 'UnitType.icon' => '',
        // 'UnitType.url' => '',
        // 'UnitType.order' => 'required',
        // 'IdNames' => '', //['required', new CommaSeparated], 
        // 'ClassNames' => '', //['required', new CommaSeparated], 
        // 'UnitType.is_active' => '',
        // 'UnitType.parent_id' => '',
    ];
    protected $messages = [
        'UnitType.required' => 'The Title is must required.',
        // 'UnitType.idNames' => 'please follow the format.',
        // 'UnitType.classNames' => 'please follow the format.',
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
        $idNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->UnitType->idNames);
        $classNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->UnitType->classNames);

        if (!$idNamesValid) {
            $this->addError('UnitType.idNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('UnitType.idNames');
        }

        if (!$classNamesValid) {
            $this->addError('UnitType.classNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('UnitType.classNames');
        }
    }
    public function setMountData($id=null)
    {
        $this->UnitType = $id != 0 ? UnitType::find($id) : new UnitType();
        
        // $this->UnitType = $UnitType ?? new UnitType();   
        $this->pageTitle = 'UnitType Operation';
        $this->MainTitle = 'UnitTypeOperation';
        $this->paginateLimit = 30;
        // $this->parent_UnitTypes = UnitType::where('is_active', 1)->where('parent_id', null)->orderBy('order')->get();
        // $this->permissionLists = Permission::pluck('title', 'id');
        
        // dd($this->parent_SideBars);

        // foreach ($this->permissionLists as $key => $roles)
        // {
        //     // if(in_array($key, old('roles', [])) || (isset($user) && $user->roles->contains($key)) 
        //     if(in_array($key, old('permissions', [])) || (isset($this->role)) && $this->role->permissions->contains($key))
        //     {
        //         $this->selectPermissions[] = $key;
        //     } 
        // }
        // $this->Updatet
    }
    protected function RenderData()
    {
        $UnitTypes = UnitType::when($this->searchByName !== '', function ($query) 
                                    {
                                        $query->where('name', 'like', '%' . $this->searchByName . '%');
                                    })
                                    // ->where('parent_id', null)
                                    ->orderBy('id', 'ASC')
                                    // ->where('is_active', 1)
                                    ->get();
                                    // ->paginate($this->paginateLimit);
                                    

        $data['UnitTypes'] = $this->readyToLoad ? $this->PaginateData($UnitTypes) : [];
        return $data;  

    }        
    public function HandledeleteSidebarOperation(UnitType $UnitType)
    {
        $SideBar->delete();    
        // $this->emit('refreshNotificationCount');
        // $this->emit('refreshNotificationList');
        $this->emit('sidebarUpdated');
        // $this->dispatchBrowserEvent('deleted_scene', ['name' => 'Sidebar']);
    }
    public function updateStatus(UnitType $UnitType, $toggle=0)
    {
        $UnitType->is_active = $toggle == 0 ? 0 : 1;
        $UnitType->save();
        $this->dispatchBrowserEvent('UnitTypeUpdated', ['name' => 'Sidebar']);
    }  
    public function EditData(UnitType $UnitType)
    {
        $this->UnitType = $UnitType;
        $this->Collapse = 'uncollapse';
        $this->Update = true;        
        // $this->dispatchBrowserEvent('updateData');
    }
    public function DeleteUnitType(UnitType $UnitType)
    {
        // dd('DeleteCategory');
        $name = $UnitType->name;
        $UnitType->delete();    
        $this->dispatchBrowserEvent('deleted_scene', ['name' => $name]);
    }
}