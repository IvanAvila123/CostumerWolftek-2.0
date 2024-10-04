<div>
    <x-button wire:click="mostrarDetalles">Ver Venta</x-button>

    <x-large-dialog-modal wire:model="modalVisible">
        <h1 class="text-2xl font-bold mb-4">Detalles de la Venta</h1>

        <x-slot name="content">
            @if ($oportunidad)
                <div class="">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white p-6 rounded-lg shadow-lg relative">
                            <div class="flex justify-end">
                                <a href="#" class="text-red-500 font-bold mb-4">Informacion del Cliente</a>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div x-data="{ showTooltip: false }" class="relative">
                                    <h3 class="text-xl font-bold mb-1 text-center">Razon Social</h3>
                                    <p class="text-sm text-blue-500 mb-4 text-center truncate cursor-pointer"
                                       @mouseenter="showTooltip = true"
                                       @mouseleave="showTooltip = false">
                                        {{ $oportunidad->cliente->razon }}
                                    </p>
                                    <div x-show="showTooltip"
                                         class="absolute z-10 p-2 bg-gray-800 text-white text-xs rounded shadow-lg"
                                         style="top: 100%; left: 50%; transform: translateX(-50%);">
                                        {{ $oportunidad->cliente->razon }}
                                    </div>
                                </div>

                                <div>
                                    <h3 class="text-xl font-bold mb-1 text-center">Cuenta Financiera</h3>
                                    <p class="text-sm text-blue-500 mb-4 text-center">{{ $oportunidad->cliente->cuenta }}</p>
                                </div>

                                <div>
                                    <h3 class="text-xl font-bold mb-1 text-center">ID Del Cliente</h3>
                                    <p class="text-sm text-blue-500 mb-4 text-center">{{ $oportunidad->cliente->id_cliente }}</p>
                                </div>
                            </div>

                            <div class="flex justify-between">

                                <div>
                                    <h3 class="text-xl font-bold mb-1 text-center">Vendedor</h3>
                                    <p class="text-sm text-blue-500 mb-4 text-center">{{ $oportunidad->vendedor }}</p>
                                </div>

                                <div>
                                    <h3 class="text-xl font-bold mb-1 text-center">Tipo De Venta</h3>
                                    <p class="text-sm text-blue-500 mb-4 text-center">{{ $oportunidad->venta }}</p>
                                </div>

                                <div>
                                    <h3 class="text-xl font-bold mb-1 text-center">Persona Autorizada</h3>
                                    <p class="text-sm text-blue-500 mb-4 text-center">{{ $oportunidad->autorizada }}</p>
                                </div>

                            </div>

                            <div class="flex justify-between">

                                <div>
                                    <h3 class="text-xl font-bold mb-1 text-center">N° De Acuerdo</h3>
                                    <p class="text-sm text-blue-500 mb-4 text-center">{{ $oportunidad->acuerdo }}</p>
                                </div>

                                <div>
                                    <h3 class="text-xl font-bold mb-1 text-center">Ultima Actualizacion</h3>
                                    <p class="text-sm text-blue-500 mb-4 text-center">
                                        {{ \Carbon\Carbon::parse($oportunidad->actualizacion)->format('d/m/Y') }}
                                    </p>
                                </div>

                                <div>
                                    <h3 class="text-xl font-bold mb-1 text-center">Estado De La Venta</h3>
                                    <p class="text-sm text-blue-500 mb-4 text-center">{{ $oportunidad->estado }}</p>
                                </div>
                            </div>

                            <div class="flex justify-center">

                                <x-textarea class="w-full text-center" readonly>{{ $oportunidad->entrega }}</x-textarea>

                            </div>



                        </div>

                        <!-- Card 2 -->
                        <div class="bg-white p-6 rounded-lg shadow-lg relative">

                            <div class="flex justify-end">
                                <a href="#" class="text-red-500 font-bold mb-4">Comentarios De la Venta</a>
                            </div>

                            <div class="flex justify-start">
                                <x-textarea class="w-full h-full" readonly>{!! $oportunidad->comentarios !!}</x-textarea>
                            </div>

                    </div>
                </div>

                @if ($oportunidad->lineas->isNotEmpty())
                    <div class="mt-4">
                        <h3 class="font-bold text-lg">Líneas Asociadas</h3>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        DN</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Plan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($oportunidad->lineas as $linea)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $linea->dn }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $linea->plan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap"> {{ \Carbon\Carbon::parse($linea->pivot->fecha_linea)->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                                @else
                            <div class="flex justify-center mt-6">
                                <td class="text-sm text-blue-500 text-center">
                                    No se encontraron lineas ya que es una venta nueva o adicion
                                </td>
                            </div>

                            </tbody>
                        </table>
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
