<?php

namespace App\Http\Livewire\Admin\Subcategory;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Admin\ecom_category;
use App\Traits\livewireComponentTraits\CategoryComponent;

class Index extends Component
{
    use WithPagination, WithFileUploads, CategoryComponent;
    protected $paginationTheme = 'bootstrap';
    public ecom_category $ecom_category;    
    protected $listeners = ['deleteSubCategoryManage' => 'deleteCategoryRecord', 'selectedColumns' => 'export'];
    
    public function mount(ecom_category $ecom_category)
    {
        $this->setMountData($ecom_category);
    }
    public function render()
    {
        $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        return view('livewire.admin.subcategory.index', $this->RenderData());
    }
    public function saveCategory()
    {
        $this->ecom_category = ReplaceStringAttributeValuesWithNull($this->ecom_category);

        if(!$this->update)
        {
            $this->validate();            
        }

        if ($this->photo) 
        {
            $filename = $this->photo->store('categories', 'public');                  
            $filenameOnly = basename($filename);
            $this->ecom_category->image = $filenameOnly;
            $this->ecom_category->image_path = 'categories/' . $filenameOnly;
        }

        $this->ecom_category->parent_id = $this->parent_category != null ? $this->parent_category : $this->ecom_category->parent_id;    
        $name = $this->ecom_category->name;
        $this->ecom_category->save();
        $this->photo = null;
        // $this->ecom_category = new ecom_category(); 

        $message = $this->update ? 'Updated' : 'Added'; 
        session()->flash('message','Sub Category '. $message . ' Successfully');
        // $this->resetInput(true);
        $this->dispatchBrowserEvent('created_module', ['name' => $name]);
        $this->Collapse = "collapse";

        if($this->update)
        {
            return redirect()->to('category-management/sub_category');
        }
    }

}
