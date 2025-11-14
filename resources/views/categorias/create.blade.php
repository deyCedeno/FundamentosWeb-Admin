@extends('layouts.app')

@section('title', 'Crear Categoría')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('categorias.index') }}">Categorías</a></li>
    <li class="breadcrumb-item active">Crear</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Crear Categoría</h3>
        </div>
        <form action="{{ route('categorias.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen de la Categoría</label>
                    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                    <div class="form-text">
                        Formatos permitidos: JPEG, PNG, JPG, GIF, WEBP. Tamaño máximo: 2MB
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection