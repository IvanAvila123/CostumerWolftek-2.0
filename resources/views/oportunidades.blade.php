<x-app-layout>
    <x-slot name="header" class="">
        <h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Oportunidades') }}
        </h2>

    </x-slot>

    <div class="py-12">
        @livewire('oportunidades')
    </div>
</x-app-layout>
