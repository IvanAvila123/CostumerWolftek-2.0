<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\User;
use App\Models\Distribuidor;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class ModalUsuario extends Component
{
    public $distribuidores;
    public $roles;
    public $userId;
    public $name;
    public $email;
    public $username;
    public $password;
    public $selectedDistribuidor;
    public $selectedRoleId;
    public $modalVisible = false;
    public $user;

    protected function rules()
{
    return [
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            Rule::unique('users')->ignore($this->userId),
        ],
        'username' => [
            'required',
            'string',
            Rule::unique('users')->ignore($this->userId),
        ],
        'password' => [
            $this->password ? 'required' : 'nullable',
            'string',
            'min:8',
        ],
        'selectedDistribuidor' => 'required|exists:distribuidors,id',
        'selectedRoleId' => 'required|exists:roles,id',
    ];
}

    public function mount()
    {
        $this->distribuidores = Distribuidor::all();
        $this->roles = Role::all();
    }

    #[On('editUser')]
    public function show($id)
    {
        $this->userId = $id;
        $user = User::find($id);

        if ($user && $user->isTheSuperAdmin()) {
            return;
        }
        
        $this->name = $user->name;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->selectedDistribuidor = $user->distribuidor_id;
        $this->selectedRoleId = $user->roles->first()->id ?? null;
        $this->modalVisible = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->userId) {
            $user = User::find($this->userId);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'username' => $this->username,
                'distribuidor_id' => $this->selectedDistribuidor,
            ]);
            if ($this->password) {
                $user->password = bcrypt($this->password);
                $user->save();
            }
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'username' => $this->username,
                'password' => bcrypt($this->password),
                'distribuidor_id' => $this->selectedDistribuidor,
            ]);
        }

        if ($this->selectedRoleId) {
            $role = Role::find($this->selectedRoleId);
            if ($role) {
                $user->syncRoles([$role->name]);
            }
        }

        $this->modalVisible = false;
        $this->reset(['name', 'email', 'username', 'password', 'userId', 'selectedDistribuidor', 'selectedRoleId']);
        $this->dispatch('userUpdated');
    }

    public function render()
    {
        return view('livewire.modal-usuario');
    }
}
