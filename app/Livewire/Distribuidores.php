<?php

namespace App\Livewire;

use App\Models\Distribuidor;
use Livewire\Attributes\On;
use Livewire\Component;

class Distribuidores extends Component
{
    public $distribuidores = [];
    public $search = '';
    public $headings = [
        ['key' => 'nombre', 'value' => 'Nombre', 'visible' => true],
        ['key' => 'apellido', 'value' => 'Apellido', 'visible' => true],
        ['key' => 'correo', 'value' => 'Correo', 'visible' => true],
        ['key' => 'telefono', 'value' => 'Teléfono', 'visible' => true],
    ];
    public $sortField = 'nombre';
    public $sortDirection = 'asc';
    public $selectedRows = [];

    #[On('distribuidorUpdated')]
    public function refreshDistribuidor()
    {
        $this->loadDistribuidores();
    }

    public function mount()
    {
        $this->loadDistribuidores();
    }

    public function loadDistribuidores()
    {
        $query = Distribuidor::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('apellido', 'like', '%' . $this->search . '%')
                    ->orWhere('correo', 'like', '%' . $this->search . '%')
                    ->orWhere('telefono', 'like', '%' . $this->search . '%');
            });
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        $this->distribuidores = $query->get()->toArray();
    }

    public function updatedSearch()
    {
        $this->loadDistribuidores();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->loadDistribuidores();
    }

    public function toggleColumn($key)
    {
        $index = array_search($key, array_column($this->headings, 'key'));
        if ($index !== false) {
            $this->headings[$index]['visible'] = !$this->headings[$index]['visible'];
        }
    }

    public function delete($id)
    {
        $distribuidor = Distribuidor::find($id);
        $distribuidor->delete();
        $this->refreshDistribuidor();
    }

    public function render()
    {
        return view('livewire.distribuidores');
    }
}
