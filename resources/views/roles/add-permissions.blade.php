@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Add Permissions to Role') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('roles.give-permissions', $role->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label for="all-permissions">{{ __('All Permissions') }}</label>
                                        <ul id="all-permissions" class="list-group" style="min-height: 200px; border: 1px solid #ced4da;">
                                            @foreach($permissions as $permission)
                                                @if (!in_array($permission->id, $assignedPermissions))
                                                    <li class="list-group-item" data-id="{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-arrows-alt-h"></i> <!-- Icono para arrastrar -->
                                    </div>
                                    <div class="col-md-5">
                                        <label for="assigned-permissions">{{ __('Assigned Permissions') }}</label>
                                        <ul id="assigned-permissions" class="list-group" style="min-height: 200px; border: 1px solid #ced4da;">
                                            @foreach($permissions as $permission)
                                                @if (in_array($permission->id, $assignedPermissions))
                                                    <li class="list-group-item" data-id="{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="permissions" id="permissions-input">
                            <button type="submit" class="btn btn-primary mt-3">{{ __('Assign Permissions') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir jQuery y jQuery UI -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            function makeDraggableAndDroppable() {
                // Hacer los elementos arrastrables
                $(".list-group-item").draggable({
                    helper: "clone",
                    revert: "invalid"
                });

                // Configurar las zonas dropeables
                $("#all-permissions").droppable({
                    accept: "#assigned-permissions .list-group-item",
                    drop: function (event, ui) {
                        moveItem(ui.draggable, $(this), "#assigned-permissions");
                    }
                });

                $("#assigned-permissions").droppable({
                    accept: "#all-permissions .list-group-item",
                    drop: function (event, ui) {
                        moveItem(ui.draggable, $(this), "#all-permissions");
                    }
                });
            }

            function moveItem(item, targetList, sourceListId) {
                const existingItem = targetList.find(`[data-id='${item.data("id")}']`);
                if (existingItem.length === 0) {
                    const clonedItem = item.clone();
                    item.remove();
                    clonedItem.draggable({
                        helper: "clone",
                        revert: "invalid"
                    });
                    targetList.append(clonedItem);

                    // Remover el elemento de la lista de origen
                    $(`${sourceListId} [data-id='${item.data("id")}']`).remove();

                    updatePermissionsInput();
                }
            }

            function updatePermissionsInput() {
                const assignedIds = $("#assigned-permissions .list-group-item").map(function () {
                    return $(this).data("id");
                }).get();
                $("#permissions-input").val(assignedIds.join(','));
            }

            // Inicializar la funcionalidad de arrastrar y soltar
            makeDraggableAndDroppable();

            // Actualizar el input con los permisos ya asignados
            updatePermissionsInput();
        });
    </script>
@endsection
