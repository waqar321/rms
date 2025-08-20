<?php


namespace App\Traits\livewireComponentTraits;


use App\Models\Admin\Ledger;
use App\Models\Admin\Item;
use App\Models\User;
use App\Models\Role;
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
    public $user_payment = 'debit';
    public $user_role_show;
    public $payment_type_show;
    public $show_vendors;
    public $show_items;
    public $payment_detail_show;
    public $selected_role_id;
    public $selected_user_id;
    public $selected_item_id;
    public $selected_payment_id;
    public $unit_price_read_only='';

    public function __construct()
    {
        $this->Tablename = 'ledger';

        $this->availableColumns = [
                                    'ID',
                                    'Role',
                                    'User',
                                    'Payment Type',
                                    'Item',
                                    'Amount',
                                    'Item Qty',
                                    // 'Price',
                                    'Total Amount',
                                    'Remaing Amount',
                                    'Amount Added',
                                    'Receipt ID',
                                    'Purchase ID',
                                    'Payment Detail',
                                    'Payment Status',
                                    'Entry Date',
                                    // 'Status',
                                    'Action'
                                ];

        // $this->update = request()->has('id') == true;
        $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
        $this->selectedRows = collect();
        $this->Ledger = new Ledger();
    }

    protected $rules = [
        // 'Ledger.name' => '',
        'Ledger.cash_amount' => '',
        'Ledger.unit_price' => '',
        'Ledger.unit_qty' => '',
        'Ledger.total_amount' => '',
        'Ledger.payment_type' => '',
        'Ledger.payment_detail' => '',
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
        // dd($value);

        if ($value == 'searchByName' || $value == 'paginateLimit')
        {
            $this->Collapse = "collapse";
        }
        else if($value == 'Ledger.cash_amount')
        {
            $this->Ledger->total_amount = $this->Ledger->cash_amount;
        }
        // else if($value == 'Ledger.cash_amount')
        // {
        //     $this->Ledger->total_amount = $this->Ledger->cash_amount;
        // }
        else if($value == 'Ledger.unit_qty')
        {
            $this->Ledger->total_amount = $this->Ledger->unit_price * $this->Ledger->unit_qty;
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
    public function setMountData()
    {
        // $this->Ledger = $id != 0 ? Ledger::find($id) : new Ledger();
        // dd($this->Ledger);
        // $this->Ledger = $Ledger ?? new Ledger();
        $this->pageTitle = 'Ledger Operation';
        $this->MainTitle = 'LedgerOperation';
        $this->paginateLimit = 100;
        $this->setBusinessTime();

        if(request()->has('customer_id'))
        {
            $customer_id = $request->customer_id;
            // dd($customer_id);
            // $ledger = Ledger::find(base64_decode($request->id));
            return view('Admin/Ledger/index', compact('customer_id'));
        }
        // dd(isset($this->Ledger->id), !isset($this->Ledger->id));

        if(!isset($this->Ledger->id))
        {
            $this->payment_type_show = 'd-none';
            $this->show_users = 'd-none';
            $this->show_items = 'd-none';
            $this->cash_amount_show = 'd-none';
            $this->unit_price_show = 'd-none';
            $this->unit_qty_show = 'd-none';
            $this->total_amount_show = 'd-none';
            $this->payment_detail_show = 'd-none';
            // $this->Collapse = 'uncollapse';
            $this->items = collect();
            $this->users = collect();
        }
        else
        {
            $this->payment_type_show = '';
            $this->show_users = '';
            $this->cash_amount_show = '';
            $this->total_amount_show = '';

            if($this->Ledger->item_id != null)
            {
                $this->show_items = '';
                $this->unit_price_show = '';
                $this->unit_qty_show = '';
            }
            else
            {
                $this->show_items = 'd-none';
                $this->unit_price_show = 'd-none';
                $this->unit_qty_show = 'd-none';
            }

            $this->payment_detail_show = '';
            $this->Collapse = 'uncollapse';
            // $this->items = collect();
            $this->items = Item::pluck('name', 'id');
            // $this->users = collect();
            $this->users = User::whereHas('roles', function ($query)
                            {
                                $query->where('id', $this->Ledger->role_id);
                            })->pluck('name', 'id');
        }
        // $this->user_role_show = 'd-none';

        // $users = User::whereHas('roles', function ($query)
        //             {
        //                 $query->where('id', $this->selected_role_id);
        //             })->pluck('name', 'id');

        // dd($users, User::with(['roles'])->get());
        // $this->Ledger->cash_amount = 0;
        // $this->Ledger->unit_price = 0;
        // $this->Ledger->unit_qty = 0;
        // $this->Ledger->total_amount = 0;
        // $this->Ledger->payment_detail = 0;

        // $this->items = Item::where('category_id', 12)->pluck('name', 'id');
        $this->roles = Role::where('id', '!=',  1)->pluck('title', 'id');
        // dd(Role::pluck('title', 'id')->toArray());
        // $this->vendor = User::whereHas('roles', function ($query) {
            //     $query->where('id', 15);
            // })->get();


        // dd($this->items);

    }
    protected function RenderData()
    {
        // $this->start = '2025-05-23 17:00:00';
        // $this->end = '2025-05-24 17:59:59';

        $states = $this->getStats();

        $Ledgers = Ledger::when($this->searchByName !== '', function ($query)
                                {

                                    $item_ids = User::where('name', 'like', '%' . $this->searchByName . '%')->pluck( 'name', 'id')->toArray();

                                    if(!empty($item_ids))
                                    {
                                        $query->whereHas('user', function ($sub_query) use ($item_ids)
                                        {
                                            $sub_query->whereIn('id', array_keys($item_ids));
                                        });
                                        // $query->whereIn('item_id', $item_ids);
                                    }
                                    // $query->where('name', 'like', '%' . $this->searchByName . '%');
                                })
                                ->when($this->searchByName == '' || $this->searchByName == null, function ($query)
                                {
                                    $query->whereBetween('created_at', [$this->start, $this->end]);
                                })
                                    // ->where('parent_id', null)
                                ->orderBy('id', 'DESC')
                                // ->whereBetween('created_at', [$this->start, $this->end])
                                    // ->where('is_active', 1)
                                ->get();
                                    // ->paginate($this->paginateLimit);


        $data['Ledgers'] = $this->readyToLoad ? $this->PaginateData($Ledgers) : [];
        $data['states'] = $this->readyToLoad ? $states : 0;
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
        $Ledger->is_paid = $toggle == 0 ? 0 : 1;
        $Ledger->save();
        // $this->emit('VendorLedgerUpdated');
    }
    public function EditData(Ledger $Ledger)
    {
        $this->Ledger = $Ledger;
        $this->Collapse = 'uncollapse';
        $this->Update = true;
        $this->dispatchBrowserEvent('updateData');

    }
    public function DeleteCategory(Ledger $Ledger)
    {
        // dd('DeleteCategory');
        $name = $Ledger->name;
        $Ledger->delete();
        $this->dispatchBrowserEvent('deleted_scene', ['name' => $name]);
    }
}
