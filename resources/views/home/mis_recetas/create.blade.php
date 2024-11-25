@extends('layouts.app')

@section('content')

<h1>Crear Receta</h1>

<form action="{{ route('mis-recetas.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Título -->
    <div class="form-group">
        <label for="titulo">Título</label>
        <input type="text" name="titulo" class="form-control" placeholder="Ejemplo: Ensalada César" required>
    </div>

    <!-- Descripción -->
    <div class="form-group mt-3">
        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" class="form-control" rows="4" placeholder="Breve descripción de la receta" required></textarea>
    </div>

    <!-- Pasos de Preparación -->
    <div class="form-group mt-3">
        <label for="pasosPreparacion">Pasos de Preparación</label>
        <textarea name="pasosPreparacion" class="form-control" rows="6" placeholder="Paso a paso de cómo preparar la receta" required></textarea>
        <small class="form-text text-muted">Escribe cada paso en una línea separada. Presiona Enter para crear un nuevo paso.</small>
    </div>

    <!-- Calorías Consumidas -->
    <div class="form-group mt-3">
        <label for="caloriasConsumidas">Calorías Consumidas</label>
        <input type="number" name="caloriasConsumidas" class="form-control" placeholder="Ejemplo: 250" min="0" required>
    </div>

    <!-- Ingredientes -->
    <div class="form-group mt-3">
        <label>Ingredientes</label>
        <button type="button" class="btn btn-info w-100" data-bs-toggle="modal" data-bs-target="#ingredientesModal">
            Seleccionar Ingredientes
        </button>
        <!-- Contenedor para mostrar los ingredientes seleccionados -->
        <div id="selected-ingredientes" class="mt-2"></div>
    </div>

    <!-- Imagen -->
    <div class="form-group mt-3">
        <label for="imagen">Imagen</label>
        <input type="file" name="imagen" class="form-control" accept=".svg,.png,.jpg,.jpeg,.webp">
    </div>

    <button type="submit" class="btn btn-primary mt-3">Guardar</button>
    <a href="{{ route('mis-recetas.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
</form>

<!-- Modal para Ingredientes -->
<div class="modal fade" id="ingredientesModal" tabindex="-1" aria-labelledby="ingredientesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccionar Ingredientes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="ingredientesForm">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Seleccionar</th>
                                <th>Ingrediente</th>
                                <th>Cantidad</th>
                                <th>Unidad de Medida</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ingredientes as $ingrediente)
                            <tr>
                                <td>
                                    <input class="form-check-input ingrediente-checkbox" type="checkbox" value="{{ $ingrediente->id }}" id="ingrediente-{{ $ingrediente->id }}">
                                </td>
                                <td>
                                    <label class="form-check-label" for="ingrediente-{{ $ingrediente->id }}">
                                        {{ $ingrediente->nombre }}
                                    </label>
                                </td>
                                <td>
                                    <input type="number" class="form-control cantidad-input" data-ingrediente-id="{{ $ingrediente->id }}" min="0" disabled>
                                </td>
                                <td>
                                    <input type="text" class="form-control unidad-input" data-ingrediente-id="{{ $ingrediente->id }}" disabled>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="save-ingredientes">Guardar Selección</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Script para manejar la selección de ingredientes -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const saveButton = document.getElementById('save-ingredientes');
        const selectedContainer = document.getElementById('selected-ingredientes');
        const ingredientesModal = document.getElementById('ingredientesModal');
        const checkboxes = document.querySelectorAll('.ingrediente-checkbox');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const ingredienteId = this.value;
                const cantidadInput = document.querySelector(`.cantidad-input[data-ingrediente-id="${ingredienteId}"]`);
                const unidadInput = document.querySelector(`.unidad-input[data-ingrediente-id="${ingredienteId}"]`);

                if (this.checked) {
                    cantidadInput.disabled = false;
                    unidadInput.disabled = false;
                } else {
                    cantidadInput.disabled = true;
                    unidadInput.disabled = true;
                    cantidadInput.value = '';
                    unidadInput.value = '';
                }
            });
        });

        saveButton.addEventListener('click', function() {
            const selectedCheckboxes = document.querySelectorAll('.ingrediente-checkbox:checked');
            selectedContainer.innerHTML = '';

            // Eliminar inputs ocultos existentes
            const existingInputs = document.querySelectorAll('.ingrediente-hidden-inputs');
            existingInputs.forEach(input => input.remove());

            let valid = true;

            selectedCheckboxes.forEach(checkbox => {
                const ingredienteId = checkbox.value;
                const label = document.querySelector(`label[for="${checkbox.id}"]`).innerText;
                const cantidadInput = document.querySelector(`.cantidad-input[data-ingrediente-id="${ingredienteId}"]`);
                const unidadInput = document.querySelector(`.unidad-input[data-ingrediente-id="${ingredienteId}"]`);

                if (cantidadInput.value === '' || unidadInput.value === '') {
                    alert('Por favor, completa la cantidad y la unidad de medida para cada ingrediente seleccionado.');
                    valid = false;
                    return;
                }

                // Mostrar ingredientes seleccionados
                const span = document.createElement('span');
                span.className = 'badge bg-info me-1 mr-2';
                span.innerText = `${label}: ${cantidadInput.value} ${unidadInput.value}`;
                selectedContainer.appendChild(span);

                // Crear inputs ocultos para enviar al servidor
                const hiddenInputId = document.createElement('input');
                hiddenInputId.type = 'hidden';
                hiddenInputId.name = `ingredientes[${ingredienteId}][id]`;
                hiddenInputId.value = ingredienteId;
                hiddenInputId.className = 'ingrediente-hidden-inputs';
                document.querySelector('form').appendChild(hiddenInputId);

                const hiddenInputCantidad = document.createElement('input');
                hiddenInputCantidad.type = 'hidden';
                hiddenInputCantidad.name = `ingredientes[${ingredienteId}][cantidad]`;
                hiddenInputCantidad.value = cantidadInput.value;
                hiddenInputCantidad.className = 'ingrediente-hidden-inputs';
                document.querySelector('form').appendChild(hiddenInputCantidad);

                const hiddenInputUnidad = document.createElement('input');
                hiddenInputUnidad.type = 'hidden';
                hiddenInputUnidad.name = `ingredientes[${ingredienteId}][unidad]`;
                hiddenInputUnidad.value = unidadInput.value;
                hiddenInputUnidad.className = 'ingrediente-hidden-inputs';
                document.querySelector('form').appendChild(hiddenInputUnidad);
            });

            if (!valid) return;

            // Cerrar el modal
            const modalInstance = bootstrap.Modal.getInstance(ingredientesModal);
            modalInstance.hide();
        });
    });
</script>

@endsection