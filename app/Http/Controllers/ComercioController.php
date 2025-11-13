<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use App\Models\Categoria;
use App\Models\Telefono;
use App\Models\Correo;
use App\Models\ComercioImagen;
use Illuminate\Http\Request;

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
            'imagenDestacada' => 'required|url',
            'categorias' => 'required|array',
            'telefonos' => 'required|array',
            'correos' => 'required|array'
        ]);

        $comercio = Comercio::create($request->all());
        
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
            'imagenDestacada' => 'required|url',
            'categorias' => 'required|array'
        ]);

        $comercio->update($request->all());
        $comercio->categorias()->sync($request->categorias);

        return redirect()->route('comercios.index')
            ->with('success', 'Comercio actualizado exitosamente.');
    }

    public function destroy(Comercio $comercio)
    {
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
            'urlImagen' => 'required|url'
        ]);

        ComercioImagen::create([
            'idComercio' => $comercio->idComercio,
            'urlImagen' => $request->urlImagen
        ]);

        return redirect()->route('comercios.galeria', $comercio)
            ->with('success', 'Imagen agregada exitosamente.');
    }

    public function destroyImagen(ComercioImagen $imagen)
    {
        $comercioId = $imagen->idComercio;
        $imagen->delete();

        return redirect()->route('comercios.galeria', $comercioId)
            ->with('success', 'Imagen eliminada exitosamente.');
    }
}