<?php

namespace App\Http\Livewire\Admin\ItemCategory;

use Livewire\Component;
use App\Models\Admin\ItemCategory;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\ItemCategoryComponent;

class Index extends Component
{
    use WithPagination, WithFileUploads, ItemCategoryComponent;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
                            'deletetest' => 'deletetestRecord',
                            'updateStatusOftest' => '',
                            'selectedColumns' => 'export',
                            // 'CategoryOperation' => 'DeleteCategory'
                            'deleteCategoryOperation' => 'DeleteCategory',
                            'UpdateCategoryIds' => 'HandleCategoryIds'
                        ];

    public function mount()
    {
        $this->setMountData();
        // dd('awdaw4444');
    }
    public function render()
    {

        $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        return view('livewire.admin.item-category.index', $this->RenderData());
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
    public function HandleCategoryIds($data_id, $value)
    {
        if($data_id == 'category_type_id')
        {
            $this->category_type = $value;
        }
    }
}
