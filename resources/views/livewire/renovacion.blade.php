<div class="min-h-screen p-8 bg-gray-100">

    <div x-data="{ showAlert: @entangle('alert.show') }" x-show="showAlert" x-effect="if (showAlert) setTimeout(() => $wire.hideAlert(), 5000)">
        <x-alerts :type="$alert['type']" :message="$alert['message']" />
    </div>

    <div class="mx-auto max-w-7xl">
        <h1 class="mb-8 text-3xl font-bold text-gray-900">Renovaciones</h1>

        <div class="mb-8 overflow-hidden bg-white rounded-lg shadow-md">
            <x-filtro-renovacion :tipoRenovacion="'tipoRenovacion'" :search="'search'" />

            <x-tabla-renovacion :clientes="$clientes" />

            <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $clientes->links() }}
            </div>
        </div>
    </div>

    <x-modal-detalle-renovacion :clienteSeleccionado="$clienteSeleccionado" :mostrarDetalles="$mostrarDetalles" />
</div>
