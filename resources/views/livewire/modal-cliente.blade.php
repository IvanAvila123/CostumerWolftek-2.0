<div>
    <x-button wire:click="$set('modalVisible', true)">Crear Cliente</x-button>


<x-dialog-modal wire:model="modalVisible">
    <x-slot name="title" class="text-gray-900 dark:text-gray-100">
        {{ $clienteId ? 'Editar Cliente' : 'Crear Cliente' }}
    </x-slot>

    <x-slot name="content">

        <input type="hidden" wire:model="user_id">
        <input type="hidden" wire:model="ejecutivo">

        <div class="mt-4">
            <x-label for="razon" value="{{ __('Razon Social') }}" />
            <x-input id="razon" class="block w-full mt-1" type="text" wire:model.defer="razon"
                autocomplete="off" />
            @error('razon')
            <span class="text-red-600 error dark:text-red-400">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <x-label for="cuenta" value="{{ __('Cuenta Financiera') }}" />
            <x-input id="cuenta" class="block w-full mt-1" type="text" wire:model.defer="cuenta"
                autocomplete="off" />
            @error('cuenta')
            <span class="text-red-600 error dark:text-red-400">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <x-label for="id_cliente" value="{{ __('Id De La Cuenta') }}" />
            <x-input id="id_cliente" class="block w-full mt-1" type="text" wire:model.defer="id_cliente"
                autocomplete="off" />
            @error('id_cliente')
            <span class="text-red-600 error dark:text-red-400">{{ $message }}</span>
            @enderror
            @if ($errorMessage)
            <div class="mt-2 text-red-600 dark:text-red-400">
                {{ $errorMessage }}
            </div>
            @endif
        </div>

        <div class="mt-4">
            <x-label for="representante" value="{{ __('Representante Legal') }}" />
            <x-input id="representante" class="block w-full mt-1" type="text" wire:model.defer="representante"
                autocomplete="off" />
            @error('representante')
            <span class="text-red-600 error dark:text-red-400">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <x-label for="telefono" value="{{ __('Telefono') }}" />
            <x-input id="telefono" class="block w-full mt-1" type="text" wire:model.defer="telefono"
                autocomplete="off" />
            @error('telefono')
            <span class="text-red-600 error dark:text-red-400">{{ $message }}</span>
            @enderror
        </div>
        <div class="mt-4">
            <x-label for="correo" value="{{ __('Correo') }}" />
            <x-input id="correo" class="block w-full mt-1" type="text" wire:model.defer="correo"
                autocomplete="off" />
            @error('correo')
            <span class="text-red-600 error dark:text-red-400">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <x-label for="fiscal" value="{{ __('Direccion Fiscal') }}" />
            <x-input id="fiscal" class="block w-full mt-1" type="text" wire:model.defer="fiscal"
                autocomplete="off" />
            @error('fiscal')
            <span class="text-red-600 error dark:text-red-400">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <x-label for="entrega" value="{{ __('Direccion De Entrega') }}" />
            <x-input id="entrega" class="block w-full mt-1" type="text" wire:model.defer="entrega"
                autocomplete="off" />
            @error('entrega')
            <span class="text-red-600 error dark:text-red-400">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <x-label for="rfc" value="{{ __('RFC') }}" />
            <x-input id="rfc" class="block w-full mt-1" type="text" wire:model.defer="rfc"
                autocomplete="off" />
            @error('rfc')
            <span class="text-red-600 error dark:text-red-400">{{ $message }}</span>
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


@push('js')
<script>
    Livewire.on()
</script>
    @endpush

</div>
