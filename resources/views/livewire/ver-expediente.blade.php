<div>
    @foreach ($clientes ?? [] as $cliente)
    <x-button wire:click="verCliente({{ $cliente->id }})">
        {{ __('Ver Cliente') }}
    </x-button>  
    @endforeach
    
    
</div>
