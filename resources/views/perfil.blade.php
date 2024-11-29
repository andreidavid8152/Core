@extends('layouts.app')

@section('content')

<h1>Perfil del Usuario</h1>

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form action="{{ route('perfil.update', $usuario->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card mb-3 mt-4">
        <div class="card-header">
            Información Personal
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $usuario->nombre }}" required>
                @error('nombre')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email (no editable)</label>
                <input type="email" id="email" class="form-control" value="{{ $usuario->email }}" disabled>
            </div>

            <div class="mb-3">
                <label for="peso" class="form-label">Peso (kg)</label>
                <input type="number" name="peso" id="peso" class="form-control" value="{{ $usuario->peso }}" step="0.01" min="0" max="635" required>
                @error('peso')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="altura" class="form-label">Altura (m)</label>
                <input type="number" name="altura" id="altura" class="form-control" value="{{ $usuario->altura }}" step="0.01" min="0" max="3" required>
                @error('altura')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="edad" class="form-label">Edad</label>
                <input type="number" name="edad" id="edad" class="form-control" value="{{ $usuario->edad }}" min="0" max="120" required>
                @error('edad')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="sexo" class="form-label">Sexo</label>
                <select name="sexo" id="sexo" class="form-control" required>
                    <option value="" disabled {{ is_null($usuario->sexo) ? 'selected' : '' }}>Seleccione</option>
                    <option value="Masculino" {{ $usuario->sexo == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Femenino" {{ $usuario->sexo == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                </select>
                @error('sexo')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label for="caloriasPorComida" class="form-label">Calorías por comida</label>
                <input type="number" name="caloriasPorComida" id="caloriasPorComida" class="form-control" value="{{ $usuario->caloriasPorComida }}" min="0" max="9999" required>
                @error('caloriasPorComida')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Guardar cambios</button>
        </div>
    </div>
</form>

<!-- Divisor -->
<hr class="my-4">

<!-- Contenedor de Restricciones -->
<div class="card">
    <div class="card-header">
        <h4>Restricciones</h4>
    </div>
    <div class="card-body">
        <button type="button" class="btn btn-info w-100 mb-3" data-bs-toggle="modal" data-bs-target="#restriccionesModal">
            Editar Restricciones
        </button>
        <!-- Contenedor para mostrar las restricciones seleccionadas -->
        <div id="selected-restricciones">
            @if (!empty($restriccionesUsuario))
            @foreach($restricciones->whereIn('id', $restriccionesUsuario) as $restriccion)
            <span class="badge bg-warning me-1">{{ $restriccion->descripcion }}</span>
            @endforeach
            @else
            <p class="text-muted">No se han seleccionado restricciones.</p>
            @endif
        </div>
        @error('restricciones')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<!-- Divisor -->
<hr class="my-4">

<!-- Contenedor de Preferencias -->
<div class="card mb-5">
    <div class="card-header">
        <h4>Preferencias</h4>
    </div>
    <div class="card-body">
        <button type="button" class="btn btn-info w-100 mb-3" data-bs-toggle="modal" data-bs-target="#preferenciasModal">
            Editar Preferencias
        </button>
        <!-- Contenedor para mostrar las preferencias seleccionadas -->
        <div id="selected-preferencias">
            @if (!empty($preferenciasUsuario))
            @foreach($preferencias->whereIn('id', $preferenciasUsuario) as $preferencia)
            <span class="badge bg-warning me-1">{{ $preferencia->descripcion }}</span>
            @endforeach
            @else
            <p class="text-muted">No se han seleccionado preferencias.</p>
            @endif
        </div>
        @error('preferencias')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>

<!-- Modal para Restricciones -->
<div class="modal fade" id="restriccionesModal" tabindex="-1" aria-labelledby="restriccionesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccionar Restricciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Seleccionar</th>
                            <th>Restricción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($restricciones as $restriccion)
                        <tr>
                            <td>
                                <input class="form-check-input restriccion-checkbox" type="checkbox" value="{{ $restriccion->id }}"
                                    id="restriccion-{{ $restriccion->id }}"
                                    {{ in_array($restriccion->id, $restriccionesUsuario) ? 'checked' : '' }}>
                            </td>
                            <td>
                                <label class="form-check-label" for="restriccion-{{ $restriccion->id }}">
                                    {{ $restriccion->descripcion }}
                                </label>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="save-restricciones">Guardar Selección</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Preferencias -->
<div class="modal fade" id="preferenciasModal" tabindex="-1" aria-labelledby="preferenciasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccionar Preferencias</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Seleccionar</th>
                            <th>Preferencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($preferencias as $preferencia)
                        <tr>
                            <td>
                                <input class="form-check-input preferencia-checkbox" type="checkbox" value="{{ $preferencia->id }}"
                                    id="preferencia-{{ $preferencia->id }}"
                                    {{ in_array($preferencia->id, $preferenciasUsuario) ? 'checked' : '' }}>
                            </td>
                            <td>
                                <label class="form-check-label" for="preferencia-{{ $preferencia->id }}">
                                    {{ $preferencia->descripcion }}
                                </label>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="save-preferencias">Guardar Selección</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Restricciones
        const saveButton = document.getElementById('save-restricciones');
        const selectedContainer = document.getElementById('selected-restricciones');
        const checkboxes = document.querySelectorAll('.restriccion-checkbox');

        saveButton.addEventListener('click', function() {
            const selectedIds = [];
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    selectedIds.push(checkbox.value);
                }
            });

            // Realizar la solicitud al servidor
            fetch(`{{ route('perfil.restricciones.update', $usuario->id) }}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        restricciones: selectedIds
                    }),
                })
                .then((response) => {
                    return response.json().then((data) => {
                        if (!response.ok) {
                            // Manejo de errores del lado del servidor
                            console.error('Error en la respuesta:', data);
                            throw new Error(data.message || 'Error en la solicitud');
                        }
                        return data;
                    });
                })
                .then((data) => {
                    if (data.success) {
                        // Actualizar las restricciones mostradas
                        selectedContainer.innerHTML = '';
                        data.restricciones.forEach((restriccion) => {
                            const span = document.createElement('span');
                            span.className = 'badge bg-warning me-1';
                            span.innerText = restriccion.descripcion;
                            selectedContainer.appendChild(span);
                        });
                    } else {
                        alert('Ocurrió un error al guardar las restricciones.');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al guardar las restricciones.');
                });

            // Cerrar el modal
            const modalInstance = bootstrap.Modal.getInstance(document.getElementById('restriccionesModal'));
            modalInstance.hide();
        });

        // Preferencias
        const savePreferenciasButton = document.getElementById('save-preferencias');
        const selectedPreferenciasContainer = document.getElementById('selected-preferencias');
        const preferenciaCheckboxes = document.querySelectorAll('.preferencia-checkbox');

        savePreferenciasButton.addEventListener('click', function() {
            const selectedIds = [];
            preferenciaCheckboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    selectedIds.push(checkbox.value);
                }
            });

            // Realizar la solicitud al servidor
            fetch(`{{ route('perfil.preferencias.update', $usuario->id) }}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        preferencias: selectedIds
                    }),
                })
                .then((response) => {
                    return response.json().then((data) => {
                        if (!response.ok) {
                            console.error('Error en la respuesta:', data);
                            throw new Error(data.message || 'Error en la solicitud');
                        }
                        return data;
                    });
                })
                .then((data) => {
                    if (data.success) {
                        // Actualizar las preferencias mostradas
                        selectedPreferenciasContainer.innerHTML = '';
                        data.preferencias.forEach((preferencia) => {
                            const span = document.createElement('span');
                            span.className = 'badge bg-warning me-1';
                            span.innerText = preferencia.descripcion;
                            selectedPreferenciasContainer.appendChild(span);
                        });
                    } else {
                        alert('Ocurrió un error al guardar las preferencias.');
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al guardar las preferencias.');
                });

            // Cerrar el modal
            const preferenciasModalInstance = bootstrap.Modal.getInstance(document.getElementById('preferenciasModal'));
            preferenciasModalInstance.hide();
        });
    });
</script>

@endsection