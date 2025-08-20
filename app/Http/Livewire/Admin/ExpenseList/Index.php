<?php

namespace App\Http\Livewire\Admin\ExpenseList;

use Livewire\Component;
use App\Models\Admin\ExpenseList;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\ExpenseListComponent;

class Index extends Component
{
    use WithPagination, WithFileUploads, ExpenseListComponent;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
                            'deletetest' => 'deletetestRecord',
                            'updateStatusOftest' => '',
                            'selectedColumns' => 'export',
                            // 'CategoryOperation' => 'DeleteCategory'
                            'deleteCategoryOperation' => 'DeleteCategory',
                            'deleteExpenseItemOperation' => 'HandledeleteExpenseItemOperation'
                        ];

    public function mount()
    {
        // dd('awdaw4444');
        $this->setMountData();
    }
    public function render()
    {

        $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        return view('livewire.admin.expense-list.index', $this->RenderData());
    }
    public function saveExpenseItem()
    {
        // dd( $this->ExpenseList);
        $this->ExpenseList->save();
        $this->ExpenseList = new ExpenseList();
        $this->Collapse = 'collapse';

        if($this->Update)
        {
            $this->dispatchBrowserEvent('ExpenseListUpdated', ['message' => 'Category updated succesfullyy!!']);
        }

        // dd($this->ExpenseList);

    }
}
