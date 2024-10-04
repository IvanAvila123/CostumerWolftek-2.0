<div>
    <x-button wire:click="$set('modalVisible', true)">Crear Rol</x-button>

    <x-dialog-modal wire:model="modalVisible">
        <x-slot name="title">
            {{ $roleId ? 'Editar Rol' : 'Crear Rol' }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-label for="name" value="{{ __('Nombre') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" wire:model.defer="name" autocomplete="off" />
                @error('name') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-label class="block text-sm font-medium text-gray-700">Permisos</x-label>
                <div class="mt-2">
                    @foreach($permissions as $permission)
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <x-input type="checkbox" wire:model.defer="selectedPermissions" value="{{ $permission->id }}" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"/>
                            </div>
                            <div class="ml-3 text-sm">
                                <x-label for="permission-{{ $permission->id }}" class="font-medium text-gray-700">{{ $permission->name }}</x-label>
                            </div>
                        </div>
                    @endforeach
                </div>
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




