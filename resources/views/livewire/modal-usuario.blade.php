<div class="bg-white dark:bg-gray-800">
        <x-button wire:click="$set('modalVisible', true)">Crear Usuario</x-button>

        <x-dialog-modal wire:model="modalVisible">
            <x-slot name="title" class="text-gray-900 dark:text-gray-100">
                {{ $userId ? 'Editar Usuario' : 'Crear Usuario' }}
            </x-slot>

            <x-slot name="content">
                <div class="mt-4">
                    <x-label for="name" value="{{ __('Nombre') }}" />
                    <x-input id="name" class="block w-full mt-1" type="text" wire:model.defer="name" autocomplete="off" />
                    @error('name') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block w-full mt-1" type="email" wire:model.defer="email" autocomplete="off" />
                    @error('email') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4">
                    <x-label for="username" value="{{ __('Username') }}" />
                    <x-input id="username" class="block w-full mt-1" type="text" wire:model.defer="username" autocomplete="off" />
                    @error('username') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Contraseña') }}" />
                    <x-input id="password" class="block w-full mt-1" type="password" wire:model.defer="password" autocomplete="off"  />
                    @error('password') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4">
                    <x-label for="distribuidor" value="{{ __('Distribuidor') }}" class="text-gray-700 dark:text-gray-300" />
                    <select id="distribuidor" class="block w-full mt-1 text-gray-900 bg-white border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" wire:model.defer="selectedDistribuidor">
                        <option value="">{{ __('Seleccione un distribuidor') }}</option>
                        @foreach ($distribuidores as $distribuidor)
                            <option value="{{ $distribuidor->id }}">{{ $distribuidor->nombre }}</option>
                        @endforeach
                    </select>
                    @error('selectedDistribuidor') <span class="text-red-600 error dark:text-red-400">{{ $message }}</span> @enderror
                </div>

                <div class="mt-4">
                    <x-label for="role" value="{{ __('Rol') }}" class="text-gray-700 dark:text-gray-300" />
                    <select id="role" class="block w-full mt-1 text-gray-900 bg-white border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" wire:model.defer="selectedRoleId">
                        <option value="">{{ __('Seleccione un rol') }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('selectedRoleId') <span class="text-red-600 error dark:text-red-400">{{ $message }}</span> @enderror
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
