<?php

namespace App\Http\Livewire\Admin\UnitType;

use Livewire\Component;
use App\Models\Admin\UnitType;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\UnitTypeComponent;
    
class Index extends Component
{
    use WithPagination, WithFileUploads, UnitTypeComponent;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
                            'deletetest' => 'deletetestRecord', 
                            'updateStatusOftest' => '', 
                            'selectedColumns' => 'export',
                            // 'CategoryOperation' => 'DeleteCategory'
                            'deleteUnitTypeOperation' => 'DeleteUnitType'
                        ];

    public function mount()
    {
        $this->setMountData();
        // dd('awdaw4444');
    }
    public function render()
    {

        $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        return view('livewire.admin.unit-type.index', $this->RenderData());
    }
    public function saveCategory()
    {
        $this->UnitType->save();
        $this->UnitType = new UnitType();
        $this->Collapse = 'collapse';

        if($this->Update)
        {
            $this->dispatchBrowserEvent('UnitTypeUpdated', ['message' => 'Category updated succesfullyy!!']);
        }

        // dd($this->UnitType);

    }
}
