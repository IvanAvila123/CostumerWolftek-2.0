<div class="bg-white dark:bg-gray-800">
    <x-button wire:click="showEliminados">Mostrar Registros Eliminados</x-button>

    <x-dialog-modal wire:model="mostrarModalEliminados">
        <x-slot name="title" class="text-gray-900 dark:text-gray-100">
            Registros Eliminados
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <div class="relative overflow-x-auto overflow-y-auto bg-white rounded-lg shadow dark:bg-gray-700" style="height: 405px;">
                    <table class="relative w-full whitespace-no-wrap bg-white border-collapse table-auto dark:bg-gray-800 table-striped">
                        <thead>
                            <tr class="text-left">
                                <th class="sticky top-0 px-3 py-2 bg-gray-100 border-b border-gray-200 dark:bg-gray-700 dark:border-gray-600">
                                    <label class="inline-flex items-center justify-between px-2 py-2 text-teal-500 rounded-lg cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600">
                                        <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline dark:bg-gray-600 dark:border-gray-500"
                                            wire:model="selectAll" @click="selectAllCheckbox($dispatch.target.checked)">
                                    </label>
                                </th>
                                <th class="sticky top-0 px-6 py-2 text-xs font-bold tracking-wider text-gray-600 uppercase bg-gray-100 border-b border-gray-200 dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600">
                                    DN</th>
                                <th class="sticky top-0 px-6 py-2 text-xs font-bold tracking-wider text-gray-600 uppercase bg-gray-100 border-b border-gray-200 dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600">
                                    Fecha</th>
                                <th class="sticky top-0 px-6 py-2 text-xs font-bold tracking-wider text-gray-600 uppercase bg-gray-100 border-b border-gray-200 dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600">
                                    Plan</th>
                                <th class="sticky top-0 px-6 py-2 text-xs font-bold tracking-wider text-gray-600 uppercase bg-gray-100 border-b border-gray-200 dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600">
                                    Equipo</th>
                                <th class="sticky top-0 px-6 py-2 text-xs font-bold tracking-wider text-gray-600 uppercase bg-gray-100 border-b border-gray-200 dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lineasEliminadas as $linea)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-3 border-t border-gray-200 border-dashed dark:border-gray-600">
                                        <label class="inline-flex items-center justify-between px-2 py-2 text-teal-500 rounded-lg cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600">
                                            <input type="checkbox" class="form-checkbox focus:outline-none focus:shadow-outline dark:bg-gray-600 dark:border-gray-500"
                                                wire:model="selectAll" @click="selectAllCheckbox($dispatch.target.checked)">
                                        </label>
                                    </td>
                                    <td class="px-6 py-3 border-t border-gray-200 border-dashed dark:border-gray-600">
                                        {{ $linea->dn }}
                                    </td>
                                    <td class="px-6 py-3 border-t border-gray-200 border-dashed dark:border-gray-600">
                                        {{ $linea->fecha }}
                                    </td>
                                    <td class="px-6 py-3 border-t border-gray-200 border-dashed dark:border-gray-600">
                                        {{ $linea->plan }}
                                    </td>
                                    <td class="px-6 py-3 border-t border-gray-200 border-dashed dark:border-gray-600">
                                        {{ $linea->equipo }}
                                    </td>
                                    <td class="px-6 py-3 border-t border-gray-200 border-dashed dark:border-gray-600">
                                        <button wire:click="restaurarLinea({{ $linea->id }})"
                                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Restaurar</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('mostrarModalEliminados', false)" wire:loading.attr="disabled">
                {{ __('Cerrar') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
