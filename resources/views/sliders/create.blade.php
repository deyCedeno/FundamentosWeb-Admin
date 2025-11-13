@extends('layouts.app')

@section('title', 'Crear Slider')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('sliders.index') }}">Sliders</a></li>
    <li class="breadcrumb-item active">Crear</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Crear Slider</h3>
        </div>
        <form action="{{ route('sliders.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">URL de la Imagen</label>
                    <input type="file" class="form-control" id="imagen" name="imagen" value="{{ old('imagen') }}" required>
                </div>
                <div class="mb-3">
                    <label for="enlace" class="form-label">Enlace</label>
                    <input type="url" class="form-control" id="enlace" name="enlace" value="{{ old('enlace') }}">
                </div>
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="datetime-local" class="form-control" id="fecha" name="fecha" value="{{ old('fecha') }}" required>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('sliders.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection