// Función para inicializar eventos al cargar la página
function init() {
    $("#frm_sesiones_entrenamiento").on("submit", function (e) {
        guardarYEditar(e);
    });
  
    // Cargar la tabla de sesiones de entrenamiento al cargar la página
    cargarTabla();
}
  
// Función para cargar la tabla de sesiones de entrenamiento
var cargarTabla = () => {
    var html = "";
  
    // Llamada AJAX para obtener la lista de sesiones de entrenamiento desde el backend
    $.get("http://localhost/sistemadegestiongimansios/controllers/sesiones.controllers.php?op=todas", (listaSesiones) => {
        $.each(listaSesiones, (indice, unaSesion) => {
            html += 
                `<tr>
                    <td>${indice + 1}</td>
                    <td>${unaSesion.fecha_sesion}</td>
                    <td>${unaSesion.duracion}</td>
                    <td>${unaSesion.notas_adicionales}</td>
                    <td>
                        <button class="btn btn-primary" onclick="editar(${unaSesion.sesion_id})">Editar</button>
                        <button class="btn btn-danger" onclick="eliminar(${unaSesion.sesion_id})">Eliminar</button>
                    </td>
                </tr>`;
        });
        $("#cuerpoSesiones").html(html); // Asignar el HTML generado al tbody con id="cuerpoSesiones"
    });
};
  
// Función para guardar o editar una sesión de entrenamiento
var guardarYEditar = (e) => {
    e.preventDefault();
    var frm_sesiones_entrenamiento = new FormData($("#frm_sesiones_entrenamiento")[0]);
  
    var id_sesion = $("#id_sesion").val();
    var ruta = "";
    if (id_sesion == 0) {
        ruta = "http://localhost/sistemadegestiongimansios/controllers/sesiones.controllers.php?op=insertar";
    } else {
        ruta = `http://localhost/sistemadegestiongimansios/controllers/sesiones.controllers.php?op=actualizar&id_sesion=${id_sesion}`;
    }
  
    // AJAX para enviar los datos al backend
    $.ajax({
        url: ruta,
        type: "POST",
        data: frm_sesiones_entrenamiento,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            $("#sesionModal").modal("hide");
            cargarTabla(); // Recargar la tabla después de guardar o editar
        },
    });
};
  
// Función para cargar datos de una sesión específica para edición
var editar = async (id_sesion) => {
    // Cargar datos específicos para la edición
    $.get(`http://localhost/sistemadegestiongimansios/controllers/sesiones.controllers.php?op=detalle&id_sesion=${id_sesion}`, (sesion) => {
        console.log(sesion);
        $("#fecha_sesion").val(sesion.fecha_sesion);
        $("#duracion").val(sesion.duracion);
        $("#notas_adicionales").val(sesion.notas_adicionales);
        $("#id_sesion").val(sesion.sesion_id);
        // Otros campos específicos del formulario de sesiones de entrenamiento
    });

    $("#sesionModal").modal("show");
};
  
// Función para eliminar una sesión de entrenamiento
var eliminar = (id_sesion) => {
    Swal.fire({
        title: "Sesiones de Entrenamiento",
        text: "¿Está seguro que desea eliminar la sesión de entrenamiento?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Eliminar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `http://localhost/sistemadegestiongimansios/controllers/sesiones.controllers.php?op=eliminar&id_sesion=${id_sesion}`,
                type: "DELETE",
                success: function (resultado) {
                    if (resultado) {
                        Swal.fire({
                            title: "Sesiones de Entrenamiento",
                            text: "Se eliminó con éxito",
                            icon: "success",
                        });
                        cargarTabla(); // Recargar la tabla después de eliminar
                    } else {
                        Swal.fire({
                            title: "Sesiones de Entrenamiento",
                            text: "No se pudo eliminar",
                            icon: "error",
                        });
                    }
                },
            });
        }
    });
};
  
// Inicializar la página
$(document).ready(() => {
    init();
});
