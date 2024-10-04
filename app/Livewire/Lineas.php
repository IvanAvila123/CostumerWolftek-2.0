<?php

namespace App\Livewire;

use App\Models\Linea;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class Lineas extends Component
{
    public $search = '';
    public $lineas = [];
    public $cliente_id;
    public $headings = [
        ['key' => 'dn', 'value' => 'DN', 'visible' => true],
        ['key' => 'fecha', 'value' => 'Fecha Fin', 'visible' => true],
        ['key' => 'plan', 'value' => 'Plan Tarifario', 'visible' => true],
        ['key' => 'equipo', 'value' => 'Equipo', 'visible' => true],
    ];
    public $selectedRows = [];
    public $selectAll = false;
    public $sortField = 'dn';
    public $sortDirection = 'asc';

    #[On('lineaUpdated')]
    #[On('lineaRestaurada')]
    public function refreshLineas()
    {
        $this->loadLineas();
    }

    public function mount($cliente_id = null)
    {
        $this->cliente_id = $cliente_id;
        $this->loadLineas();
    }

    public function loadLineas()
    {
        $query = Linea::query();

        if ($this->cliente_id) {
            $query->where('cliente_id', $this->cliente_id);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('dn', 'like', '%' . $this->search . '%')
                    ->orWhere('fecha', 'like', '%' . $this->search . '%')
                    ->orWhere('plan', 'like', '%' . $this->search . '%')
                    ->orWhere('equipo', 'like', '%' . $this->search . '%');
            });
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        $this->lineas = $query->get()->map(function ($linea) {
            $linea->fecha = Carbon::parse($linea->fecha)->format('d/m/Y');
            return $linea;
        })->toArray();
    }

    public function updatedSearch()
    {
        $this->loadLineas();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->loadLineas();
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
        $linea = Linea::find($id);
        $linea->delete();
        $this->refreshLineas();
    }

    public function deleteSelected()
    {
        Linea::whereIn('id', $this->selectedRows)->delete();
        $this->selectedRows = [];
        $this->refreshLineas();
    }

    public function render()
    {
        return view('livewire.lineas');
    }
}