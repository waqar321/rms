<?php


namespace App\Traits\livewireComponentTraits;


use App\Models\Admin\Item;
use App\Models\Admin\ItemCategory;
use App\Models\Admin\UnitType;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
// use App\Exports\CategoriesExport;
use App\Exports\Exports;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\CommaSeparated; 

trait ItemComponent
{
    use LivewireComponentsCommon;

    public Item $Item;  
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
        $this->availableColumns = ['ID', 'Name', 'Order', 'Category', 'Description', 'Cost', 'Price', 'Stock', 'Unit Type', 'Image', 'Created By', 'Status', 'Action'];

        // $this->update = request()->has('id') == true;
        $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
        $this->selectedRows = collect();
        $this->Item = new Item();
    }

    protected $rules = [
        'Item.name' => 'required',
        'Item.category_id' => '',
        'Item.unit_type_id' => '',
        'Item.description' => '',
        'Item.price' => '',
        'Item.stock_quantity' => '',
        'Item.cost_price' => '',
        // 'Item.unit' => '',
        'Item.is_available' => '',
        'Item.image' => '',
        'Item.created_by' => '',
        'Item.order' => '',
        // 'Item.is_active' => '',
        // 'Item.order' => 'required',
        // 'IdNames' => '', //['required', new CommaSeparated], 
        // 'ClassNames' => '', //['required', new CommaSeparated], 
        // 'Item.is_active' => '',
        // 'Item.parent_id' => '',
    ];

    protected $messages = [
        'Item.required' => 'The Title is must required.',
        // 'Item.idNames' => 'please follow the format.',
        // 'Item.classNames' => 'please follow the format.',
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
        $idNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->Item->idNames);
        $classNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->Item->classNames);

        if (!$idNamesValid) {
            $this->addError('Item.idNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('Item.idNames');
        }

        if (!$classNamesValid) {
            $this->addError('Item.classNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('Item.classNames');
        }
    }
    public function setMountData($id=null)
    {
        $this->Item = $id != 0 ? Item::find($id) : new Item();
        
        // $this->Item = $Item ?? new Item();   
        $this->pageTitle = 'Item Operation';
        $this->MainTitle = 'ItemOperation';
        $this->paginateLimit = 30;
        $this->categories = ItemCategory::all();
        $this->unitTypes = UnitType::all();

        // $this->parent_Items = Item::where('is_active', 1)->where('parent_id', null)->orderBy('order')->get();
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
        $Items = Item::when($this->searchByName !== '', function ($query) 
                            {
                                $query->where('name', 'like', '%' . $this->searchByName . '%');
                            })
                            // ->where('parent_id', null)
                            ->orderBy('order', 'ASC')
                            // ->where('is_available', 1)
                            ->get();
                                    // ->paginate($this->paginateLimit);
        $data['Items'] = $this->readyToLoad ? $this->PaginateData($Items) : [];
        

        // dd($data['categories']);

        return $data;  

    }        
    public function HandledeleteSidebarOperation(Item $Item)
    {
        $SideBar->delete();    
        // $this->emit('refreshNotificationCount');
        // $this->emit('refreshNotificationList');
        $this->emit('sidebarUpdated');
        // $this->dispatchBrowserEvent('deleted_scene', ['name' => 'Sidebar']);
    }

    public function updateStatus(Item $Item, $toggle)
    {
        $Item->is_available = $toggle == 0 ? 0 : 1;
        $Item->save();
        // $this->emit('ItemUpdated');
    }  
    public function EditData(Item $Item)
    {
        $this->Item = $Item;
        $this->Collapse = 'uncollapse';
        $this->Update = true;   
        $this->RenderData();
        // dd($this->Item );     
        // $this->dispatchBrowserEvent('updateData');
    }
    public function DeleteItem(Item $Item)
    {
        // dd('DeleteCategory');
        $name = $Item->name;
        $Item->delete();    
        $this->dispatchBrowserEvent('deleted_scene', ['name' => $name]);
    }
    public function UpdateDropDowns($Field, $id)
    {
        if($Field == 'category')
        {
            $this->Item->category_id = (int)$id;
        }
        else if($Field == 'unittype')
        {
            $this->Item->unit_type_id = (int)$id;
            // dd((int)$id, $this->Item);

        }
        // $this->emit('refreshNotificationList');
        // $this->emit('sidebarUpdated');
        // $this->dispatchBrowserEvent('deleted_scene', ['name' => 'Sidebar']);
    }
}