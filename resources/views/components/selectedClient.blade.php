@props(['client'])

<div class="p-6 bg-white rounded-lg shadow-md">
    <div
        class="w-full divide-y divide-slate-300 overflow-hidden rounded-xl border border-slate-300 bg-slate-100/40 text-slate-700 dark:divide-slate-700 dark:border-slate-700 dark:bg-slate-800/50 dark:text-slate-300">
        <div x-data="{ isExpanded: false }" class="divide-y divide-slate-300 dark:divide-slate-700">
            <button id="controlsAccordionClient" type="button"
                class="flex w-full items-center justify-between gap-4 bg-slate-100 p-4 text-left underline-offset-2 hover:bg-slate-100/75 focus-visible:bg-slate-100/75 focus-visible:underline focus-visible:outline-none dark:bg-slate-800 dark:hover:bg-slate-800/75 dark:focus-visible:bg-slate-800/75"
                aria-controls="accordionClient" @click="isExpanded = !isExpanded"
                :class="isExpanded ? 'text-onSurfaceStrong dark:text-onSurfaceDarkStrong font-bold' :
                    'text-onSurface dark:text-onSurfaceDark font-medium'"
                :aria-expanded="isExpanded ? 'true' : 'false'">
                {{ $client->razon }}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2"
                    stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true"
                    :class="isExpanded ? 'rotate-180' : ''">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div x-cloak x-show="isExpanded" id="accordionClient" role="region"
                aria-labelledby="controlsAccordionClient" x-collapse>
                <div class="p-4 text-sm sm:text-base text-pretty">
                    <p>NUMERO DE CUENTA: {{ $client->cuenta }}</p>
                    <p>ID DE LA CUENTA: {{ $client->id_cliente }}</p>
                    <p>REPRESENTANTE LEGAL: {{ $client->representante }}</p>
                    <p>TELEFONO: {{ $client->telefono }}</p>
                    <p>CORREO: {{ $client->correo }}</p>
                    <p>RFC: {{ $client->rfc }}</p>
                    <div class="mt-6">
                        <h2 class="text-xl font-bold">FECHA DE ACTUALIZACION</h2>
                        <p>{{ $this->formatDate($client->updated_at) }}</p>
                        <h2 class="text-xl font-bold mt-4">USUARIO</h2>
                        <p>{{ $client->user->username }}</p>
                    </div>
                    <div class="mt-6">
                        @if(Auth::user()->isSuperAdmin() || Auth::user()->can('editar-cliente'))
                        <x-button wire:click="$dispatch('editCliente', { id: {{ $client->id }} })">
                            {{ __('Editar') }}
                        </x-button>
                        @endif
                        @if(Auth::user()->isSuperAdmin() || Auth::user()->can('ver-cambios'))
                        <x-button wire:click="$dispatch('showHistorial', { clienteId: {{ $client->id }} })">
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
                <h3 class="font-bold">DIRECCION FISCAL</h3>
                <x-textarea class="w-full h-24">
                    {{ $client->fiscal }}
                </x-textarea>
            </div>
            <div>
                <h3 class="font-bold">DIRECCION ENTREGA</h3>
                <x-textarea class="w-full h-24">
                    {{ $client->entrega }}
                </x-textarea>
            </div>
        </div>

        <div class="mt-6">
            @if(Auth::user()->isSuperAdmin() || Auth::user()->can('ver-eliminados'))
            @livewire('modal-show-deleted-lineas', ['cliente_id' => $client->id])
            @endif
            @livewire('lineas', ['cliente_id' => $client->id])
        </div>
    </div>
</div>
