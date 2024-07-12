<?php

namespace App\Http\Livewire\Admin\ListingOnly;

use Livewire\Component;
use App\Models\Admin\central_ops_city;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\CategoryComponent;
use App\Traits\livewireComponentTraits\LivewireComponentsCommon;
    
class City extends Component
{
    use WithPagination, WithFileUploads, LivewireComponentsCommon;
    protected $paginationTheme = 'bootstrap';
    // public $AllCities;
    public $availableColumns;
    public $pageTitle;
    public $MainTitle;
    public $title= '';
    
    
    public function mount()
    {
        // $this->pageTitle = 'Show City List';
        // $this->MainTitle = 'CityList';
        $this->pageTitle = 'CityList Manage';
        $this->MainTitle = 'CityListManage';

        $this->availableColumns = ['ID', 'City', 'Short Name', 'Zone']; 
    }
    public function resetInput()
    {
        $this->title='';
    }
    public function render()
    {
        // $AllCities = central_ops_city::all();
        $AllCity = central_ops_city::when($this->title !== '', function ($query) 
                                        {
                                            $query->where('city_name', 'like', '%' . $this->title . '%');
                                        }) 
                                        ->orderBy('city_id', 'DESC')
                                        ->paginate(10);  

        // dd(var_dump($AllCities));

        return view('livewire.admin.listing-only.city', compact('AllCity')) ;
    }
 
}
