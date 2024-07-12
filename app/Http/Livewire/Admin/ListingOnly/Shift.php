<?php

namespace App\Http\Livewire\Admin\ListingOnly;

use Livewire\Component;
use App\Models\Admin\ecom_employee_time_slots;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
    
class Shift extends Component
{
    use WithPagination, WithFileUploads, LivewireComponentsCommon;
    protected $paginationTheme = 'bootstrap';
    // public $AllShifts;
    public $availableColumns;
    public $pageTitle;
    public $MainTitle;
    public $shift_code= '';

    public function mount()
    {
        // $this->pageTitle = 'Show Shift List';
        // $this->MainTitle = 'ShiftList';
        $this->pageTitle = 'ShiftList Manage';
        $this->MainTitle = 'ShiftListManage';
        $this->availableColumns = ['Shift Code', 'Start Time', 'End Time']; 
    }
    public function resetInput()
    {
        $this->shift_code='';
    }

    public function render()
    {        
        // dd(ecom_employee_time_slots::all()[0]);

        $AllShift = ecom_employee_time_slots::when($this->shift_code !== '', function ($query) 
                                        {
                                            $query->where('shift_code', 'like', '%' . $this->shift_code . '%');
                                        }) 
                                        ->orderBy('shift_code', 'DESC')
                                        ->paginate(10);  
                                        
        return view('livewire.admin.listing-only.shift', compact('AllShift')) ;
    }

}
