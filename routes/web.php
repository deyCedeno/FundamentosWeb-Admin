<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComercioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\SliderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas administrativas
    Route::prefix('admin')->group(function () {
        // Sliders
        Route::resource('sliders', SliderController::class)->names([
            'index' => 'sliders.index',
            'create' => 'sliders.create',
            'store' => 'sliders.store',
            'edit' => 'sliders.edit',
            'update' => 'sliders.update',
            'destroy' => 'sliders.destroy',
        ]);

        // Categorías
        Route::resource('categorias', CategoriaController::class)->names([
            'index' => 'categorias.index',
            'create' => 'categorias.create',
            'store' => 'categorias.store',
            'edit' => 'categorias.edit',
            'update' => 'categorias.update',
            'destroy' => 'categorias.destroy',
        ]);

        // Comercios
        Route::resource('comercios', ComercioController::class)->names([
            'index' => 'comercios.index',
            'create' => 'comercios.create',
            'store' => 'comercios.store',
            'edit' => 'comercios.edit',
            'update' => 'comercios.update',
            'destroy' => 'comercios.destroy',
        ]);

        // Galería de comercios
        Route::get('comercios/{comercio}/galeria', [ComercioController::class, 'galeria'])->name('comercios.galeria');
        Route::post('comercios/{comercio}/imagenes', [ComercioController::class, 'storeImagen'])->name('comercios.storeImagen');
        Route::delete('imagenes-comercio/{imagen}', [ComercioController::class, 'destroyImagen'])->name('comercios.destroyImagen');

        // Productos
        Route::resource('productos', ProductoController::class)->names([
            'index' => 'productos.index',
            'create' => 'productos.create',
            'store' => 'productos.store',
            'edit' => 'productos.edit',
            'update' => 'productos.update',
            'destroy' => 'productos.destroy',
        ]);

        // Galería de productos
        Route::get('productos/{producto}/galeria', [ProductoController::class, 'galeria'])->name('productos.galeria');
        Route::post('productos/{producto}/imagenes', [ProductoController::class, 'storeImagen'])->name('productos.storeImagen');
        Route::delete('imagenes-producto/{imagen}', [ProductoController::class, 'destroyImagen'])->name('productos.destroyImagen');
    });
});

// Crear enlace simbólico para desarrollo
Route::get('/test-image/{id}', function($id) {
    $slider = \App\Models\Slider::find($id);
    
    if (!$slider) {
        return "Slider no encontrado";
    }
    
    // Verificar diferentes aspectos
    $diagnostico = [
        'slider_id' => $slider->id,
        'nombre_imagen_bd' => $slider->imagen,
        'ruta_fisica' => 'C:/laravel/shared-images/sliders/' . $slider->imagen,
        'existe_archivo' => file_exists('C:/laravel/shared-images/sliders/' . $slider->imagen) ? 'SÍ' : 'NO',
        'url_generada' => $slider->imagen_url,
    ];
    
    // Intentar acceder directamente
    $rutaDirecta = public_path('shared-images/sliders/' . $slider->imagen);
    $diagnostico['ruta_publica'] = $rutaDirecta;
    $diagnostico['existe_en_public'] = file_exists($rutaDirecta) ? 'SÍ' : 'NO';
    
    return $diagnostico;
});

// En web.php - ruta temporal para diagnóstico
Route::get('/debug-categoria/{id}', function($id) {
    $categoria = \App\Models\Categoria::find($id);
    
    if (!$categoria) {
        return "Categoría no encontrada";
    }
    
    return [
        'id' => $categoria->idCategoria,
        'nombre' => $categoria->nombre,
        'urlImagen_bd' => $categoria->urlImagen,
        'imagen_url_attribute' => $categoria->imagen_url,
        'tiene_imagen_attribute' => $categoria->tiene_imagen ? 'SÍ' : 'NO',
        'es_url_externa' => filter_var($categoria->urlImagen, FILTER_VALIDATE_URL) ? 'SÍ' : 'NO',
        'archivo_existe' => $categoria->urlImagen && !filter_var($categoria->urlImagen, FILTER_VALIDATE_URL) ? 
            (Storage::disk('shared')->exists('categorias/' . $categoria->urlImagen) ? 'SÍ' : 'NO') : 'N/A'
    ];
});

require __DIR__.'/auth.php';