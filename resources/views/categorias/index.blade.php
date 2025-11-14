@extends('layouts.app')

@section('title', 'Gestión de Categorías')

@section('breadcrumb')
    <li class="breadcrumb-item active">Categorías</li>
@endsection

@section('actions')
    <a href="{{ route('categorias.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nueva Categoría
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
                            <th>Comercios</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->idCategoria }}</td>
                            <td>
                                @if($categoria->tiene_imagen)
                                    <img src="{{ $categoria->imagen_url }}" 
                                         alt="{{ $categoria->nombre }}" 
                                         style="max-width: 100px; height: auto; border: 1px solid #ddd; border-radius: 4px;">
                                @else
                                    <div style="width: 100px; height: 60px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border: 1px dashed #ccc; border-radius: 4px;">
                                        <small style="color: #999;">NO IMG</small>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $categoria->nombre }}</td>
                            <td>{{ $categoria->comerciosCount() }}</td>
                            <td>
                                <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="d-inline">
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