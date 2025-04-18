<?php

namespace App\Http\Livewire\Admin\Pos;

use Livewire\Component;
use App\Models\Admin\ItemCategory;
use App\Models\Admin\Item;
use App\Models\Admin\Receipt;
use App\Models\Admin\ReceiptItem;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\PosComponent;
use Illuminate\Support\Facades\Redirect;

class Index extends Component
{
    use WithPagination, WithFileUploads, PosComponent;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
                            'deletetest' => 'deletetestRecord', 
                            'updateStatusOftest' => '', 
                            'selectedColumns' => 'export',
                            // 'CategoryOperation' => 'DeleteCategory'
                            'deletePOSOperation' => 'deleteReceipt'
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
    public function removeItem($item_id)
    {
        unset($this->cart[$item_id]);
        $this->totalItems--;

    }
 
    public function printOut()
    {
        $pos = [];

        if(count($this->cart) < 1)
        {
            $this->dispatchBrowserEvent('no_item_selected', ['message' => 'please select items to print!!']); // JS event to open in new tab
            return false;
        }

        $Receipt['total_amount'] = array_sum(array_column($this->cart, 'subtotal'));
        $Receipt['created_at'] = now();
        $Receipt['entry_by'] = auth()->user()->id;

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

        // dd($pos, $this->cart);

        session()->put('cart', $this->cart); // Pass data through session
        // return redirect()->route('print.receipt');
        $url = route('print.receipt'); // Build the URL
        $this->cart = [];
        $this->totalItems = 0;
        $this->subtotal = 0;
        $this->selectedCategory = null;


        $this->dispatchBrowserEvent('open-new-tab', ['url' => $url]); // JS event to open in new tab
        // return Redirect::route('pos.index');
        // $cart = $this->cart; // Contains your selected items
        // if (empty($cart)) {
        //     dd('Cart is empty');
        // }
        // return view('print_receipt', compact('cart'));
        // i have 

    }
    public function saveCategory()
    {
        $this->ItemCategory->save();
        $this->ItemCategory = new ItemCategory();
        $this->Collapse = 'uncollapse';

        if($this->Update)
        {
            $this->dispatchBrowserEvent('ItemCategoryUpdated', ['message' => 'Category updated succesfullyy!!']);
        }

        // dd($this->ItemCategory);

    }
}
