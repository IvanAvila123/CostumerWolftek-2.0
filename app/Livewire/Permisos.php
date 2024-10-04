<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Permisos extends Component
{
    public $permissions;
    public $roles;

    #[On('permissionUpdated')]
    public function refreshPermissions()
    {
        $this->permissions = Permission::all();
    }

    public function mount()
    {
        $this->permissions = Permission::all();
        $this->roles = Role::all();
    }

    public function delete($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
        $this->refreshPermissions();
    }

    public function render()
    {
        return view('livewire.permisos');
    }
}
