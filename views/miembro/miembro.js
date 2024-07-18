// Función para inicializar eventos al cargar la página
function init() {
    $("#frm_miembros").on("submit", function (e) {
      guardaryeditar(e); // Llamar a la función guardaryeditar cuando se envía el formulario
    });
  
    cargaTabla(); // Cargar la tabla de miembros al cargar la página
  }
  
  // Función para cargar la tabla de miembros
  var cargaTabla = () => {
    var html = "";
  
    // Llamada AJAX para obtener la lista de miembros desde el backend
    $.get("http://localhost/Proyectofinal/controllers/miembros.controllers.php", (listaMiembros) => {
      $.each(listaMiembros, (indice, unMiembro) => {
        html += `
              <tr>
                  <td>${indice + 1}</td>
                  <td>${unMiembro.nombre}</td>
                  <td>${unMiembro.apellido}</td>
                  <td>${unMiembro.fecha_nacimiento}</td>
                  <td>${unMiembro.tipo_membresia}</td>
                  <td>
                      <button class="btn btn-primary" onclick="editar(${unMiembro.miembro_id})">Editar</button>
                      <button class="btn btn-danger" onclick="eliminar(${unMiembro.miembro_id})">Eliminar</button>
                  </td>
              </tr>
          `;
      });
      $("#cuerpomiembros").html(html); // Asignar el HTML generado al tbody con id="cuerpomiembros"
    }).fail(function(jqXHR, textStatus, errorThrown) {
      console.error("Error al cargar la lista de miembros:", errorThrown);
      // Puedes mostrar un mensaje de error aquí si lo deseas
    });
  };
  
  // Función para guardar o editar un miembro
  var guardaryeditar = (e) => {
    e.preventDefault();
    var frm_miembros = new FormData($("#frm_miembros")[0]);
  
    var miembro_id = $("#miembro_id").val();
    var ruta = "";
    if (miembro_id == 0) {
      ruta = "http://localhost/Proyectofinal/controllers/miembros.controllers.php";
    } else {
      ruta = `http://localhost/Proyectofinal/controllers/miembros.controllers.php?miembro_id=${miembro_id}&op=actualizar`;
    }
  
    // AJAX para enviar los datos al backend
    $.ajax({
      url: ruta,
      type: "POST",
      data: frm_miembros,
      contentType: false,
      processData: false,
      success: function (datos) {
        console.log(datos);
        $("#miembrosModal").modal("hide");
        cargaTabla(); // Recargar la tabla después de guardar o editar
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error("Error al guardar o editar miembro:", errorThrown);
        // Puedes mostrar un mensaje de error aquí si lo deseas
      }
    });
  };
  
  // Función para cargar datos de un miembro específico para edición
  var editar = async (miembro_id) => {
    await cargarDatosEspecificos(); // Si necesitas cargar otros datos específicos para la edición
    $.get(`http://localhost/Proyectofinal/controllers/miembros.controllers.php?miembro_id=${miembro_id}`, (miembro) => {
      console.log(miembro);
      $("#nombre").val(miembro.nombre);
      $("#apellido").val(miembro.apellido);
      $("#fecha_nacimiento").val(miembro.fecha_nacimiento);
      $("#tipo_membresia").val(miembro.tipo_membresia);
      $("#miembro_id").val(miembro.miembro_id);
      // Otros campos específicos del formulario de miembros
    });
  
    $("#modalMiembro").modal("show");
  };
  
  // Función para eliminar un miembro
  var eliminar = (miembro_id) => {
    Swal.fire({
      title: "Miembros",
      text: "¿Está seguro que desea eliminar el miembro?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Eliminar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: `http://localhost/Proyectofinal/controllers/miembros.controllers.php?miembro_id=${miembro_id}`,
          type: "DELETE",
          success: function (resultado) {
            if (resultado) {
              Swal.fire({
                title: "Miembros",
                text: "Se eliminó con éxito",
                icon: "success",
              });
              cargaTabla(); // Recargar la tabla después de eliminar
            } else {
              Swal.fire({
                title: "Miembros",
                text: "No se pudo eliminar",
                icon: "error",
              });
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error al eliminar miembro:", errorThrown);
            // Puedes mostrar un mensaje de error aquí si lo deseas
          }
        });
      }
    });
  };
  
  // Inicializar la página cuando el DOM esté completamente cargado
  $(document).ready(() => {
    init();
  });
