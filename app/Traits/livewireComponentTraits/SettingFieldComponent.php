<?php


namespace App\Traits\livewireComponentTraits;


use App\Models\Admin\Setting;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
// use App\Exports\CategoriesExport;
use App\Exports\Exports;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\CommaSeparated;

trait SettingFieldComponent
{
    use LivewireComponentsCommon;

    public Setting $Setting;
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
        $this->availableColumns = ['ID', 'Title', 'Status', 'Action'];
        // $this->update = request()->has('id') == true;
        // $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
        $this->Collapse = 'uncollapse';
        $this->selectedRows = collect();
        $this->Setting = new Setting();
    }
    protected $rules =
    [
        'Setting.Brand_name' => '',
        'Setting.employee_discount' => '',
        'Setting.shift_starting_time' => '',
        'Setting.shift_ending_time' => '',
        // 'Setting.icon' => '',
        // 'Setting.url' => '',
        // 'Setting.order' => 'required',
        // 'IdNames' => '', //['required', new CommaSeparated],
        // 'ClassNames' => '', //['required', new CommaSeparated],
        // 'Setting.is_active' => '',
        // 'Setting.parent_id' => '',
    ];
    protected $messages = [
        'Setting.required' => 'The Title is must required.',
        // 'Setting.idNames' => 'please follow the format.',
        // 'Setting.classNames' => 'please follow the format.',
    ];
    public function resetInput($searchReset=false)
    {
        $this->searchByName = "";
    }
    public function updated($value)
    {
        if ($value == 'searchByName' || $value == 'paginateLimit')
        {
            $this->Collapse = "'uncollapse'";
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
        $idNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->Setting->idNames);
        $classNamesValid = preg_match('/^([a-zA-Z0-9]+, )*[a-zA-Z0-9]+$/', $this->Setting->classNames);

        if (!$idNamesValid) {
            $this->addError('Setting.idNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('Setting.idNames');
        }

        if (!$classNamesValid) {
            $this->addError('Setting.classNames', 'Invalid format. Accepted format: value1, value2, value3');
        } else {
            $this->resetErrorBag('Setting.classNames');
        }
    }
    public function setMountData($id=null)
    {
        // $this->Setting = $id != 0 ? Setting::find($id) : new Setting();
        $this->Setting = Setting::first();
        // $this->Setting = $Setting ?? new Setting();
        $this->pageTitle = 'Setting Operation';
        $this->MainTitle = 'SettingOperation';
        $this->paginateLimit = 30;

        // image
        // image_path
        // shift_starting_time
        // shift_ending_time

        // $this->parent_Settings = Setting::where('is_active', 1)->where('parent_id', null)->orderBy('order')->get();
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
        $Settings = Setting::when($this->searchByName !== '', function ($query)
                                    {
                                        $query->where('name', 'like', '%' . $this->searchByName . '%');
                                    })
                                    // ->where('parent_id', null)
                                    ->orderBy('id', 'ASC')
                                    // ->where('is_active', 1)
                                    ->get();
                                    // ->paginate($this->paginateLimit);


        $data['Settings'] = $this->readyToLoad ? $this->PaginateData($Settings) : [];
        return $data;

    }
    public function HandledeleteSidebarOperation(Setting $Setting)
    {
        $SideBar->delete();
        // $this->emit('refreshNotificationCount');
        // $this->emit('refreshNotificationList');
        $this->emit('sidebarUpdated');
        // $this->dispatchBrowserEvent('deleted_scene', ['name' => 'Sidebar']);
    }
    public function updateStatus(Setting $Setting, $toggle=0)
    {
        $Setting->is_active = $toggle == 0 ? 0 : 1;
        $Setting->save();
        $this->dispatchBrowserEvent('SettingUpdated', ['name' => 'Sidebar']);
    }
    public function EditData(Setting $Setting)
    {
        $this->Setting = $Setting;
        $this->Collapse = 'uncollapse';
        $this->Update = true;
        // $this->dispatchBrowserEvent('updateData');
    }
    public function DeleteSetting(Setting $Setting)
    {
        // dd('DeleteCategory');
        $name = $Setting->name;
        $Setting->delete();
        $this->dispatchBrowserEvent('deleted_scene', ['name' => $name]);
    }
}
