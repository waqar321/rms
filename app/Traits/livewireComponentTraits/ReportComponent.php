<?php


namespace App\Traits\livewireComponentTraits;


use App\Models\Admin\Receipt;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
// use App\Exports\CategoriesExport;
use App\Exports\Exports;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\CommaSeparated;

trait ReportComponent
{
    use LivewireComponentsCommon;

    public Receipt $Receipt;
    public $searchByReceiptNo='';
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
        $this->availableColumns = ['ID', 'BIll No', 'Amount', 'Entry By', 'DATE'];
        // $this->update = request()->has('id') == true;
        $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
        $this->selectedRows = collect();
        $this->Receipt = new Receipt();
    }
    protected $rules =
    [
        'Receipt.name' => 'required',
        'Receipt.is_Receipt_product' => 'required',
        'Receipt.is_item_purchasing_category' => 'required',
        // 'Receipt.icon' => '',
        // 'Receipt.url' => '',
        // 'Receipt.order' => 'required',
        // 'IdNames' => '', //['required', new CommaSeparated],
        // 'ClassNames' => '', //['required', new CommaSeparated],
        // 'Receipt.is_active' => '',
        // 'Receipt.parent_id' => '',
    ];
    protected $messages =
    [
        'Receipt.required' => 'The Title is must required.',
        // 'Receipt.idNames' => 'please follow the format.',
        // 'Receipt.classNames' => 'please follow the format.',
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
        $idNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->Receipt->idNames);
        $classNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->Receipt->classNames);

        if (!$idNamesValid) {
            $this->addError('Receipt.idNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('Receipt.idNames');
        }

        if (!$classNamesValid) {
            $this->addError('Receipt.classNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('Receipt.classNames');
        }
    }
    public function setMountData($id=null)
    {
        $this->Receipt = $id != 0 ? Receipt::find($id) : new Receipt();

        // $this->Receipt = $Receipt ?? new Receipt();
        $this->pageTitle = 'Category Operation';
        $this->MainTitle = 'CategoryOperation';
        $this->paginateLimit = 100;
        // $this->parent_Receipts = Receipt::where('is_active', 1)->where('parent_id', null)->orderBy('order')->get();
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

           /*
            SELECT
                    DATE(receipt_items.created_at) AS sale_date,
                    SUM(receipt_items.item_sub_total) AS total_sale
                FROM receipts
                LEFT JOIN receipt_items
                    ON receipt_items.receipt_id = receipts.id
                GROUP BY DATE(receipt_items.created_at)
                ORDER BY sale_date DESC;
            */

        $Receipts = Receipt::when($this->searchByReceiptNo !== '', function ($query)
                                    {
                                        // $query->where('id', 'like', '%' . $this->searchByName . '%');
                                        $query->where('id', $this->searchByReceiptNo);
                                    })
                                    // ->where('parent_id', null)
                                    ->orderBy('id', 'ASC')
                                    // ->where('is_active', 1)
                                    ->get();
                                    // ->paginate($this->paginateLimit);

        $data['Receipts'] = $this->readyToLoad ? $this->PaginateData($Receipts) : [];
        return $data;

    }
    public function HandledeleteSidebarOperation(Receipt $Receipt)
    {
        $SideBar->delete();
        // $this->emit('refreshNotificationCount');
        // $this->emit('refreshNotificationList');
        $this->emit('sidebarUpdated');
        // $this->dispatchBrowserEvent('deleted_scene', ['name' => 'Sidebar']);
    }
    public function updateStatus(Receipt $Receipt, $toggle=0)
    {
        $Receipt->is_active = $toggle == 0 ? 0 : 1;
        $Receipt->save();
        // $this->emit('ReceiptUpdated');
    }
    public function updateReceipt(Receipt $Receipt, $toggle=0)
    {
        $Receipt->is_Receipt_product = $toggle == 0 ? 0 : 1;
        $Receipt->save();
        // $this->emit('ReceiptUpdated');
    }
    public function updateItemPurchasing(Receipt $Receipt, $toggle=0)
    {
        $Receipt->is_item_purchasing_category = $toggle == 0 ? 0 : 1;
        $Receipt->save();
        // $this->emit('ReceiptUpdated');
    }
    public function EditData(Receipt $Receipt)
    {
        $this->Receipt = $Receipt;
        $this->Collapse = 'uncollapse';
        $this->Update = true;
        // $this->dispatchBrowserEvent('updateData');
    }
    public function DeleteCategory(Receipt $Receipt)
    {
        // dd('DeleteCategory');
        $name = $Receipt->name;
        $Receipt->delete();
        $this->dispatchBrowserEvent('deleted_scene', ['name' => $name]);
    }
}
