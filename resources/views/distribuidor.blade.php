<x-app-layout>
    <x-slot name="header">
        <h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Roles') }}

           @livewire('modal-distribuidores')
        </h2>

    </x-slot>

    <div class="py-12">
        @livewire('distribuidores')
    </div>
</x-app-layout>
