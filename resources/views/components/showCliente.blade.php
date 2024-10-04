@props(['clientes'])

@foreach ($clientes as $cliente)
    <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <div
            class="w-full overflow-hidden text-gray-700 border border-gray-300 divide-y divide-gray-300 dark:divide-gray-700 rounded-xl dark:border-gray-700 bg-gray-100/40 dark:bg-gray-800/50 dark:text-gray-300">
            <div x-data="{ isExpanded: false }" class="divide-y divide-gray-300 dark:divide-gray-700">
                <button id="controlsAccordionClient" type="button"
                    class="flex items-center justify-between w-full gap-4 p-4 text-left bg-gray-100 dark:bg-gray-800 underline-offset-2 hover:bg-gray-200 dark:hover:bg-gray-700 focus-visible:bg-gray-200 dark:focus-visible:bg-gray-700 focus-visible:underline focus-visible:outline-none"
                    aria-controls="accordionClient" @click="isExpanded = !isExpanded"
                    :class="isExpanded ? 'text-gray-900 dark:text-white font-bold' : 'text-gray-700 dark:text-gray-300 font-medium'"
                    :aria-expanded="isExpanded ? 'true' : 'false'">
                    {{ $cliente->razon }}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5 transition-transform duration-200" aria-hidden="true"
                        :class="isExpanded ? 'rotate-180' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div x-cloak x-show="isExpanded" id="accordionClient" role="region"
                    aria-labelledby="controlsAccordionClient" x-collapse>
                    <div class="p-4 text-sm text-gray-700 sm:text-base dark:text-gray-300">
                        <p>NUMERO DE CUENTA: {{ $cliente->cuenta }}</p>
                        <p>ID DE LA CUENTA: {{ $cliente->id_cliente }}</p>
                        <p>REPRESENTANTE LEGAL: {{ $cliente->representante }}</p>
                        <p>TELEFONO: {{ $cliente->telefono }}</p>
                        <p>CORREO: {{ $cliente->correo }}</p>
                        <p>RFC: {{ $cliente->rfc }}</p>
                        <div class="mt-6">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">FECHA DE ACTUALIZACION</h2>
                            <p>{{ $this->formatDate($cliente->updated_at) }}</p>
                            <h2 class="mt-4 text-xl font-bold text-gray-900 dark:text-white">USUARIO</h2>
                            <p>{{ $cliente->user->username }}</p>
                        </div>
                        <div class="mt-6">
                            @if(Auth::user()->isSuperAdmin() || Auth::user()->can('editar-cliente'))
                            <x-button wire:click="$dispatch('editCliente', { id: {{ $cliente->id }} })" class="text-white bg-blue-500 hover:bg-blue-600">
                                {{ __('Editar') }}
                            </x-button>
                            @endif
                            @if(Auth::user()->isSuperAdmin() || Auth::user()->can('ver-cambios'))
                            <x-button wire:click="$dispatch('showHistorial', { clienteId: {{ $cliente->id }} })" class="text-white bg-green-500 hover:bg-green-600">
                                {{ __('Ver Historial De Cambios') }}
                            </x-button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-white">DIRECCION FISCAL</h3>
                    <x-textarea class="w-full h-24 text-gray-900 bg-white dark:bg-gray-700 dark:text-white" readonly>
                        {{ $cliente->fiscal }}
                    </x-textarea>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 dark:text-white">DIRECCION ENTREGA</h3>
                    <x-textarea class="w-full h-24 text-gray-900 bg-white dark:bg-gray-700 dark:text-white" readonly>
                        {{ $cliente->entrega }}
                    </x-textarea>
                </div>
            </div>

            <div class="mt-6">
                @can('ver-eliminados')
                @livewire('modal-show-deleted-lineas', ['cliente_id' => $cliente->id])
                @endcan
                @livewire('lineas', ['cliente_id' => $cliente->id])
            </div>
        </div>
    </div>
@endforeach
@if ($clientes && count($clientes) == 0)
    <div class="flex justify-center text-gray-700 dark:text-gray-300">
        <h2>No se Encontro El Cliente Favor De Validar</h2>
    </div>
@endif
