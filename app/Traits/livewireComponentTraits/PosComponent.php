<?php


namespace App\Traits\livewireComponentTraits;


use App\Models\Admin\Expense;
use App\Models\Admin\Receipt;
use App\Models\Admin\Item;
use App\Models\User;
use App\Models\Admin\ItemCategory;
use App\Models\Admin\VendorLedger;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;

trait PosComponent
{
    use LivewireComponentsCommon;

    public Receipt $Receipt;
    public $cart;
    public $totalItems=0;
    public $subtotal=0;

    public $selectedCategory;
    public $searchByID;
    public $searchByItemName;
    public $searchByItem_id;
    public $searchByCategory_id;
    public $total_quantity=0;

    public $items;
    public $start;
    public $end;
    public $payment_from;
    public $payment_to;
    public $vendor_id;
    public $user_id;
    public $showVendorDropdown = false;
    public $selectedVendor = null;
    public $vendors = []; // Load this from DB
    public $item_ids = [];
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
        else if($value == 'searchByItemName')
        {

            // $this->searchByItemName = $value;
            // dd(Receipt::count());



            if ($this->searchByItemName !== null)
            {
                $this->item_ids = Item::where('name', 'like', '%' . $this->searchByItemName . '%')->pluck('id')->toArray();
            }

            $Receipts = Receipt::when($this->searchByItemName !== null, function ($query)
                                {

                                    // $item_ids = Item::where('name', 'like', '%' . $this->searchByItemName . '%')->pluck('id')->toArray();
                                    // $item = Item::where('id', $this->searchByItemName)->first();
                                    // dd($item_ids);
                                    if(!empty($item_ids))
                                    {
                                        $query->whereHas('receiptItems', function ($sub_query)
                                        {
                                            $sub_query->whereIn('item_id', $this->item_ids);
                                        });
                                    }
                                    // dd($item_ids);
                                    // $query->where('id', 'like', '%' . $this->searchByItem . '%');
                                })
                                ->whereBetween('created_at', [$this->start, $this->end])
                                ->orderBy('id', 'DESC')
                                ->with(['receiptItems'])
                                ->get();

            // dd($Receipts->count(), $item_ids);

            foreach($Receipts as $Receipt)
            {
                foreach($Receipt->receiptItems as $receiptItem)
                {
                    // if($receiptItem->item->category_id == $this->searchByCategory_id)
                    if(in_array($receiptItem->item->id, $this->item_ids))
                    {
                        $item_total = $receiptItem->item_qty * $receiptItem->item_price;
                        $this->total_item_sale += $item_total;
                        $this->total_quantity += $receiptItem->item_qty;
                        // $this->total_item_sale += $receiptItem->item->price;
                    }
                }
            }
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
        // dd('awdawd');
        $this->Receipt = $id != 0 ? Receipt::find($id) : new Receipt();

        // $this->Receipt = $pos ?? new pos();
        $this->pageTitle = 'POS Operation';
        $this->MainTitle = 'POSOperation';
        $this->paginateLimit = 200;
        // $this->items = Item::where('is_active', 1)->orderBy('order', 'ASC')->get();
        $this->items = Item::where('is_pos_product', 1)->where('is_active', 1)->orderBy('order', 'ASC')->get();
        // $this->categories = ItemCategory::whereNotIn('id', [12, 13, 14, 15, 16, 17])->orderBy('order', 'ASC')->get();
        $this->categories = ItemCategory::where('is_pos_product', 1)->where('is_active', 1)->orderBy('order', 'ASC')->get();
        $this->cart = [];
        $this->selectedCategory = ItemCategory::first()->id;

        // $this->users = User::where('id', '!=', 1)->pluck('name', 'id')->toArray();
        $this->users = User::all()->pluck('name', 'id')->toArray();
        // dd($this->users);
        // $this->vendors = User::whereHas('roles', function ($query) {
        //                     $query->where('id', 15);
        //                 })->get();


        $this->setBusinessTime();

        // $this->items = Item::where('category_id', 12)->pluck('name', 'id');
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

        $states = $this->getStats();

        $Receipts = Receipt::when($this->searchByID !== null, function ($query)
                                {
                                    $query->where('id', $this->searchByID);
                                    // $query->where('id', 'like', '%' . $this->searchByID . '%');

                                })
                                ->when($this->searchByItemName !== null, function ($query)
                                {

                                    $item_ids = Item::where('name', 'like', '%' . $this->searchByItemName . '%')->pluck('id')->toArray();
                                    // $item = Item::where('id', $this->searchByItemName)->first();
                                    // dd($item_ids);
                                    if(!empty($item_ids))
                                    {
                                        $query->whereHas('receiptItems', function ($sub_query) use ($item_ids)
                                        {
                                            $sub_query->whereIn('item_id', $item_ids);
                                        });
                                    }

                                    // dd($item_ids);
                                    // $query->where('id', 'like', '%' . $this->searchByItem . '%');
                                })
                                ->when($this->searchByItem_id !== null, function ($query)
                                {

                                    // $item = Item::where('name', 'like', '%' . $this->searchByItem_id . '%')->first();
                                    $item = Item::where('id', $this->searchByItem_id)->first();

                                    if($item)
                                    {
                                        $query->whereHas('receiptItems', function ($sub_query) use ($item)
                                        {
                                            $sub_query->where('item_id', $item->id);
                                        });
                                    }

                                    // $query->where('id', 'like', '%' . $this->searchByItem . '%');
                                })
                                ->when($this->searchByCategory_id !== null, function ($query)
                                {
                                    // $item = Item::where('name', 'like', '%' . $this->searchByItem_id . '%')->first();
                                    $Category = ItemCategory::where('id', $this->searchByCategory_id)->first();

                                    if($Category)
                                    {
                                        $item_ids = Item::where('category_id', $Category->id)->pluck('id');

                                        $query->whereHas('receiptItems', function ($sub_query) use ($item_ids)
                                        {
                                            $sub_query->whereIn('item_id', $item_ids);
                                        });
                                    }

                                    // $query->where('id', 'like', '%' . $this->searchByItem . '%');
                                })
                                ->when($this->searchByID == null, function ($query)
                                {
                                    if($this->payment_from == null)
                                    {
                                        $query->whereBetween('created_at', [$this->start, $this->end]);
                                    }
                                    else
                                    {
                                        $query->whereBetween('created_at', [$this->payment_from, $this->payment_to]);
                                    };
                                })
                                // ->where('parent_id', null)
                                ->orderBy('id', 'DESC')
                                // ->where('is_active', 1)
                                ->get();
                                    // ->paginate($this->paginateLimit);

        $Expenses = Expense::orderBy('id', 'DESC')
                            ->whereBetween('created_at', [$this->start, $this->end])
                            ->get();

        $data['Receipts'] = $this->readyToLoad ? $this->PaginateData($Receipts) : [];
        $data['Expenses'] = $this->readyToLoad ? $Expenses : 0;

        if($this->readyToLoad)
        {
            $data['states'] = $states;
        }
        else
        {
            $data['states'] = 0;
        }

        // if($this->readyToLoad)
        // {
        //     dd($data['Receipts']->getCollection());

        //     dd($totalSum);
        // }
        return $data;

    }
    public function showVendorBill()
    {
        if(empty($this->cart))
        {
             $this->dispatchBrowserEvent('cart_empty', ['name' => 'Sidebar']);
            // $this->addError('selectedVendor', 'Please add item to cart.');
            return;
        }

        $this->showVendorDropdown = true;
        $this->dispatchBrowserEvent('show_users', ['name' => 'Sidebar']);
    }
    // public function updateselectedVendor()
    // {
    //     dd("awdawd");
    // }
    public function addToVendorLedger()
    {
        // Perform saving logic here, e.g., create entry in vendor ledger
        // You can also store current cart info or subtotal

        if(empty($this->cart))
        {
             $this->dispatchBrowserEvent('cart_empty', ['name' => 'Sidebar']);
            // $this->addError('selectedVendor', 'Please add item to cart.');
            return;
        }

        // if (!$this->selectedVendor)
        // {
        //     $this->addError('selectedVendor', 'Please select a vendor.');
        //     return;
        // }

        // dd('vendor bill', $this->cart);

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
