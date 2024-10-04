<?php

namespace App\Livewire;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class UserTable extends Component
{

    public function render()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('livewire.user-table', compact('users', 'roles'));
    }
}
