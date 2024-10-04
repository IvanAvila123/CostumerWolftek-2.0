<?php

namespace App\Livewire;

use App\Models\Linea;
use Livewire\Component;

class ModalShowDeletedLineas extends Component
{
    
    public $cliente_id;
    public $lineasEliminadas = [];
    public $selectedRows = [];
    public $selectAll = false;
    public $mostrarModalEliminados = false;

    public function mount($cliente_id)
    {
        $this->cliente_id = $cliente_id;
    }

    public function showEliminados()
    {
        $distribuidorId = auth()->user()->distribuidor_id;
        $this->lineasEliminadas = Linea::onlyTrashed()
            ->where('cliente_id', $this->cliente_id)
            ->where('id_distribuidor', $distribuidorId)
            ->get();
        $this->mostrarModalEliminados = true;
    }

    public function ocultarModalEliminados()
    {
        $this->mostrarModalEliminados = false;
    }

    public function restaurarLinea($lineaId)
    {
        $linea = Linea::onlyTrashed()->find($lineaId);
        if ($linea) {
            $linea->restore();
            $this->lineasEliminadas = $this->lineasEliminadas->filter(function ($item) use ($lineaId) {
                return $item->id !== $lineaId;
            });
            $this->dispatch('lineaRestaurada');
        }
    }

    public function selectAllCheckbox($checked)
    {
        if ($checked) {
            $this->selectedRows = $this->lineasEliminadas->pluck('id')->toArray();
        } else {
            $this->selectedRows = [];
        }
        $this->selectAll = $checked;
    }


    public function render()
    {
        return view('livewire.modal-show-deleted-lineas');
    }
}
