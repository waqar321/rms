<?php

namespace App\Http\Livewire\Admin\UserManagement;

use App\Models\Product;
use App\Models\Admin\permission;
use Livewire\Component;

class Products extends Component
{
    public $editedPermissionIndex = null;
    public $editedPermissionField = null;
    public $permissions = [];

    public $designTemplate = 'tailwind';

    protected $rules = [
        'permissions.*.title' => ['required'],
        // 'permissions.*.price' => ['required', 'numeric'],
    ];

    protected $validationAttributes = [
        'permissions.*.title' => 'name',
        // 'permissions.*.price' => 'price',
    ];

    public function mount()
    {
        // $this->permissions = permission::all()->toArray();
        $this->permissions = permission::all()->toArray();
    }

    public function render()
    {
        // return view('livewire.'.$this->designTemplate.'.permissions', [
        //     'permissions' => $this->permissions
        // ]);
        return view('livewire.admin.user-management.products', [
            'permissions' => $this->permissions
        ]);
    }

    public function editPermission($permissionIndex)
    {
        $this->editedPermissionIndex = $permissionIndex;
    }

    public function editPermissionField($permissionIndex, $fieldName)
    {
        $this->editedPermissionField = $permissionIndex . '.' . $fieldName;
    }

    public function savePermission($permissionIndex)
    {
        $this->validate();

        $permission = $this->permissions[$permissionIndex] ?? NULL;
        if (!is_null($permission)) {
            optional(permission::find($permission['id']))->update($permission);
        }
        $this->editedPermissionIndex = null;
        $this->editedPermissionField = null;
    }
}
