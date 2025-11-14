@extends('layouts.app')

@section('title', 'Crear Producto')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
    <li class="breadcrumb-item active">Crear</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Crear Producto</h3>
        </div>
        <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="{{ old('precio') }}" required>
                </div>
                <div class="mb-3">
                    <label for="tipoProducto" class="form-label">Tipo de Producto</label>
                    <select class="form-control" id="tipoProducto" name="tipoProducto" required>
                        <option value="">Seleccione un tipo</option>
                        <option value="producto" {{ old('tipoProducto') == 'producto' ? 'selected' : '' }}>Producto</option>
                        <option value="servicio" {{ old('tipoProducto') == 'servicio' ? 'selected' : '' }}>Servicio</option>
                        <option value="comida" {{ old('tipoProducto') == 'comida' ? 'selected' : '' }}>Comida</option>
                        <option value="bebida" {{ old('tipoProducto') == 'bebida' ? 'selected' : '' }}>Bebida</option>
                        <option value="postre" {{ old('tipoProducto') == 'postre' ? 'selected' : '' }}>Postre</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="imagenDestacada" class="form-label">Imagen Destacada</label>
                    <input type="file" class="form-control" id="imagenDestacada" name="imagenDestacada" accept="image/*" required>
                    <div class="form-text">
                        Formatos permitidos: JPEG, PNG, JPG, GIF, WEBP. Tamaño máximo: 2MB
                    </div>
                </div>
                <div class="mb-3">
                    <label for="idComercio" class="form-label">Comercio</label>
                    <select class="form-control" id="idComercio" name="idComercio" required>
                        <option value="">Seleccione un comercio</option>
                        @foreach($comercios as $comercio)
                        <option value="{{ $comercio->idComercio }}" {{ old('idComercio') == $comercio->idComercio ? 'selected' : '' }}>
                            {{ $comercio->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection