<?php


namespace App\Traits\livewireComponentTraits;


use App\Models\Admin\ecom_department;
use App\Models\Admin\ecom_admin_user;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;

//export excels
use App\Exports\Exports;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

trait DepartmentComponent
{
    use LivewireComponentsCommon;

    public $photo;
    public $parent_department;
    public $subDepartment=false;
    public ecom_department $ecom_department;    
    public Collection $parent_departments;    
    // public Collection $selectedRows;

    public $availableColumns;
    
    public $c = [];

    public function __construct()
    {  
        // for export tables 
        $this->Tablename = 'ecom_department';        
        $this->selectedRows = collect();
        $this->availableColumns = ['ID', 'Department', 'Parent Department', 'Date Created', 'Status', 'Actions'];

        if (!collect(request()->segments())->contains('sub_department')) 
        {
            $this->availableColumns = array_diff($this->availableColumns, ['Parent Department']);
        }

        $this->update = request()->has('id') == true;
        $this->subDepartment = collect(request()->segments())->contains('sub_department');        
        $this->pageTitle = collect(request()->segments())->contains('sub_department') ? 'Add New Sub Department' : 'Add New Department';
        $this->MainTitle = collect(request()->segments())->contains('sub_department') ? 'SubDepartment' : 'Department';
        
        $this->Collapse = $this->update ? 'uncollapse' : 'collapse';
        $this->rules['parent_department'] = $this->subDepartment && !$this->update ? 'required' : '';
    }
    public function setMountData($ecom_department)
    {
        $this->ecom_department = $ecom_department ?? new ecom_department();   
        $this->parent_departments = ecom_department::where('parent_id', null)->get();
    }   
    protected function RenderData()
    {
        // $this->testingLoading = Product::all();        ;
        // $data['testingLoading1'] = Product::all();  
        $departments = ecom_department::where('parent_id', $this->subDepartment ? '!=' : '=', null)
                                            ->when($this->searchByName !== '', function ($query) {
                                                $query->where('name', 'like', '%' . $this->searchByName . '%');
                                            }) 
                                            ->orderBy('id', 'DESC')
                                            ->paginate(10);    

        $data['departmentListing'] = $this->readyToLoad ? $departments : [];    
        return $data;      
    }
    public function resetInput($searchReset=false)
    {
        if($this->subDepartment)
        {
            $this->parent_department = '';
        }
        
        if($searchReset)
        {
            $this->searchByName = '';
            $this->selectedRows = collect();
        }
        else
        {
            $this->ecom_department = new ecom_department();
            // $this->photo = null;
        }
    }
    protected $rules = [
        'ecom_department.name' => 'required|min:2|unique:ecom_department',
        'ecom_department.office_location' => 'required|min:2',
        // 'photo' => 'required|image|mimes: jpg,jpeg,png,svg,gif|max:2048'
        // 'photo' => '',
    ];
    protected $messages = [
        'ecom_department.parent_id.required' => 'The parent Department is must required.',
        'ecom_department.name.required' => 'The name cannot be empty.',
        'ecom_department.name.unique' => 'The Department already exists, Please add new One!!',
        'ecom_department.name.min:2' => 'The name length must be greater than 2.',
        'ecom_department.office_location.required' => 'The Department Office Location Cannot Be Empty!!.',
        // 'photo.required' => 'The image is required,',
        // 'ecom_department.address.min:2' => 'The address length must be greater than 2.',
    ];
    public function updated($field)
    {
        if($field == 'photo')
        {
            $this->Collapse = "uncollapse";
            $this->validate([
                'photo' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:100'
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
    public function saveDepartment()
    {
        if(!$this->update)
        {
            $this->validate();            
        }

        // if ($this->photo) 
        // {
        //     $this->validate([
        //         'photo' => 'required|image|mimes: jpg,jpeg,png,svg,gif|max:100'
        //     ]);  

        //     $filename = $this->photo->store('categories', 'public');   // Store the image in the 'categories' folder of the public disk
        //     $filenameOnly = basename($filename);
        //     $this->ecom_department->image = $filenameOnly;
        //     $this->ecom_department->image_path = 'categories/' . $filenameOnly;
        // }
        $this->ecom_department->parent_id = $this->parent_department != null ? $this->parent_department : $this->ecom_department->parent_id;  
        $this->ecom_department->save();
        $name = $this->ecom_department->name;
        $this->ecom_department = new ecom_department(); 

        session()->flash('message', $this->MainTitle.' '. $this->update ? 'Updated' : 'Added' . ' Successfully');
        $this->resetInput();
        $this->dispatchBrowserEvent('created_module', ['name' => $name]);
        $this->Collapse = "collapse";

        if($this->update)
        {
            return redirect()->to($this->subDepartment ? 'manage-department/sub_department' : 'manage-department/department');
        }
    }
    public function deleteDepartmentRecord(ecom_department $ecom_department)
    {
        // if(isset($ecom_department->image))
        // {
        //     if (file_exists(public_path('storage/departments/') . $ecom_department->image)) 
        //     {
        //         unlink(public_path('storage/departments/') . $ecom_department->image); 
        //     }
        //     // Storage::delete('departments/'.$ecom_department->image);
        // }
        $ecom_department->delete();    

        $this->dispatchBrowserEvent('deleted_scene', ['name' => $ecom_department->name]);
    }
    public function updateStatus(ecom_department $ecom_department, $toggle)
    {
        $ecom_department->is_active = $toggle == 0 ? 0 : 1;
        $ecom_department->save();
        $this->dispatchBrowserEvent('status_updated', ['name' => $ecom_department->name]);
    }

}