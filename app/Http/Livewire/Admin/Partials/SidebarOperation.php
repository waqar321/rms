<?php

namespace App\Http\Livewire\Admin\Partials;

use Livewire\Component;
use App\Models\Admin\SideBar;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\SidebarComponent;


class SidebarOperation extends Component
{
    use WithPagination, WithFileUploads, SidebarComponent;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
                                'deleteSidebarOperation' => 'HandledeleteSidebarOperation', 
                                'updateStatusOftest' => '', 
                                'UpdatePermissionId' => 'HandleUpdatePermissionId', 
                                'UpdateParentId' => 'HandleUpdateParentId', 
                                'selectedColumns' => 'export',
                                'deleteSideBarManage' => 'handleSidebarDelete', 
                            ];
                            
    public function mount($id)
    {
        $this->update = $id != 0 ? true : false;
        $this->setMountData($id);
        $this->pageTitle = 'SideBar Manage';
        $this->MainTitle = 'SideBarManage';

    }
    public function render()
    {
        if($this->update)
        {
            $this->Collapse = "uncollapse";
        }
        else
        {
            $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        }

        return view('livewire.admin.partials.sidebar-operation', $this->RenderData());
    }
    public function updateOrder($list)
    {
        // foreach($list as $item) 
        // {
        //     SideBar::find($item['value'])->update(['order' => $item['order']]);
        // }
    }    

    public function SaveSidebar()
    {
        if(!$this->update)
        {
            $this->validate();            
        }

        $this->SideBar->is_active = 1;
        // $this->SideBar->IdNames = ['menu1', 'menu2'];    // side-bar-menus
        // $this->SideBar->ClassNames = ['menu1', 'menu2']; // side-bar-menus
        $this->SideBar->IdNames = explode(', ', $this->IdNames); // side-bar-menus
        $this->SideBar->ClassNames = explode(', ', $this->ClassNames); // side-bar-menus        
        
        // dd($this->SelectedParentId, $this->SelectedPermissionId);

        // dd(var_dump($this->SelectedPermissionId));

        if($this->SelectedPermissionId != null)
        {
            if($this->update)
            {   
                $this->SideBar->update(['permission_id' => $this->SelectedPermissionId]);
            }
            else
            {
                $this->SideBar->permission_id = $this->SelectedPermissionId;
            }
        }

        if($this->SelectedParentId != null)
        {
            if($this->update)
            {   
                $this->SideBar->update(['parent_id' => $this->SelectedParentId]);
            }
            else
            {
                $this->SideBar->parent_id = $this->SelectedParentId;
            }
        }

        // dd($this->SideBar , $this->SelectedPermissionId, $this->SelectedPermissionId != null, $this->SelectedParentId, $this->SelectedParentId != null);

        $this->SideBar->save();

        $name = $this->SideBar->title;
        $this->SideBar = new SideBar(); 
        $this->SelectedPermissionId = null;
        $this->SelectedParentId = null;

        session()->flash('message', $this->MainTitle.' '. $this->update ? 'Updated' : 'Added' . ' Successfully');
        $this->resetInput();
        $this->dispatchBrowserEvent('created_module', ['name' => $name]);
 
        // $this->emit('sidebarUpdated');
        // $this->dispatchBrowserEvent('sidebar_created');
        $this->Collapse = "collapse";

        if($this->update)
        {
            return redirect()->to('sidebar');
        }
    }
    public function hydrate()
    {
        $this->emit('select2');
    }
    public function HandleUpdatePermissionId($fieldname, $value)
    {
        $this->SelectedPermissionId = $value;
        $this->Collapse = "uncollapse";
    }
    public function HandleUpdateParentId($fieldname, $value)
    {
        // dd('parent selected');
        $this->SelectedParentId = $value;
        $this->Collapse = "uncollapse";
    }
    public function handleSidebarDelete(SideBar $sidebar)
    {
        $name = $sidebar->title;
        $sidebar->delete();   
        $this->dispatchBrowserEvent('deleted_scene', ['name' => $name]);
    }
}
