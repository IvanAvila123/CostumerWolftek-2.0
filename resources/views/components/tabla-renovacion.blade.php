@props(['clientes'])

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                @foreach (['Razón Social', 'Cuenta', 'ID Cliente', 'Representante', 'Vencidas', 'Anticipadas T-1', 'Anticipadas', 'Acciones'] as $header)
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
            @foreach ($clientes as $cliente)
                <tr class="dark:hover:bg-gray-700">
                    <td class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-gray-100">{{ $cliente->razon }}</td>
                    <td class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-gray-100">{{ $cliente->cuenta }}</td>
                    <td class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-gray-100">{{ $cliente->id_cliente }}</td>
                    <td class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-gray-100">{{ $cliente->representante }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full dark:bg-red-900 dark:text-red-200">
                            {{ $cliente->vencidas }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-900 dark:text-yellow-200">
                            {{ $cliente->anticipadasT1 }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-200">
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
                                        >
                                        Devolver venta
                                    </x-orange-button>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">Adquirido por
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
