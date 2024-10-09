<div class="bg-white dark:bg-gray-800">
    <x-dialog-modal wire:model="showModalHistorial">
        <x-slot name="title" class="text-gray-900 dark:text-gray-100">
            Historial De Cambios
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <div class="relative overflow-x-auto overflow-y-auto bg-white rounded-lg shadow dark:bg-gray-700"
                    style="max-height: 405px;">
                    @if ($audits && count($audits) > 0)
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Fecha</th>
                                    <th scope="col" class="px-6 py-3">Usuario</th>
                                    <th scope="col" class="px-6 py-3">Evento</th>
                                    <th scope="col" class="px-6 py-3">Cambios</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->audits as $audit)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4">{{ $audit->created_at->format('d/m/Y H:i:s') }}</td>
                                        <td class="px-6 py-4">{{ $audit->user->name ?? 'Sistema' }}</td>
                                        <td class="px-6 py-4">{{ $audit->event }}
                                            ({{ $audit->auditable_type == 'App\Models\Cliente' ? 'Cliente' : 'Línea' }})
                                        </td>
                                        <td class="px-6 py-4">
                                            <ul class="list-disc list-inside">
                                                @foreach ($audit->modified as $attribute => $modified)
                                                    @if (!in_array($attribute, ['cliente_id', 'user_id', 'id_distribuidor', 'id']))
                                                        <li>
                                                            <strong>{{ $attribute }}:</strong>
                                                            {{ $modified['old'] ?? 'N/A' }} →
                                                            {{ $modified['new'] ?? 'N/A' }}
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="py-4 text-center text-gray-700 dark:text-gray-300">No hay historial de cambios disponible.</p>
                    @endif
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('showModalHistorial', false)" wire:loading.attr="disabled">
                {{ __('Cerrar') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
