<div>
    <x-button wire:click="$set('modalVisible', true)">Crear Cliente</x-button>


<x-dialog-modal wire:model="modalVisible">
    <x-slot name="title">
        {{ $clienteId ? 'Editar Cliente' : 'Crear Cliente' }}
    </x-slot>

    <x-slot name="content">

        <input type="hidden" wire:model="user_id">
        <input type="hidden" wire:model="ejecutivo">

        <div class="mt-4">
            <x-label for="razon" value="{{ __('Razon Social') }}" />
            <x-input id="razon" class="block mt-1 w-full" type="text" wire:model.defer="razon"
                autocomplete="off" />
            @error('razon')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <x-label for="cuenta" value="{{ __('Cuenta Financiera') }}" />
            <x-input id="cuenta" class="block mt-1 w-full" type="text" wire:model.defer="cuenta"
                autocomplete="off" />
            @error('cuenta')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <x-label for="id_cliente" value="{{ __('Id De La Cuenta') }}" />
            <x-input id="id_cliente" class="block mt-1 w-full" type="text" wire:model.defer="id_cliente"
                autocomplete="off" />
            @error('id_cliente')
                <span class="error">{{ $message }}</span>
            @enderror
            @if ($errorMessage)
                <div class="mt-2 text-red-600">
                    {{ $errorMessage }}
                </div>
            @endif
        </div>

        <div class="mt-4">
            <x-label for="representante" value="{{ __('Representante Legal') }}" />
            <x-input id="representante" class="block mt-1 w-full" type="text" wire:model.defer="representante"
                autocomplete="off" />
            @error('representante')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <x-label for="telefono" value="{{ __('Telefono') }}" />
            <x-input id="telefono" class="block mt-1 w-full" type="text" wire:model.defer="telefono"
                autocomplete="off" />
            @error('telefono')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="mt-4">
            <x-label for="correo" value="{{ __('Correo') }}" />
            <x-input id="correo" class="block mt-1 w-full" type="text" wire:model.defer="correo"
                autocomplete="off" />
            @error('correo')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <x-label for="fiscal" value="{{ __('Direccion Fiscal') }}" />
            <x-input id="fiscal" class="block mt-1 w-full" type="text" wire:model.defer="fiscal"
                autocomplete="off" />
            @error('fiscal')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <x-label for="entrega" value="{{ __('Direccion De Entrega') }}" />
            <x-input id="entrega" class="block mt-1 w-full" type="text" wire:model.defer="entrega"
                autocomplete="off" />
            @error('entrega')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <x-label for="rfc" value="{{ __('RFC') }}" />
            <x-input id="rfc" class="block mt-1 w-full" type="text" wire:model.defer="rfc"
                autocomplete="off" />
            @error('rfc')
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


@push('js')
<script>
    Livewire.on()
</script>
    @endpush

</div>
