<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Comercio;
use App\Models\ProductoImagen;
use Illuminate\Http\Request;

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
            'imagenDestacada' => 'required|url',
            'idComercio' => 'required|exists:comercio,idComercio'
        ]);

        Producto::create($request->all());

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
            'imagenDestacada' => 'required|url',
            'idComercio' => 'required|exists:comercio,idComercio'
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Producto $producto)
    {
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
            'urlImagen' => 'required|url'
        ]);

        ProductoImagen::create([
            'idProducto' => $producto->idProducto,
            'urlImagen' => $request->urlImagen
        ]);

        return redirect()->route('productos.galeria', $producto)
            ->with('success', 'Imagen agregada exitosamente.');
    }

    public function destroyImagen(ProductoImagen $imagen)
    {
        $productoId = $imagen->idProducto;
        $imagen->delete();

        return redirect()->route('productos.galeria', $productoId)
            ->with('success', 'Imagen eliminada exitosamente.');
    }
}