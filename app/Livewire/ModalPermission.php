<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ModalPermission extends Component
{
    public $roles;
    public $permissionId;
    public $name;
    public $modalVisible = false;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->roles = Role::all();
    }

    #[On('editPermission')]
    public function show($id)
    {
        $this->permissionId = $id;
        $permission = Permission::find($id);

        $this->name = $permission->name;
        $this->modalVisible = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->permissionId) {
            $permission = Permission::find($this->permissionId);
            $permission->update([
                'name' => $this->name,
            ]);
        } else {
            Permission::create([
                'name' => $this->name,
            ]);
        }

        $this->modalVisible = false;
        $this->reset(['name', 'permissionId']);
        $this->dispatch('permissionUpdated'); 
    }

    public function render()
    {
        return view('livewire.modal-permission');
    }
}
