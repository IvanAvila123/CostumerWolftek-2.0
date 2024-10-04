<div>
    <x-button wire:click="$set('modalVisible', true)">Crear Distribuidor</x-button>

    <x-dialog-modal wire:model="modalVisible">
        <x-slot name="title">
            {{ $distribuidoresId ? 'Editar Distribuidor' : 'Crear Distribuidor' }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-label for="nombre" value="{{ __('Nombre') }}" />
                <x-input id="nombre" class="block mt-1 w-full" type="text" wire:model.defer="nombre" autocomplete="off" />
                @error('nombre') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-label for="apellido" value="{{ __('Apellido') }}" />
                <x-input id="apellido" class="block mt-1 w-full" type="text" wire:model.defer="apellido" autocomplete="off" />
                @error('apellido') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-label for="correo" value="{{ __('Correo') }}" />
                <x-input id="correo" class="block mt-1 w-full" type="email" wire:model.defer="correo" autocomplete="off" />
                @error('correo') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="mt-4">
                <x-label for="telefono" value="{{ __('Telefono') }}" />
                <x-input id="telefono" class="block mt-1 w-full" type="text" wire:model.defer="telefono" autocomplete="off" />
                @error('telefono') <span class="error">{{ $message }}</span> @enderror
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('modalVisible', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
                {{ __('Guardar') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>


