<?php


namespace App\Traits\livewireComponentTraits;


use App\Models\Admin\Ledger;
use App\Models\Admin\Item;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
// use App\Exports\CategoriesExport;
use App\Exports\Exports;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\CommaSeparated; 

trait LedgerComponent
{
    use LivewireComponentsCommon;

    public Ledger $Ledger;  
    public $Update=false;
    public $items;

    public function __construct()
    {       
        $this->Tablename = 'ledger';        
        $this->availableColumns = ['ID', 'Payment Individual', 'Detail', 'Amount', 'Entry Date', 'Status', 'Action'];

        // $this->update = request()->has('id') == true;
        $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
        $this->selectedRows = collect();
        $this->Ledger = new Ledger();
    }

    protected $rules = [
        'Ledger.name' => 'required',
    ];
    protected $messages = [
        'Ledger.required' => 'The Title is must required.',
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
        $idNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->Ledger->idNames);
        $classNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->Ledger->classNames);

        if (!$idNamesValid) {
            $this->addError('Ledger.idNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('Ledger.idNames');
        }

        if (!$classNamesValid) {
            $this->addError('Ledger.classNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('Ledger.classNames');
        }
    }
    public function setMountData($id=null)
    {
        $this->Ledger = $id != 0 ? Ledger::find($id) : new Ledger();
        
        // $this->Ledger = $Ledger ?? new Ledger();   
        $this->pageTitle = 'Ledger Operation';
        $this->MainTitle = 'LedgerOperation';
        $this->paginateLimit = 100;
        
        $this->items = Item::where('category_id', 12)->pluck('name', 'id');
        // $this->vendors = User::whereHas('roles', function ($query) {
        //     $query->where('id', 15);
        // })->get();

        // dd($this->items);

    }
    protected function RenderData()
    {
        $Ledgers = Ledger::when($this->searchByName !== '', function ($query) 
                                    {
                                        $query->where('name', 'like', '%' . $this->searchByName . '%');
                                    })
                                    // ->where('parent_id', null)
                                    ->orderBy('id', 'ASC')
                                    // ->where('is_active', 1)
                                    ->get();
                                    // ->paginate($this->paginateLimit);


        $data['Ledgers'] = $this->readyToLoad ? $this->PaginateData($Ledgers) : [];
        return $data;  

    }        
    public function HandledeleteSidebarOperation(Ledger $Ledger)
    {
        $SideBar->delete();    
        // $this->emit('refreshNotificationCount');
        // $this->emit('refreshNotificationList');
        $this->emit('sidebarUpdated');
        // $this->dispatchBrowserEvent('deleted_scene', ['name' => 'Sidebar']);
    }
    public function updateStatus(Ledger $Ledger, $toggle=0)
    {
        $Ledger->is_active = $toggle == 0 ? 0 : 1;
        $Ledger->save();
        // $this->emit('VendorLedgerUpdated');
    }  
    public function EditData(Ledger $Ledger)
    {
        $this->Ledger = $Ledger;
        $this->Collapse = 'uncollapse';
        $this->Update = true;        
        // $this->dispatchBrowserEvent('updateData');
    }
    public function DeleteCategory(Ledger $Ledger)
    {
        // dd('DeleteCategory');
        $name = $Ledger->name;
        $Ledger->delete();    
        $this->dispatchBrowserEvent('deleted_scene', ['name' => $name]);
    }
}