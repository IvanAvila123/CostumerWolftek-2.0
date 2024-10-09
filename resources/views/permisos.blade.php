<x-app-layout>
    <x-slot name="header" class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Permisos') }}
            @livewire('modal-permission')
        </h2>
    </x-slot>

    <div class="flex items-center justify-center py-12 bg-gray-100 dark:bg-gray-900">
        @livewire('permisos')
    </div>
</x-app-layout>
