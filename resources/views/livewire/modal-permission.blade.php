<div>
    <x-button wire:click="$set('modalVisible', true)">Crear Permiso</x-button>

    <x-dialog-modal wire:model="modalVisible">
        <x-slot name="title">
            {{ $permissionId ? 'Editar Permiso' : 'Crear Permiso' }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" wire:model.defer="name" autocomplete="off" />
                @error('name') <span class="error">{{ $message }}</span> @enderror
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
