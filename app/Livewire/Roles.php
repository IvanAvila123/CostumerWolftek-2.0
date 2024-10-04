<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    public $roles;

    #[On('roleUpdate')]
    public function refreshRoles(){
        $this->roles = Role::all();
    }

    public function mount(){
        $this->roles = Role::all();
    }

    public function delete($id){

       $role = Role::find($id);
       $role->delete();
       $role->refreshRoles;
    }

    public function render()
    {
        return view('livewire.roles');
    }
}
