<?php

namespace App\Http\Livewire\Admin\Ledger;

use Livewire\Component;
use App\Models\Admin\ItemCategory;
use App\Models\Admin\Item;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\LedgerComponent;
    
class Index extends Component
{
    use WithPagination, WithFileUploads, LedgerComponent;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
                            'deletetest' => 'deletetestRecord', 
                            'updateStatusOftest' => '', 
                            'selectedColumns' => 'export',
                            // 'CategoryOperation' => 'DeleteCategory'
                            'deleteCategoryOperation' => 'DeleteCategory',
                            'getItemAmount' => 'fetchItemAmount'
                        ];

    public function mount()
    {
        $this->setMountData();
        // dd('awdaw4444');
    }
    public function render()
    {

        $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        return view('livewire.admin.ledger.index', $this->RenderData());
    }
    public function fetchItemAmount($itemId)
    {
        // Fetch the selected item and its amount
        $item = Item::find($itemId);
        // dd($item);
        if ($item) 
        {
            $this->itemAmount = $item->cost_price;  // Assuming the `amount` column exists
        } 
        else 
        {
            $this->itemAmount = null;
        }
        $this->Collapse = 'uncollapse';

        $this->dispatchBrowserEvent('item_price', ['item_price' => $this->itemAmount]);
    }   

    public function saveCategory()
    {
        $this->ItemCategory->save();
        $this->ItemCategory = new ItemCategory();
        $this->Collapse = 'collapse';

        if($this->Update)
        {
            $this->dispatchBrowserEvent('ItemCategoryUpdated', ['message' => 'Category updated succesfullyy!!']);
        }

        // dd($this->ItemCategory);

    }
}
