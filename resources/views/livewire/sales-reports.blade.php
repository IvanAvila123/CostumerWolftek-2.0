<div>

    <x-button wire:click="$set('showModal', true)">Informes de venta</x-button>

    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Informes De Venta
        </x-slot>

        <x-slot name="content">

            <div class="mt-4">
                <x-label for="fechaInicio" value="Fecha de inicio" />
                <x-input id="fechaInicio" type="date" class="mt-1 block w-full" wire:model="fechaInicio" />
            </div>

            <div class="mt-4">
                <x-label for="fechaFin" value="Fecha de fin" />
                <x-input id="fechaFin" type="date" class="mt-1 block w-full" wire:model="fechaFin" />
            </div>

            <div class="mt-4">
                <x-label for="estado" value="Estado de la venta" />
                <select id="estado"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    wire:model="estado">
                    <option value="">Seleccione un estado</option>
                    <option value="Orden Entregada">Orden Entregada</option>
                    <!-- Agrega más opciones según tus estados de venta -->
                </select>
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showModal', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-button class="ml-2" wire:click="generarInforme" wire:loading.attr="disabled">
                Generar Informe
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
