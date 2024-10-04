<?php

namespace App\Livewire;

use App\Models\Oportunidad;
use Livewire\Attributes\On;
use Livewire\Component;

class VerVenta extends Component
{   public $modalVisible = false;
    public $id_oportunidad;
    public $oportunidad;

    public function mostrarDetalles()
    {
        $this->oportunidad = Oportunidad::with(['cliente', 'lineas', 'user', 'distribuidor'])->findOrFail($this->id_oportunidad);
        $this->modalVisible = true;
    }

    public function mount($id_oportunidad)
    {
        $this->id_oportunidad = $id_oportunidad;
    }

    public function render()
    {
        return view('livewire.ver-venta');
    }
}
