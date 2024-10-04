<div class="bg-white dark:bg-gray-800">
    <x-datatable
        :headings="$headings"
        :rows="$users"
        :sortField="$sortField"
        :sortDirection="$sortDirection"
        class="text-gray-900 dark:text-gray-100"
    >
        @foreach($users as $user)
            <x-slot :name="'actions_'.$user['id']">
                @if(!$user['is_super_admin'])
                    <x-button wire:click="$dispatch('editUser', { id: {{ $user['id'] }} })" class="mr-2">
                        {{ __('Editar') }}
                    </x-button>
                    <x-danger-button wire:click="delete({{ $user['id'] }})" wire:confirm="¿Estás seguro de que deseas eliminar este usuario?">
                        {{ __('Eliminar') }}
                    </x-danger-button>
                    <x-button wire:click="toggleUserStatus({{ $user['id'] }})" class="mr-2">
                        {{ $user['is_active'] ? __('Desactivar') : __('Activar') }}
                    </x-button>
                @else
                    <span class="text-gray-500">{{ __('Superadmin') }}</span>
                @endif
            </x-slot>
            <x-slot :name="'is_active_'.$user['id']">
                {{ $user['is_active'] ? __('Activo') : __('Inactivo') }}
            </x-slot>
        @endforeach
    </x-datatable>
</div>
