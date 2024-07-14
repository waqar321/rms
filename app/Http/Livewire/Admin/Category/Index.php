<?php

namespace App\Http\Livewire\Admin\Category;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Admin\ecom_category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use FilesystemIterator;
use App\Traits\livewireComponentTraits\CategoryComponent;
use App\Models\testingExport\Product;


class Index extends Component
{
    use WithPagination, WithFileUploads, CategoryComponent;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['deleteCategoryManage' => 'deleteCategoryRecord', 'updateStatusOfCategory' => '', 'selectedColumns' => 'export'];
    public $testing="unchanged";
    public $testingLoading;

    // public Collection $categories1;  

    public function mount(ecom_category $ecom_category)
    {
        // $loadCategories = ecom_category::all();        
        // dd($loadCategories);
        // dd(Product::find(1));

        // Product::take(100000)->get()
        // $this->testingLoading = Product::take(100000)->get();
        $this->setMountData($ecom_category);
    }
    public function render()
    {
        $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        
        return view('livewire.admin.category.index', $this->RenderData());
    }

    public function loadTestData()
    {
        // $this->testingLoading = Product::all();
        $this->testingLoading = Product::take(100000)->get();
    }
    
    public function saveCategory()
    {
        if(!$this->update)
        {
            $this->validate();            
        }

        if ($this->photo) 
        {
            $this->validate([
                'photo' => 'required|image|mimes: jpg,jpeg,png,svg,gif|max:100'
            ]);  

            $filename = $this->photo->store('categories', 'public');   // Store the image in the 'categories' folder of the public disk
            $filenameOnly = basename($filename);
            $this->ecom_category->image = $filenameOnly;
            $this->ecom_category->image_path = 'categories/' . $filenameOnly;
        }
        
        $this->ecom_category->save();
        $name = $this->ecom_category->name;
        $this->photo = null;
        $this->ecom_category = new ecom_category(); 

        session()->flash('message', $this->MainTitle.' '. $this->update ? 'Updated' : 'Added' . ' Successfully');
        $this->resetInput();
        $this->dispatchBrowserEvent('created_module', ['name' => $name]);
        $this->Collapse = "collapse";

        if($this->update)
        {
            return redirect()->to('category-management/category');
        }
  
    }
}
 