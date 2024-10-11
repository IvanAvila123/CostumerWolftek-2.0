<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\Linea;
use App\Models\Oportunidad;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ModalOportunidad extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $oportunidadId;
    public $vendedor;
    public $venta;
    public $razon;
    public $cuenta;
    public $id_cliente;
    public $entrega;
    public $autorizada;
    public $comentarios;
    public $acuerdo;
    public $actualizacion;
    public $estado;
    public $selectedClienteId;
    public $selectedLineas = [];
    public $lineasNoRenovables = [];
    public $lineasEnUso = [];
    public $lineasNoPertenecientes = [];
    public $modalVisible = false;
    public $search = '';
    public $clientes = [];
    public $user;
    public $lineaId;
    public $user_id;
    public $cliente_id;
    public $id_distribuidor;
    public $csvFile;
    public $lineasPorPagina = 10;
    public $alert = ['show' => false, 'type' => '', 'message' => ''];
    public function hideAlert()
    {
        $this->alert['show'] = false;
    }

    protected function rules()
    {
        $rules = [
            'vendedor' => 'required|string|max:255',
            'venta' => 'required|in:Renovacion,Adicion,Renovacion Anticipada T-1,Renovacion Anticipada,Venta Nueva',
            'razon' => 'required|string|max:255',
            'cuenta' => 'required|integer',
            'id_cliente' => 'required|integer',
            'entrega' => 'required|string|max:500',
            'autorizada' => 'required|string|max:255',
            'comentarios' => 'nullable|string|max:250',
            'acuerdo' => 'nullable|string|max:255',
            'actualizacion' => 'required|date',
            'estado' => 'required|in:Haciendo Contratos,Se ingresa Venta,Revision,Captura,Verificacion De Credito,Rechazada Por Credito,Verificacion de Credito Rechazada,Verificacion De Credito Aprobada,Asignacion De Equipo,Cancela/Envios,Envios/Por Confirmar,Envios/En Ruta,Orden Entregada,Pendiente,Aprobada,Rechazada,Revisando Venta,Se Entrega Contratos',
            'selectedClienteId' => 'required|exists:clientes,id',
        ];

        if (!in_array($this->venta, ['Adicion', 'Venta Nueva'])) {
            $rules['selectedLineas'] = 'required|array|min:1';
        }

        return $rules;
    }

    #[On('editOportunidad')]
    public function show($id = null)
    {
        $this->resetValidation();
        $this->reset(['vendedor', 'venta', 'razon', 'cuenta', 'id_cliente', 'entrega', 'autorizada', 'acuerdo', 'comentarios', 'estado', 'selectedClienteId', 'selectedLineas']);

        if ($id) {
            $this->oportunidadId = $id;
            $oportunidad = Oportunidad::with(['lineas', 'cliente'])->findOrFail($id);
            $this->vendedor = $oportunidad->vendedor;
            $this->venta = $oportunidad->venta;
            $this->razon = $oportunidad->cliente->razon;
            $this->cuenta = $oportunidad->cliente->cuenta;
            $this->id_cliente = $oportunidad->cliente->id_cliente;
            $this->entrega = $oportunidad->entrega;
            $this->autorizada = $oportunidad->autorizada;
            $this->comentarios = $oportunidad->comentarios;
            $this->acuerdo = $oportunidad->acuerdo;
            $this->actualizacion = $oportunidad->actualizacion;
            $this->selectedClienteId = $oportunidad->cliente_id;
            $this->selectedLineas = $oportunidad->lineas->pluck('id')->toArray();
        }

        $this->modalVisible = true;
    }

    public function updatedSearch()
    {
        if (strlen($this->search) >= 2) {
            $query = Cliente::query()
                ->where('razon', 'like', '%' . $this->search . '%');

            if (!$this->user->isSuperAdmin()) {
                $query->where(function ($q) {
                    $q->where('ejecutivo', $this->user->distribuidor_id)
                        ->orWhere('user_id', $this->user->id);
                });
            }

            $this->clientes = $query->take(5)->get();
        } else {
            $this->clientes = [];
        }
    }

    public function selectCliente($clienteId)
    {
        $this->selectedClienteId = $clienteId;
        $cliente = Cliente::find($clienteId);
        $this->razon = $cliente->razon;
        $this->cuenta = $cliente->cuenta;
        $this->id_cliente = $cliente->id_cliente;
        $this->selectedLineas = [];
        $this->lineasNoRenovables = [];
        $this->lineasEnUso = [];
        $this->lineasNoPertenecientes = [];
        $this->alert = ['show' => false, 'type' => '', 'message' => ''];

        if (empty($this->vendedor)) {
            $this->vendedor = $this->user ? $this->user->name : '';
        }

        $this->loadLineas();
    }

    public function loadLineas()
    {
        if ($this->selectedClienteId && $this->venta) {
            $query = Linea::where('cliente_id', $this->selectedClienteId);

            $today = now()->startOfDay();
            $oneMonthLater = $today->copy()->addMonth();
            $threeMonthsLater = $today->copy()->addMonths(3);

            switch ($this->venta) {
                case 'Renovacion':
                    $query->where('fecha', '<=', $today);
                    break;
                case 'Renovacion Anticipada T-1':
                    $query->whereBetween('fecha', [$today->copy()->addDay(), $oneMonthLater]);
                    break;
                case 'Renovacion Anticipada':
                    $query->whereBetween('fecha', [$oneMonthLater->copy()->addDay(), $threeMonthsLater]);
                    break;
                case 'Adicion':
                case 'Venta Nueva':
                    // No cargar líneas para estos tipos
                    return collect();
            }

            return $query->paginate($this->lineasPorPagina);
        }

        return collect();
    }

    public function toggleLineaSelection($lineaId)
    {
        if (in_array($lineaId, $this->selectedLineas)) {
            $this->selectedLineas = array_diff($this->selectedLineas, [$lineaId]);
        } else {
            $this->selectedLineas[] = $lineaId;
        }
    }

    public function save()
    {
        $this->validate();

        $oportunidadData = [
            'vendedor' => $this->vendedor,
            'venta' => $this->venta,
            'razon' => $this->razon,
            'entrega' => $this->entrega,
            'autorizada' => $this->autorizada,
            'comentarios' => $this->comentarios ?? 'Sin Comentarios',
            'acuerdo' => $this->acuerdo ?? 'Sin Acuerdo',
            'actualizacion' => $this->actualizacion,
            'estado' => $this->estado,
            'cliente_id' => $this->selectedClienteId,
            'user_id' => auth()->id(),
            'id_ejecutivo' => auth()->user()->distribuidor_id,
        ];

        if ($this->oportunidadId) {
            $oportunidad = Oportunidad::find($this->oportunidadId);
            $oportunidad->update($oportunidadData);
        } else {
            $oportunidad = Oportunidad::create($oportunidadData);
        }

        if (!in_array($this->venta, ['Adicion', 'Venta Nueva']) && !empty($this->selectedLineas)) {
            $lineasData = [];
            foreach ($this->selectedLineas as $linea) {
                if (is_array($linea) && isset($linea['id'])) {
                    $lineasData[$linea['id']] = ['fecha_linea' => Linea::find($linea['id'])->fecha];
                }
            }
            $oportunidad->lineas()->sync($lineasData);
        }

        $this->modalVisible = false;
        $this->dispatch('oportunidadUpdated');
        $this->reset(['vendedor', 'venta', 'razon', 'entrega', 'autorizada', 'actualizacion', 'estado', 'selectedLineas']);
    }

    public function mount()
    {
        $this->user = Auth::user();
        $this->vendedor = $this->user ? $this->user->name : '';
        $this->actualizacion = Carbon::now()->format('d/m/Y');
    }

    public function importDNs()
    {
        $this->validate([
            'csvFile' => 'required|file|mimes:csv,txt',
        ]);

        $path = $this->csvFile->getRealPath();
        $dns = array_map('str_getcsv', file($path));

        $this->selectedLineas = [];
        $this->lineasEnUso = [];
        $this->lineasNoRenovables = [];
        $this->lineasNoPertenecientes = [];
        $today = now()->startOfDay();
        $oneMonthLater = $today->copy()->addMonth();
        $threeMonthsLater = $today->copy()->addMonths(3);

        foreach ($dns as $dn) {
            $linea = Linea::where('dn', $dn[0])
                ->where('cliente_id', $this->selectedClienteId)
                ->first();
            if ($linea) {
                $fechaLinea = \Carbon\Carbon::parse($linea->fecha);
                if ($fechaLinea <= $today) {
                    $tipo = 'Renovacion vencida';
                } elseif ($fechaLinea > $today && $fechaLinea <= $oneMonthLater) {
                    $tipo = 'Renovacion Anticipada T-1';
                } elseif ($fechaLinea > $oneMonthLater && $fechaLinea <= $threeMonthsLater) {
                    $tipo = 'Renovacion Anticipada';
                } else {
                    $tipo = 'No elegible para renovación';
                    $this->lineasNoRenovables[] = $linea->dn;
                }

                // Verificar si la línea está en uso por otro usuario del mismo distribuidor
                $lineaEnUso = Oportunidad::where('id_ejecutivo', $this->user->distribuidor_id)
                    ->whereHas('lineas', function ($query) use ($linea) {
                        $query->where('lineas.id', $linea->id);
                    })
                    ->where('user_id', '!=', $this->user->id)
                    ->first();

                if ($lineaEnUso) {
                    $this->lineasEnUso[] = [
                        'dn' => $linea->dn,
                        'usuario' => User::find($lineaEnUso->user_id)->name
                    ];
                } else {
                    $this->selectedLineas[] = [
                        'id' => $linea->id,
                        'dn' => $linea->dn,
                        'tipo' => $tipo,
                        'renovable' => $tipo !== 'No elegible para renovación'
                    ];
                }
            } else {
                // Si la línea no pertenece al cliente, la agregamos a la nueva array
                $this->lineasNoPertenecientes[] = $dn[0];
            }
        }

        // Configurar las alertas
        if (!empty($this->lineasNoRenovables)) {
            $this->alert = [
                'show' => true,
                'type' => 'error',
                'message' => 'Hay líneas no elegibles para renovación.'
            ];
        }

        if (!empty($this->lineasEnUso)) {
            $this->alert = [
                'show' => true,
                'type' => 'warning',
                'message' => 'Algunas líneas ya están en uso por otros usuarios.'
            ];
        }

        if (!empty($this->lineasNoPertenecientes)) {
            $this->alert = [
                'show' => true,
                'type' => 'error',
                'message' => 'Algunos DNs no pertenecen al cliente seleccionado.'
            ];
        }
    }

    public function render()
    {
        return view('livewire.modal-oportunidad', [
            'user' => $this->user,
            'lineasPaginadas' => $this->loadLineas(),
        ]);
    }
}
