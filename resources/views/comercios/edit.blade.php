@extends('layout.app')

@section('title', 'Editar Comercio')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('comercios.index') }}">Comercios</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Editar Comercio</h3>
        </div>
        <form action="{{ route('comercios.update', $comercio) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $comercio->nombre) }}" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion', $comercio->descripcion) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="dirección" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="dirección" name="dirección" value="{{ old('dirección', $comercio->dirección) }}" required>
                </div>
                <div class="mb-3">
                    <label for="facebook" class="form-label">Facebook</label>
                    <input type="url" class="form-control" id="facebook" name="facebook" value="{{ old('facebook', $comercio->facebook) }}">
                </div>
                <div class="mb-3">
                    <label for="instagram" class="form-label">Instagram</label>
                    <input type="url" class="form-control" id="instagram" name="instagram" value="{{ old('instagram', $comercio->instagram) }}">
                </div>
                <div class="mb-3">
                    <label for="urlMapa" class="form-label">URL del Mapa</label>
                    <input type="url" class="form-control" id="urlMapa" name="urlMapa" value="{{ old('urlMapa', $comercio->urlMapa) }}" required>
                </div>
                <div class="mb-3">
                    <label for="imagenDestacada" class="form-label">URL de la Imagen Destacada</label>
                    <input type="url" class="form-control" id="imagenDestacada" name="imagenDestacada" value="{{ old('imagenDestacada', $comercio->imagenDestacada) }}" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Categorías</label>
                    <div class="row">
                        @foreach($categorias as $categoria)
                        <div class="col-md-3 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="categorias[]" 
                                       value="{{ $categoria->idCategoria }}" 
                                       id="cat{{ $categoria->idCategoria }}"
                                       {{ $comercio->categorias->contains($categoria->idCategoria) ? 'checked' : '' }}>
                                <label class="form-check-label" for="cat{{ $categoria->idCategoria }}">
                                    {{ $categoria->nombre }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('comercios.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection