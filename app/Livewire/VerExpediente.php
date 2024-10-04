<?php

namespace App\Livewire;

use Livewire\Component;

class VerExpediente extends Component
{
    public $mostrarBotonVerExpedientes = true;
   
    public function VerCliente()
    {
        $this->dispatch('VerCliente');
        $this->mostrarBotonVerExpedientes = false;
    }

    public function render()
    {
        return view('livewire.ver-expediente');
    }
}
