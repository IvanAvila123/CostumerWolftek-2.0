<div>
    <x-button wire:click="$set('modalVisible', true)">Crear Linea</x-button>

    <x-dialog-modal wire:model="modalVisible">
        <x-slot name="title">
            {{ $lineaId ? 'Editar Linea' : 'Crear Linea' }}
        </x-slot>

        <x-slot name="content">

            <input type="hidden" wire:model="cliente_id">
            <input type="hidden" wire:model="user_id">
            <input type="hidden" wire:model="id_distribuidor">


            <div class="mt-4">
                <x-label for="dn" value="{{ __('DN') }}" />
                <x-input id="dn" class="block mt-1 w-full" type="text" max='10' wire:model.defer="dn"
                    autocomplete="off" />
                @error('dn')
                    <span class="error">{{ $message }}</span>
                @enderror
                @if ($errorMessage)
                    <div class="mt-2 text-red-600">
                        {{ $errorMessage }}
                    </div>
                @endif
            </div>
            <div class="mt-4">
                <x-label for="fecha" value="{{ __('Fecha Fin') }}" />
                <x-input id="fecha" class="block mt-1 w-full" type="date" wire:model="fecha"
                    autocomplete="off" />
                @error('fecha')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-label for="plan" value="{{ __('Plan') }}" />
                <x-input id="plan" class="block mt-1 w-full" type="text" wire:model.defer="plan"
                    autocomplete="off" />
                @error('plan')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div class="mt-4">
                <x-label for="equipo" value="{{ __('Equipo') }}" />
                <x-input id="equipo" class="block mt-1 w-full" type="text" wire:model.defer="equipo"
                    autocomplete="off" />
                @error('equipo')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeModal" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
                {{ __('Guardar') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
