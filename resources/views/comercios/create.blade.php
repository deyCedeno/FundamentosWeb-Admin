@extends('layouts.app')

@section('title', 'Crear Comercio')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('comercios.index') }}">Comercios</a></li>
    <li class="breadcrumb-item active">Crear</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Crear Comercio</h3>
        </div>
        <form action="{{ route('comercios.store') }}" method="POST" enctype="multipart/form-data">
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
                    <label for="dirección" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="dirección" name="dirección" value="{{ old('dirección') }}" required>
                </div>
                
                <!-- OPCIONES PARA GOOGLE MAPS -->
                <div class="mb-3">
                    <label for="urlMapa" class="form-label">URL de Google Maps</label>
                    <input type="url" class="form-control" id="urlMapa" name="urlMapa" value="{{ old('urlMapa') }}" required>
                    <div class="form-text">
                        <strong>Opciones para obtener el enlace:</strong>
                        <ul class="mb-1">
                            <li>Ve a Google Maps y busca el lugar</li>
                            <li>Haz clic en "Compartir" y selecciona "Insertar un mapa"</li>
                            <li>Copia el enlace que comienza con: <code>https://www.google.com/maps/embed?...</code></li>
                        </ul>
                        <strong>O usa este formato:</strong> 
                        <code>https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d...[tu_código]</code>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="facebook" class="form-label">Facebook</label>
                    <input type="url" class="form-control" id="facebook" name="facebook" value="{{ old('facebook') }}">
                </div>
                <div class="mb-3">
                    <label for="instagram" class="form-label">Instagram</label>
                    <input type="url" class="form-control" id="instagram" name="instagram" value="{{ old('instagram') }}">
                </div>
                
                <div class="mb-3">
                    <label for="imagenDestacada" class="form-label">Imagen Destacada</label>
                    <input type="file" class="form-control" id="imagenDestacada" name="imagenDestacada" accept="image/*" required>
                    <div class="form-text">
                        Formatos permitidos: JPEG, PNG, JPG, GIF, WEBP. Tamaño máximo: 2MB
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Categorías</label>
                    <div class="row">
                        @foreach($categorias as $categoria)
                        <div class="col-md-3 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="categorias[]" value="{{ $categoria->idCategoria }}" id="cat{{ $categoria->idCategoria }}">
                                <label class="form-check-label" for="cat{{ $categoria->idCategoria }}">
                                    {{ $categoria->nombre }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Teléfonos</label>
                    <div id="telefonos-container">
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="telefonos[]" placeholder="Número de teléfono">
                            <button type="button" class="btn btn-outline-danger" onclick="removeField(this)">×</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addField('telefonos-container', 'teléfono')">Agregar Teléfono</button>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correos Electrónicos</label>
                    <div id="correos-container">
                        <div class="input-group mb-2">
                            <input type="email" class="form-control" name="correos[]" placeholder="Correo electrónico">
                            <button type="button" class="btn btn-outline-danger" onclick="removeField(this)">×</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addField('correos-container', 'correo')">Agregar Correo</button>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('comercios.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        function addField(containerId, type) {
            const container = document.getElementById(containerId);
            const inputType = type === 'teléfono' ? 'text' : 'email';
            const placeholder = type === 'teléfono' ? 'Número de teléfono' : 'Correo electrónico';
            
            const div = document.createElement('div');
            div.className = 'input-group mb-2';
            div.innerHTML = `
                <input type="${inputType}" class="form-control" name="${type === 'teléfono' ? 'telefonos[]' : 'correos[]'}" placeholder="${placeholder}">
                <button type="button" class="btn btn-outline-danger" onclick="removeField(this)">×</button>
            `;
            container.appendChild(div);
        }

        function removeField(button) {
            button.parentElement.remove();
        }
    </script>
@endsection