<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\Linea;
use Livewire\Attributes\On;
use Livewire\Component;

class HistorialCliente extends Component
{
    public $showModalHistorial = false;
    public $audits = [];
    public $cliente_id;

    public function mount($cliente_id = null)
    {
        $this->cliente_id = $cliente_id;
        if ($this->cliente_id) {
            $this->showHistorial($this->cliente_id);
        }
    }
    #[On('showHistorial')]
    public function showHistorial($clienteId)
    {
        $this->cliente_id = $clienteId;
        $cliente = Cliente::find($this->cliente_id);
        if ($cliente) {
            $clienteAudits = $cliente->audits()->with('user')->latest()->get();
            $lineaAudits = Linea::where('cliente_id', $this->cliente_id)
                ->withTrashed()
                ->get()
                ->flatMap(function ($linea) {
                    return $linea->audits()->with('user')->get();
                });

            $this->audits = $clienteAudits->concat($lineaAudits)->sortByDesc('created_at');
            $this->audits = $this->audits->map(function ($audit) {
                $audit->modified = collect($audit->getModified())->except(['cliente_id', 'user_id', 'id_distribuidor', 'id'])->toArray();
                return $audit;
            });
            $this->showModalHistorial = true;
        }
    }

    public function ocultarModalHistorial()
    {
        $this->showModalHistorial = false;
    }

    public function render()
    {
        return view('livewire.historial-cliente');
    }
}
