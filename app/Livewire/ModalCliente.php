<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Distribuidor;
use App\Models\Cliente;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalCliente extends Component
{

    public $cliente = [];
    public $razon;
    public $cuenta;
    public $id_cliente;
    public $representante;
    public $telefono;
    public $correo;
    public $fiscal;
    public $entrega;
    public $rfc;
    public $clienteId;
    public $user_id;
    public $ejecutivo;
    public $modalVisible = false;
    public $errorMessage = '';

    protected function rules()
    {
        $rules = [
            'user_id' => 'required|integer',
            'razon' => 'required|string',
            'cuenta' => 'required|integer',
            'id_cliente' => [
                'required',
                'integer',
                Rule::unique('clientes')->where(function ($query) {
                    return $query->where('ejecutivo', $this->ejecutivo);
                })->ignore($this->clienteId)
            ],
            'representante' => 'required|string',
            'telefono' => 'required|string',
            'correo' => 'required|string',
            'fiscal' => 'required|string',
            'entrega' => 'required|string',
            'rfc' => 'required|string',
            'ejecutivo' => 'required|integer',
        ];

        return $rules;
    }

    public function mount($user_id = null)
    {
        $this->user_id = $user_id ?? auth()->user()->id;
        $this->ejecutivo = auth()->user()->distribuidor_id;
    }

    public function closeModal()
    {
        $this->modalVisible = false;
    }

    #[On('editCliente')]
    public function show($id)
    {
        $this->clienteId = $id;
        $cliente = Cliente::find($id);
        $this->razon = $cliente->razon;
        $this->cuenta = $cliente->cuenta;
        $this->id_cliente = $cliente->id_cliente;
        $this->representante = $cliente->representante;
        $this->telefono = $cliente->telefono;
        $this->correo = $cliente->correo;
        $this->fiscal = $cliente->fiscal;
        $this->entrega = $cliente->entrega;
        $this->rfc = $cliente->rfc;
        $this->modalVisible = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->clienteId) {
            // Lógica para actualizar cliente existente
            $cliente = Cliente::find($this->clienteId);
            if ($cliente->id_cliente != $this->id_cliente) {
                $existingCliente = Cliente::where('id_cliente', $this->id_cliente)
                    ->where('ejecutivo', $this->ejecutivo)
                    ->where('id', '!=', $this->clienteId)
                    ->first();
                if ($existingCliente) {
                    $this->dispatch('errorGuardar');
                    return;
                }
            }

            $cliente->update([
                'razon' => $this->razon,
                'cuenta' => $this->cuenta,
                'id_cliente' => $this->id_cliente,
                'representante' => $this->representante,
                'telefono' => $this->telefono,
                'correo' => $this->correo,
                'fiscal' => $this->fiscal,
                'entrega' => $this->entrega,
                'rfc' => $this->rfc,
            ]);

            $message = 'Cliente actualizado con éxito.';
        } else {
            // Lógica para crear nuevo cliente
            $existingCliente = Cliente::where('id_cliente', $this->id_cliente)
                ->where('ejecutivo', $this->ejecutivo)
                ->first();
            if ($existingCliente) {
                $this->dispatch('errorGuardar');
                return;
            }

            Cliente::create([
                'razon' => $this->razon,
                'cuenta' => $this->cuenta,
                'id_cliente' => $this->id_cliente,
                'representante' => $this->representante,
                'telefono' => $this->telefono,
                'correo' => $this->correo,
                'fiscal' => $this->fiscal,
                'entrega' => $this->entrega,
                'rfc' => $this->rfc,
                'user_id' => $this->user_id,
                'ejecutivo' => $this->ejecutivo,
            ]);

            $message = 'Cliente creado con éxito.';
        }

        $this->modalVisible = false;
        $this->reset(['razon', 'cuenta', 'id_cliente', 'representante', 'correo', 'fiscal', 'rfc']);
        $this->dispatch('clienteUpdate');
        $this->dispatch('guardarCliente');

    }


    public function render()
    {
        return view('livewire.modal-cliente');
    }
}
