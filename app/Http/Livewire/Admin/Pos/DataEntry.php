<?php

namespace App\Http\Livewire\Admin\Pos;

use Livewire\Component;
use App\Models\Admin\ecom_test;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\CategoryComponent;
    
class DataEntry extends Component
{
    use WithPagination, WithFileUploads, CategoryComponent;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['deletetest' => 'deletetestRecord', 'updateStatusOftest' => '', 'selectedColumns' => 'export'];

    public function mount(ecom_test $ecom_test)
    {

    }
    public function render()
    {
        return view('livewire.admin.pos.data-entry');
    }
    public function SaveModel()
    {

    }
}
