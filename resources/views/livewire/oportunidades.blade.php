<div>
    <div x-data="{ showAlert: @entangle('alert.show') }" x-show="showAlert" x-effect="if (showAlert) setTimeout(() => $wire.hideAlert(), 5000)">
        <x-alerts :type="$alert['type']" :message="$alert['message']" />
    </div>

    <div class="p-6">
        <div class="flex mb-4 space-x-4 overflow-auto">
            @if (Auth::user()->isSuperAdmin() || $user->hasRole(['Manager', 'Capturista']))
                <input wire:model.live="search" type="text" placeholder="Buscar por vendedor, razón o estado"
                    class="w-full max-w-sm px-4 py-2 border rounded-md">
            @endif

            @if ($user->hasRole('Vendedor'))
                <input wire:model.live="search" type="text" placeholder="Busca tu venta"
                    class="w-full max-w-sm px-4 py-2 border rounded-md">
            @endif

            @if (Auth::user()->isSuperAdmin() || $user->hasRole(['Manager', 'Capturista']))
                <select wire:model.live="tipoFiltro" class="w-full px-4 py-2 border rounded-md md:w-48">
                    <option value="">Todos los tipos de venta</option>
                    <option value="Renovacion">Renovación</option>
                    <option value="Adicion">Adición</option>
                    <option value="Renovacion Anticipada T-1">Renovación Anticipada T-1</option>
                    <option value="Renovacion Anticipada">Renovación Anticipada</option>
                    <option value="Venta Nueva">Venta Nueva</option>
                </select>

                <select wire:model.live="estadoFiltro" class="w-full px-4 py-2 border rounded-md md:w-48">
                    <option value="">Todos los estados</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Aprobada">Aprobada</option>
                    <option value="Rechazada">Rechazada</option>
                    <option value="Revisando Venta">Revisando Venta</option>
                    <option value="Verificacion De Credito">Verificacion De Credito</option>
                    <option value="Rechazada Por Credito">Rechazada Por Credito</option>
                    <option value="Orden Entregada">Orden Entregada</option>
                </select>

                <input wire:model.live="fechaInicioFiltro" type="date"
                    class="w-full px-4 py-2 border rounded-md md:w-40" placeholder="Fecha inicio">
                <input wire:model.live="fechaFinFiltro" type="date"
                    class="w-full px-4 py-2 border rounded-md md:w-40" placeholder="Fecha fin">
            @endif

            @if ($user->hasRole('Vendedor'))
                <select wire:model.live="tipoFiltro" class="px-4 py-2 border rounded-md">
                    <option value="">Todos los tipos de venta</option>
                    <option value="Renovacion">Renovación</option>
                    <option value="Adicion">Adición</option>
                    <option value="Renovacion Anticipada T-1">Renovación Anticipada T-1</option>
                    <option value="Renovacion Anticipada">Renovación Anticipada</option>
                    <option value="Venta Nueva">Venta Nueva</option>
                </select>

                <select wire:model.live="estadoFiltro" class="px-4 py-2 border rounded-md">
                    <option value="">Todos los estados</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Aprobada">Aprobada</option>
                    <option value="Rechazada">Rechazada</option>
                    <option value="Revisando Venta">Revisando Venta</option>
                    <option value="Verificacion De Credito">Verificacion De Credito</option>
                    <option value="Rechazada Por Credito">Rechazada Por Credito</option>
                    <option value="Orden Entregada">Orden Entregada</option>
                </select>
            @endif

            @if (Auth::user()->isSuperAdmin() || $user->hasRole(['Manager', 'Capturista']))
                @livewire('sales-reports');
            @endif

            @livewire('modal-oportunidad')

        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    @if (Auth::user()->isSuperAdmin() || $user->hasRole(['Manager', 'Capturista']))
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Tipo De Venta</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Razón Social</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Vendedor</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Estado De La Venta</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Acciones</th>
                        </tr>
                    @endif
                    @if ($user->hasRole('Vendedor'))
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Tipo De Venta</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Razón Social</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Estado</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                Acciones</th>
                        </tr>
                    @endif
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($oportunidades as $oportunidad)
                        @if (Auth::user()->isSuperAdmin() || $user->hasRole(['Manager', 'Capturista']))
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $oportunidad->venta }}</td>
                                <td class="relative px-6 py-4 whitespace-nowrap" x-data="{ tooltip: false }">
                                    <div class="max-w-xs truncate cursor-pointer"
                                         @mouseenter="tooltip = true"
                                         @mouseleave="tooltip = false">
                                        {{ $oportunidad->cliente->razon }}
                                    </div>
                                    <div x-show="tooltip"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 transform scale-95"
                                         x-transition:enter-end="opacity-100 transform scale-100"
                                         x-transition:leave="transition ease-in duration-100"
                                         x-transition:leave-start="opacity-100 transform scale-100"
                                         x-transition:leave-end="opacity-0 transform scale-95"
                                         class="absolute z-50 px-2 py-1 text-sm text-white bg-black rounded-lg shadow-lg"
                                         style="top: 100%; left: 0; white-space: nowrap;"
                                         x-cloak>
                                        {{ $oportunidad->cliente->razon }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $oportunidad->vendedor }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $oportunidad->estado }}</td>
                                <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        @livewire('ver-Venta', ['id_oportunidad' => $oportunidad->id], key('ver-venta-' . $oportunidad->id))
                                        @if (Auth::user()->can('aprobar-rechazar-ventas'))
                                            @if (in_array($oportunidad->estado, [
                                                    'Pendiente',
                                                    'Revisando Venta',
                                                    'Rechazada Por Credito',
                                                    'Verificacion de Credito Rechazada',
                                                ]))
                                                @if ($oportunidad->estado != 'Aprobada')
                                                    <x-success-button
                                                        wire:click="aprobarOportunidad({{ $oportunidad->id }})">
                                                        Aprobar
                                                    </x-success-button>
                                                    <x-danger-button
                                                        wire:click="mostrarModalRechazo({{ $oportunidad->id }})">
                                                        {{ in_array($oportunidad->estado, ['Rechazada', 'Rechazada Por Credito', 'Verificacion de Credito Rechazada']) ? 'Editar Rechazo' : 'Rechazar' }}
                                                    </x-danger-button>
                                                @endif
                                            @endif
                                        @endif
                                        <x-secondary-button
                                            wire:click="$dispatch('editOportunidad', { id: {{ $oportunidad['id'] }} })">
                                            {{ __('Editar') }}
                                        </x-secondary-button>
                                        <x-secondary-button wire:click="delete({{ $oportunidad['id'] }})"
                                            wire:confirm="¿Estás seguro de que deseas eliminar esta oportunidad?">
                                            {{ __('Eliminar') }}
                                        </x-secondary-button>
                                    </div>
                                </td>
                            </tr>
                        @endif

                        @if ($user->hasRole('Vendedor'))
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $oportunidad->venta }}</td>
                                <td class="relative px-6 py-4 whitespace-nowrap" x-data="{ tooltip: false }">
                                    <div class="max-w-xs truncate cursor-pointer"
                                         @mouseenter="tooltip = true"
                                         @mouseleave="tooltip = false">
                                        {{ $oportunidad->cliente->razon }}
                                    </div>
                                    <div x-show="tooltip"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 transform scale-95"
                                         x-transition:enter-end="opacity-100 transform scale-100"
                                         x-transition:leave="transition ease-in duration-100"
                                         x-transition:leave-start="opacity-100 transform scale-100"
                                         x-transition:leave-end="opacity-0 transform scale-95"
                                         class="absolute z-50 px-2 py-1 text-sm text-white bg-black rounded-lg shadow-lg"
                                         style="top: 100%; left: 0; white-space: nowrap;"
                                         x-cloak>
                                        {{ $oportunidad->cliente->razon }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $oportunidad->estado }}</td>
                                <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        @livewire('ver-Venta', ['id_oportunidad' => $oportunidad->id], key('ver-venta-' . $oportunidad->id))

                                        @if ($oportunidad->estado == 'Rechazada')
                                            <x-success-button
                                                wire:click="reingresarOportunidad({{ $oportunidad->id }})">Reingresar</x-success-button>
                                        @endif
                                        @if ($oportunidad->estado == 'Se Entrega Contratos')
                                            <x-success-button
                                                wire:click="reingresarOportunidad({{ $oportunidad->id }})">Reingresar</x-success-button>
                                        @endif
                                        @if ($oportunidad->estado == 'Pendiente')
                                            <x-secondary-button
                                                wire:click="$dispatch('editOportunidad', { id: {{ $oportunidad['id'] }} })">
                                                {{ __('Editar') }}
                                            </x-secondary-button>
                                            <x-danger-button wire:click="delete({{ $oportunidad['id'] }})"
                                                wire:confirm="¿Estás seguro de que deseas eliminar esta oportunidad?">
                                                {{ __('Eliminar') }}
                                            </x-danger-button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $oportunidades->links() }}
        </div>

        <x-dialog-modal wire:model="modalRechazoVisible">
            <x-slot name="title">
                {{ $estado == 'Rechazada' ? 'Editar Rechazo' : 'Rechazar Oportunidad' }}
            </x-slot>

            <x-slot name="content">
                <div class="mt-4">
                    <x-label for="comentarios" value="{{ __('Comentarios') }}" />
                    <x-textarea id="comentarios" class="block w-full mt-1" wire:model.defer="comentarios" />
                    @error('comentarios')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mt-4">
                    <x-label for="estado" value="{{ __('Estado') }}" />
                    <select id="estado" class="block w-full mt-1" wire:model="estado">
                        <option value="Revisando Venta">Revisando Venta</option>
                        <option value="Rechazada">Rechazada</option>
                        <option value="Rechazada Por Credito">Rechazada Por Credito</option>
                        <option value="Verificacion de Credito Rechazada">Verificacion de Credito Rechazada</option>
                    </select>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$set('modalRechazoVisible', false)" wire:loading.attr="disabled">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="ml-2" wire:click="guardarComentarios" wire:loading.attr="disabled">
                    {{ __('Guardar') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </div>
</div>
