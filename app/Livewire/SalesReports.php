<?php

namespace App\Livewire;

use Livewire\Component;
use App\Exports\SalesExport;
use App\Models\Distribuidor;
use App\Models\Oportunidad;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class SalesReports extends Component
{
    public $showModal = false;
    public $fechaInicio;
    public $fechaFin;
    public $estado;
    public $distribuidor;

    public function mount()
    {
        $this->distribuidor = Auth::user()->distribuidor_id;
    }

    public function generarInforme()
    {
        $this->validate([
            'fechaInicio' => 'required|date',
            'fechaFin' => 'required|date|after_or_equal:fechaInicio',
            'estado' => 'required',
        ]);

        $distribuidor = Distribuidor::findOrFail($this->distribuidor);
        $usuariosIds = $distribuidor->users->pluck('id')->toArray();

        $ventas = Oportunidad::whereBetween('actualizacion', [$this->fechaInicio, $this->fechaFin])
                            ->where('estado', $this->estado)
                            ->where(function($query) use ($usuariosIds) {
                                $query->whereIn('user_id', $usuariosIds)
                                      ->orWhere('id_ejecutivo', $this->distribuidor);
                            })
                            ->with(['lineas', 'user', 'distribuidor'])
                            ->get();

        return Excel::download(new SalesExport($ventas), 'informe_ventas.xlsx');
    }


    public function render()
    {
        return view('livewire.sales-reports');
    }
}