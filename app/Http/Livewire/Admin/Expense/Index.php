<?php

namespace App\Http\Livewire\Admin\Expense;

use Livewire\Component;
use App\Models\Admin\expense;
use App\Models\Admin\ExpenseList;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\ExpenseComponent;
use Illuminate\Support\Facades\Redirect;

class Index extends Component
{
    use WithPagination, WithFileUploads, ExpenseComponent;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
                            'deletetest' => 'deletetestRecord',
                            'updateStatusOftest' => '',
                            'selectedColumns' => 'export',
                            // 'CategoryOperation' => 'DeleteCategory'
                            'updateItemId' => 'HandleupdateItemId',
                            'deleteExpenseOperation' => 'HandledeleteExpenseOperation'
                        ];

    public function mount()
    {
        // dd('expense');
        $this->setMountData();
        // dd('awdaw4444');
    }
    public function render()
    {
        // $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        $this->Collapse = "uncollapse";
        return view('livewire.admin.expense.index', $this->RenderData());
    }
    public function saveExpense()
    {
        // dd($this->selected_item_id != null, $this->Expense->item_id != null);

        if($this->selected_user_id != null)
        {
            $this->Expense->user_id = $this->selected_user_id;
            $this->selected_user_id = null;
        }


        if($this->selected_item_id != null)
        {
            $this->Expense->item_id = $this->selected_item_id;
            $this->selected_item_id = null;
        }
        else if($this->Expense->item_id != null)
        {
            $ExpenseList = new ExpenseList();
            $ExpenseList->name = $this->Expense->item_id;
            $ExpenseList->save();

            $this->Expense->item_id = $ExpenseList->id;
        }

        // dd($this->Expense);

        $this->Expense->save();
        $this->Expense = new Expense();
        $this->Collapse = 'uncollapse';

        if($this->Update)
        {
            $this->dispatchBrowserEvent('expenseUpdated', ['message' => 'Category updated succesfullyy!!']);
        }
        return Redirect::route('expense');
        // dd($this->Expense);

    }
    public function HandleupdateItemId($type, $id)
    {
        // dd($type, $item_id);

        if($type == 'user_id')
        {
            $this->selected_user_id = $id;
            $this->show_items = '';
        }
        else if($type == 'user_expense_item')
        {
            $this->selected_item_id = $id;
        }
    }
}
