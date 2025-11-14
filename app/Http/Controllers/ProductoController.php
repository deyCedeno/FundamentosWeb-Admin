<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Comercio;
use App\Models\ProductoImagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('comercio')->get();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $comercios = Comercio::all();
        return view('productos.create', compact('comercios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'tipoProducto' => 'required|string|max:20',
            'imagenDestacada' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'idComercio' => 'required|exists:comercio,idComercio'
        ]);

        $imagenDestacadaNombre = null;

        // Procesar imagen destacada
        if ($request->hasFile('imagenDestacada')) {
            $extension = $request->file('imagenDestacada')->getClientOriginalExtension();
            $fileName = 'producto_destacada_' . uniqid() . '.' . $extension;
            $request->file('imagenDestacada')->storeAs('productos', $fileName, 'shared');
            $imagenDestacadaNombre = $fileName;
        }

        Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'tipoProducto' => $request->tipoProducto,
            'imagenDestacada' => $imagenDestacadaNombre,
            'idComercio' => $request->idComercio
        ]);

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Producto $producto)
    {
        $comercios = Comercio::all();
        return view('productos.edit', compact('producto', 'comercios'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'tipoProducto' => 'required|string|max:20',
            'imagenDestacada' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'idComercio' => 'required|exists:comercio,idComercio'
        ]);

        $data = $request->only(['nombre', 'descripcion', 'precio', 'tipoProducto', 'idComercio']);

        // Procesar nueva imagen destacada si se subió
        if ($request->hasFile('imagenDestacada')) {
            // Eliminar imagen anterior si existe y es local
            if ($producto->imagenDestacada && !filter_var($producto->imagenDestacada, FILTER_VALIDATE_URL)) {
                Storage::disk('shared')->delete('productos/' . $producto->imagenDestacada);
            }
            
            $extension = $request->file('imagenDestacada')->getClientOriginalExtension();
            $fileName = 'producto_destacada_' . uniqid() . '.' . $extension;
            $request->file('imagenDestacada')->storeAs('productos', $fileName, 'shared');
            $data['imagenDestacada'] = $fileName;
        }

        $producto->update($data);

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Producto $producto)
    {
        // Eliminar imagen destacada si es local
        if ($producto->imagenDestacada && !filter_var($producto->imagenDestacada, FILTER_VALIDATE_URL)) {
            Storage::disk('shared')->delete('productos/' . $producto->imagenDestacada);
        }

        // Eliminar imágenes de la galería
        foreach ($producto->imagenes as $imagen) {
            if ($imagen->urlImagen && !filter_var($imagen->urlImagen, FILTER_VALIDATE_URL)) {
                Storage::disk('shared')->delete('productos/galeria/' . $imagen->urlImagen);
            }
        }

        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }

    // Gestión de galería de imágenes del producto
    public function galeria(Producto $producto)
    {
        $imagenes = $producto->imagenes;
        return view('productos.galeria', compact('producto', 'imagenes'));
    }

    public function storeImagen(Request $request, Producto $producto)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $imagenNombre = null;

        if ($request->hasFile('imagen')) {
            $extension = $request->file('imagen')->getClientOriginalExtension();
            $fileName = 'producto_galeria_' . uniqid() . '.' . $extension;
            $request->file('imagen')->storeAs('productos/galeria', $fileName, 'shared');
            $imagenNombre = $fileName;
        }

        ProductoImagen::create([
            'idProducto' => $producto->idProducto,
            'urlImagen' => $imagenNombre
        ]);

        return redirect()->route('productos.galeria', $producto)
            ->with('success', 'Imagen agregada exitosamente.');
    }

    public function destroyImagen(ProductoImagen $imagen)
    {
        if ($imagen->urlImagen && !filter_var($imagen->urlImagen, FILTER_VALIDATE_URL)) {
            Storage::disk('shared')->delete('productos/galeria/' . $imagen->urlImagen);
        }

        $productoId = $imagen->idProducto;
        $imagen->delete();

        return redirect()->route('productos.galeria', $productoId)
            ->with('success', 'Imagen eliminada exitosamente.');
    }
}