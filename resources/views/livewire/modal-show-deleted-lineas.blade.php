<div>
    <x-button wire:click="showEliminados">Mostrar Registros Eliminados</x-button>

    <x-dialog-modal wire:model="mostrarModalEliminados">
        <x-slot name="title">
            Registros Eliminados
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative" style="height: 405px;">
                    <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                        <thead>
                            <tr class="text-left">
                                <<th class="py-2 px-3 sticky top-0 border-b border-gray-200 bg-gray-100">
                                    <label
                                        class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                                        <input type="checkbox"
                                            class="form-checkbox focus:outline-none focus:shadow-outline"
                                            wire:model="selectAll" @click="selectAllCheckbox($dispatch.target.checked)">
                                    </label>
                                    </th>
                                    <th
                                        class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                        DN</th>
                                    <th
                                        class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                        Fecha</th>
                                    <th
                                        class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                        Plan</th>
                                    <th
                                        class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                        Equipo</th>
                                    <th
                                        class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs">
                                    </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lineasEliminadas as $linea)
                                <tr>
                                    <td class="border-dashed border-t border-gray-200 px-3">
                                        <label
                                            class="text-teal-500 inline-flex justify-between items-center hover:bg-gray-200 px-2 py-2 rounded-lg cursor-pointer">
                                            <input type="checkbox"
                                                class="form-checkbox focus:outline-none focus:shadow-outline"
                                                wire:model="selectAll"
                                                @click="selectAllCheckbox($dispatch.target.checked)">
                                        </label>
                                    </td>
                                    <td class="border-dashed border-t border-gray-200 px-6 py-3">
                                        {{ $linea->dn }}
                                    </td>
                                    <td class="border-dashed border-t border-gray-200 px-6 py-3">
                                        {{ $linea->fecha }}
                                    </td>
                                    <td class="border-dashed border-t border-gray-200 px-6 py-3">
                                        {{ $linea->plan }}
                                    </td>
                                    <td class="border-dashed border-t border-gray-200 px-6 py-3">
                                        {{ $linea->equipo }}
                                    </td>
                                    <td class="border-dashed border-t border-gray-200 px-6 py-3">
                                        <button wire:click="restaurarLinea({{ $linea->id }})"
                                            class="text-indigo-600 hover:text-indigo-900">Restaurar</button>
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
