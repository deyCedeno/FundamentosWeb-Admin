@extends('layouts.app')

@section('title', 'Galería del Producto')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
    <li class="breadcrumb-item active">Galería - {{ $producto->nombre }}</li>
@endsection

@section('actions')
    <a href="{{ route('productos.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Agregar Imagen</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('productos.storeImagen', $producto) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="urlImagen" class="form-label">URL de la Imagen</label>
                            <input type="url" class="form-control" id="urlImagen" name="urlImagen" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Imagen</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Imágenes de la Galería</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($imagenes as $imagen)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="{{ $imagen->urlImagen }}" class="card-img-top" alt="Imagen del producto" style="height: 150px; object-fit: cover;">
                                <div class="card-body text-center">
                                    <form action="{{ route('productos.destroyImagen', $imagen) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection