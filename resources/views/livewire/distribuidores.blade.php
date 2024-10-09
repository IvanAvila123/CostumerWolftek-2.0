<div class="bg-white dark:bg-gray-800">
    <div class="w-full mx-auto">
        <x-datatable
            :headings="$headings"
            :rows="$distribuidores"
            :sortField="$sortField"
            :sortDirection="$sortDirection"
            class="text-gray-900 dark:text-gray-100"
        >
            @foreach($distribuidores as $distribuidor)
                <x-slot :name="'actions_'.$distribuidor['id']">
                    <x-button wire:click="$dispatch('editDistribuidor', { id: {{ $distribuidor['id'] }} })">
                        {{ __('Editar') }}
                    </x-button>
                    <x-danger-button wire:click="delete({{ $distribuidor['id'] }})"
                        wire:confirm="¿Estás seguro de que deseas eliminar este distribuidor?">
                        {{ __('Eliminar') }}
                    </x-danger-button>
                </x-slot>
            @endforeach
        </x-datatable>
    </div>
</div>
