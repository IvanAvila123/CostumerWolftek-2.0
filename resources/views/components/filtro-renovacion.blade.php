@props(['tipoRenovacion', 'search'])

<div class="p-4 border-b border-gray-200">
    <div class="flex flex-wrap items-center justify-between">
        <div class="flex space-x-4 mb-4 sm:mb-0">
            <select wire:model.live="{{ $tipoRenovacion }}" class="form-select rounded-md shadow-sm mt-1 block w-full">
                <option value="">Todas las renovaciones</option>
                <option value="Vencidas">Vencidas</option>
                <option value="Anticipadas T-1">Anticipadas T-1</option>
                <option value="Anticipadas">Anticipadas</option>
            </select>
            <input type="text" wire:model.live.debounce.300ms="{{ $search }}" class="form-input rounded-md shadow-sm mt-1 block w-full" placeholder="Buscar cliente...">
        </div>
        <div>
            <x-success-button wire:click="exportToExcel">
                Exportar a Excel
            </x-button>
        </div>
    </div>
</div>