<div x-data="{ open: @entangle($attributes->wire('model')) }" x-cloak>
    <!-- Modal que cubre toda la ventana -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 w-full h-full">

        <!-- Contenedor del contenido del modal -->
        <div class="bg-white w-11/12 h-5/6 max-w-full max-h-full p-6 rounded-lg shadow-lg overflow-auto relative">
            <!-- Botón para cerrar el modal -->
            <button @click="open = false" class="text-gray-500 hover:text-gray-700 absolute top-4 right-4">
                X
            </button>

            <!-- Contenido dinámico del modal -->
            <div class="container mx-auto bg-gray-100 p-10 h-full overflow">
                {{ $content }}
            </div>
        </div>
    </div>
</div>
