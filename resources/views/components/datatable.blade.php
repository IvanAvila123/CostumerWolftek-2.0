@props(['headings', 'rows', 'sortField', 'sortDirection'])

<div x-data="dataTable($wire)" x-init="init" class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
    <div class="px-4 py-5 sm:p-6">
        <div class="flex justify-between mb-4">
            <div class="w-1/3">
                <x-input type="search" wire:model.live="search" placeholder="Buscar..." />
            </div>
            <div x-data="{ open: false }" class="relative">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                            <div>Columnas</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @foreach($headings as $heading)
                            <div class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                <label class="flex items-center">
                                    <input type="checkbox" class="form-checkbox"
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
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            <x-checkbox wire:model="selectAll" />
                        </th>
                        @foreach($headings as $heading)
                            @if($heading['visible'])
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    <button wire:click="sortBy('{{ $heading['key'] }}')" class="group inline-flex">
                                        {{ $heading['value'] }}
                                        <span class="ml-2 flex-none rounded text-gray-400 group-hover:visible group-focus:visible">
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
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($rows as $row)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <x-checkbox :value="$row['id']" wire:model="selectedRows" />
                            </td>
                            @foreach($headings as $heading)
                                @if($heading['visible'])
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-gray-100">{{ $row[$heading['key']] }}</div>
                                    </td>
                                @endif
                            @endforeach
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
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
function dataTable($wire) {
    return {
        headings: @json($headings),
        rows: @json($rows),
        sortColumn: null,
        sortDirection: 'asc',

        init() {
            this.$watch('rows', value => {
                this.rows = value;
            });
        },

        get sortedRows() {
            if (this.sortColumn === null) {
                return this.rows;
            }

            return [...this.rows].sort((a, b) => {
                if (a[this.sortColumn] < b[this.sortColumn]) return this.sortDirection === 'asc' ? -1 : 1;
                if (a[this.sortColumn] > b[this.sortColumn]) return this.sortDirection === 'asc' ? 1 : -1;
                return 0;
            });
        },

        sortTable(column) {
            if (this.sortColumn === column) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortColumn = column;
                this.sortDirection = 'asc';
            }
        },

        toggleColumn(key) {
            const index = this.headings.findIndex(h => h.key === key);
            if (index !== -1) {
                this.headings[index].visible = !this.headings[index].visible;
            }
            $wire.call('toggleColumn', key);
        }
    }
}
</script>
