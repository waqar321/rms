<?php

namespace App\Http\Livewire\Admin\Report;

use Livewire\Component;
use App\Models\Admin\ItemCategory;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\ReportComponent;

class Index extends Component
{
    use WithPagination, WithFileUploads, ReportComponent;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
                            'deletetest' => 'deletetestRecord',
                            'updateStatusOftest' => '',
                            'selectedColumns' => 'export',
                            // 'CategoryOperation' => 'DeleteCategory'
                            'deleteCategoryOperation' => 'DeleteCategory'
                        ];

    public function mount()
    {
        $this->setMountData();
    }
    public function render()
    {

        $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        return view('livewire.admin.report.index', $this->RenderData());
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
