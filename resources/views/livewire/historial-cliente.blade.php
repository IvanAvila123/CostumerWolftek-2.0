<div>
    <x-dialog-modal wire:model="showModalHistorial">
        <x-slot name="title">
            Historial De Cambios
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <div class="overflow-x-auto bg-white rounded-lg shadow overflow-y-auto relative"
                    style="max-height: 405px;">
                    @if ($audits && count($audits) > 0)
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Fecha</th>
                                    <th scope="col" class="px-6 py-3">Usuario</th>
                                    <th scope="col" class="px-6 py-3">Evento</th>
                                    <th scope="col" class="px-6 py-3">Cambios</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->audits as $audit)
                                    <tr class="bg-white border-b hover:bg-gray-50">
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
                        <p class="text-center py-4">No hay historial de cambios disponible.</p>
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
