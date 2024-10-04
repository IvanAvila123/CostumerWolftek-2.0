<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ModelRole extends Component
{
    public $roleId;
    public $name;
    public $permissions = [];
    public $selectedPermissions = [];
    public $modalVisible = false;

    public function mount()
    {
        $this->permissions = Permission::all();
    }

    #[On('editRole')]
    public function show($id)
    {
        $this->roleId = $id;
        $role = Role::find($id);

        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
        $this->modalVisible = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $this->roleId,
            'selectedPermissions' => 'array',
        ]);

        $permissions = Permission::whereIn('id', $this->selectedPermissions)->pluck('name')->toArray();

        if ($this->roleId) {
            $role = Role::find($this->roleId);
            $role->update([
                'name' => $this->name,
            ]);
            $role->syncPermissions($permissions);
        } else {
            $role = Role::create([
                'name' => $this->name,
            ]);
            $role->syncPermissions($permissions);
        }

        $this->modalVisible = false;
        $this->reset(['name', 'roleId', 'selectedPermissions']);
        $this->dispatch('roleUpdated'); // Dispatch event to refresh roles list
    }

    public function render()
    {
        return view('livewire.model-role');
    }
}
