<x-app-layout>
    <x-slot name="header" class="bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Roles') }}

           @livewire('model-role')
        </h2>

    </x-slot>

    <div class="flex items-center justify-center py-12">
        @livewire('roles')
    </div>
</x-app-layout>
