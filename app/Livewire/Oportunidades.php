<?php

namespace App\Livewire;

use App\Models\Oportunidad;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Oportunidades extends Component
{
    use WithPagination;

    public $search = '';
    public $tipoFiltro = '';
    public $estadoFiltro = '';
    public $fechaInicioFiltro = '';
    public $fechaFinFiltro = '';
    public $user;
    public $modalRechazoVisible = false;
    public $oportunidadId;
    public $comentarios;
    public $estado;
    public $alert = ['show' => false, 'type' => '', 'message' => ''];
    public function hideAlert()
    {
        $this->alert['show'] = false;
    }

    public function mount()
    {
        $this->user = Auth::user();
    }


    public function loadOportunidades()
    {
        $query = Oportunidad::with('cliente')
            ->when($this->user->distribuidor_id, function ($query) {
                return $query->where('id_ejecutivo', $this->user->distribuidor_id);
            })
            ->when($this->user->hasRole('Vendedor'), function ($query) {
                return $query->where('vendedor', $this->user->name);
            })
            ->when($this->search, function ($query) {
                return $query->where(function ($query) {
                    $query->where('vendedor', 'like', '%' . $this->search . '%')
                        ->orWhereHas('cliente', function ($q) {
                            $q->where('razon', 'like', '%' . $this->search . '%');
                        })
                        ->orWhere('estado', 'like', '%' . $this->search . '%');
                });
            })

            ->when($this->tipoFiltro !== '' && $this->tipoFiltro !== 'todos', function ($query) {
                return $query->where('venta', $this->tipoFiltro);
            })
            ->when($this->estadoFiltro !== '' && $this->estadoFiltro !== 'todos', function ($query) {
                return $query->where('estado', $this->estadoFiltro);
            })
            ->when($this->fechaInicioFiltro, function ($query) {
                return $query->whereDate('actualizacion', '>=', $this->fechaInicioFiltro);
            })
            ->when($this->fechaFinFiltro, function ($query) {
                return $query->whereDate('actualizacion', '<=', $this->fechaFinFiltro);
            })
            ->orderBy('actualizacion', 'desc')
            ->orderBy('created_at', 'desc');

        return $query;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedTipoFiltro()
    {
        if ($this->tipoFiltro === 'todos') {
            $this->tipoFiltro = '';
        }
        $this->resetPage();
    }

    public function updatedEstadoFiltro()
    {
        if ($this->estadoFiltro === 'todos') {
            $this->estadoFiltro = '';
        }
        $this->resetPage();
    }

    public function updatedFechaInicioFiltro()
    {
        $this->resetPage();
    }

    public function updatedFechaFinFiltro()
    {
        $this->resetPage();
    }


    #[On('oportunidadUpdated')]
    public function refreshOportunidades()
    {
        $this->loadOportunidades();
    }


    public function delete($id)
    {
        $oportunidad = Oportunidad::find($id);
        $oportunidad->delete();
        $this->dispatch('oportunidadUpdated');
    }

    public function reingresarOportunidad($id)
    {
        $oportunidad = Oportunidad::findOrFail($id);
        $oportunidad->estado = 'Revisando Venta';
        $oportunidad->save();

        $this->dispatch('oportunidadUpdated');
    }

    public function aprobarOportunidad($id)
    {
        $oportunidad = Oportunidad::findOrFail($id);
        $oportunidad->estado = 'Aprobada';
        $oportunidad->comentarios = 'Sin comentarios';
        $oportunidad->save();

        $this->dispatch('oportunidadUpdated');

        $this->alert = [
            'show' => true,
            'type' => 'success',
            'message' => 'La venta fue aprobada exitosamente.'
        ];
    }

    public function mostrarModalRechazo($oportunidadId)
    {
        $this->oportunidadId = $oportunidadId;
        $oportunidad = Oportunidad::find($oportunidadId);
        $this->comentarios = $oportunidad->comentarios;
        $this->estado = $oportunidad->estado;
        $this->modalRechazoVisible = true;
    }

    public function guardarComentarios()
    {
        $this->validate([
            'comentarios' => 'required',
            'estado' => 'required|in:Rechazada,Rechazada Por Credito,Verificacion de Credito Rechazada,Revisando Venta',
        ]);

        $oportunidad = Oportunidad::find($this->oportunidadId);
        $oportunidad->comentarios = $this->comentarios;
        $oportunidad->estado = $this->estado;
        $oportunidad->save();

        $this->modalRechazoVisible = false;
        $this->reset('oportunidadId', 'comentarios', 'estado');
        $this->dispatch('oportunidadUpdated');
    }

    public $oportunidadRechazadaId;

    public function rechazarOportunidad()
    {
        $this->validate([
            'motivoRechazo' => 'required',
        ]);

        $oportunidad = Oportunidad::find($this->oportunidadIdParaRechazar);
        $oportunidad->estado = 'Rechazada';
        $oportunidad->comentarios = "Favor de corregir los siguientes rechazos por favor:\n\n" . $this->motivoRechazo;
        $oportunidad->save();

        $this->oportunidadRechazadaId = $oportunidad->id;
        $this->modalRechazoVisible = false;
        $this->reset('motivoRechazo', 'oportunidadIdParaRechazar');
        $this->dispatch('oportunidadUpdated');

        $this->alert = [
            'show' => true,
            'type' => 'error',
            'message' => 'La venta fue Rechazada Exitosamente'
        ];
    }

    public function editarOportunidadRechazada()
    {
        $this->dispatch('editOportunidad', ['id' => $this->oportunidadRechazadaId]);
        $this->oportunidadRechazadaId = null;

        $this->alert = [
            'show' => true,
            'type' => 'success',
            'message' => 'La venta Editada Exitosamente'
        ];
    }


    public function render()
    {
        $oportunidades = $this->loadOportunidades()->paginate(5);

        return view('livewire.oportunidades', [
            'oportunidades' => $oportunidades,
            'user' => $this->user
        ]);
    }
}
