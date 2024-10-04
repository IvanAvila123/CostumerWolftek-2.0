<div class="bg-white dark:bg-gray-800">
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg shadow dark:border-gray-700">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700">
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-300">
                        {{ __('Nombre') }}
                    </th>
                    <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-300">
                        {{ __('Acciones') }}
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($roles as $role)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-gray-100">
                            {{ $role->name }}
                        </td>
                        <td class="px-6 py-4 space-x-2 text-sm font-medium text-right whitespace-nowrap">
                            <x-button wire:click="$dispatch('editRole', { id: {{ $role->id }} })">
                                {{ __('Editar') }}
                            </x-button>
                            <x-danger-button wire:click="delete({{ $role->id }})" wire:confirm="¿Estás seguro de que deseas eliminar este rol?">
                                {{ __('Eliminar') }}
                            </x-danger-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
