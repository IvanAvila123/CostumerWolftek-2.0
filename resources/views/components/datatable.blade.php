@props(['headings', 'rows', 'sortField', 'sortDirection'])

<div x-data="dataTable($wire)" x-init="init" class="overflow-hidden bg-white rounded-lg shadow-sm dark:bg-gray-800">
    <div class="px-4 py-5 sm:p-6">
        <div class="flex justify-between mb-4">
            <div class="w-1/3">
                <x-input type="search" wire:model.live="search" placeholder="Buscar..." class="dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600" />
            </div>
            <div x-data="{ open: false }" class="relative">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 transition duration-150 ease-in-out dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                            <div>Columnas</div>
                            <div class="ml-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @foreach($headings as $heading)
                            <div class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-600">
                                <label class="flex items-center">
                                    <input type="checkbox" class="form-checkbox dark:bg-gray-700 dark:border-gray-600"
                                           wire:click="toggleColumn('{{ $heading['key'] }}')"
                                           @if($heading['visible']) checked @endif>
                                    <span class="ml-2">{{ $heading['value'] }}</span>
                                </label>
                            </div>
                        @endforeach
                    </x-slot>
                </x-dropdown>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                            <x-checkbox wire:model="selectAll" class="dark:bg-gray-700 dark:border-gray-600" />
                        </th>
                        @foreach($headings as $heading)
                            @if($heading['visible'])
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                                    <button wire:click="sortBy('{{ $heading['key'] }}')" class="inline-flex group">
                                        {{ $heading['value'] }}
                                        <span class="flex-none ml-2 text-gray-400 rounded group-hover:visible group-focus:visible">
                                            @if($sortField === $heading['key'])
                                                @if($sortDirection === 'asc')
                                                    ▲
                                                @else
                                                    ▼
                                                @endif
                                            @endif
                                        </span>
                                    </button>
                                </th>
                            @endif
                        @endforeach
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Acciones</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @foreach($rows as $row)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-checkbox :value="$row['id']" wire:model="selectedRows" class="dark:bg-gray-700 dark:border-gray-600" />
                            </td>
                            @foreach($headings as $heading)
                                @if($heading['visible'])
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">{{ $row[$heading['key']] }}</div>
                                    </td>
                                @endif
                            @endforeach
                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                {{ ${'actions_'.$row['id']} ?? '' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// El script permanece igual
</script>
