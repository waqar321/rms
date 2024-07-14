<?php

namespace App\Http\Livewire\Admin\UserManagement\Role;

use Livewire\Component;
use App\Models\Admin\Role;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\UserManagement\RolesComponent;
use Illuminate\Support\Facades\Hash;

class Index extends Component
{
    use WithPagination, WithFileUploads, RolesComponent;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
                            'UpdatePermissionIds' => 'handleUpdatePermissionIds',
                            'UpdateCityID' => 'handleUpdateCityID',
                            'errorsDetected' => 'updateSelect2',
                            'deleteRoleManage' => 'HandleDeleteRoleManage'
                        ];

    public function mount(Role $role)
    {
        $this->setMountData($role);
    }
    public function render()
    {
        $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        return view('livewire.admin.user-management.role.index', $this->RenderData());
    }
    public function saveRole()
    {

        if(!$this->update)
        {
            $this->validate();   
            // $this->ecom_admin_user->password = Hash::make($this->password);         
        }

        $this->role->save();
        
        if(!empty($this->SelectedPermissionIds))
        {
            $this->role->permissions()->sync($this->SelectedPermissionIds);
        }
        
        $this->SelectedPermissionIds = [];
        $name = $this->role->title;
        $this->role = new role(); 


        session()->flash('message', $this->MainTitle.' '. $this->update ? 'Updated' : 'Added' . ' Successfully');
        $this->resetInput();
        $this->Collapse = "collapse";
        $this->dispatchBrowserEvent('created_module', ['name'=> $name]);
        $this->dispatchBrowserEvent('ResetDropDowns');

        $this->emit('sidebarUpdated');

        if($this->update)
        {
            return redirect()->to('/manage_user/roles/');
        }
    }
    public function handleUpdatePermissionIds($FieldName, $value=[])
    {
        $this->SelectedPermissionIds = $value;
        $this->Collapse = "uncollapse";

    }
}
