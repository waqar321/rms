<?php

namespace App\Http\Livewire\Admin\UserManagement\User;

use Livewire\Component;
use App\Models\Admin\ecom_admin_user;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use App\Traits\livewireComponentTraits\UserManagement\UsersComponent;
    
class Index extends Component
{
    use WithPagination, WithFileUploads, UsersComponent;
    protected $paginationTheme = 'bootstrap';


    protected $listeners = [
                            'UpdateRoleIds' => 'handleUpdateRoleIds',
                            'UpdateCityID' => 'handleUpdateCityID',
                            'UpdateCountryID' => 'HandleUpdateCountryID',
                            'UpdateGenderID' => 'HandleUpdateGenderID',
                            'errorsDetected' => 'updateSelect2',
                            'deleteUserManage' => 'HandleDeleteUserManage',
                            'selectedColumns' => 'export',
                            'selectAll' => 'selectAllmethod',
                            'CheckIfRowSelected' => 'HanldeCheckIfRowSelected'
                        ];

    protected $queryString = [
        'sortBy' => ['except' => 'employee_id'],
        'sortDirection' => ['except' => 'asc'],
        'searchByEmployeeCode' => ['except' => '', 'as' => 's_C'],
        'searchByName' => ['except' => '', 'as' => 's_N'],
        'searchByEmployeeRole' => ['except' => '', 'as' => 's_R'],
        'searchByEmployeeDesignation' => ['except' => '', 'as' => 's_D'],
        'searchByEmployeeCity' => ['except' => '', 'as' => 's_Cy'],
    ];
    
    public function mount(ecom_admin_user $user)
    {
        $this->setMountData($user);
    }
    public function render()
    {
        $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        return view('livewire.admin.user-management.user.index', $this->RenderData());
    }
    public function saveUser()
    {
        if(!$this->update)
        {
            $this->validate();   
            $this->ecom_admin_user->password = Hash::make($this->password);         
        }
        else
        {
            if($this->password != null)
            {
                $this->validate([
                    'password' => 'required',
                    'confirm_password' => 'required|same:password',
                ]);          
            }
            $this->ecom_admin_user->password = Hash::make($this->password);
        }
        if($this->selected_city_id != null)
        {
            $this->ecom_admin_user->city_id = $this->selected_city_id;
        }
        
        $this->ecom_admin_user->user_type_id = 1;
        $this->ecom_admin_user->save();
        
        if(!empty($this->SelectedRolesIds))
        {
            $this->ecom_admin_user->roles()->sync($this->SelectedRolesIds);
        }
  

        $this->SelectedRolesIds = [];
        $name = $this->ecom_admin_user->full_name;
        $this->ecom_admin_user = new ecom_admin_user(); 

        session()->flash('message', $this->MainTitle.' '. $this->update ? 'Updated' : 'Added' . ' Successfully');
        $this->resetInput();
        $this->Collapse = "collapse";
        $this->dispatchBrowserEvent('created_module', ['name'=> $name]);
        $this->dispatchBrowserEvent('ResetDropDowns');

        if($this->update)
        {
            return redirect()->to('/manage_user');
        }
    }
    public function updateSelect2()
    {
        // $this->dispatchBrowserEvent('validationFailed');
        // $this->emit('validationFailed');  
    }
    public function handleUpdateRoleIds($FieldName, $value=[])
    {
        $this->SelectedRolesIds = $value;
        $this->Collapse = "uncollapse";
    }
    public function handleUpdateCityID($FieldName, $value)
    {
        $this->selected_city_id = $value;
        $this->Collapse = "uncollapse";
    }
    public function HandleUpdateCountryID($FieldName, $value)
    {
        $this->Collapse = "uncollapse";
        $this->ecom_admin_user->country_id = $value;
        // dd('selectedCountry:' .$value);
        // $this->ecom_admin_user->awd = $value;
    }
    public function HandleUpdateGenderID($FieldName, $value)
    {
        $this->Collapse = "uncollapse";
        $this->ecom_admin_user->gender = $value;
        // dd('selectedGender:' .$value);
        // $this->ecom_admin_user->awd = $value;
    }
    public function selectAllmethod($select)
    {
        if($select)
        {
            // foreach ($this->CurrentPaginatedUsers->take($this->paginateLimit) as $user) 
            foreach ($this->CurrentPaginatedUsers as $user) 
            {
                $this->selectedRows[$user->id] = true;
            }
        }
        else
        {
            $this->selectedRows = collect();
        }   
    }
    public function HanldeCheckIfRowSelected()
    {
        $this->dispatchBrowserEvent('exportFile', ['value' => $this->selectedRows->isEmpty()]);
    }
    public function selectAll()
    {
        foreach ($this->users as $user) {
            $this->selectedRows[$user->id] = true;
        }
    }
}

