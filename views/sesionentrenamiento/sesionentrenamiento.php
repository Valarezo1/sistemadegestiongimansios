<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once('../html/head4.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="../public/lib/calendar/lib/main.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        /* Your custom styles here */
    </style>
</head>
<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <!-- Include your spinner code here -->
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        <?php require_once('../html/menu.php'); ?>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <?php require_once('../html/header.php'); ?>
            <!-- Navbar End -->

            <!-- Lista de Sesiones de Entrenamiento -->
            <div class="container-fluid pt-4 px-4">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalSesion">
                    Nueva Sesión de Entrenamiento
                </button>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Lista de Sesiones de Entrenamiento</h6>
                </div>
                <table class="table table-bordered table-striped table-hover table-responsive">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Entrenador</th>
                            <th>Miembro</th>
                            <th>Fecha</th>
                            <th>Duración</th>
                            <th>Notas Adicionales</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoSesiones">
                        <!-- Aquí se cargarán las sesiones dinámicamente -->
                    </tbody>
                </table>
            </div>
            <!-- Fin Lista de Sesiones de Entrenamiento -->

            <!-- Modal Nueva Sesión -->
            <div class="modal fade" id="modalSesion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nueva Sesión de Entrenamiento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formNuevaSesion">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="entrenadorSelect">Entrenador</label>
                                    <select name="entrenador_id" id="entrenadorSelect" class="form-control" required>
                                        <!-- Opciones de entrenadores se cargarán dinámicamente -->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="miembroSelect">Miembro</label>
                                    <select name="miembro_id" id="miembroSelect" class="form-control" required>
                                        <!-- Opciones de miembros se cargarán dinámicamente -->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="fechaSesion">Fecha de Sesión</label>
                                    <input type="date" name="fecha_sesion" id="fechaSesion" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="duracionSesion">Duración (HH:MM)</label>
                                    <input type="time" name="duracion" id="duracionSesion" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="notasAdicionales">Notas Adicionales</label>
                                    <textarea name="notas_adicionales" id="notasAdicionales" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Modal Nueva Sesión -->

            <!-- Modal Edición de Sesión -->
            <div class="modal fade" id="modalEditarSesion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar Sesión de Entrenamiento</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formEditarSesion">
                            <div class="modal-body">
                                <input type="hidden" name="sesion_id" id="sesionId">
                                <div class="form-group">
                                    <label for="entrenadorEditarSelect">Entrenador</label>
                                    <select name="entrenador_id" id="entrenadorEditarSelect" class="form-control" required>
                                        <!-- Opciones de entrenadores se cargarán dinámicamente -->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="miembroEditarSelect">Miembro</label>
                                    <select name="miembro_id" id="miembroEditarSelect" class="form-control" required>
                                        <!-- Opciones de miembros se cargarán dinámicamente -->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="fechaSesionEditar">Fecha de Sesión</label>
                                    <input type="date" name="fecha_sesion" id="fechaSesionEditar" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="duracionSesionEditar">Duración (HH:MM)</label>
                                    <input type="time" name="duracion" id="duracionSesionEditar" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="notasAdicionalesEditar">Notas Adicionales</label>
                                    <textarea name="notas_adicionales" id="notasAdicionalesEditar" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Modal Edición de Sesión -->

            <!-- JavaScript Libraries -->
            <?php require_once('../html/scripts3.php'); ?>
            <script>
                $(document).ready(function() {
                    function cargarSesiones() {
                        $.ajax({
                            url: 'http://localhost/sistemadegestiongimansios/controllers/sesiones.controllers.php?op=todos',
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                console.log('Respuesta del servidor:', response);
                                if (response && response.length > 0) {
                                    mostrarSesiones(response);
                                } else {
                                    $('#cuerpoSesiones').html('<tr><td colspan="7">No se encontraron sesiones de entrenamiento.</td></tr>');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud AJAX:', error);
                                alert('Error al cargar las sesiones de entrenamiento.');
                            }
                        });
                    }

                    function mostrarSesiones(sesiones) {
                        var html = '';
                        $.each(sesiones, function(index, sesion) {
                            html += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${sesion.nombre_entrenador}</td>
                                    <td>${sesion.nombre_miembro}</td>
                                    <td>${sesion.fecha_sesion}</td>
                                    <td>${sesion.duracion}</td>
                                    <td>${sesion.notas_adicionales}</td>
                                    <td>
                                        <button class="btn btn-primary btn-editar-sesion" data-id="${sesion.sesion_id}">Editar</button>
                                        <button class="btn btn-danger btn-eliminar-sesion" data-id="${sesion.sesion_id}">Eliminar</button>
                                    </td>
                                </tr>
                            `;
                        });
                        $('#cuerpoSesiones').html(html);
                    }

                    function cargarEntrenadores() {
                        $.ajax({
                            url: 'http://localhost/sistemadegestiongimansios/controllers/entrenadores.controllers.php?op=todos',
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                if (response && response.length > 0) {
                                    var options = '<option value="">Seleccione un entrenador</option>';
                                    $.each(response, function(index, entrenador) {
                                        options += `<option value="${entrenador.entrenador_id}">${entrenador.nombre} ${entrenador.apellido}</option>`;
                                    });
                                    $('#entrenadorSelect, #entrenadorEditarSelect').html(options);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud AJAX (entrenadores):', error);
                                alert('Error al cargar entrenadores.');
                            }
                        });
                    }

                    function cargarMiembros() {
                        $.ajax({
                            url: 'http://localhost/sistemadegestiongimansios/controllers/miembros.controllers.php?op=todos',
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                if (response && response.length > 0) {
                                    var options = '<option value="">Seleccione un miembro</option>';
                                    $.each(response, function(index, miembro) {
                                        options += `<option value="${miembro.miembro_id}">${miembro.nombre} ${miembro.apellido}</option>`;
                                    });
                                    $('#miembroSelect, #miembroEditarSelect').html(options);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud AJAX (miembros):', error);
                                alert('Error al cargar miembros.');
                            }
                        });
                    }

                    function eliminarSesion(id) {
                        $.ajax({
                            url: 'http://localhost/sistemadegestiongimansios/controllers/sesiones.controllers.php?op=eliminar',
                            type: 'POST',
                            data: { id: id },
                            dataType: 'json',
                            success: function(response) {
                                if (response) {
                                    cargarSesiones();
                                    Swal.fire('¡Éxito!', 'Sesión de entrenamiento eliminada correctamente', 'success');
                                } else {
                                    Swal.fire('Error', 'No se pudo eliminar la sesión de entrenamiento', 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud AJAX (eliminar):', error);
                                Swal.fire('Error', 'Error de conexión al servidor', 'error');
                            }
                        });
                    }

                    $('#formNuevaSesion').submit(function(event) {
                        event.preventDefault();
                        var formData = $(this).serialize();

                        $.ajax({
                            url: 'http://localhost/sistemadegestiongimansios/controllers/sesiones.controllers.php?op=insertar',
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            success: function(response) {
                                if (response) {
                                    cargarSesiones();
                                    $('#modalSesion').modal('hide');
                                    $('#formNuevaSesion')[0].reset();
                                    Swal.fire('¡Éxito!', 'Sesión de entrenamiento agregada correctamente', 'success');
                                } else {
                                    Swal.fire('Error', 'No se pudo insertar la sesión de entrenamiento', 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud AJAX (insertar):', error);
                                Swal.fire('Error', 'Error de conexión al servidor', 'error');
                            }
                        });
                    });

                    $('#formEditarSesion').submit(function(event) {
                        event.preventDefault();
                        var formData = $(this).serialize();

                        $.ajax({
                            url: 'http://localhost/sistemadegestiongimansios/controllers/sesiones.controllers.php?op=actualizar',
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            success: function(response) {
                                if (response) {
                                    cargarSesiones();
                                    $('#modalEditarSesion').modal('hide');
                                    Swal.fire('¡Éxito!', 'Sesión de entrenamiento actualizada correctamente', 'success');
                                } else {
                                    Swal.fire('Error', 'No se pudo actualizar la sesión de entrenamiento', 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud AJAX (actualizar):', error);
                                Swal.fire('Error', 'Error de conexión al servidor', 'error');
                            }
                        });
                    });

                    $(document).on('click', '.btn-editar-sesion', function() {
                        var id = $(this).data('id');
                        $.ajax({
                            url: 'http://localhost/sistemadegestiongimansios/controllers/sesiones.controllers.php?op=obtener',
                            type: 'GET',
                            data: { id: id },
                            dataType: 'json',
                            success: function(response) {
                                if (response) {
                                    $('#sesionId').val(response.sesion_id);
                                    $('#entrenadorEditarSelect').val(response.entrenador_id);
                                    $('#miembroEditarSelect').val(response.miembro_id);
                                    $('#fechaSesionEditar').val(response.fecha_sesion);
                                    $('#duracionSesionEditar').val(response.duracion);
                                    $('#notasAdicionalesEditar').val(response.notas_adicionales);
                                    $('#modalEditarSesion').modal('show');
                                } else {
                                    Swal.fire('Error', 'No se pudo obtener la sesión de entrenamiento', 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud AJAX (obtener):', error);
                                Swal.fire('Error', 'Error de conexión al servidor', 'error');
                            }
                        });
                    });

                    $(document).on('click', '.btn-eliminar-sesion', function() {
                        var id = $(this).data('id');
                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: "¡No podrás recuperar esta sesión de entrenamiento!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, eliminarla'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                eliminarSesion(id);
                            }
                        });
                    });

                    cargarSesiones();
                    cargarEntrenadores();
                    cargarMiembros();
                });
            </script>
        </div>
    </div>
</body>
</html>
