@extends('layouts.app')

@section('title', 'Gestión de Comercios')

@section('breadcrumb')
    <li class="breadcrumb-item active">Comercios</li>
@endsection

@section('actions')
    <a href="{{ route('comercios.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuevo Comercio
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
                            <th>Descripción</th>
                            <th>Categorías</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comercios as $comercio)
                        <tr>
                            <td>{{ $comercio->idComercio }}</td>
                            <td>
                                @if($comercio->tiene_imagen_destacada)
                                    <img src="{{ $comercio->imagen_destacada_url }}" 
                                         alt="{{ $comercio->nombre }}" 
                                         style="max-width: 100px; height: auto; border: 1px solid #ddd; border-radius: 4px;">
                                @else
                                    <div style="width: 100px; height: 60px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border: 1px dashed #ccc; border-radius: 4px;">
                                        <small style="color: #999;">NO IMG</small>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $comercio->nombre }}</td>
                            <td>{{ Str::limit($comercio->descripcion, 50) }}</td>
                            <td>
                                @foreach($comercio->categorias as $categoria)
                                    <span class="badge bg-primary">{{ $categoria->nombre }}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('comercios.edit', $comercio) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('comercios.galeria', $comercio) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-images"></i>
                                </a>
                                <form action="{{ route('comercios.destroy', $comercio) }}" method="POST" class="d-inline">
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