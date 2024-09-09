<?php

namespace App\Http\Livewire\Admin\UserManagement\Permission;

use Livewire\Component;
use App\Models\permission;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\UserManagement\PermissionsComponent;
    
class Index extends Component
{
    use WithPagination, WithFileUploads, PermissionsComponent;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['deletePermissionManage' => 'HandleDeletePermissionManage'];

    public function mount(permission $permission)
    {
        $this->setMountData($permission);
    }
    public function render()
    {
        $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        return view('livewire.admin.user-management.permission.index', $this->RenderData());
    }
    public function savePermission()
    {
        if(!$this->update)
        {
            $this->validate();        
        }

        $this->Permission->save();

        $name = $this->Permission->title;
        $this->Permission = new Permission(); 

        session()->flash('message', $this->MainTitle.' '. $this->update ? 'Updated' : 'Added' . ' Successfully');
        $this->resetInput();
        $this->Collapse = "collapse";
        $this->dispatchBrowserEvent('created_module', ['name'=> $name]);
        $this->dispatchBrowserEvent('ResetDropDowns');

        if($this->update)
        {
            return redirect()->to('/manage_user/permissions/');
        }
    }
}
