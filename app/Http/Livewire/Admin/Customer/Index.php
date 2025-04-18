<?php

namespace App\Http\Livewire\Admin\Customer;

use Livewire\Component;
use App\Models\Admin\Customer;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\CustomerComponent;
    
class Index extends Component
{
    use WithPagination, WithFileUploads, CustomerComponent;
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
        // dd('awdaw4444');
    }
    public function render()
    {

        $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        
        return view('livewire.admin.customer.index', $this->RenderData());
    }
    public function saveCategory()
    {
        $this->Customer->save();
        $this->Customer = new Customer();
        $this->Collapse = 'collapse';

        if($this->Update)
        {
            $this->dispatchBrowserEvent('CustomerUpdated', ['message' => 'Category updated succesfullyy!!']);
        }

        // dd($this->Customer);

    }
}
