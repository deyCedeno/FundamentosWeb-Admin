@extends('layouts.app')

@section('title', 'Crear Slider')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('sliders.index') }}">Sliders</a></li>
    <li class="breadcrumb-item active">Crear</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Crear Slider</h3>
        </div>
        <form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen</label>
                    <input type="file" class="form-control" id="imagen" name="imagen" required>
                    <div class="form-text">Formatos: JPEG, PNG, JPG, GIF. Máx: 2MB</div>
                </div>
                
                <!-- SELECT PARA EL ENLACE -->
                <div class="mb-3">
                    <label for="tipo_enlace" class="form-label">Enlace de destino</label>
                    <select class="form-control" id="tipo_enlace" name="tipo_enlace" required>
                        <option value="">-- Seleccionar destino --</option>
                        <option value="/categorias" {{ old('tipo_enlace') == '/categorias' ? 'selected' : '' }}>Categorías</option>
                        <option value="/comercios" {{ old('tipo_enlace') == '/comercios' ? 'selected' : '' }}>Comercios</option>
                        <option value="/productos" {{ old('tipo_enlace') == '/productos' ? 'selected' : '' }}>Productos</option>
                    </select>
                    <input type="hidden" id="enlace" name="enlace" value="{{ old('enlace') }}">
                    <div class="form-text">Selecciona a qué sección debe redirigir este slider</div>
                </div>

                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input type="datetime-local" class="form-control" id="fecha" name="fecha" value="{{ old('fecha') }}" required>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('sliders.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectEnlace = document.getElementById('tipo_enlace');
    const inputEnlace = document.getElementById('enlace');
    
    // Actualizar el campo hidden cuando cambie el select
    selectEnlace.addEventListener('change', function() {
        inputEnlace.value = this.value;
    });
    
    // Inicializar el valor al cargar la página
    if (selectEnlace.value) {
        inputEnlace.value = selectEnlace.value;
    }
});
</script>
@endsection