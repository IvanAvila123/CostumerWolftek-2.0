<div class="bg-white dark:bg-gray-800">
    <x-button wire:click="mostrarDetalles">Ver Venta</x-button>

    <x-large-dialog-modal wire:model="modalVisible">
        <h1 class="mb-4 text-2xl font-bold text-gray-900 dark:text-gray-100">Detalles de la Venta</h1>

        <x-slot name="content">
            @if ($oportunidad)
                <div class="">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="relative p-6 bg-white rounded-lg shadow-lg dark:bg-gray-700">
                            <div class="flex justify-end">
                                <a href="#" class="mb-4 font-bold text-red-500 dark:text-red-400">Informacion del
                                    Cliente</a>
                            </div>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div x-data="{ showTooltip: false }" class="relative">
                                    <h3 class="mb-1 text-xl font-bold text-center">Razon Social</h3>
                                    <p class="mb-4 text-sm text-center text-blue-500 truncate cursor-pointer"
                                        @mouseenter="showTooltip = true" @mouseleave="showTooltip = false">
                                        {{ $oportunidad->cliente->razon }}
                                    </p>
                                    <div x-show="showTooltip"
                                        class="absolute z-10 p-2 text-xs text-white bg-gray-800 rounded shadow-lg"
                                        style="top: 100%; left: 50%; transform: translateX(-50%);">
                                        {{ $oportunidad->cliente->razon }}
                                    </div>
                                </div>

                                <div>
                                    <h3 class="mb-1 text-xl font-bold text-center">Cuenta Financiera</h3>
                                    <p class="mb-4 text-sm text-center text-blue-500">
                                        {{ $oportunidad->cliente->cuenta }}</p>
                                </div>

                                <div>
                                    <h3 class="mb-1 text-xl font-bold text-center">ID Del Cliente</h3>
                                    <p class="mb-4 text-sm text-center text-blue-500">
                                        {{ $oportunidad->cliente->id_cliente }}</p>
                                </div>
                            </div>

                            <div class="flex justify-between">

                                <div>
                                    <h3 class="mb-1 text-xl font-bold text-center">Vendedor</h3>
                                    <p class="mb-4 text-sm text-center text-blue-500">{{ $oportunidad->vendedor }}</p>
                                </div>

                                <div>
                                    <h3 class="mb-1 text-xl font-bold text-center">Tipo De Venta</h3>
                                    <p class="mb-4 text-sm text-center text-blue-500">{{ $oportunidad->venta }}</p>
                                </div>

                                <div>
                                    <h3 class="mb-1 text-xl font-bold text-center">Persona Autorizada</h3>
                                    <p class="mb-4 text-sm text-center text-blue-500">{{ $oportunidad->autorizada }}</p>
                                </div>

                            </div>

                            <div class="flex justify-between">

                                <div>
                                    <h3 class="mb-1 text-xl font-bold text-center">N° De Acuerdo</h3>
                                    <p class="mb-4 text-sm text-center text-blue-500">{{ $oportunidad->acuerdo }}</p>
                                </div>

                                <div>
                                    <h3 class="mb-1 text-xl font-bold text-center">Ultima Actualizacion</h3>
                                    <p class="mb-4 text-sm text-center text-blue-500">
                                        {{ \Carbon\Carbon::parse($oportunidad->actualizacion)->format('d/m/Y') }}
                                    </p>
                                </div>

                                <div>
                                    <h3 class="mb-1 text-xl font-bold text-center">Estado De La Venta</h3>
                                    <p class="mb-4 text-sm text-center text-blue-500">{{ $oportunidad->estado }}</p>
                                </div>
                            </div>

                            <div class="flex justify-center">

                                <x-textarea class="w-full text-center"
                                    readonly>{{ $oportunidad->entrega }}</x-textarea>

                            </div>



                        </div>

                        <!-- Card 2 -->
                        <div class="relative p-6 bg-white rounded-lg shadow-lg dark:bg-gray-700">

                            <div class="flex justify-end">
                                <a href="#" class="mb-4 font-bold text-red-500">Comentarios De la Venta</a>
                            </div>

                            <div class="flex justify-start">
                                <x-textarea class="w-full h-full" readonly>{!! $oportunidad->comentarios !!}</x-textarea>
                            </div>

                        </div>
                    </div>

                    @if ($oportunidad->lineas->isNotEmpty())
                        <div class="mt-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Líneas Asociadas</h3>
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                            DN</th>
                                        <th
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                            Plan</th>
                                        <th
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                            Fecha</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    @foreach ($oportunidad->lineas as $linea)
                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-gray-300">
                                                {{ $linea->dn }}</td>
                                            <td class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-gray-300">
                                                {{ $linea->plan }}</td>
                                            <td class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-gray-300">
                                                {{ $linea->pivot->fecha_linea ? \Carbon\Carbon::parse($linea->pivot->fecha_linea)->format('d/m/Y') : 'N/A' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="flex justify-center mt-6">
                            <p class="text-sm text-center text-blue-500 dark:text-blue-400">
                                No se encontraron lineas ya que es una venta nueva o adicion
                            </p>
                        </div>
                    @endif
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('modalVisible', false)">
                Cerrar
            </x-secondary-button>
        </x-slot>
    </x-large-dialog-modal>
</div>
