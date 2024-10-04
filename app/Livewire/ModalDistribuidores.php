<?php

namespace App\Livewire;

use App\Models\Distribuidor;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ModalDistribuidores extends Component
{
    public $distribuidores;
    public $users;
    public $user_id;
    public $distribuidoresId;
    public $nombre;
    public $apellido;
    public $correo;
    public $telefono;
    public $modalVisible = false;

    protected function rules()
    {
        return [
            'nombre' => 'required|string',
            'apellido' => 'nullable|string',
            'correo' => [
                'required',
                'email',
                $this->distribuidoresId ? 'unique:distribuidors,correo,' . $this->distribuidoresId : 'unique:distribuidors,correo',
            ],
            'telefono' => 'required|string',
        ];
    }

    public function mount()
    {
        $this->users = User::all();
    }

    #[On('editDistribuidor')]
    public function show($id)
    {
        $this->distribuidoresId = $id;
        $distribuidor = Distribuidor::find($id);

        $this->nombre = $distribuidor->nombre;
        $this->apellido = $distribuidor->apellido;
        $this->correo = $distribuidor->correo;
        $this->telefono = $distribuidor->telefono;
        $this->modalVisible = true;
    }

    public function save()
    {
        $this->validate();

        $userId = Auth::id(); // Obtener el ID del usuario autenticado

        if ($this->distribuidoresId) {
            $distribuidor = Distribuidor::find($this->distribuidoresId);
            $distribuidor->update([
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'correo' => $this->correo,
                'telefono' => $this->telefono,
                'user_id' => $userId,
            ]);
        } else {
            $distribuidor = Distribuidor::create([
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'correo' => $this->correo,
                'telefono' => $this->telefono,
                'user_id' => $userId,
            ]);
        }

        $this->modalVisible = false;
        $this->reset(['nombre', 'apellido', 'correo', 'telefono', 'distribuidoresId', 'user_id']);
        $this->dispatch('distribuidorUpdated');
    }

    public function render()
    {
        return view('livewire.modal-distribuidores');
    }
}
