<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\Linea;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Clientes extends Component
{
    use WithPagination;

    public $singleSearchResult = null;
    public $showCliente = false;
    public $selectedClient = null;
    public $clienteId;
    public $cliente;
    public $showClientes = true;
    public $showTable = false;
    public $search = '';
    public $searchCliente = '';
    public $searchTable = '';

    protected $queryString = ['searchCliente', 'searchTable'];

    #[On('clienteUpdate')]
    public function refreshCliente()
    {
        $this->loadClientes();
    }

    #[On('ver-clientes')]
    public function toggleClientes()
    {
        $this->showTable = true;
        $this->selectedClient = null;
        $this->showClientes = false;
    }

    #[On('cliente-search-update')]
    public function handleSearch($search)
    {
        $this->searchCliente = $search;
        $this->resetPage();

        $results = $this->loadClientes();

        $this->updateViewBasedOnResults($results);
    }

    public function resetView()
    {
        $this->reset(['showClientes', 'showTable', 'selectedClient', 'searchCliente', 'searchTable']);
        $this->showClientes = true;
    }

    #[On('selectedCliente')]
    public function selectedCliente($id)
    {
        $this->selectedClient = Cliente::findOrFail($id);
        $this->showTable = false;
        $this->showClientes = false;
    }

    public function loadClientes()
    {
        $search = $this->searchCliente ?: $this->searchTable;

        $query = Cliente::query()
            ->with(['lineas', 'user', 'distribuidor'])
            ->when(auth()->user()->distribuidor_id, function ($query) {
                return $query->where('ejecutivo', auth()->user()->distribuidor_id);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('razon', 'like', "%{$search}%")
                        ->orWhere('id_cliente', 'like', "%{$search}%")
                        ->orWhere('cuenta', 'like', "%{$search}%")
                        ->orWhereHas('lineas', function ($q) use ($search) {
                            $q->where('dn', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('updated_at', 'desc');

        return $query->paginate(5);
    }

    public function formatDate($date)
    {
        return $date->format('d/m/Y');
    }

    public function showHistorial($clienteId)
    {
        $this->dispatch('showHistorial', clienteId: $clienteId);
    }

    public function updatedSearch()
    {
        $this->loadClientes();
    }

    public function updatedSearchCliente()
    {
        $this->resetPage();
        $results = $this->loadClientes();
        $this->updateViewBasedOnResults($results);
    }

    public function updatedSearchTable()
    {
        $this->resetPage();
    }

    private function updateViewBasedOnResults($results)
    {
        $count = $results->count();
        $this->selectedClient = $count === 1 ? $results->first() : null;
        $this->showCliente = $count === 0;
        $this->showClientes = $count === 0;
        $this->showTable = $count > 1;
    }

    public function deleted($id)
    {
        $cliente = Cliente::find($id);
        $cliente->delete();
        $this->loadClientes();
    }

    public function render()
    {
        $clientes = $this->loadClientes();
        return view('livewire.clientes', [
            'clientes' => $clientes
        ]);
    }
}
