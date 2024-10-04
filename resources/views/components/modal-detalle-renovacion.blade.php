@props(['clienteSeleccionado', 'mostrarDetalles'])

<x-dialog-modal wire:model="mostrarDetalles">
    <x-slot name="title">
        Detalles de Renovación
    </x-slot>

    <x-slot name="content">
        @if($clienteSeleccionado)
            <p class="text-sm text-gray-500 mb-4">
                <strong>Cliente:</strong> {{ $clienteSeleccionado['cliente']->razon }} |
                <strong>Cuenta:</strong> {{ $clienteSeleccionado['cliente']->cuenta }}
            </p>

            @foreach(['vencidas' => 'Vencidas', 'anticipadasT1' => 'Anticipadas T-1', 'anticipadas' => 'Anticipadas'] as $key => $title)
                @if($clienteSeleccionado['lineas'][$key]->isNotEmpty())
                <h4 class="font-semibold mt-4 mb-2">{{ $title }}</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DN</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipo</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($clienteSeleccionado['lineas'][$key] as $linea)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $linea->dn }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($linea->fecha)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $linea->plan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $linea->equipo }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            @endforeach
        @endif
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="$set('mostrarDetalles', false)" wire:loading.attr="disabled">
            Cerrar
        </x-secondary-button>
    </x-slot>
</x-dialog-modal>