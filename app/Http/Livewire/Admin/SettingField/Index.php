<?php

namespace App\Http\Livewire\Admin\SettingField;

use Livewire\Component;
use App\Models\Admin\Setting;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\livewireComponentTraits\SettingFieldComponent;
use Illuminate\Support\Facades\Redirect;

class Index extends Component
{
    use WithPagination, WithFileUploads, SettingFieldComponent;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
                            'deletetest' => 'deletetestRecord',
                            'updateStatusOftest' => '',
                            'selectedColumns' => 'export',
                            // 'CategoryOperation' => 'DeleteCategory'
                            'deleteSettingOperation' => 'DeleteSetting'
                        ];

    public function mount()
    {
        $this->setMountData();
        // dd('awdaw4444');
    }
    public function render()
    {
        // $this->Collapse = $this->hasErrors() ? "uncollapse" : $this->Collapse;
        $this->Collapse = "uncollapse";
        return view('livewire.admin.setting-field.index', $this->RenderData());
    }
    public function saveSetting()
    {
        // dd($this->Setting);

        if ($this->photo)
        {
            // $this->validate([
            //     'photo' => 'required|image|mimes: jpg,jpeg,png,svg,gif|max:100'
            // ]);

            $filename = $this->photo->store('settings', 'public');   // Store the image in the 'categories' folder of the public disk
            $filenameOnly = basename($filename);
            $this->Setting->image = $filenameOnly;
            $this->Setting->image_path = 'settings/' . $filenameOnly;
        }


        $this->Setting->save();
        // $this->Setting = new Setting();
        $this->Collapse = 'uncollapse';

        // if($this->Update)
        // {
            $this->dispatchBrowserEvent('SettingUpdated', ['message' => 'Setting updated succesfullyy!!']);
        // }
        return Redirect::route('settings');
        // dd($this->Setting);

    }
}
