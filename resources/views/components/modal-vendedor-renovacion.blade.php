<x-dialog-modal wire:model="modalVisible">
    <x-slot name="title" class="text-gray-900 dark:text-gray-100">
        Adquirir Venta
    </x-slot>

    <x-slot name="content">
        <div class="mt-4">
            <x-label for="nombreVendedor" value="{{ __('Nombre del vendedor') }}" class="text-gray-700 dark:text-gray-300" />
            <x-input id="nombreVendedor" class="block w-full mt-1 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600" type="text" wire:model.defer="nombreVendedor" autocomplete="off" />
            @error('nombreVendedor') <span class="text-red-600 error dark:text-red-400">{{ $message }}</span> @enderror
        </div>
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="$set('modalVisible', false)" wire:loading.attr="disabled">
            {{ __('Cancelar') }}
        </x-secondary-button>

        <x-button wire:click="adquirirVenta" wire:loading.attr="disabled">
            {{ __('Guardar') }}
        </x-button>
    </x-slot>
</x-dialog-modal>
