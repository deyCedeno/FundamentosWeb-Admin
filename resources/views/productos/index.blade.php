@extends('layouts.app')

@section('title', 'Gestión de Productos')

@section('breadcrumb')
    <li class="breadcrumb-item active">Productos</li>
@endsection

@section('actions')
    <a href="{{ route('productos.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuevo Producto
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Tipo</th>
                            <th>Comercio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $producto)
                        <tr>
                            <td>{{ $producto->idProducto }}</td>
                            <td>
                                <img src="{{ $producto->imagenDestacada }}" alt="{{ $producto->nombre }}" style="max-width: 100px; height: auto;">
                            </td>
                            <td>{{ $producto->nombre }}</td>
                            <td>₡{{ number_format($producto->precio, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $producto->tipoProducto == 'servicio' ? 'info' : 'success' }}">
                                    {{ $producto->tipoProducto }}
                                </span>
                            </td>
                            <td>{{ $producto->comercio->nombre }}</td>
                            <td>
                                <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('productos.galeria', $producto) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-images"></i>
                                </a>
                                <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection