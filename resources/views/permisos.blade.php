<x-app-layout>
    <x-slot name="header">
        <h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Permisos') }}

            @livewire('modal-permission')
        </h2>

    </x-slot>

    <div class="flex items-center justify-center py-12">
    @livewire('permisos')
    </div>
</x-app-layout>
