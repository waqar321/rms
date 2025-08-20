<?php


namespace App\Traits\livewireComponentTraits;


use App\Models\Admin\Receipt;
use App\Models\Admin\Expense;
use App\Models\Admin\Ledger;
use App\Models\Admin\ExpenseList;
use App\Models\User;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
// use App\Exports\CategoriesExport;
use App\Exports\Exports;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\CommaSeparated;
use Carbon\Carbon;
use App\Models\Admin\Item;

trait ExpenseComponent
{
    use LivewireComponentsCommon;

    public Expense $Expense;
    // public $parent_SideBars;
    // public $IdNames='';
    // public $ClassNames='';
    // public $SelectedPermissionIds=[];
    // public $selectPermissions = [];
    // public $SelectedPermissionId;
    // public $SelectedParentId;
    public $expenseItems;
    public $start;
    public $end;
    public $selected_item_id;
    public $selected_vendor_item_id;
    public $selected_user_id;
    public $show_items;
    public $Update=false;

    public function __construct()
    {
        $this->Tablename = 'ecom_notification';
        $this->availableColumns = ['ID', 'Item', 'Amount', 'Description', 'Entry Date', 'Status', 'Action'];
        // $this->update = request()->has('id') == true;
        // $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
        $this->Collapse = 'uncollapse';
        $this->selectedRows = collect();
        $this->Expense = new Expense();
    }
    protected $rules = [
        'Expense.item_id' => '',
        // 'Expense.amount' => '',
        'Expense.description' => '',
        'Expense.amount' => '',
        // 'Expense.name' => 'required',
        // 'Expense.url' => '',
        // 'Expense.order' => 'required',
        // 'IdNames' => '', //['required', new CommaSeparated],
        // 'ClassNames' => '', //['required', new CommaSeparated],
        // 'Expense.is_active' => '',
        // 'Expense.parent_id' => '',
    ];
    protected $messages = [
        'Expense.required' => 'The Title is must required.',
        // 'Expense.idNames' => 'please follow the format.',
        // 'Expense.classNames' => 'please follow the format.',
    ];
    public function resetInput($searchReset=false)
    {
        $this->searchByName = "";
    }
    public function updated($value)
    {
        if ($value == 'searchByName' || $value == 'paginateLimit')
        {
            $this->Collapse = "'uncollapse'";
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
        $idNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->Expense->idNames);
        $classNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->Expense->classNames);

        if (!$idNamesValid) {
            $this->addError('Expense.idNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('Expense.idNames');
        }

        if (!$classNamesValid) {
            $this->addError('Expense.classNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('Expense.classNames');
        }
    }
    public function setMountData($id=null)
    {
        $this->Expense = $id != 0 ? Expense::find($id) : new Expense();

        // $this->Expense = $Expense ?? new Expense();
        $this->pageTitle = 'Expense Operation';
        $this->MainTitle = 'ExpenseOperation';
        $this->paginateLimit = 50;
        // $this->parent_Expenses = Expense::where('is_active', 1)->where('parent_id', null)->orderBy('order')->get();
        // $this->permissionLists = Permission::pluck('title', 'id');
        $this->expenseItems = ExpenseList::pluck('name', 'id');

        $this->setBusinessTime();
        $this->payment_from = Carbon::today()->format('Y-m-d');
        $this->payment_to = Carbon::today()->format('Y-m-d');

        // dd($this->Expense->item_id);

        $this->users = User::whereHas('roles', function ($query)
                        {
                            // $query->where('id', $this->Ledger->role_id);
                            $query->where('id', 15);
                        })->pluck('name', 'id');

        $this->items = Item::pluck('name', 'id');

        $this->show_items = 'd-none';
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
        // $this->start = '2025-05-23 17:00:00';
        // $this->end = '2025-05-24 17:59:59';

        // $ledger_cash = Ledger::whereNull('receipt_id')->whereNull('purchase_id')->whereBetween('created_at', [$this->start, $this->end])->sum('total_amount');
        // $ledger_credit_sale = Ledger::whereNotNull('receipt_id')->whereBetween('created_at', [$this->start, $this->end])->sum('total_amount');
        // $total_sale = Receipt::whereBetween('created_at', [$this->start, $this->end])->sum('total_amount');

        $states = $this->getStats();

        $Expenses = Expense::when($this->searchByName !== '', function ($query)
                                {

                                    $item_ids = ExpenseList::where('name', 'like', '%' . $this->searchByName . '%')->pluck( 'name', 'id')->toArray();

                                    if(!empty($item_ids))
                                    {
                                        $query->whereHas('item', function ($sub_query) use ($item_ids)
                                        {
                                            $sub_query->whereIn('id', array_keys($item_ids));
                                        });
                                        // $query->whereIn('item_id', $item_ids);
                                    }

                                    // return $query->whereBetween('created_at', [$this->start, $this->end]);
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

        // dd($Receipts->sum('total_amount'));

        $data['Expenses'] = $this->readyToLoad ? $this->PaginateData($Expenses) : [];
        // $data['total_sale'] = $this->readyToLoad ? $total_sale : 0;
        // $data['ledger_cash'] = $this->readyToLoad ? $ledger_cash : 0;
        // $data['ledger_credit_sale'] = $this->readyToLoad ? $ledger_credit_sale : 0;
        $data['states'] = $this->readyToLoad ? $states : 0;
        return $data;

    }
    public function HandledeleteExpenseOperation(Expense $Expense)
    {
        $Expense->delete();
        // $this->emit('refreshNotificationCount');
        // $this->emit('refreshNotificationList');
        // $this->emit('sidebarUpdated');
        $this->dispatchBrowserEvent('deleted_scene', ['name' => 'Expense']);
    }
    public function updateStatus(Expense $Expense, $toggle=0)
    {
        $Expense->is_active = $toggle == 0 ? 0 : 1;
        $Expense->save();
        $this->dispatchBrowserEvent('ExpenseUpdated', ['name' => 'Sidebar']);
    }
    public function EditData(Expense $Expense)
    {
        $this->Expense = $Expense;
        // dd($this->Expense);
        $this->Collapse = 'uncollapse';
        $this->Update = true;
        // $this->dispatchBrowserEvent('updateData');
    }
    public function DeleteExpense(Expense $Expense)
    {
        // dd('DeleteCategory');
        $name = $Expense->name;
        $Expense->delete();
        $this->dispatchBrowserEvent('deleted_scene', ['name' => $name]);
    }
}
