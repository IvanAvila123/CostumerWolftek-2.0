<div class="text-gray-900 bg-white dark:bg-gray-800 dark:text-gray-100">
    @if ($showClientes)
        <div class="flex justify-center">
            <h2 class="text-gray-700 dark:text-gray-300">Favor De Buscar Un Cliente O Darle Click Ver Clientes</h2>
        </div>
    @endif

    @if ($selectedClient)
        <x-selectedClient :client="$selectedClient" />
    @endif

    @if ($singleSearchResult)
        <x-singleSearchResult :result="$singleSearchResult" />
    @endif

    @if ($showCliente && count($clientes) > 0)
        <x-showCliente :clientes="$clientes" />
    @endif

    @if ($showTable)
        <x-showTable :clientes="$clientes" />
    @endif

    @livewire('historial-cliente')
</div>
