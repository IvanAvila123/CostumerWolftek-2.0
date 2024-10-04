<x-app-layout>
    <x-slot name="header">
        <h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Usuarios') }}

            @livewire('modal-usuario')
        </h2>

    </x-slot>

    <div class="py-12">
        @livewire('usuario')
    </div>
</x-app-layout>
