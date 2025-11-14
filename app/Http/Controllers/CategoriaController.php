<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Support\Facades\Storage;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048' // Cambié a 'imagen'
        ]);

        $imagenNombre = null;

        // Procesar imagen
        if ($request->hasFile('imagen')) { // Cambié a 'imagen'
            // Generar nombre único
            $extension = $request->file('imagen')->getClientOriginalExtension();
            $fileName = 'categoria_' . uniqid() . '.' . $extension;
            
            // Guardar en storage compartido
            $request->file('imagen')->storeAs('categorias', $fileName, 'shared');
            
            // Guardar solo el nombre del archivo en la BD
            $imagenNombre = $fileName;
        }

        Categoria::create([
            'nombre' => $request->nombre,
            'urlImagen' => $imagenNombre // Guardar en el campo correcto de la BD
        ]);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada exitosamente.');
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048' // Cambié a 'imagen'
        ]);

        $data = [
            'nombre' => $request->nombre
        ];

        // Procesar la nueva imagen si se subió
        if ($request->hasFile('imagen')) { // Cambié a 'imagen'
            // Eliminar la imagen anterior si existe y es un archivo local
            if ($categoria->urlImagen && !filter_var($categoria->urlImagen, FILTER_VALIDATE_URL)) {
                Storage::disk('shared')->delete('categorias/' . $categoria->urlImagen);
            }
            
            // Guardar nueva imagen
            $extension = $request->file('imagen')->getClientOriginalExtension();
            $fileName = 'categoria_' . uniqid() . '.' . $extension;
            $request->file('imagen')->storeAs('categorias', $fileName, 'shared');
            $data['urlImagen'] = $fileName;
        }

        $categoria->update($data);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada exitosamente.');
    }

    public function destroy(Categoria $categoria)
    {
        // Eliminar la imagen del storage solo si es un archivo local
        if ($categoria->urlImagen && !filter_var($categoria->urlImagen, FILTER_VALIDATE_URL)) {
            Storage::disk('shared')->delete('categorias/' . $categoria->urlImagen);
        }

        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada exitosamente.');
    }
}