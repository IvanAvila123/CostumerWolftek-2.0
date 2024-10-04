<?php

namespace App\Livewire;

use Livewire\Component;

class VerClientesButton extends Component
{

    public function verClientes()
    {
        $this->dispatch('ver-clientes');
    }

    public function render()
    {
        return view('livewire.ver-clientes-button');
    }
}
