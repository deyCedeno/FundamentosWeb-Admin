@extends('layouts.app')

@section('title', 'Gestión de Sliders')

@section('breadcrumb')
    <li class="breadcrumb-item active">Sliders</li>
@endsection

@section('actions')
    <a href="{{ route('sliders.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuevo Slider
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
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sliders as $slider)
                        <tr>
                            <td>{{ $slider->id }}</td>
                            <td>
                                <img src="{{ Storage::url($slider->imagen) }}" alt="{{ $slider->titulo }}" style="max-width: 100px; height: auto;">
                            </td>
                            <td>{{ $slider->titulo }}</td>
                            <td>{{ Str::limit($slider->descripcion, 50) }}</td>
                            <td>{{ $slider->fecha->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('sliders.edit', $slider) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('sliders.destroy', $slider) }}" method="POST" class="d-inline">
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