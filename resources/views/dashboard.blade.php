<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Panel de Control</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div class="bg-blue-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800">Sliders</h4>
                            <p class="text-2xl font-bold text-blue-600">{{ App\Models\Slider::count() }}</p>
                            <a href="{{ route('sliders.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">Gestionar →</a>
                        </div>
                        
                        <div class="bg-green-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800">Categorías</h4>
                            <p class="text-2xl font-bold text-green-600">{{ App\Models\Categoria::count() }}</p>
                            <a href="{{ route('categorias.index') }}" class="text-green-600 hover:text-green-800 text-sm">Gestionar →</a>
                        </div>
                        
                        <div class="bg-yellow-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-yellow-800">Comercios</h4>
                            <p class="text-2xl font-bold text-yellow-600">{{ App\Models\Comercio::count() }}</p>
                            <a href="{{ route('comercios.index') }}" class="text-yellow-600 hover:text-yellow-800 text-sm">Gestionar →</a>
                        </div>
                        
                        <div class="bg-purple-100 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-800">Productos</h4>
                            <p class="text-2xl font-bold text-purple-600">{{ App\Models\Producto::count() }}</p>
                            <a href="{{ route('productos.index') }}" class="text-purple-600 hover:text-purple-800 text-sm">Gestionar →</a>
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <h4 class="font-semibold mb-3">Acciones Rápidas</h4>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('sliders.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Nuevo Slider
                            </a>
                            <a href="{{ route('categorias.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Nueva Categoría
                            </a>
                            <a href="{{ route('comercios.create') }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                Nuevo Comercio
                            </a>
                            <a href="{{ route('productos.create') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                Nuevo Producto
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>