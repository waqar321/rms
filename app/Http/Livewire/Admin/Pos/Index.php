<?php

namespace App\Http\Livewire\Admin\Pos;

use Livewire\Component;
use App\Models\Admin\ItemCategory;
use App\Models\Admin\Item;
use App\Models\Admin\Receipt;
use App\Models\Admin\ReceiptItem;
use App\Models\User;
use App\Models\Admin\Ledger;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\PosComponent;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination, WithFileUploads, PosComponent;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
                            'deletetest' => 'deletetestRecord',
                            'updateStatusOftest' => '',
                            'selectedColumns' => 'export',
                            // 'CategoryOperation' => 'DeleteCategory'
                            'deletePOSOperation' => 'deleteReceipt',
                            'UpdatePermissionIds' => 'UpdatingPermissionIds',
                            'UpdateVendorId' => 'HandleUpdateVendorId',
                            'ResetData' => 'HandleResetData'
                        ];

    public function mount()
    {
        session()->forget('cart');

        // dd('pos');
        $this->setMountData();
        // dd('awdaw4444');
    }
    public function render()
    {

        $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        return view('livewire.admin.pos.index', $this->RenderData());
    }
    public function selectCategory(ItemCategory $ItemCategory)
    {
        $this->selectedCategory = $ItemCategory->id;
    }
    public function UpdatingPermissionIds($data_id, $value)
    {
        $this->total_item_sale = 0;
        $this->total_quantity = 0;

        if($data_id == 'item_id')
        {
            $this->searchByItem_id = $value;

            $Receipts = Receipt::when($this->searchByID !== null, function ($query)
                                                    {
                                                        $query->where('id', 'like', '%' . $this->searchByID . '%');
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
                                                    ->whereBetween('created_at',[$this->start, $this->end])
                                                    ->orderBy('id', 'DESC')
                                                    ->with(['receiptItems'])
                                                    ->get();
            // dd( $Receipt);
            foreach($Receipts as $Receipt)
            {
                foreach($Receipt->receiptItems as $receiptItem)
                {
                    if($receiptItem->item_id == $this->searchByItem_id)
                    {
                        // dd($receiptItem);
                        $item_total = $receiptItem->item_qty * $receiptItem->item_price;
                        $this->total_item_sale += $item_total;
                        $this->total_quantity += $receiptItem->item_qty;
                    }
                }
            }

            // dd($this->total_item_sale);
            // $this->total_item_sale = 20;
        }
        else if($data_id == 'category_id')
        {
            $this->searchByCategory_id = $value;

            // dd(Receipt::count());
             $Receipts = Receipt::when($this->searchByID !== null, function ($query)
                                                    {
                                                        $query->where('id', 'like', '%' . $this->searchByID . '%');
                                                    })
                                                    ->when($this->searchByCategory_id !== null, function ($query)
                                                    {

                                                        // $item = Item::where('name', 'like', '%' . $this->searchByItem_id . '%')->first();
                                                        $Category = ItemCategory::where('id', $this->searchByCategory_id)->first();

                                                        if($Category)
                                                        {
                                                            $item_ids = Item::where('category_id', $Category->id)->pluck('id')->toArray();
                                                            $query->whereHas('receiptItems', function ($sub_query) use ($item_ids)
                                                            {
                                                                $sub_query->whereIn('item_id', $item_ids);
                                                            });
                                                        }

                                                        // $query->where('id', 'like', '%' . $this->searchByItem . '%');
                                                    })
                                                    ->whereBetween('created_at', [$this->start, $this->end])
                                                    ->orderBy('id', 'DESC')
                                                    ->with(['receiptItems'])
                                                    ->get();

            // dd($Receipts->count());

            foreach($Receipts as $Receipt)
            {
                foreach($Receipt->receiptItems as $receiptItem)
                {
                    // if($receiptItem->item->category_id == $this->searchByCategory_id)
                    if($receiptItem->item->category_id == $this->searchByCategory_id)
                    {
                        $item_total = $receiptItem->item_qty * $receiptItem->item_price;
                        $this->total_item_sale += $item_total;
                        $this->total_quantity += $receiptItem->item_qty;
                        // $this->total_item_sale += $receiptItem->item->price;
                    }
                }
            }

        }

        // dd($data_id, $value);
    }
    public function addItem(Item $item)
    {
        $item->load(['Category', 'unit_type']);
        $item_array = $item->toArray();
        $item_array['qty'] = 1;
        $this->subtotal = $this->subtotal + $item_array['price'];
        $item_array['subtotal'] = (int)$item_array['price'];
        $this->totalItems++;
        $this->cart[$item->id] = $item_array;

        // dd($this->cart);
    }
    public function decreaseQty($item_id)
    {
        if($this->cart[$item_id]['qty'] > 0)
        {
            $this->cart[$item_id]['qty']--;
            $this->cart[$item_id]['subtotal'] = $this->cart[$item_id]['qty'] * $this->cart[$item_id]['price'];
            $this->subtotal = $this->subtotal - $this->cart[$item_id]['price'];
        }
    }
    public function increaseQty($item_id)
    {
        // if($this->cart[$item_id]['qty'] > 0)
        // {
            $this->cart[$item_id]['qty']++;
            $this->cart[$item_id]['subtotal'] = $this->cart[$item_id]['qty'] * $this->cart[$item_id]['price'];
            $this->subtotal = $this->subtotal + $this->cart[$item_id]['price'];
        // }

    }
    public function HandleResetData()
    {
        $this->RenderData();
    }
    public function removeItem(Item $item)
    {
        $item_quantity = $this->cart[$item->id]['qty'];
        unset($this->cart[$item->id]);
        $item_amounts = $item_quantity * $item->price;
        $this->subtotal  = $this->subtotal - $item_amounts;
        $this->totalItems--;
    }
    public function printOut()
    {
        $pos = [];

        // $this->Ledger = new Ledger();
        // $this->Ledger->role_id = User::find($this->user_id)->roles->first()->id;
        // $this->Ledger->user_id =  $this->user_id;
        // $this->Ledger->receipt_id = 333;
        // $this->Ledger->payment_type = 'Sale';  //vendor id
        // $this->Ledger->cash_amount = 300;
        // $this->Ledger->total_amount = 300;
        // $this->Ledger->payment_detail = 'entry from POS';  //vendor id
        // $this->Ledger->created_at = now();  //vendor id
        // $this->Ledger->save();
        // dd($this->Ledger);

        // dd(User::find($this->user_id)->roles->first()->id);
        // $this->Collapse = 'collapse';

        if($this->showVendorDropdown)
        {
            if($this->user_id == null || $this->user_id == '')
            {
                $this->dispatchBrowserEvent('no_user_error', ['name' => 'Sidebar']);
                return false;
            }
        }

        // dd($this->cart);
        if(count($this->cart) < 1)
        {
            $this->dispatchBrowserEvent('no_item_selected', ['message' => 'please select items to print!!']); // JS event to open in new tab
            return false;
        }

        $Receipt['total_amount'] = array_sum(array_column($this->cart, 'subtotal'));
        $Receipt['created_at'] = now();
        $Receipt['entry_by'] = auth()->user()->id;
        // dd($Receipt);

        $Receipt = Receipt::create($Receipt);

        foreach($this->cart as $item_detail)
        {
            // dd($item_detail['id']);

            $Receipt_items[] = [
                        'receipt_id' => $Receipt->id,
                        'item_id' => $item_detail['id'],
                        'item_price' => $item_detail['price'],
                        'item_qty' => $item_detail['qty'],
                        'item_sub_total' => $item_detail['subtotal'],
                        'created_at' => now()
                    ];
        }


        // Receipt
        // total_amount
        // entry_by

        ReceiptItem::insert($Receipt_items);

        if($this->showVendorDropdown)
        {
            if($this->user_id != null || $this->user_id != '')
            {
                $Ledger = Ledger::where('user_id', $this->user_id)
                                ->orderBy('id', 'desc')
                                ->first();


                $this->Ledger = new Ledger();
                $this->Ledger->role_id = User::find($this->user_id)->roles->first()->id;
                $this->Ledger->user_id =  $this->user_id;
                $this->Ledger->receipt_id = $Receipt->id;
                $this->Ledger->payment_type = 'Sale';  //vendor id
                $this->Ledger->cash_amount = $Receipt['total_amount'] ?? 0.0;
                $this->Ledger->total_amount = $Receipt['total_amount'] ?? 0.0;
                $this->Ledger->payment_detail = 'entry from POS';  //vendor id

                if(isset($this->Ledger) && $Ledger->remaining_amount != 0)
                {
                    $new_remaining_amount = $Ledger->remaining_amount + $Receipt['total_amount'];
                    $this->Ledger->remaining_amount = $new_remaining_amount;
                }

                $this->Ledger->created_at = now();  //vendor id
                $this->Ledger->save();
            }
            $this->showVendorDropdown = false;
        }

        // dd($pos, $this->cart);

        session()->put('cart', $this->cart); // Pass data through session
        // return redirect()->route('print.receipt');
        $url = route('print.receipt'); // Build the URL
        $this->cart = [];
        $this->totalItems = 0;
        $this->subtotal = 0;
        $this->vendor_id = null;
        $this->selectedCategory = null;

        $this->dispatchBrowserEvent('open-new-tab', ['url' => $url]); // JS event to open in new tab

    }
    public function RowReceiptPrintOut(Receipt $Receipt)
    {
        $this->dispatchBrowserEvent('open-new-tab', ['url' => GetItemDetailsForPrinting($Receipt, true)]); // JS event to open in new tab
    }
    public function HandleUpdateVendorId($type, $user_id)
    {

        if($type == 'User_id')
        {
            $this->user_id = $user_id;
        }
    }
    public function saveCategory()
    {
        $this->ItemCategory->save();
        $this->ItemCategory = new ItemCategory();
        // $this->Collapse = 'uncollapse';

        if($this->Update)
        {
            $this->dispatchBrowserEvent('ItemCategoryUpdated', ['message' => 'Category updated succesfullyy!!']);
        }

        // dd($this->ItemCategory);

    }
}
