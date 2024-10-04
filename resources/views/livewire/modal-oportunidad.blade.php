<div class="bg-white dark:bg-gray-800">

    <x-button wire:click="$set('modalVisible', true)">Crear Oportunidad</x-button>

    <x-dialog-modal wire:model="modalVisible">
        <x-slot name="title">
            {{ $oportunidadId ? 'Editar Oportunidad' : 'Crear Oportunidad' }}
        </x-slot>

        <x-slot name="content">

            <div class="mt-4">
                <x-label for="search" value="{{ __('Buscar Cliente') }}" />
                <x-input id="search" class="block w-full mt-1" type="text" wire:model.live="search"
                    autocomplete="off" placeholder="Buscar por razón social..." />
                @if ($clientes && !$selectedClienteId)
                    <ul class="mt-2 border border-gray-200 rounded-md">
                        @forelse($clientes as $cliente)
                            <li class="px-4 py-2 cursor-pointer hover:bg-gray-100"
                                wire:click="selectCliente({{ $cliente->id }})">
                                {{ $cliente->razon }}
                            </li>
                        @empty
                            <li class="px-4 py-2 text-blue-600">No se encontraron resultados</li>
                        @endforelse
                    </ul>
                @endif
            </div>

            @if ($selectedClienteId)
                @if (Auth::user()->isSuperAdmin() || $user->hasRole(['Manager', 'Capturista']))
                    <div class="mt-4">
                        <x-label for="vendedor" value="{{ __('Vendedor') }}" />
                        <x-input id="vendedor" class="block w-full mt-1" type="text" wire:model.defer="vendedor"
                            readonly />
                        @error('vendedor')
                            <span class="text-red-600 error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="venta" value="{{ __('Tipo de Venta') }}" />
                        <select id="venta" class="block w-full mt-1" wire:model.defer="venta"
                            wire:change="$refresh">
                            <option value="">Seleccione un tipo de venta</option>
                            <option value="Renovacion">Renovación</option>
                            <option value="Adicion">Adición</option>
                            <option value="Renovacion Anticipada T-1">Renovación Anticipada T-1</option>
                            <option value="Renovacion Anticipada">Renovación Anticipada</option>
                            <option value="Venta Nueva">Venta Nueva</option>
                        </select>
                        @error('venta')
                            <span class="text-red-600 error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="razon" value="{{ __('Razón Social') }}" />
                        <x-input id="razon" class="block w-full mt-1" type="text" wire:model.defer="razon"
                            readonly />
                    </div>

                    <div class="mt-4">
                        <x-label for="cuenta" value="{{ __('Cuenta') }}" />
                        <x-input id="cuenta" class="block w-full mt-1" type="text" wire:model.defer="cuenta"
                            readonly />
                    </div>

                    <div class="mt-4">
                        <x-label for="id_cliente" value="{{ __('ID Cliente') }}" />
                        <x-input id="id_cliente" class="block w-full mt-1" type="text" wire:model.defer="id_cliente"
                            readonly />
                    </div>

                    <div class="mt-4">
                        <x-label for="entrega" value="{{ __('Dirección de Entrega') }}" />
                        <x-input id="entrega" class="block w-full mt-1" type="text" wire:model.defer="entrega" />
                        @error('entrega')
                            <span class="text-red-600 error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="autorizada" value="{{ __('Persona Autorizada') }}" />
                        <x-input id="autorizada" class="block w-full mt-1" type="text"
                            wire:model.defer="autorizada" />
                        @error('autorizada')
                            <span class="text-red-600 error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="acuerdo" value="{{ __('Acuerdo') }}" />
                        <x-input id="acuerdo" class="block w-full mt-1" type="text" wire:model.defer="acuerdo" />
                        @error('acuerdo')
                            <span class="text-red-600 error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="actualizacion" value="{{ __('Ultima Actualizacion') }}" />
                        <x-input id="actualizacion" class="block w-full mt-1" type="date"
                            wire:model.defer="actualizacion" placeholder="DD/MM/YYYY" />
                        @error('actualizacion')
                            <span class="text-red-600 error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="estado" value="{{ __('Estado') }}" />
                        <select id="estado" class="block w-full mt-1" wire:model.defer="estado">
                            <option value="">Seleccione un estado</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Revisando Venta">Revisando Venta</option>
                            <option value="Haciendo Contratos">Haciendo Contratos</option>
                            <option value="Se Entrega Contratos">Se Entrega Contratos</option>
                            <option value="Revision">Revisión</option>
                            <option value="Captura">Captura</option>
                            <option value="Verificacion De Credito">Verificación De Crédito</option>
                            <option value="Rechazada Por Credito">Rechazada Por Crédito</option>
                            <option value="Verificacion de Credito Rechazada">Verificación de Crédito Rechazada
                            </option>
                            <option value="Verificacion De Credito Aprobada">Verificación De Crédito Aprobada</option>
                            <option value="Asignacion De Equipo">Asignación De Equipo</option>
                            <option value="Cancela/Envios">Cancela/Envíos</option>
                            <option value="Envios/Por Confirmar">Envíos/Por Confirmar</option>
                            <option value="Envios/En Ruta">Envíos/En Ruta</option>
                            <option value="Orden Entregada">Orden Entregada</option>
                        </select>
                        @error('estado')
                            <span class="text-red-600 error">{{ $message }}</span>
                        @enderror
                    </div>

                    @if ($venta && $venta !== 'Adicion' && $venta !== 'Venta Nueva')
                        <div class="mt-4">
                            <x-label value="{{ __('Importar DNs desde CSV') }}" />
                            <input type="file" wire:model="csvFile">
                            <x-button wire:click="importDNs" class="mt-2">Importar DNs</x-button>
                        </div>
                    @endif


                    @if ($venta && $venta !== 'Adicion' && $venta !== 'Venta Nueva')
                        <div class="overflow-x-auto">
                            <x-label value="{{ __('Líneas') }}" />
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Seleccionar</th>
                                        <th
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            DN</th>
                                        <th
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Plan</th>
                                        <th
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Fecha Fin</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($lineasPaginadas as $linea)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" wire:model="selectedLineas"
                                                    value="{{ $linea->id }}"
                                                    wire:click="toggleLineaSelection({{ $linea->id }})"
                                                    class="w-5 h-5 text-indigo-600 form-checkbox">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $linea->dn }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $linea->plan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $linea->fecha }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $lineasPaginadas->links() }}
                        </div>
                    @endif
                @endif

                @if ($user->hasRole('Vendedor'))
                    <div class="mt-4">
                        <x-label for="vendedor" value="{{ __('Vendedor') }}" />
                        <x-input id="vendedor" class="block w-full mt-1" type="text" wire:model.defer="vendedor"
                            readonly />
                        @error('vendedor')
                            <span class="text-red-600 error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="venta" value="{{ __('Tipo de Venta') }}" />
                        <select id="venta" class="block w-full mt-1" wire:model.defer="venta"
                            wire:change="$refresh">
                            <option value="">Seleccione un tipo de venta</option>
                            <option value="Renovacion">Renovación</option>
                            <option value="Adicion">Adición</option>
                            <option value="Renovacion Anticipada T-1">Renovación Anticipada T-1</option>
                            <option value="Renovacion Anticipada">Renovación Anticipada</option>
                            <option value="Venta Nueva">Venta Nueva</option>
                        </select>
                        @error('venta')
                            <span class="text-red-600 error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="razon" value="{{ __('Razón Social') }}" />
                        <x-input id="razon" class="block w-full mt-1" type="text" wire:model.defer="razon"
                            readonly />
                    </div>

                    <div class="mt-4">
                        <x-label for="cuenta" value="{{ __('Cuenta') }}" />
                        <x-input id="cuenta" class="block w-full mt-1" type="text" wire:model.defer="cuenta"
                            readonly />
                    </div>

                    <div class="mt-4">
                        <x-label for="id_cliente" value="{{ __('ID Cliente') }}" />
                        <x-input id="id_cliente" class="block w-full mt-1" type="text"
                            wire:model.defer="id_cliente" readonly />
                    </div>

                    <div class="mt-4">
                        <x-label for="entrega" value="{{ __('Dirección de Entrega') }}" />
                        <x-input id="entrega" class="block w-full mt-1" type="text"
                            wire:model.defer="entrega" />
                        @error('entrega')
                            <span class="text-red-600 error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="autorizada" value="{{ __('Autorizada por') }}" />
                        <x-input id="autorizada" class="block w-full mt-1" type="text"
                            wire:model.defer="autorizada" />
                        @error('autorizada')
                            <span class="text-red-600 error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="acuerdo" value="{{ __('Acuerdo') }}" />
                        <x-input id="acuerdo" class="block w-full mt-1" type="text"
                            wire:model.defer="acuerdo" />
                        @error('acuerdo')
                            <span class="text-red-600 error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="actualizacion" value="{{ __('Ultima Actualizacion') }}" />
                        <x-input id="actualizacion" class="block w-full mt-1" type="date"
                            wire:model.defer="actualizacion" />
                        @error('actualizacion')
                            <span class="text-red-600 error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="estado" value="{{ __('Estado') }}" />
                        <select id="estado" class="block w-full mt-1" wire:model.defer="estado">
                            <option value="">Seleccionar un estado</option>
                            <option value="Pendiente">Pendiente</option>
                        </select>
                        @error('estado')
                            <span class="text-red-600 error">{{ $message }}</span>
                        @enderror
                    </div>

                    @if ($venta && $venta !== 'Adicion' && $venta !== 'Venta Nueva')
                        <div class="mt-4">
                            <x-label value="{{ __('Importar DNs desde CSV') }}" />
                            <input type="file" wire:model="csvFile">
                            <x-button wire:click="importDNs" class="mt-2">Importar DNs</x-button>
                        </div>
                    @endif

                    @if ($venta && $venta !== 'Adicion' && $venta !== 'Venta Nueva')
                        <div class="mt-4">
                            <x-label value="{{ __('Líneas') }}" />
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Seleccionar</th>
                                        <th
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            DN</th>
                                        <th
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Plan</th>
                                        <th
                                            class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Fecha Fin</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($lineasPaginadas as $linea)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" wire:model="selectedLineas"
                                                    value="{{ $linea->id }}"
                                                    wire:click="toggleLineaSelection({{ $linea->id }})"
                                                    class="w-5 h-5 text-indigo-600 form-checkbox">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $linea->dn }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $linea->plan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($linea->fecha)->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $lineasPaginadas->links() }}
                        </div>
                    @endif
                @endif
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('modalVisible', false)" wire:loading.attr="disabled">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-button class="ml-2" wire:click="save" wire:loading.attr="disabled">
                {{ __('Guardar') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
