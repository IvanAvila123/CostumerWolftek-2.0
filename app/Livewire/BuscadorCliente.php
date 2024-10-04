<?php

namespace App\Livewire;

use Livewire\Component;

class BuscadorCliente extends Component
{
    public $search = '';

    public function updatedSearch()
    {
        $this->checkResetSearch();
    }

    public function performSearch()
    {
        $this->dispatch('cliente-search-update', $this->search);
    }

    public function checkResetSearch()
    {
        if (empty($this->search)) {
            $this->resetSearch();
        }
    }

    public function resetSearch()
    {
        $this->search = '';
        $this->dispatch('cliente-search-update', search: '');
    }
    
    public function render()
    {
        return view('livewire.buscador-cliente');
    }
}
