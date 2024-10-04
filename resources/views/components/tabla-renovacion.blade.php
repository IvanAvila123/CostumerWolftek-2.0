@props(['clientes'])

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                @foreach (['Razón Social', 'Cuenta', 'ID Cliente', 'Representante', 'Vencidas', 'Anticipadas T-1', 'Anticipadas', 'Acciones'] as $header)
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($clientes as $cliente)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $cliente->razon }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $cliente->cuenta }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $cliente->id_cliente }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $cliente->representante }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                            {{ $cliente->vencidas }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex px-2 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full">
                            {{ $cliente->anticipadasT1 }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span
                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                            {{ $cliente->anticipadas }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                        <div class="flex flex-col items-start space-y-2">
                            <div class="flex space-x-2">
                                <x-button wire:click="verDetalles({{ $cliente->id }})">
                                    Ver detalles
                                </x-button>
                                @if ($this->puedeAdquirir($cliente))
                                    <x-success-button wire:click="adquirirVenta({{ $cliente->id }})">
                                        Adquirir venta
                                    </x-success-button>
                                @elseif($this->puedeDevolver($cliente))
                                    <x-orange-button wire:click="devolverVenta({{ $cliente->id }})"
                                        class="bg-yellow-500 hover:bg-yellow-600">
                                        Devolver venta
                                    </x-orange-button>
                                @else
                                    <span class="text-gray-500">Adquirido por
                                        {{ $cliente->vendedorAdquisicion->name }}</span>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
