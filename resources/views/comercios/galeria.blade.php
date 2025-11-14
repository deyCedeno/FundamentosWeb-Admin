@extends('layouts.app')

@section('title', 'Galería del Comercio')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('comercios.index') }}">Comercios</a></li>
    <li class="breadcrumb-item active">Galería - {{ $comercio->nombre }}</li>
@endsection

@section('actions')
    <a href="{{ route('comercios.index') }}" class="btn btn-secondary">
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
                    <form action="{{ route('comercios.storeImagen', $comercio) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                            <div class="form-text">
                                Formatos permitidos: JPEG, PNG, JPG, GIF, WEBP. Tamaño máximo: 2MB
                            </div>
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
                    @if($imagenes->count() > 0)
                        <div class="row">
                            @foreach($imagenes as $imagen)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    @if($imagen->tiene_imagen)
                                        <img src="{{ $imagen->imagen_url }}" 
                                             class="card-img-top" 
                                             alt="Imagen del comercio" 
                                             style="height: 150px; object-fit: cover;">
                                    @else
                                        <div style="height: 150px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                            <small style="color: #999;">Imagen no disponible</small>
                                        </div>
                                    @endif
                                    <div class="card-body text-center">
                                        <form action="{{ route('comercios.destroyImagen', $imagen) }}" method="POST" class="d-inline">
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
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay imágenes en la galería</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection