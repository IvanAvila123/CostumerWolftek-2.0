<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Cliente;
use App\Models\Distribuidor;
use App\Models\Linea;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalLinea extends Component
{
    public $dn, $fecha, $plan, $equipo, $cliente_id, $user_id, $id_distribuidor, $lineaId;
    public $linea = [];
    public $modalVisible = false;
    public $errorMessage = '';

    protected $rules = [
        'cliente_id' => 'required|integer',
        'user_id' => 'required|integer',
        'id_distribuidor' => 'required|integer',
        'dn' => 'required|string|max:255',
        'fecha' => 'required|date',
        'plan' => 'required|string|max:255',
        'equipo' => 'required|string|max:255',
    ];

    public function mount($cliente_id = null)
    {
        $this->cliente_id = $cliente_id ?? auth()->user()->cliente->id;
        $this->user_id = auth()->user()->id;
        $this->id_distribuidor = auth()->user()->distribuidor_id;
    }

    #[On('editLinea')]
    public function show($id)
    {
        $this->lineaId = $id;
        $linea = Linea::find($id);
        $this->dn = $linea->dn;
        $this->fecha = $linea->fecha;
        $this->plan = $linea->plan;
        $this->equipo = $linea->equipo;
        $this->modalVisible = true;
    }

    public function closeModal()
    {
        $this->modalVisible = false;
        $this->reset(['dn', 'fecha', 'plan', 'equipo', 'errorMessage']);
    }

    public function save()
    {
        $this->validate();

        // Verificar si ya existe una línea con el mismo DN
        $existingLinea = Linea::where('dn', $this->dn)->first();

        if ($this->lineaId) {
            // Edición de línea existente
            $linea = Linea::find($this->lineaId);
            if ($existingLinea && $existingLinea->id !== $this->lineaId) {
                $this->errorMessage = "Ya existe una línea con este DN. Favor de validar.";
                return;
            }
            $linea->update([
                'dn' => $this->dn,
                'fecha' => $this->fecha,
                'plan' => $this->plan,
                'equipo' => $this->equipo
            ]);
        } else {
            // Creación de nueva línea
            if ($existingLinea) {
                $this->errorMessage = "Ya existe una línea con este DN. Favor de validar.";
                return;
            }
            Linea::create([
                'dn' => $this->dn,
                'fecha' => $this->fecha,
                'plan' => $this->plan,
                'equipo' => $this->equipo,
                'cliente_id' => $this->cliente_id,
                'user_id' => $this->user_id,
                'id_distribuidor' => $this->id_distribuidor,
            ]);
        }

        $this->modalVisible = false;
        $this->reset(['dn', 'fecha', 'plan', 'equipo', 'errorMessage']);
        $this->dispatch('lineaUpdated');
    }

    public function render()
    {
        return view('livewire.modal-linea');
    }
}