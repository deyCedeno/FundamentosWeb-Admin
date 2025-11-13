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
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tipo_enlace' => 'required|string|in:/categorias,/comercios,/productos',
            'fecha' => 'required|date'
        ]);

        $imagenNombre = null;

        // Procesar imagen localmente
        if ($request->hasFile('imagen')) {
            // Generar nombre único
            $extension = $request->file('imagen')->getClientOriginalExtension();
            $fileName = 'slider_' . uniqid() . '.' . $extension;
            
            // Guardar en storage compartido
            $request->file('imagen')->storeAs('sliders', $fileName, 'shared');
            
            // Guardar solo el nombre del archivo en la BD
            $imagenNombre = $fileName;
        }

        Slider::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $imagenNombre,
            'enlace' => $request->tipo_enlace,
            'fecha' => $request->fecha
        ]);

        return redirect()->route('sliders.index')
            ->with('success', 'Slider creado exitosamente.');
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tipo_enlace' => 'required|string|in:/categorias,/comercios,/productos',
            'fecha' => 'required|date'
        ]);

        $data = $request->only(['titulo', 'descripcion', 'fecha']);
        $data['enlace'] = $request->tipo_enlace;

        // Procesar la nueva imagen si se subió
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($slider->imagen) {
                Storage::disk('shared')->delete('sliders/' . $slider->imagen);
            }
            
            // Guardar nueva imagen
            $extension = $request->file('imagen')->getClientOriginalExtension();
            $fileName = 'slider_' . uniqid() . '.' . $extension;
            $request->file('imagen')->storeAs('sliders', $fileName, 'shared');
            $data['imagen'] = $fileName;
        }

        $slider->update($data);

        return redirect()->route('sliders.index')
            ->with('success', 'Slider actualizado exitosamente.');
    }

    public function edit(Slider $slider)
    {
        return view('sliders.edit', compact('slider'));
    }

    public function destroy(Slider $slider)
    {
        // Eliminar la imagen del storage
        if ($slider->imagen) {
            Storage::disk('shared')->delete('sliders/' . $slider->imagen);
        }

        $slider->delete();

        return redirect()->route('sliders.index')
            ->with('success', 'Slider eliminado exitosamente.');
    }
}