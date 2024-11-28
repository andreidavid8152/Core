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
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email (no editable)</label>
                <input type="email" id="email" class="form-control" value="{{ $usuario->email }}" disabled>
            </div>

            <div class="mb-3">
                <label for="peso" class="form-label">Peso (kg)</label>
                <input type="number" name="peso" id="peso" class="form-control" value="{{ $usuario->peso }}" step="0.01" min="0" max="635">
            </div>

            <div class="mb-3">
                <label for="altura" class="form-label">Altura (m)</label>
                <input type="number" name="altura" id="altura" class="form-control" value="{{ $usuario->altura }}" step="0.01" min="0" max="3">
            </div>

            <div class="mb-3">
                <label for="edad" class="form-label">Edad</label>
                <input type="number" name="edad" id="edad" class="form-control" value="{{ $usuario->edad }}" min="0" max="120">
            </div>

            <div class="mb-3">
                <label for="sexo" class="form-label">Sexo</label>
                <select name="sexo" id="sexo" class="form-control" required>
                    <option value="" disabled {{ is_null($usuario->sexo) ? 'selected' : '' }}>Seleccione</option>
                    <option value="Masculino" {{ $usuario->sexo == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Femenino" {{ $usuario->sexo == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="caloriasPorComida" class="form-label">Calorías por comida</label>
                <input type="number" name="caloriasPorComida" id="caloriasPorComida" class="form-control" value="{{ $usuario->caloriasPorComida }}" min="0" max="9999">
            </div>

            <button type="submit" class="btn btn-success">Guardar cambios</button>
        </div>
    </div>
</form>

<!-- Divisor -->
<hr class="my-4">

<!-- Formulario de Restricciones -->
<form action="{{ route('perfil.restricciones.update', $usuario->id) }}" method="POST">
    @csrf
    @method('PUT')

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
                <span class="badge bg-info me-1">{{ $restriccion->descripcion }}</span>
                @endforeach
                @else
                <p class="text-muted">No se han seleccionado restricciones.</p>
                @endif
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">Guardar Restricciones</button>
        </div>
    </div>
</form>

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const saveButton = document.getElementById('save-restricciones');
        const selectedContainer = document.getElementById('selected-restricciones');
        const checkboxes = document.querySelectorAll('.restriccion-checkbox');
        const mainForm = document.querySelector(`form[action="{{ route('perfil.restricciones.update', $usuario->id) }}"]`);

        saveButton.addEventListener('click', function() {
            selectedContainer.innerHTML = ''; // Limpia las restricciones seleccionadas

            // Eliminar inputs ocultos existentes
            const existingInputs = mainForm.querySelectorAll('.restriccion-hidden-inputs');
            existingInputs.forEach(input => input.remove());

            let selectedCount = 0;

            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedCount++;

                    const restriccionId = checkbox.value;
                    const label = document.querySelector(`label[for="restriccion-${restriccionId}"]`).innerText;

                    // Mostrar restricciones seleccionadas
                    const span = document.createElement('span');
                    span.className = 'badge bg-info me-1';
                    span.innerText = label;
                    selectedContainer.appendChild(span);

                    // Crear inputs ocultos para enviar al servidor
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'restricciones[]';
                    hiddenInput.value = restriccionId;
                    hiddenInput.className = 'restriccion-hidden-inputs';
                    mainForm.appendChild(hiddenInput);
                }
            });

            // Si no se selecciona nada, mostrar mensaje
            if (selectedCount === 0) {
                selectedContainer.innerHTML = '<p class="text-muted">No se han seleccionado restricciones.</p>';
            }

            // Cerrar el modal
            const modalInstance = bootstrap.Modal.getInstance(document.getElementById('restriccionesModal'));
            modalInstance.hide();
        });
    });
</script>

@endsection