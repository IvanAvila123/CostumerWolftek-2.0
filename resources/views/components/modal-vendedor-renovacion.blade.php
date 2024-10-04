<x-dialog-modal wire:model="modalVisible">
    <x-slot name="title">
        Adquirir Venta
    </x-slot>

    <x-slot name="content">
        <div class="mt-4">
            <x-label for="nombreVendedor" value="{{ __('Nombre del vendedor') }}" />
            <x-input id="nombreVendedor" class="block w-full mt-1" type="text" wire:model.defer="nombreVendedor" autocomplete="off" />
            @error('nombreVendedor') <span class="error">{{ $message }}</span> @enderror
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="$set('modalVisible', false)" wire:loading.attr="disabled">
            {{ __('Cancelar') }}
        </x-secondary-button>

        <x-button class="ml-2" wire:click="adquirirVenta" wire:loading.attr="disabled">
            {{ __('Guardar') }}
        </x-button>
    </x-slot>
</x-dialog-modal>
