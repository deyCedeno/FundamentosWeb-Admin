@extends('layouts.app')

@section('title', 'Editar Slider')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('sliders.index') }}">Sliders</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Editar Slider</h3>
        </div>
        <form action="{{ route('sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo', $slider->titulo) }}" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion', $slider->descripcion) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen</label>
                    <input type="file" class="form-control" id="imagen" name="imagen">
                    @if($slider->imagen)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$slider->imagen) }}" alt="{{ $slider->titulo }}" style="max-width: 200px; height: auto;">
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="enlace" class="form-label">Enlace</label>
                    <input type="url" class="form-control" id="enlace" name="enlace" value="{{ old('enlace', $slider->enlace) }}">
                </div>
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="datetime-local" class="form-control" id="fecha" name="fecha" value="{{ old('fecha', $slider->fecha->format('Y-m-d\TH:i')) }}" required>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('sliders.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection