@props(['clienteSeleccionado', 'mostrarDetalles'])

<x-dialog-modal wire:model="mostrarDetalles">
    <x-slot name="title" class="text-gray-900 dark:text-gray-100">
        Detalles de Renovación
    </x-slot>

    <x-slot name="content">
        @if($clienteSeleccionado)
            <p class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                <strong>Cliente:</strong> {{ $clienteSeleccionado['cliente']->razon }} |
                <strong>Cuenta:</strong> {{ $clienteSeleccionado['cliente']->cuenta }}
            </p>

            @foreach(['vencidas' => 'Vencidas', 'anticipadasT1' => 'Anticipadas T-1', 'anticipadas' => 'Anticipadas'] as $key => $title)
                @if($clienteSeleccionado['lineas'][$key]->isNotEmpty())
                <h4 class="mt-4 mb-2 font-semibold text-gray-900 dark:text-gray-100">{{ $title }}</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">DN</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Fecha</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Plan</th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">Equipo</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach($clienteSeleccionado['lineas'][$key] as $linea)
                                <tr class="dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">{{ $linea->dn }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">{{ \Carbon\Carbon::parse($linea->fecha)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">{{ $linea->plan }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400">{{ $linea->equipo }}</td>
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
