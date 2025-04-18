<?php


namespace App\Traits\livewireComponentTraits;



use App\Models\Admin\Customer;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
// use App\Exports\CategoriesExport;
use App\Exports\Exports;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\CommaSeparated; 

trait CustomerComponent
{
    use LivewireComponentsCommon;

    public Customer $Customer;  
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
        $this->Customer = new Customer();
    }

    protected $rules = [
        'Customer.name'         => '',
        'Customer.phone'        => '',
        'Customer.email'        => '',
        'Customer.address'      => '',
        'Customer.city'         => '',
        'Customer.cnic'         => '',
        'Customer.gender'       => '',
        'Customer.dob'          => '',
        'Customer.total_spent'  => '',
        'Customer.visits'       => '',
        'Customer.is_active'    => '',
    ];
    
    
    protected $messages = [
        'Customer.required' => 'The Title is must required.',
        // 'Customer.idNames' => 'please follow the format.',
        // 'Customer.classNames' => 'please follow the format.',
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
        $idNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->Customer->idNames);
        $classNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->Customer->classNames);

        if (!$idNamesValid) {
            $this->addError('Customer.idNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('Customer.idNames');
        }

        if (!$classNamesValid) {
            $this->addError('Customer.classNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('Customer.classNames');
        }
    }
    public function setMountData($id=null)
    {
        $this->Customer = $id != 0 ? Customer::find($id) : new Customer();
        
        // $this->Customer = $Customer ?? new Customer();   
        $this->pageTitle = 'Customer Operation';
        $this->MainTitle = 'CustomerOperation';
        $this->paginateLimit = 10;
        // $this->parent_Customers = Customer::where('is_active', 1)->where('parent_id', null)->orderBy('order')->get();
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
        $Customers = Customer::when($this->searchByName !== '', function ($query) 
                                    {
                                        $query->where('name', 'like', '%' . $this->searchByName . '%');
                                    })
                                    // ->where('parent_id', null)
                                    ->orderBy('id', 'ASC')
                                    // ->where('is_active', 1)
                                    ->get();
                                    // ->paginate($this->paginateLimit);
        
        $data['Customers'] = $this->readyToLoad ? $this->PaginateData($Customers) : [];

        // if($this->readyToLoad)
        // {
        //     dd($data['Customers']);
        // }

        return $data;  

    }        
    public function HandledeleteSidebarOperation(Customer $Customer)
    {
        $SideBar->delete();    
        // $this->emit('refreshNotificationCount');
        // $this->emit('refreshNotificationList');
        $this->emit('sidebarUpdated');
        // $this->dispatchBrowserEvent('deleted_scene', ['name' => 'Sidebar']);
    }
    public function updateStatus(Customer $Customer, $toggle=0)
    {
        $Customer->is_active = $toggle == 0 ? 0 : 1;
        $Customer->save();
        // $this->emit('CustomerUpdated');
    }  
    public function EditData(Customer $Customer)
    {
        $this->Customer = $Customer;
        $this->Collapse = 'uncollapse';
        $this->Update = true;        
        // $this->dispatchBrowserEvent('updateData');
    }
    public function DeleteCategory(Customer $Customer)
    {
        // dd('DeleteCategory');
        $name = $Customer->name;
        $Customer->delete();    
        $this->dispatchBrowserEvent('deleted_scene', ['name' => $name]);
    }
}