<?php

namespace App\Livewire;

use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Renovacion extends Component
{
    use WithPagination;

    public $search = '';
    public $tipoRenovacion = '';
    public $clienteSeleccionado = null;
    public $mostrarDetalles = false;
    public $clienteAdquirirId;
    public $fechaAdquisicion;
    public $vendedor;
    public $alert = ['show' => false, 'type' => '', 'message' => ''];
    public function hideAlert()
    {
        $this->alert['show'] = false;
    }

    protected $queryString = ['search', 'tipoRenovacion'];

    const TIPO_VENCIDAS = 'Vencidas';
    const TIPO_ANTICIPADAS_T1 = 'Anticipadas T-1';
    const TIPO_ANTICIPADAS = 'Anticipadas';


    public function adquirirVenta($clienteId)
    {
        $cliente = Cliente::findOrFail($clienteId);
        $cliente->update([
            'vendedor_adquisicion' => Auth::id(),
            'fecha_adquisicion' => Carbon::now()->toDateTimeString(), // Asegura que se guarde como datetime
        ]);

        $this->alert = [
            'show' => true,
            'type' => 'success',
            'message' => 'Venta adquirida con éxito. Tienes 5 días para completar el proceso.'
        ];
    }

    public function devolverVenta($clienteId)
    {
        $cliente = Cliente::findOrFail($clienteId);
        $cliente->update([
            'vendedor_adquisicion' => null,
            'fecha_adquisicion' => null,
        ]);

        $this->alert = [
            'show' => true,
            'type' => 'success',
            'message' => 'Venta devuelta con éxito.'
        ];
    }

    public function puedeAdquirir($cliente)
    {
        return is_null($cliente->vendedor_adquisicion) || $cliente->adquisicionExpirada();
    }

    public function puedeDevolver($cliente)
    {
        return $cliente->vendedor_adquisicion == Auth::id() && !$cliente->adquisicionExpirada();
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingTipoRenovacion()
    {
        $this->resetPage();
    }

    public function getClientesQuery()
    {
        $now = Carbon::now();
        $oneMonthFromNow = $now->copy()->addMonth();
        $threeMonthsFromNow = $now->copy()->addMonths(3);

        $distribuidorId = Auth::user()->distribuidor_id;

        return Cliente::with(['lineas' => function ($query) use ($threeMonthsFromNow) {
            $query->whereDate('fecha', '<=', $threeMonthsFromNow);
        }])
            ->where('ejecutivo', $distribuidorId)
            ->whereHas('lineas', function ($query) use ($threeMonthsFromNow) {
                $query->whereDate('fecha', '<=', $threeMonthsFromNow);
            })
            ->when($this->search, $this->applySearch())
            ->when($this->tipoRenovacion, $this->applyTipoRenovacionFilter($now, $oneMonthFromNow, $threeMonthsFromNow));
    }

    private function applySearch()
    {
        return function ($query) {
            $query->where(function ($q) {
                $q->where('razon', 'like', '%' . $this->search . '%')
                    ->orWhere('cuenta', 'like', '%' . $this->search . '%')
                    ->orWhere('id_cliente', 'like', '%' . $this->search . '%');
            });
        };
    }

    private function applyTipoRenovacionFilter($now, $oneMonthFromNow, $threeMonthsFromNow)
    {
        return function ($query) use ($now, $oneMonthFromNow, $threeMonthsFromNow) {
            switch ($this->tipoRenovacion) {
                case self::TIPO_VENCIDAS:
                    $query->whereHas('lineas', function ($q) use ($now) {
                        $q->whereDate('fecha', '<', $now);
                    });
                    break;
                case self::TIPO_ANTICIPADAS_T1:
                    $query->whereHas('lineas', function ($q) use ($now, $oneMonthFromNow) {
                        $q->whereDate('fecha', '>=', $now)
                            ->whereDate('fecha', '<', $oneMonthFromNow);
                    });
                    break;
                case self::TIPO_ANTICIPADAS:
                    $query->whereHas('lineas', function ($q) use ($oneMonthFromNow, $threeMonthsFromNow) {
                        $q->whereDate('fecha', '>=', $oneMonthFromNow)
                            ->whereDate('fecha', '<=', $threeMonthsFromNow);
                    });
                    break;
            }
        };
    }

    public function exportToExcel()
    {
        // Implementar lógica de exportación a Excel
    }

    public function verDetalles($clienteId)
    {
        $now = Carbon::now();
        $oneMonthFromNow = $now->copy()->addMonth();
        $threeMonthsFromNow = $now->copy()->addMonths(3);

        $cliente = Cliente::with(['lineas' => function ($query) use ($threeMonthsFromNow) {
            $query->whereDate('fecha', '<=', $threeMonthsFromNow);
        }])->findOrFail($clienteId);

        $this->clienteSeleccionado = [
            'cliente' => $cliente,
            'lineas' => $this->agruparLineasPorTipo($cliente->lineas, $now, $oneMonthFromNow, $threeMonthsFromNow)
        ];

        $this->mostrarDetalles = true;
    }

    private function agruparLineasPorTipo($lineas, $now, $oneMonthFromNow, $threeMonthsFromNow)
    {
        return [
            'vencidas' => $lineas->filter(fn($linea) => Carbon::parse($linea->fecha)->lt($now)),
            'anticipadasT1' => $lineas->filter(fn($linea) => Carbon::parse($linea->fecha)->between($now, $oneMonthFromNow)),
            'anticipadas' => $lineas->filter(fn($linea) => Carbon::parse($linea->fecha)->between($oneMonthFromNow, $threeMonthsFromNow))
        ];
    }

    public function render()
    {
        $clientes = $this->getClientesQuery()->paginate(10);
        $clientesConTipos = $this->procesarClientesConTipos($clientes);

        return view('livewire.renovacion', [
            'clientes' => $clientesConTipos,
        ]);
    }

    private function procesarClientesConTipos($clientes)
    {
        $now = Carbon::now();
        $oneMonthFromNow = $now->copy()->addMonth();
        $threeMonthsFromNow = $now->copy()->addMonths(3);

        return $clientes->through(function ($cliente) use ($now, $oneMonthFromNow, $threeMonthsFromNow) {
            $lineasAgrupadas = $this->agruparLineasPorTipo($cliente->lineas, $now, $oneMonthFromNow, $threeMonthsFromNow);
            $cliente->vencidas = $lineasAgrupadas['vencidas']->count();
            $cliente->anticipadasT1 = $lineasAgrupadas['anticipadasT1']->count();
            $cliente->anticipadas = $lineasAgrupadas['anticipadas']->count();
            $cliente->adquisicionExpirada = $cliente->adquisicionExpirada();
            return $cliente;
        });
    }
}
