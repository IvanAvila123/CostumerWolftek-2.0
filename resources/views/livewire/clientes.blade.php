<div>
    @if ($showClientes)
        <div class="flex justify-center">
            <h2>Favor De Buscar Un Cliente O Darle Click Ver Clientes</h2>
        </div>
    @endif

    @if ($selectedClient)
        <x-selectedClient :client="$selectedClient"></x-selectedClient>
    @endif

    @if ($singleSearchResult)
        <x-singleSearchResult :result="$singleSearchResult"></x-singleSearchResult>
    @endif

    @if ($showCliente && count($clientes) > 0)
        <x-showCliente :clientes="$clientes"></x-showCliente>
    @endif

    @if ($showTable)
        <x-showTable :clientes="$clientes"></x-showTable>
    @endif

    @livewire('historial-cliente')
</div>
