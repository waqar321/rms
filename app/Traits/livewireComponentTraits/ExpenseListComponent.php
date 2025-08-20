<?php


namespace App\Traits\livewireComponentTraits;


use App\Models\Admin\ExpenseList;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
// use App\Exports\CategoriesExport;
use App\Exports\Exports;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\CommaSeparated;

trait ExpenseListComponent
{
    use LivewireComponentsCommon;

    public ExpenseList $ExpenseList;
    // public $parent_SideBars;
    // public $IdNames='';
    // public $ClassNames='';
    // public $SelectedPermissionIds=[];
    // public $selectPermissions = [];
    // public $SelectedPermissionId;
    // public $SelectedParentId;
    public $Update=false;

    public function __construct()
    {
        $this->Tablename = 'ecom_notification';
        $this->availableColumns = ['ID', 'Title', 'Action'];
        // $this->update = request()->has('id') == true;
        $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
        $this->selectedRows = collect();
        $this->ExpenseList = new ExpenseList();
    }
    protected $rules = [
        'ExpenseList.name' => 'required',
        // 'ExpenseList.icon' => '',
        // 'ExpenseList.url' => '',
        // 'ExpenseList.order' => 'required',
        // 'IdNames' => '', //['required', new CommaSeparated],
        // 'ClassNames' => '', //['required', new CommaSeparated],
        // 'ExpenseList.is_active' => '',
        // 'ExpenseList.parent_id' => '',
    ];
    protected $messages = [
        'ExpenseList.required' => 'The Title is must required.',
        // 'ExpenseList.idNames' => 'please follow the format.',
        // 'ExpenseList.classNames' => 'please follow the format.',
    ];
    public function resetInput($searchReset=false)
    {
        $this->searchByName = "";
    }
    public function updated($value)
    {
        if ($value == 'searchByName' || $value == 'paginateLimit')
        {
            $this->Collapse = "collapse";
        }
        else if ($value == 'IdNames')
        {
            if (!preg_match('/^([\w-]+,? ?)*[\w-]+$/', $this->IdNames))
            {
                $this->addError('IdNames', 'Invalid format. Accepted format: value1, value2, value3');
            }
            $this->Collapse = "uncollapse";
        }
        else if ($value == 'ClassNames')
        {
            if (!preg_match('/^([\w-]+,? ?)*[\w-]+$/', $this->ClassNames))
            {
                $this->addError('ClassNames', 'Invalid format. Accepted format: value1, value2, value3');
            }
            $this->Collapse = "uncollapse";

        }
        else
        {
            $this->validateOnly($value);
            $this->Collapse = "uncollapse";
        }
    }
    protected function validateIdAndClassNames()
    {
        $idNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->ExpenseList->idNames);
        $classNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->ExpenseList->classNames);

        if (!$idNamesValid) {
            $this->addError('ExpenseList.idNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('ExpenseList.idNames');
        }

        if (!$classNamesValid) {
            $this->addError('ExpenseList.classNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('ExpenseList.classNames');
        }
    }
    public function setMountData($id=null)
    {
        $this->ExpenseList = $id != 0 ? ExpenseList::find($id) : new ExpenseList();

        // $this->ExpenseList = $ExpenseList ?? new ExpenseList();
        $this->pageTitle = 'ExpenseItem Operation';
        $this->MainTitle = 'ExpenseItemOperation';
        $this->paginateLimit = 200;
        // $this->parent_ExpenseList = ExpenseList::where('is_active', 1)->where('parent_id', null)->orderBy('order')->get();
        // $this->permissionLists = Permission::pluck('title', 'id');

        // dd($this->parent_SideBars);

        // foreach ($this->permissionLists as $key => $roles)
        // {
        //     // if(in_array($key, old('roles', [])) || (isset($user) && $user->roles->contains($key))
        //     if(in_array($key, old('permissions', [])) || (isset($this->role)) && $this->role->permissions->contains($key))
        //     {
        //         $this->selectPermissions[] = $key;
        //     }
        // }
        // $this->Updatet
    }
    protected function RenderData()
    {
        $ExpenseList = ExpenseList::when($this->searchByName !== '', function ($query)
                                    {
                                        $query->where('name', 'like', '%' . $this->searchByName . '%');
                                    })
                                    // ->where('parent_id', null)
                                    ->orderBy('id', 'DESC')
                                    // ->where('is_active', 1)
                                    ->get();
                                    // ->paginate($this->paginateLimit);

        $data['ExpenseLists'] = $this->readyToLoad ? $this->PaginateData($ExpenseList) : [];
        return $data;

    }
    public function HandledeleteExpenseItemOperation(ExpenseList $ExpenseList)
    {
        // dd($ExpenseList);
        $ExpenseList->delete();
        // $this->emit('refreshNotificationCount');
        // $this->emit('refreshNotificationList');
        // $this->emit('sidebarUpdated');
        $this->RenderData();
        $this->dispatchBrowserEvent('deleted_scene', ['name' => 'Expense Item']);
    }
    public function updateStatus(ExpenseList $ExpenseList, $toggle=0)
    {
        $ExpenseList->is_active = $toggle == 0 ? 0 : 1;
        $ExpenseList->save();
        // $this->emit('ExpenseList');
    }
    public function EditData(ExpenseList $ExpenseList)
    {
        $this->ExpenseList = $ExpenseList;
        $this->Collapse = 'uncollapse';
        $this->Update = true;
        // $this->dispatchBrowserEvent('updateData');
    }
    public function DeleteCategory(ExpenseList $ExpenseList)
    {
        // dd('DeleteCategory');
        $name = $ExpenseList->name;
        $ExpenseList->delete();
        $this->dispatchBrowserEvent('deleted_scene', ['name' => $name]);
    }
}
