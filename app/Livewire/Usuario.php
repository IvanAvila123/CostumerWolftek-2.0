<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Usuario extends Component
{
    public $search = '';
    public $usuarios = [];
    public $headings = [
        ['key' => 'name', 'value' => 'Nombre', 'visible' => true],
        ['key' => 'username', 'value' => 'Usuario', 'visible' => true],
        ['key' => 'email', 'value' => 'Email', 'visible' => true],
        ['key' => 'distribuidor', 'value' => 'Distribuidor', 'visible' => true],
        ['key' => 'roles', 'value' => 'Roles', 'visible' => true],
        ['key' => 'is_active', 'value' => 'Estado', 'visible' => true],
    ];
    public $selectedRows = [];
    public $selectAll = false;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    public function updatedSelectAll($value)
    {
        $this->selectedRows = $value ? collect($this->usuarios)->pluck('id')->map(fn ($id) => (string) $id)->toArray() : [];
    }

    public function toggleColumn($key)
    {
        $index = array_search($key, array_column($this->headings, 'key'));
        if ($index !== false) {
            $this->headings[$index]['visible'] = !$this->headings[$index]['visible'];
        }
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->loadUsuarios();
    }

    #[On('userUpdated')]
    public function refreshUsers()
    {
        $this->loadUsuarios();
    }

    public function mount()
    {
        $this->loadUsuarios();
    }

    public function toggleUserStatus($id)
    {
        $user = User::find($id);
        $user->is_active = !$user->is_active;
        $user->save();
        $this->dispatch('userUpdated');
    }

    public function loadUsuarios()
    {
        $search = '%' . $this->search . '%';

        $users = User::with('distribuidor', 'roles')
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', $search)
                    ->orWhere('email', 'like', $search)
                    ->orWhere('username', 'like', $search)
                    ->orWhereHas('distribuidor', function ($q) use ($search) {
                        $q->where('nombre', 'like', $search);
                    });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();

        $this->usuarios = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'distribuidor' => $user->distribuidor->nombre,
                'roles' => $user->roles->pluck('name')->implode(', '),
                'is_active' => $user->is_active,
                'is_super_admin' => $user->isTheSuperAdmin(),
            ];
        })->toArray();
    }

    public function updatedSearch()
    {
        $this->loadUsuarios();
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        $this->refreshUsers();
    }

    public function render()
    {
        return view('livewire.usuario', [
            'users' => $this->usuarios
        ]);
    }
}
