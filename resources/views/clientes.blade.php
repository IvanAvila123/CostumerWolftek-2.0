<x-app-layout>
    <x-slot name="header" class="">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Clientes') }}
            <div class="flex justify-end">
                <div class="mr-4">
                    @livewire('buscador-cliente')
                </div>
                @if(Auth::user()->isSuperAdmin() || Auth::user()->can('crear-cliente'))
                <div class="mr-4">
                    @livewire('modal-cliente')
                </div>
                @endif
                <div class="mr-4">
                    @livewire('ver-clientes-button')
                </div>

            </div>

        </h2>

    </x-slot>

    <div class="py-12">
        @livewire('clientes')

    </div>
</x-app-layout>
