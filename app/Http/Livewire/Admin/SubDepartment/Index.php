<?php

namespace App\Http\Livewire\Admin\SubDepartment;

use Livewire\Component;
use App\Models\Admin\ecom_department;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\DepartmentComponent;
    
class Index extends Component
{
    use WithPagination, WithFileUploads, DepartmentComponent;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['deleteSubDepartment' => 'deleteDepartmentRecord', 'updateStatusOftest' => '', 'selectedColumns' => 'export'];

    public function mount(ecom_department $ecom_department)
    {   

        $this->setMountData($ecom_department);
    }

    public function render()
    {
        $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        return view('livewire.admin.sub-department.index', $this->RenderData());
    }
}
