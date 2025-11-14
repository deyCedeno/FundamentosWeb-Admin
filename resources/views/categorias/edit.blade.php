@extends('layouts.app')

@section('title', 'Editar Categoría')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('categorias.index') }}">Categorías</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Editar Categoría</h3>
        </div>
        <form action="{{ route('categorias.update', $categoria) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $categoria->nombre) }}" required>
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen de la Categoría</label>
                    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                    <div class="form-text">
                        Formatos permitidos: JPEG, PNG, JPG, GIF, WEBP. Tamaño máximo: 2MB
                        @if($categoria->imagen)
                            <br><strong>Imagen actual:</strong>
                            <div class="mt-2">
                                <img src="{{ $categoria->imagen_url }}" alt="{{ $categoria->nombre }}" style="max-width: 200px; height: auto; border: 1px solid #ddd; border-radius: 4px;">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection