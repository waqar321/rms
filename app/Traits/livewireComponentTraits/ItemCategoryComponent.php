<?php


namespace App\Traits\livewireComponentTraits;


use App\Models\Admin\ItemCategory;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
// use App\Exports\CategoriesExport;
use App\Exports\Exports;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\CommaSeparated; 

trait ItemCategoryComponent
{
    use LivewireComponentsCommon;

    public ItemCategory $ItemCategory;  
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
        $this->ItemCategory = new ItemCategory();
    }

    protected $rules = [
        'ItemCategory.name' => 'required',
        // 'ItemCategory.icon' => '',
        // 'ItemCategory.url' => '',
        // 'ItemCategory.order' => 'required',
        // 'IdNames' => '', //['required', new CommaSeparated], 
        // 'ClassNames' => '', //['required', new CommaSeparated], 
        // 'ItemCategory.is_active' => '',
        // 'ItemCategory.parent_id' => '',
    ];
    protected $messages = [
        'ItemCategory.required' => 'The Title is must required.',
        // 'ItemCategory.idNames' => 'please follow the format.',
        // 'ItemCategory.classNames' => 'please follow the format.',
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
        $idNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->ItemCategory->idNames);
        $classNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->ItemCategory->classNames);

        if (!$idNamesValid) {
            $this->addError('ItemCategory.idNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('ItemCategory.idNames');
        }

        if (!$classNamesValid) {
            $this->addError('ItemCategory.classNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('ItemCategory.classNames');
        }
    }
    public function setMountData($id=null)
    {
        $this->ItemCategory = $id != 0 ? ItemCategory::find($id) : new ItemCategory();
        
        // $this->ItemCategory = $ItemCategory ?? new ItemCategory();   
        $this->pageTitle = 'Category Operation';
        $this->MainTitle = 'CategoryOperation';
        $this->paginateLimit = 10;
        // $this->parent_ItemCategorys = ItemCategory::where('is_active', 1)->where('parent_id', null)->orderBy('order')->get();
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
        $ItemCategorys = ItemCategory::when($this->searchByName !== '', function ($query) 
                                    {
                                        $query->where('name', 'like', '%' . $this->searchByName . '%');
                                    })
                                    // ->where('parent_id', null)
                                    ->orderBy('id', 'ASC')
                                    // ->where('is_active', 1)
                                    ->get();
                                    // ->paginate($this->paginateLimit);

        $data['ItemCategorys'] = $this->readyToLoad ? $this->PaginateData($ItemCategorys) : [];
        return $data;  

    }        
    public function HandledeleteSidebarOperation(ItemCategory $ItemCategory)
    {
        $SideBar->delete();    
        // $this->emit('refreshNotificationCount');
        // $this->emit('refreshNotificationList');
        $this->emit('sidebarUpdated');
        // $this->dispatchBrowserEvent('deleted_scene', ['name' => 'Sidebar']);
    }
    public function updateStatus(ItemCategory $ItemCategory, $toggle=0)
    {
        $ItemCategory->is_active = $toggle == 0 ? 0 : 1;
        $ItemCategory->save();
        // $this->emit('ItemCategoryUpdated');
    }  
    public function EditData(ItemCategory $ItemCategory)
    {
        $this->ItemCategory = $ItemCategory;
        $this->Collapse = 'uncollapse';
        $this->Update = true;        
        // $this->dispatchBrowserEvent('updateData');
    }
    public function DeleteCategory(ItemCategory $ItemCategory)
    {
        // dd('DeleteCategory');
        $name = $ItemCategory->name;
        $ItemCategory->delete();    
        $this->dispatchBrowserEvent('deleted_scene', ['name' => $name]);
    }
}