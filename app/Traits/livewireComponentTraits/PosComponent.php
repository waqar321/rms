<?php


namespace App\Traits\livewireComponentTraits;


use App\Models\Admin\Receipt;
use App\Models\Admin\Item;
use App\Models\User;
use App\Models\Admin\ItemCategory;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
// use App\Exports\CategoriesExport;
use App\Exports\Exports;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\CommaSeparated; 

trait PosComponent
{
    use LivewireComponentsCommon;

    public Receipt $Receipt;  
    public $cart; 
    public $totalItems=0; 
    public $subtotal=0; 
    public $selectedCategory; 
    public $searchByID; 
    public $showVendorDropdown = false;
    public $selectedVendor = null;
    public $vendors = []; // Load this from DB
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
        $this->availableColumns = ['ID', 'Items', 'Total Amount', 'Entry By', 'Slip Time', 'Action'];
        // $this->update = request()->has('id') == true;
        // $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
        $this->Collapse = 'uncollapse';
        $this->selectedRows = collect();
        $this->Receipt = new Receipt();
    }

    protected $rules = [
        // 'pos.' => 'required',
        // 'pos.icon' => '',
        // 'pos.url' => '',
        // 'pos.order' => 'required',
        // 'IdNames' => '', //['required', new CommaSeparated], 
        // 'ClassNames' => '', //['required', new CommaSeparated], 
        // 'pos.is_active' => '',
        // 'pos.parent_id' => '',
    ];
    protected $messages = [
        'pos.required' => 'The Title is must required.',
        // 'pos.idNames' => 'please follow the format.',
        // 'pos.classNames' => 'please follow the format.',
    ];
    public function resetInput($searchReset=false)
    {       
        $this->searchByName = "";
    }
    public function updated($value)
    {
        if ($value == 'searchByName' || $value == 'paginateLimit')
        {
            $this->Collapse = "uncollapse";
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
            // $this->validateOnly($value);
            $this->Collapse = "uncollapse";
        }
    }
    protected function validateIdAndClassNames()
    {
        $idNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->Receipt->idNames);
        $classNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->Receipt->classNames);

        if (!$idNamesValid) {
            $this->addError('pos.idNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('pos.idNames');
        }

        if (!$classNamesValid) {
            $this->addError('pos.classNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('pos.classNames');
        }
    }
    public function setMountData($id=null)
    {
        $this->Receipt = $id != 0 ? Receipt::find($id) : new Receipt();
        
        // $this->Receipt = $pos ?? new pos();   
        $this->pageTitle = 'POS Operation';
        $this->MainTitle = 'POSOperation';
        $this->paginateLimit = 50;
        $this->items = Item::orderBy('order', 'ASC')->get();
        $this->categories = ItemCategory::all();
        $this->cart = [];
        $this->selectedCategory = ItemCategory::first()->id;

        $this->vendors = User::whereHas('roles', function ($query) {
            $query->where('id', 15);
        })->get();

        // dd($this->vendors);

        // $this->parent_poss = pos::where('is_active', 1)->where('parent_id', null)->orderBy('order')->get();
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
        $Receipts = Receipt::when($this->searchByID !== null, function ($query) 
                                    {
                                        $query->where('id', 'like', '%' . $this->searchByID . '%');
                                    })
                                    // ->where('parent_id', null)
                                    ->orderBy('id', 'ASC')
                                    // ->where('is_active', 1)
                                    ->get();
                                    // ->paginate($this->paginateLimit);

        $data['Receipts'] = $this->readyToLoad ? $this->PaginateData($Receipts) : [];

        // if($this->readyToLoad)
        // {
        //     dd($data['Receipts']->getCollection());

        //     dd($totalSum);
        // }
        return $data;  

    }     
    public function showVendorBill()
    {
        $this->showVendorDropdown = true;
    }   
    public function addToVendorLedger()
    {
        // Perform saving logic here, e.g., create entry in vendor ledger
        // You can also store current cart info or subtotal

        if (!$this->selectedVendor) {
            $this->addError('selectedVendor', 'Please select a vendor.');
            return;
        }

        VendorLedger::create([
            'vendor_id' => $this->selectedVendor,
            'amount' => $this->subtotal, // assuming this exists in your component
            'details' => 'Auto-added from POS',
            'entry_date' => now(),
        ]);

        session()->flash('message', 'Amount added to Vendor Ledger.');
        $this->showVendorDropdown = false;
        $this->selectedVendor = null;
    }

    public function HandledeleteSidebarOperation(pos $pos)
    {
        $SideBar->delete();    
        // $this->emit('refreshNotificationCount');
        // $this->emit('refreshNotificationList');
        $this->emit('sidebarUpdated');
        // $this->dispatchBrowserEvent('deleted_scene', ['name' => 'Sidebar']);
    }
    public function updateStatus(pos $pos, $toggle=0)
    {
        $pos->is_active = $toggle == 0 ? 0 : 1;
        $pos->save();
        // $this->emit('posUpdated');
    }  
    public function EditData(pos $pos)
    {
        $this->Receipt = $pos;
        $this->Collapse = 'uncollapse';
        $this->Update = true;        
        // $this->dispatchBrowserEvent('updateData');
    }
    public function deleteReceipt(Receipt $Receipt)
    {
        // dd('DeleteCategory', $Receipt);

        $id = $Receipt->id;
        
        foreach ($Receipt->receiptItems as $receiptItem) 
        {
            $receiptItem->delete();
        }
        $Receipt->delete();    

        $this->dispatchBrowserEvent('deleted_scene', ['id' => $id]);
    }
}