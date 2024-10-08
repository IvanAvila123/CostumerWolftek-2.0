<div class="bg-white dark:bg-gray-800">
    <div class="w-full mx-auto">
        <div class="flex justify-end mb-4 mr-4">
            @if(Auth::user()->isSuperAdmin() || Auth::user()->can('crear-linea'))
                @livewire('modal-linea', ['cliente_id' => $cliente_id])
            @endif
            @if(Auth::user()->isSuperAdmin() || Auth::user()->can('borrar-linea'))
                @if (empty($selectedRows))
                    <x-danger-button disabled class="opacity-50 cursor-not-allowed">
                        Eliminar seleccionados
                    </x-danger-button>
                @else
                    <x-danger-button wire:click="deleteSelected"
                        wire:confirm="¿Estás seguro de que deseas eliminar las líneas seleccionadas?"
                        >
                        Eliminar seleccionados
                    </x-danger-button>
                @endif
            @endif
        </div>

        <x-datatable
            :headings="$headings"
            :rows="$lineas"
            :sortField="$sortField"
            :sortDirection="$sortDirection"
            class="text-gray-900 bg-white dark:bg-gray-800 dark:text-gray-100"
        >
            @foreach($lineas as $linea)
                <x-slot :name="'actions_'.$linea['id']">
                    @if(Auth::user()->isSuperAdmin() || Auth::user()->can('editar-linea'))
                        <x-button wire:click="$dispatch('editLinea', { id: {{ $linea['id'] }} })"
                            >
                            {{ __('Editar') }}
                        </x-button>
                    @endif
                    @if(Auth::user()->isSuperAdmin() || Auth::user()->can('borrar-linea'))
                        <x-danger-button wire:click="delete({{ $linea['id'] }})"
                            wire:confirm="¿Estás seguro de que deseas eliminar esta linea?"
                            >
                            {{ __('Eliminar') }}
                        </x-danger-button>
                    @endif
                </x-slot>
            @endforeach
        </x-datatable>
    </div>
</div>
