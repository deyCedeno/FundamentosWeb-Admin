<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('fecha', 'desc')->get();
        return view('sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('sliders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validación de imagen
            'enlace' => 'nullable|url',
            'fecha' => 'required|date'
        ]);

        // Subir la imagen
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('sliders', 'public');
        }

        Slider::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $imagenPath, // Guardamos la ruta relativa
            'enlace' => $request->enlace,
            'fecha' => $request->fecha
        ]);

        return redirect()->route('sliders.index')
            ->with('success', 'Slider creado exitosamente.');
    }

    public function edit(Slider $slider)
    {
        return view('sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Opcional en actualizar
            'enlace' => 'nullable|url',
            'fecha' => 'required|date'
        ]);

        $data = $request->only(['titulo', 'descripcion', 'enlace', 'fecha']);

        // Si se sube una nueva imagen, actualizarla
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior
            if ($slider->imagen) {
                Storage::disk('public')->delete($slider->imagen);
            }
            $imagenPath = $request->file('imagen')->store('sliders', 'public');
            $data['imagen'] = $imagenPath;
        }

        $slider->update($data);

        return redirect()->route('sliders.index')
            ->with('success', 'Slider actualizado exitosamente.');
    }

    public function destroy(Slider $slider)
    {
        // Eliminar la imagen del storage
        if ($slider->imagen) {
            Storage::disk('public')->delete($slider->imagen);
        }

        $slider->delete();

        return redirect()->route('sliders.index')
            ->with('success', 'Slider eliminado exitosamente.');
    }
}