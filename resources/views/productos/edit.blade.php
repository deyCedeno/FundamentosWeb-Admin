@extends('layouts.app')

@section('title', 'Editar Producto')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('productos.index') }}">Productos</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Editar Producto</h3>
        </div>
        <form action="{{ route('productos.update', $producto) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="{{ old('precio', $producto->precio) }}" required>
                </div>
                <div class="mb-3">
                    <label for="tipoProducto" class="form-label">Tipo de Producto</label>
                    <select class="form-control" id="tipoProducto" name="tipoProducto" required>
                        <option value="">Seleccione un tipo</option>
                        <option value="producto" {{ old('tipoProducto', $producto->tipoProducto) == 'producto' ? 'selected' : '' }}>Producto</option>
                        <option value="servicio" {{ old('tipoProducto', $producto->tipoProducto) == 'servicio' ? 'selected' : '' }}>Servicio</option>
                        <option value="comida" {{ old('tipoProducto', $producto->tipoProducto) == 'comida' ? 'selected' : '' }}>Comida</option>
                        <option value="bebida" {{ old('tipoProducto', $producto->tipoProducto) == 'bebida' ? 'selected' : '' }}>Bebida</option>
                        <option value="postre" {{ old('tipoProducto', $producto->tipoProducto) == 'postre' ? 'selected' : '' }}>Postre</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="imagenDestacada" class="form-label">URL de la Imagen Destacada</label>
                    <input type="url" class="form-control" id="imagenDestacada" name="imagenDestacada" value="{{ old('imagenDestacada', $producto->imagenDestacada) }}" required>
                </div>
                <div class="mb-3">
                    <label for="idComercio" class="form-label">Comercio</label>
                    <select class="form-control" id="idComercio" name="idComercio" required>
                        <option value="">Seleccione un comercio</option>
                        @foreach($comercios as $comercio)
                        <option value="{{ $comercio->idComercio }}" {{ old('idComercio', $producto->idComercio) == $comercio->idComercio ? 'selected' : '' }}>
                            {{ $comercio->nombre }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection