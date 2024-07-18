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

            <!-- Lista de Miembros -->
            <div class="container-fluid pt-4 px-4">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalMiembro">
                    Nuevo Miembro
                </button>
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Lista de Miembros</h6>
                </div>
                <table class="table table-bordered table-striped table-hover table-responsive">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Tipo de Membresía</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoMiembros">
                        <!-- Aquí se cargarán los miembros dinámicamente -->
                    </tbody>
                </table>
            </div>
            <!-- Fin Lista de Miembros -->

            <!-- Modal Nuevo Miembro -->
            <div class="modal fade" id="modalMiembro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Nuevo Miembro</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formNuevoMiembro">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nombreMiembro">Nombre</label>
                                    <input type="text" name="nombreMiembro" id="nombreMiembro" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="apellido">Apellido</label>
                                    <input type="text" name="apellido" id="apellido" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="fechaNacimiento">Fecha de Nacimiento</label>
                                    <input type="date" name="fechaNacimiento" id="fechaNacimiento" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="tipoMembresia">Tipo de Membresía</label>
                                    <input type="text" name="tipoMembresia" id="tipoMembresia" class="form-control" required>
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
            <!-- Fin Modal Nuevo Miembro -->

            <!-- Modal Edición de Miembro -->
            <div class="modal fade" id="modalEditarMiembro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Editar Miembro</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formEditarMiembro">
                            <div class="modal-body">
                                <input type="hidden" name="idMiembro" id="idMiembro">
                                <div class="form-group">
                                    <label for="nombreEditarMiembro">Nombre</label>
                                    <input type="text" name="nombreEditarMiembro" id="nombreEditarMiembro" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="apellidoEditar">Apellido</label>
                                    <input type="text" name="apellidoEditar" id="apellidoEditar" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="fechaNacimientoEditar">Fecha de Nacimiento</label>
                                    <input type="date" name="fechaNacimientoEditar" id="fechaNacimientoEditar" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="tipoMembresiaEditar">Tipo de Membresía</label>
                                    <input type="text" name="tipoMembresiaEditar" id="tipoMembresiaEditar" class="form-control" required>
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
            <!-- Fin Modal Edición de Miembro -->

            <!-- JavaScript Libraries -->
            <?php require_once('../html/scripts4.php'); ?>
            <script>
                $(document).ready(function() {
                    function cargarMiembros() {
                        $.ajax({
                            url: 'http://localhost/sistemadegestiongimansios/controllers/miembros.controllers.php?op=todos',
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                console.log('Respuesta del servidor:', response);
                                if (response && response.length > 0) {
                                    mostrarMiembros(response);
                                } else {
                                    $('#cuerpoMiembros').html('<tr><td colspan="6">No se encontraron miembros.</td></tr>');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud AJAX:', error);
                                alert('Error al cargar los miembros.');
                            }
                        });
                    }

                    function mostrarMiembros(miembros) {
                        var html = '';
                        $.each(miembros, function(index, miembro) {
                            html += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${miembro.nombre}</td>
                                    <td>${miembro.apellido}</td>
                                    <td>${miembro.fecha_nacimiento}</td>
                                    <td>${miembro.tipo_membresia}</td>
                                    <td>
                                        <button class="btn btn-primary btn-editar-miembro" data-id="${miembro.miembro_id}">Editar</button>
                                        <button class="btn btn-danger btn-eliminar-miembro" data-id="${miembro.miembro_id}">Eliminar</button>
                                    </td>
                                </tr>
                            `;
                        });
                        $('#cuerpoMiembros').html(html);
                    }

                    $('#formNuevoMiembro').submit(function(event) {
                        event.preventDefault();
                        var nombreMiembro = $('#nombreMiembro').val();
                        var apellido = $('#apellido').val();
                        var fechaNacimiento = $('#fechaNacimiento').val();
                        var tipoMembresia = $('#tipoMembresia').val();

                        $.ajax({
                            url: 'http://localhost/sistemadegestiongimansios/controllers/miembros.controllers.php?op=insertar',
                            type: 'POST',
                            data: {
                                nombre: nombreMiembro,
                                apellido: apellido,
                                fecha_nacimiento: fechaNacimiento,
                                tipo_membresia: tipoMembresia
                            },
                            dataType: 'json',
                            success: function(response) {
                                console.log('Respuesta del servidor (insertar):', response);
                                if (response) {
                                    cargarMiembros();
                                    $('#modalMiembro').modal('hide');
                                    $('#formNuevoMiembro')[0].reset();
                                    Swal.fire('¡Éxito!', 'Miembro agregado correctamente', 'success');
                                } else {
                                    Swal.fire('Error', 'No se pudo insertar el miembro', 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud AJAX (insertar):', error);
                                Swal.fire('Error', 'Ocurrió un error al agregar el miembro', 'error');
                            }
                        });
                    });

                    $(document).on('click', '.btn-editar-miembro', function() {
                        var miembroId = $(this).data('id');

                        $.ajax({
                            url: 'http://localhost/sistemadegestiongimansios/controllers/miembros.controllers.php?op=uno',
                            type: 'GET',
                            data: { miembro_id: miembroId },
                            dataType: 'json',
                            success: function(response) {
                                console.log('Respuesta del servidor (uno):', response);
                                if (response) {
                                    $('#idMiembro').val(response.miembro_id);
                                    $('#nombreEditarMiembro').val(response.nombre);
                                    $('#apellidoEditar').val(response.apellido);
                                    $('#fechaNacimientoEditar').val(response.fecha_nacimiento);
                                    $('#tipoMembresiaEditar').val(response.tipo_membresia);
                                    $('#modalEditarMiembro').modal('show');
                                } else {
                                    alert('Error al cargar los datos del miembro.');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud AJAX (uno):', error);
                                alert('Error al cargar los datos del miembro.');
                            }
                        });
                    });

                    $('#formEditarMiembro').submit(function(event) {
                        event.preventDefault();
                        var miembroId = $('#idMiembro').val();
                        var nombre = $('#nombreEditarMiembro').val();
                        var apellido = $('#apellidoEditar').val();
                        var fechaNacimiento = $('#fechaNacimientoEditar').val();
                        var tipoMembresia = $('#tipoMembresiaEditar').val();

                        $.ajax({
                            url: 'http://localhost/sistemadegestiongimansios/controllers/miembros.controllers.php?op=actualizar',
                            type: 'POST',
                            data: {
                                miembro_id: miembroId,
                                nombre: nombre,
                                apellido: apellido,
                                fecha_nacimiento: fechaNacimiento,
                                tipo_membresia: tipoMembresia
                            },
                            dataType: 'json',
                            success: function(response) {
                                console.log('Respuesta del servidor (actualizar):', response);
                                if (response) {
                                    cargarMiembros();
                                    $('#modalEditarMiembro').modal('hide');
                                    $('#formEditarMiembro')[0].reset();
                                    Swal.fire('¡Éxito!', 'Miembro actualizado correctamente', 'success');
                                } else {
                                    Swal.fire('Error', 'No se pudo actualizar el miembro', 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud AJAX (actualizar):', error);
                                Swal.fire('Error', 'Ocurrió un error al actualizar el miembro', 'error');
                            }
                        });
                    });

                    $(document).on('click', '.btn-eliminar-miembro', function() {
                        var miembroId = $(this).data('id');

                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: "No podrás revertir esto",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, eliminar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: 'http://localhost/sistemadegestiongimansios/controllers/miembros.controllers.php?op=eliminar',
                                    type: 'POST',
                                    data: { miembro_id: miembroId },
                                    dataType: 'json',
                                    success: function(response) {
                                        console.log('Respuesta del servidor (eliminar):', response);
                                        if (response) {
                                            cargarMiembros();
                                            Swal.fire('¡Eliminado!', 'Miembro eliminado correctamente', 'success');
                                        } else {
                                            Swal.fire('Error', 'No se pudo eliminar el miembro', 'error');
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('Error en la solicitud AJAX (eliminar):', error);
                                        Swal.fire('Error', 'Ocurrió un error al eliminar el miembro', 'error');
                                    }
                                });
                            }
                        });
                    });

                    // Cargar los miembros al cargar la página
                    cargarMiembros();
                });
            </script>
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>
</body>
</html>
