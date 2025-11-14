<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use App\Models\Categoria;
use App\Models\Telefono;
use App\Models\Correo;
use App\Models\ComercioImagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComercioController extends Controller
{
    public function index()
    {
        $comercios = Comercio::with('categorias')->get();
        return view('comercios.index', compact('comercios'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('comercios.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:255',
            'dirección' => 'required|string|max:100',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'urlMapa' => 'required|url',
            'imagenDestacada' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Cambiar a file
            'categorias' => 'required|array',
            'telefonos' => 'required|array',
            'correos' => 'required|array'
        ]);

        $imagenDestacadaNombre = null;

        // Procesar imagen destacada
        if ($request->hasFile('imagenDestacada')) {
            $extension = $request->file('imagenDestacada')->getClientOriginalExtension();
            $fileName = 'comercio_destacada_' . uniqid() . '.' . $extension;
            $request->file('imagenDestacada')->storeAs('comercios', $fileName, 'shared');
            $imagenDestacadaNombre = $fileName;
        }

        $comercio = Comercio::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'dirección' => $request->dirección,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'urlMapa' => $request->urlMapa,
            'imagenDestacada' => $imagenDestacadaNombre
        ]);
        
        // Sincronizar categorías
        $comercio->categorias()->sync($request->categorias);

        // Guardar teléfonos
        foreach ($request->telefonos as $telefono) {
            if (!empty($telefono)) {
                Telefono::create([
                    'telefono' => $telefono,
                    'idComercio' => $comercio->idComercio
                ]);
            }
        }

        // Guardar correos
        foreach ($request->correos as $correo) {
            if (!empty($correo)) {
                Correo::create([
                    'correo' => $correo,
                    'idComercio' => $comercio->idComercio
                ]);
            }
        }

        return redirect()->route('comercios.index')
            ->with('success', 'Comercio creado exitosamente.');
    }

    public function edit(Comercio $comercio)
    {
        $categorias = Categoria::all();
        $comercio->load('telefonos', 'correos', 'categorias');
        return view('comercios.edit', compact('comercio', 'categorias'));
    }

    public function update(Request $request, Comercio $comercio)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:255',
            'dirección' => 'required|string|max:100',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'urlMapa' => 'required|url',
            'imagenDestacada' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Cambiar a file
            'categorias' => 'required|array'
        ]);

        $data = $request->only(['nombre', 'descripcion', 'dirección', 'facebook', 'instagram', 'urlMapa']);

        // Procesar nueva imagen destacada si se subió
        if ($request->hasFile('imagenDestacada')) {
            // Eliminar imagen anterior si existe y es local
            if ($comercio->imagenDestacada && !filter_var($comercio->imagenDestacada, FILTER_VALIDATE_URL)) {
                Storage::disk('shared')->delete('comercios/' . $comercio->imagenDestacada);
            }
            
            $extension = $request->file('imagenDestacada')->getClientOriginalExtension();
            $fileName = 'comercio_destacada_' . uniqid() . '.' . $extension;
            $request->file('imagenDestacada')->storeAs('comercios', $fileName, 'shared');
            $data['imagenDestacada'] = $fileName;
        }

        $comercio->update($data);
        $comercio->categorias()->sync($request->categorias);

        return redirect()->route('comercios.index')
            ->with('success', 'Comercio actualizado exitosamente.');
    }

    public function destroy(Comercio $comercio)
    {
        // Eliminar imagen destacada si es local
        if ($comercio->imagenDestacada && !filter_var($comercio->imagenDestacada, FILTER_VALIDATE_URL)) {
            Storage::disk('shared')->delete('comercios/' . $comercio->imagenDestacada);
        }

        // Eliminar imágenes de la galería
        foreach ($comercio->imagenes as $imagen) {
            if ($imagen->imagen && !filter_var($imagen->imagen, FILTER_VALIDATE_URL)) {
                Storage::disk('shared')->delete('comercios/galeria/' . $imagen->imagen);
            }
        }

        $comercio->delete();

        return redirect()->route('comercios.index')
            ->with('success', 'Comercio eliminado exitosamente.');
    }

    // Gestión de galería de imágenes del comercio
    public function galeria(Comercio $comercio)
    {
        $imagenes = $comercio->imagenes;
        return view('comercios.galeria', compact('comercio', 'imagenes'));
    }

    public function storeImagen(Request $request, Comercio $comercio)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048' // Cambiar a file
        ]);

        $imagenNombre = null;

        if ($request->hasFile('imagen')) {
            $extension = $request->file('imagen')->getClientOriginalExtension();
            $fileName = 'comercio_galeria_' . uniqid() . '.' . $extension;
            $request->file('imagen')->storeAs('comercios/galeria', $fileName, 'shared');
            $imagenNombre = $fileName;
        }

        ComercioImagen::create([
            'idComercio' => $comercio->idComercio,
            'urlImagen' => $imagenNombre
        ]);

        return redirect()->route('comercios.galeria', $comercio)
            ->with('success', 'Imagen agregada exitosamente.');
    }

    public function destroyImagen(ComercioImagen $imagen)
    {
        if ($imagen->urlImagen && !filter_var($imagen->urlImagen, FILTER_VALIDATE_URL)) {
            Storage::disk('shared')->delete('comercios/galeria/' . $imagen->urlImagen);
        }

        $comercioId = $imagen->idComercio;
        $imagen->delete();

        return redirect()->route('comercios.galeria', $comercioId)
            ->with('success', 'Imagen eliminada exitosamente.');
    }
}