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

            <!-- Lista de Entrenadores -->
            <div class="container-fluid pt-4 px-4">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEntrenador">
                    Nuevo Entrenador
                </button>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Lista de Entrenadores</h6>
                </div>
                <table class="table table-bordered table-striped table-hover table-responsive">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Especialidad</th>
                            <th>Teléfono</th> <!-- Nueva columna -->
                            <th>Email</th> <!-- Nueva columna -->
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoEntrenadores">
                        <!-- Aquí se cargarán los entrenadores dinámicamente -->
                    </tbody>
                </table>
            </div>
            <!-- Fin Lista de Entrenadores -->

            <!-- Modal Nuevo Entrenador -->
            <div class="modal fade" id="modalEntrenador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nuevo Entrenador</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formNuevoEntrenador">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nombreEntrenador">Nombre</label>
                                    <input type="text" name="nombreEntrenador" id="nombreEntrenador" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="especialidad">Especialidad</label>
                                    <input type="text" name="especialidad" id="especialidad" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="telefono">Teléfono</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required>
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
            <!-- Fin Modal Nuevo Entrenador -->

            <!-- Modal Edición de Entrenador -->
            <div class="modal fade" id="modalEditarEntrenador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar Entrenador</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formEditarEntrenador">
                            <div class="modal-body">
                                <input type="hidden" name="idEntrenador" id="idEntrenador">
                                <div class="form-group">
                                    <label for="nombreEditarEntrenador">Nombre</label>
                                    <input type="text" name="nombreEditarEntrenador" id="nombreEditarEntrenador" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="especialidadEditar">Especialidad</label>
                                    <input type="text" name="especialidadEditar" id="especialidadEditar" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="telefonoEditar">Teléfono</label>
                                    <input type="text" name="telefonoEditar" id="telefonoEditar" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="emailEditar">Email</label>
                                    <input type="email" name="emailEditar" id="emailEditar" class="form-control" required>
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
            <!-- Fin Modal Edición de Entrenador -->

            <!-- JavaScript Libraries -->
            <?php require_once('../html/scripts4.php'); ?>
            <script>
                $(document).ready(function() {
                    function cargarEntrenadores() {
                        $.ajax({
                            url: 'http://localhost/sistemadegestiongimansios/controllers/entrenadores.controllers.php?op=todos',
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                if (response && response.length > 0) {
                                    mostrarEntrenadores(response);
                                } else {
                                    $('#cuerpoEntrenadores').html('<tr><td colspan="6">No se encontraron entrenadores.</td></tr>');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud AJAX:', error);
                                alert('Error al cargar los entrenadores.');
                            }
                        });
                    }

                    function mostrarEntrenadores(entrenadores) {
                        var html = '';
                        $.each(entrenadores, function(index, entrenador) {
                            html += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${entrenador.nombre}</td>
                                    <td>${entrenador.especialidad}</td>
                                    <td>${entrenador.telefono}</td>
                                    <td>${entrenador.email}</td>
                                    <td>
                                        <button class="btn btn-primary btn-editar-entrenador" data-id="${entrenador.entrenador_id}">Editar</button>
                                        <button class="btn btn-danger btn-eliminar-entrenador" data-id="${entrenador.entrenador_id}">Eliminar</button>
                                    </td>
                                </tr>
                            `;
                        });
                        $('#cuerpoEntrenadores').html(html);
                    }

                    $('#formNuevoEntrenador').submit(function(event) {
                        event.preventDefault();
                        var nombreEntrenador = $('#nombreEntrenador').val();
                        var especialidad = $('#especialidad').val();
                        var telefono = $('#telefono').val();
                        var email = $('#email').val();

                        $.ajax({
                            url: 'http://localhost/sistemadegestiongimansios/controllers/entrenadores.controllers.php?op=insertar',
                            type: 'POST',
                            data: {
                                nombre: nombreEntrenador,
                                especialidad: especialidad,
                                telefono: telefono,
                                email: email
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response) {
                                    cargarEntrenadores();
                                    $('#modalEntrenador').modal('hide');
                                    $('#formNuevoEntrenador')[0].reset();
                                    Swal.fire('¡Éxito!', 'Entrenador agregado correctamente', 'success');
                                } else {
                                    Swal.fire('Error', 'No se pudo insertar el entrenador', 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud AJAX (insertar):', error);
                                Swal.fire('Error', 'Error de conexión al servidor', 'error');
                            }
                        });
                    });

                    $('#cuerpoEntrenadores').on('click', '.btn-editar-entrenador', function() {
                        var idEntrenador = $(this).data('id');
                        $.ajax({
                            url: 'http://localhost/sistemadegestiongimansios/controllers/entrenadores.controllers.php?op=detalle&id=' + idEntrenador,
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                if (response) {
                                    $('#idEntrenador').val(response.entrenador_id);
                                    $('#nombreEditarEntrenador').val(response.nombre);
                                    $('#especialidadEditar').val(response.especialidad);
                                    $('#telefonoEditar').val(response.telefono);
                                    $('#emailEditar').val(response.email);
                                    $('#modalEditarEntrenador').modal('show');
                                } else {
                                    Swal.fire('Error', 'No se pudo obtener los detalles del entrenador', 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud AJAX (detalle):', error);
                                Swal.fire('Error', 'Error de conexión al servidor', 'error');
                            }
                        });
                    });

                    $('#formEditarEntrenador').submit(function(event) {
                        event.preventDefault();
                        var idEntrenador = $('#idEntrenador').val();
                        var nombre = $('#nombreEditarEntrenador').val();
                        var especialidad = $('#especialidadEditar').val();
                        var telefono = $('#telefonoEditar').val();
                        var email = $('#emailEditar').val();

                        $.ajax({
                            url: 'http://localhost/sistemadegestiongimansios/controllers/entrenadores.controllers.php?op=actualizar',
                            type: 'POST',
                            data: {
                                id: idEntrenador,
                                nombre: nombre,
                                especialidad: especialidad,
                                telefono: telefono,
                                email: email
                            },
                            dataType: 'json',
                            success: function(response) {
                                if (response) {
                                    cargarEntrenadores();
                                    $('#modalEditarEntrenador').modal('hide');
                                    $('#formEditarEntrenador')[0].reset();
                                    Swal.fire('¡Éxito!', 'Entrenador actualizado correctamente', 'success');
                                } else {
                                    Swal.fire('Error', 'No se pudo actualizar el entrenador', 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud AJAX (actualizar):', error);
                                Swal.fire('Error', 'Error de conexión al servidor', 'error');
                            }
                        });
                    });

                    $('#cuerpoEntrenadores').on('click', '.btn-eliminar-entrenador', function() {
                        var idEntrenador = $(this).data('id');
                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: '¡No podrás recuperar este registro!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, eliminar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: 'http://localhost/sistemadegestiongimansios/controllers/entrenadores.controllers.php?op=eliminar',
                                    type: 'POST',
                                    data: {
                                        id: idEntrenador
                                    },
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response) {
                                            cargarEntrenadores();
                                            Swal.fire('¡Eliminado!', 'El entrenador ha sido eliminado.', 'success');
                                        } else {
                                            Swal.fire('Error', 'No se pudo eliminar el entrenador', 'error');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error en la solicitud AJAX (eliminar):', error);
                                        Swal.fire('Error', 'Error de conexión al servidor', 'error');
                                    }
                                });
                            }
                        });
                    });

                    cargarEntrenadores();
                });
            </script>
        </div>
        <!-- Content End -->
    </div>
</body>
</html>
