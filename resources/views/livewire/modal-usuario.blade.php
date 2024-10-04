<div>
        <x-button wire:click="$set('modalVisible', true)">Crear Usuario</x-button>

        <x-dialog-modal wire:model="modalVisible">
            <x-slot name="title">
                {{ $userId ? 'Editar Usuario' : 'Crear Usuario' }}
            </x-slot>

            <x-slot name="content">
                <div class="mt-4">
                    <x-label for="name" value="{{ __('Nombre') }}" />
                    <x-input id="name" class="block mt-1 w-full" type="text" wire:model.defer="name" autocomplete="off" />
                    @error('name') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" wire:model.defer="email" autocomplete="off" />
                    @error('email') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4">
                    <x-label for="username" value="{{ __('Username') }}" />
                    <x-input id="username" class="block mt-1 w-full" type="text" wire:model.defer="username" autocomplete="off" />
                    @error('username') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Contraseña') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" wire:model.defer="password" autocomplete="off"  />
                    @error('password') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4">
                    <x-label for="distribuidor" value="{{ __('Distribuidor') }}" />
                    <select id="distribuidor" class="block mt-1 w-full" wire:model.defer="selectedDistribuidor">
                        <option value="">{{ __('Seleccione un distribuidor') }}</option>
                        @foreach ($distribuidores as $distribuidor)
                            <option value="{{ $distribuidor->id }}">{{ $distribuidor->nombre }}</option>
                        @endforeach
                    </select>
                    @error('selectedDistribuidor') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4">
                    <x-label for="role" value="{{ __('Rol') }}" />
                    <select id="role" class="block mt-1 w-full" wire:model.defer="selectedRoleId">
                        <option value="">{{ __('Seleccione un rol') }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('selectedRoleId') <span class="error">{{ $message }}</span> @enderror
                </div>
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
