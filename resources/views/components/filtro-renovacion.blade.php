@props(['tipoRenovacion', 'search'])

<div class="p-4 border-b border-gray-200 dark:border-gray-700">
    <div class="flex flex-wrap items-center justify-between">
        <div class="flex mb-4 space-x-4 sm:mb-0">
            <select wire:model.live="{{ $tipoRenovacion }}" class="block w-full mt-1 rounded-md shadow-sm form-select dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600">
                <option value="">Todas las renovaciones</option>
                <option value="Vencidas">Vencidas</option>
                <option value="Anticipadas T-1">Anticipadas T-1</option>
                <option value="Anticipadas">Anticipadas</option>
            </select>
            <input type="text" wire:model.live.debounce.300ms="{{ $search }}" class="block w-full mt-1 rounded-md shadow-sm form-input dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600" placeholder="Buscar cliente...">
        </div>
        <div>
            <x-success-button wire:click="exportToExcel">
                Exportar a Excel
            </x-success-button>
        </div>
    </div>
</div>
