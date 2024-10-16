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
                                {{ $cliente->razon }}-{{ $cliente->cuenta }}
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


                    @if ($alert['show'])
                        <x-alerts :type="$alert['type']" :message="$alert['message']" />
                    @endif

                    @if (!empty($selectedLineas))
                        <div class="mt-4">
                            <x-label value="{{ __('Líneas Importadas') }}" />
                            <div class="space-y-4">
                                @php
                                    $groupedLineas = collect($selectedLineas)->groupBy('tipo');
                                @endphp
                                @foreach ($groupedLineas as $tipo => $lineas)
                                    <div>
                                        <h3 class="font-bold">{{ $tipo }}</h3>
                                        <ul class="list-disc list-inside">
                                            @foreach ($lineas as $linea)
                                                <li
                                                    class="{{ is_array($linea) && isset($linea['renovable']) && $linea['renovable'] ? '' : 'text-red-500' }}">
                                                    {{ is_array($linea) && isset($linea['dn']) ? $linea['dn'] : $linea }}
                                                    @if (is_array($linea) && isset($linea['renovable']) && !$linea['renovable'])
                                                        <span class="text-red-500"> - Esta línea no se puede
                                                            renovar</span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if (!empty($lineasEnUso))
                        <div class="mt-4">
                            <h3 class="font-bold">Líneas ya en uso:</h3>
                            <ul class="list-disc list-inside">
                                @foreach ($lineasEnUso as $linea)
                                    <li>{{ $linea['dn'] }} - En uso por: {{ $linea['usuario'] }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($lineasNoRenovables))
                        <div class="mt-4">
                            <h3 class="font-bold">Líneas no elegibles para renovación:</h3>
                            <ul class="list-disc list-inside">
                                @foreach ($lineasNoRenovables as $dn)
                                    <li>{{ $dn }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($lineasNoPertenecientes))
                        <div class="mt-4">
                            <h3 class="font-bold">DNs que no pertenecen al cliente:</h3>
                            <ul class="list-disc list-inside">
                                @foreach ($lineasNoPertenecientes as $dn)
                                    <li>{{ $dn }}</li>
                                @endforeach
                            </ul>
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

                    @if ($alert['show'])
                        <x-alerts :type="$alert['type']" :message="$alert['message']" />
                    @endif

                    @if (!empty($selectedLineas))
                        <div class="mt-4">
                            <x-label value="{{ __('Líneas Importadas') }}" />
                            <div class="space-y-4">
                                @php
                                    $groupedLineas = collect($selectedLineas)->groupBy('tipo');
                                @endphp
                                @foreach ($groupedLineas as $tipo => $lineas)
                                    <div>
                                        <h3 class="font-bold">{{ $tipo }}</h3>
                                        <ul class="list-disc list-inside">
                                            @foreach ($lineas as $linea)
                                                <li
                                                    class="{{ is_array($linea) && isset($linea['renovable']) && $linea['renovable'] ? '' : 'text-red-500' }}">
                                                    {{ is_array($linea) && isset($linea['dn']) ? $linea['dn'] : $linea }}
                                                    @if (is_array($linea) && isset($linea['renovable']) && !$linea['renovable'])
                                                        <span class="text-red-500"> - Esta línea no se puede
                                                            renovar</span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if (!empty($lineasEnUso))
                        <div class="mt-4">
                            <h3 class="font-bold">Líneas ya en uso:</h3>
                            <ul class="list-disc list-inside">
                                @foreach ($lineasEnUso as $linea)
                                    <li>{{ $linea['dn'] }} - En uso por: {{ $linea['usuario'] }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($lineasNoRenovables))
                        <div class="mt-4">
                            <h3 class="font-bold">Líneas no elegibles para renovación:</h3>
                            <ul class="list-disc list-inside">
                                @foreach ($lineasNoRenovables as $dn)
                                    <li>{{ $dn }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (!empty($lineasNoPertenecientes))
                        <div class="mt-4">
                            <h3 class="font-bold">DNs que no pertenecen al cliente:</h3>
                            <ul class="list-disc list-inside">
                                @foreach ($lineasNoPertenecientes as $dn)
                                    <li>{{ $dn }}</li>
                                @endforeach
                            </ul>
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
