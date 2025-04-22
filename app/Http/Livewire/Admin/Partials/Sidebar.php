<?php

namespace App\Http\Livewire\Admin\Partials;

use Livewire\Component;
use App\Models\Admin\SideBar as SideBarModel;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
    
class Sidebar extends Component
{
    use WithPagination, WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    // protected $listeners = ['deletetest' => 'deletetestRecord', 'updateStatusOftest' => '', 'selectedColumns' => 'export'];
    protected $listeners = [
                            'sidebarUpdated' => 'handleSidebarUpdated'
                        ];

    public function mount()
    {

        $menus = SideBarModel::where('is_active', 1)->where('parent_id', null)->orderBy('order')->get();
        // dd($menus[1]->subMenus[0]->permisssion->title);


        // dd(can($menus[0]->permission->title));

        // echo "<pre>";
        // print_r($menus[0]->permission);
        // echo "</pre>";
        // die();



        // ----------- for parent menu -------------------
        // --------template---------------
        // SideBarModel::create([    
        //     'title' => 'Manage Users',
        //     'icon' => 'fa fa-group',
        //     'url' => '/dashboard',
        //     'order' => 1,
        // ]);

        // --------dashboard
        // SideBarModel::create([    
        //     'title' => 'Manage Users',
        //     'icon' => 'fa fa-group',
        //     'url' => '/dashboard',
        //     'order' => 1,
        // ]);
        
        // --------Manage Users
        // SideBarModel::create([
            //     'title' => 'Manage Users',
            //     'icon' => 'fa fa-group',
            //     'url' => '/dashboard',
            //     'order' => 1,
            //     'ClassNames' => ['side-bar-menus']
        // ]);
        
        
        // ----------- for child -------------------
        // --------template---------------
        // SideBarModel::create([
        //     'title' => 'Manage Users',
        //     'icon' => 'fa fa-group',
        //     'url' => '/dashboard',
        //     'order' => 1,
        //     'IdNames' => ['menu1', 'menu2'],
        //     'ClassNames' => ['class1', 'class2']
        // ]);

        // --------Users
        // SideBarModel::create([
        //     'title' => 'Users',
        //     // 'icon' => '',
        //     'url' => '/manage_user',
        //     'order' => 2,
        //     // 'IdNames' => ['menu1', 'menu2'],
        //     // 'ClassNames' => ['class1', 'class2']
        // ]);

   }
    public function render()
    {

        $menus = SideBarModel::where('is_active', 1)->where('parent_id', null)->orderBy('order')->get();        

        return view('livewire.admin.partials.sidebar', compact('menus'));
    }
    public function SaveModel()
    {

    }
    public function updateOrder($SideBars)
    {
        // dd($SideBars);
        
        foreach($SideBars as $item) 
        {
            SideBarModel::where('id', $item['value'])->update(['order' => $item['order']]);
        }
        
        // $this->tasks = SideBarModel::orderBy('order')->get();
    }
    public function handleSidebarUpdated()
    {
        $this->render();
    }
}
