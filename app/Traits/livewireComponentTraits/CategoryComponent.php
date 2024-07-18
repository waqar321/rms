<?php


namespace App\Traits\livewireComponentTraits;


use App\Models\Admin\ecom_category;
use App\Models\Admin\ecom_admin_user;
use App\Models\testingExport\Product;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;

use App\Repositories\Interfaces\CategoryRepositoryInterface;

//export excels
// use App\Exports\CategoriesExport;
use App\Exports\Exports;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;

use DB;


trait CategoryComponent
{
    use LivewireComponentsCommon;

    public $photo;
    public $parent_category;
    public $subCategory=false;
    public ecom_category $ecom_category;    
    public Collection $parent_categories;    
    // public Collection $selectedRows;

    public $availableColumns;
    public $c = [];

    public function __construct()
    {            
        $this->Tablename = 'ecom_category';    
        $this->availableColumns = ['ID', 'Category', 'Image',  'Parent Category', 'Date', 'Status', 'Actions'];
        $this->selectedRows = collect();

        // $this->parent_categories = ecom_category::where('parent_id', null)->get();

        $this->update = request()->has('id') == true;
        $this->subCategory = request()->segment(2) === 'sub_category';
        $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
        $this->rules['parent_category'] = $this->subCategory && !$this->update ? 'required' : '';
    }
    public function resetInput($searchReset=false)
    {
        if($this->subCategory)
        {
            $this->parent_category = '';
        }
        
        if($searchReset)
        {
            $this->searchByName = '';
            $this->selectedRows = collect();
        }
        else
        {
            // $this->ecom_category->name = '';
            $this->ecom_category = new ecom_category();
            $this->photo = null;
        }
    }
    protected $rules = [
        'ecom_category.parent_id' => '',
        'ecom_category.name' => 'required|min:2|unique:ecom_category',
        // 'photo' => 'required|image|mimes: jpg,jpeg,png,svg,gif|max:2048'
        'photo' => '',
    ];
    // protected $messages = [
    //     'ecom_category.parent_id.required' => 'The parent Category is must required.',
        // 'ecom_category.name.required' => 'The '.$this->pageTitle.' cannot be empty.',
        // 'ecom_category.name.unique' => 'The Category already exists, Please add new One!!',
        // 'ecom_category.name.min:2' => 'The name length must be greater than 2.',
        // 'photo.required' => 'The image is required,',
        // 'ecom_category.address.min:2' => 'The address length must be greater than 2.',
    // ];

    public function updated($field)
    {

        if($field == 'photo')
        {
            $this->Collapse = "uncollapse";
            $this->validate([
                'photo' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:50000'
            ]);            
        }
        else
        {
            if($field == 'searchByName' || strpos($field, 'selectedRows') !== false)
            {
                $this->Collapse = "collapse";
            }
            else
            {
                $this->Collapse = "uncollapse";
            }

            $this->validateOnly($field);
        }
    }
    public function GetData($tablename, $columns) 
    {   
        // dd($columns);
        return DB::table($tablename)->where( $columns['column1'], $columns['column1Value'] ? '!=' : '=', null)
                                    ->when($columns['column2Value'] !== '', function ($query) use ($columns) {
                                        $query->where($columns['column2'], 'like', '%' . $columns['column2Value'] . '%');
                                    }) 
                                    ->orderBy('id', 'DESC')
                                    ->get();
                                    // ->paginate(3);

    }   
    protected function RenderData()
    {
        $loadCategories = ecom_category::where('parent_id', $this->subCategory ? '!=' : '=', null)
                                            ->when($this->searchByName !== '', function ($query) {
                                                $query->where('name', 'like', '%' . $this->searchByName . '%');
                                            }) 
                                            ->orderBy('id', 'DESC')
                                            // ->paginate(3);
                                            ->get();        

        $data['categoryListing'] = $this->readyToLoad ? $this->PaginateData($loadCategories) : [];

        // $data['categoryListing'] = $this->readyToLoad ? $loadCategories : [];
        // $data['products'] = $this->readyToLoad ? Product::take(1220000)->orderBy('id', 'DESC')->paginate(10) : [];
        return $data;      
    }
    public function deleteCategoryRecord(ecom_category $ecom_category)
    {
        if(isset($ecom_category->image) && !empty($ecom_category->image))
        {
            if (file_exists(public_path('storage/categories/') . $ecom_category->image)) 
            {
                unlink(public_path('storage/categories/') . $ecom_category->image); 
            }
            // Storage::delete('categories/'.$ecom_category->image);
        }
        $ecom_category->delete();    

        $this->dispatchBrowserEvent('deleted_scene', ['name' => $ecom_category->name]);
    }
    public function updateStatus(ecom_category $ecom_category, $toggle)
    {
        $ecom_category->is_active = $toggle == 0 ? 0 : 1;
        $ecom_category->save();
        $this->dispatchBrowserEvent('status_updated', ['name' => $ecom_category->name]);
    }
    public function setMountData($ecom_category)
    {
        $this->ecom_category = $ecom_category ?? new ecom_category();   
        
        // $this->pageTitle = request()->segment(2) == 'category' ? 'Add New Category' : 'Add New Sub Category';
        // $this->MainTitle = request()->segment(2) == 'category' ? 'Category' : 'SubCategory';

        $this->pageTitle = request()->segment(2) == 'category' ? 'Category Manage' : 'SubCategory Manage';
        $this->MainTitle = request()->segment(2) == 'category' ? 'CategoryManage' : 'SubCategoryManage';
        $this->paginateLimit = 10;
        // added here becuase was not able to set at  protected $messages = [
        $this->messages = [
            'ecom_category.parent_id.required' => 'The parent Category is must required.',
            'ecom_category.name.required' => 'The ' . explode(" ", $this->pageTitle)[0]   . ' cannot be empty.',
            'ecom_category.name.unique' => 'The ' . explode(" ", $this->pageTitle)[0]   . '  already exists, Please add new One!!',
            'ecom_category.name.min:2' => 'The ' . explode(" ", $this->pageTitle)[0]   . '  length must be greater than 2.',
            'photo.required' => 'The image is required,',
            'ecom_category.address.min:2' => 'The address length must be greater than 2.'
        ];


        $this->parent_categories = ecom_category::where('parent_id', null)->get();

        return true;
    }   
}