<?php

namespace App\Http\Livewire\Admin\Item;

use Livewire\Component;
use App\Models\Admin\Item;
use App\Models\Admin\ItemCategory;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\ItemComponent;

class Index extends Component
{
use WithPagination, WithFileUploads, ItemComponent;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
                            'deletetest' => 'deletetestRecord',
                            'updateStatusOftest' => '',
                            'selectedColumns' => 'export',
                            'deleteItemOperation' => 'DeleteItem',
                            'UpdateDropDowns' => 'UpdateDropDowns'
                        ];

    public function mount()
    {

        $this->setMountData();
        // dd('awdaw4444');
    }
    public function render()
    {
        // dd(Item::all());

        $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        return view('livewire.admin.item.index', $this->RenderData());
    }
    public function saveItem()
    {
        if ($this->photo)
        {
            // $this->validate([
            //     'photo' => 'required|image|mimes: jpg,jpeg,png,svg,gif|max:100'
            // ]);

            $filename = $this->photo->store('items', 'public');   // Store the image in the 'categories' folder of the public disk
            $filenameOnly = basename($filename);
            $this->Item->image = $filenameOnly;
            $this->Item->image_path = 'items/' . $filenameOnly;
        }

        $this->Item->is_available = 1;
        $this->Item->created_by = auth()->user()->id;
        $this->Item->save();

        $this->Item = new Item();
        $this->photo = null;
        $this->Collapse = 'collapse';

        if($this->Update)
        {
            $this->dispatchBrowserEvent('ItemUpdated', ['message' => 'Item updated succesfully!!']);
        }

        // dd($this->Item);

    }
    public function updateStatus(Item $Item, $toggle=0)
    {
        $Item->is_active = $toggle == 0 ? 0 : 1;
        $Item->save();
        // dd($Item, $toggle);
        // $this->emit('ItemUpdated');
        $this->dispatchBrowserEvent('ItemUpdated', ['name' => 'Item Updated Succesfully']);
    }
    public function updatePOS(Item $Item, $toggle=0)
    {
        $Item->is_pos_product = $toggle == 0 ? 0 : 1;
        $Item->save();
        // $this->emit('ItemUpdated');
        $this->dispatchBrowserEvent('ItemUpdated', ['name' => 'Item Updated Succesfully']);
    }
    public function updateItemPurchasing(Item $Item, $toggle=0)
    {
        $Item->is_item_purchasing_product = $toggle == 0 ? 0 : 1;
        $Item->save();
        // $this->emit('ItemUpdated');
        $this->dispatchBrowserEvent('ItemUpdated', ['name' => 'Item Updated Succesfully']);
    }
}
