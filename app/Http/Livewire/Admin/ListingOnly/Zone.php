<?php

namespace App\Http\Livewire\Admin\ListingOnly;

use Livewire\Component;
use App\Models\Admin\Zone as ZoneModal;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
    
class Zone extends Component
{
    use WithPagination, WithFileUploads, LivewireComponentsCommon;
    protected $paginationTheme = 'bootstrap';
    public $availableColumns;
    public $pageTitle;
    public $MainTitle;
    public $zone_name= '';

    public function mount()
    {
        // $this->pageTitle = 'Show Zone List';
        // $this->MainTitle = 'ZoneList';
        $this->pageTitle = 'ZoneList Manage';
        $this->MainTitle = 'ZoneListManage';


        $this->availableColumns = ['Zone Code', 'Zone Name', 'Zone Short Name']; 

    }
    public function resetInput()
    {
        $this->zone_name='';
    }
    public function render()
    {
        $AllZone = ZoneModal::when($this->zone_name !== '', function ($query) 
                                        {
                                            $query->where('zone_name', 'like', '%' . $this->zone_name . '%');
                                        }) 
                                        ->orderBy('zone_code', 'ASC')
                                        ->paginate(10);  

        return view('livewire.admin.listing-only.zone', compact('AllZone')) ;
    }
    public function SaveModel()
    {

    }
}
