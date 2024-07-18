// Función para inicializar eventos al cargar la página
function init() {
  $("#frm_entrenadores").on("submit", function (e) {
      guardarYEditar(e);
  });

  // Cargar la tabla de entrenadores al cargar la página
  cargarTabla();
}

// Función para cargar la tabla de entrenadores
var cargarTabla = () => {
  var html = "";

  // Llamada AJAX para obtener la lista de entrenadores desde el backend
  $.get("http://localhost/sistemadegestiongimansios/controllers/entrenadores.controllers.php?op=todOs", (listaEntrenadores) => {
      $.each(listaEntrenadores, (indice, unEntrenador) => {
          html += `
              <tr>
                  <td>${indice + 1}</td>
                  <td>${unEntrenador.nombre}</td>
                  <td>${unEntrenador.especialidad}</td>
                  <td>${unEntrenador.telefono}</td>
                  <td>${unEntrenador.email}</td>
                  <td>
                      <button class="btn btn-primary" onclick="editar(${unEntrenador.entrenador_id})">Editar</button>
                      <button class="btn btn-danger" onclick="eliminar(${unEntrenador.entrenador_id})">Eliminar</button>
                  </td>
              </tr>
          `;
      });
      $("#cuerpoEntrenadores").html(html); // Asignar el HTML generado al tbody con id="cuerpoEntrenadores"
  });
};

// Función para guardar o editar un entrenador
var guardarYEditar = (e) => {
  e.preventDefault();
  var frm_entrenadores = new FormData($("#frm_entrenadores")[0]);

  var id_entrenador = $("#id_entrenador").val();
  var ruta = "";
  if (id_entrenador == 0) {
      ruta = "http://localhost/sistemadegestiongimansios/controllers/entrenadores.controllers.php?op=insertar";
  } else {
      ruta = `http://localhost/sistemadegestiongimansios/controllers/entrenadores.controllers.php?op=actualizar&id_entrenador=${id_entrenador}`;
  }

  // AJAX para enviar los datos al backend
  $.ajax({
      url: ruta,
      type: "POST",
      data: frm_entrenadores,
      contentType: false,
      processData: false,
      success: function (datos) {
          console.log(datos);
          $("#entrenadoresModal").modal("hide");
          cargarTabla(); // Recargar la tabla después de guardar o editar
      },
  });
};

// Función para cargar datos de un entrenador específico para edición
var editar = async (id_entrenador) => {
  await cargarDatosEspecificos(); // Si necesitas cargar otros datos específicos para la edición
  $.get(`http://localhost/sistemadegestiongimansios/controllers/entrenadores.controllers.php?op=detalle&id_entrenador=${id_entrenador}`, (entrenador) => {
      console.log(entrenador);
      $("#nombre").val(entrenador.nombre);
      $("#especialidad").val(entrenador.especialidad);
      $("#telefono").val(entrenador.telefono);
      $("#email").val(entrenador.email);
      $("#id_entrenador").val(entrenador.entrenador_id);
      // Otros campos específicos del formulario de entrenadores
  });

  $("#modalEntrenador").modal("show");
};

// Función para eliminar un entrenador
var eliminar = (id_entrenador) => {
  Swal.fire({
      title: "Entrenadores",
      text: "¿Está seguro que desea eliminar el entrenador?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Eliminar",
  }).then((result) => {
      if (result.isConfirmed) {
          $.ajax({
              url: `http://localhost/sistemadegestiongimansios/controllers/entrenadores.controllers.php?op=eliminar&id_entrenador=${id_entrenador}`,
              type: "DELETE",
              success: function (resultado) {
                  if (resultado) {
                      Swal.fire({
                          title: "Entrenadores",
                          text: "Se eliminó con éxito",
                          icon: "success",
                      });
                      cargarTabla(); // Recargar la tabla después de eliminar
                  } else {
                      Swal.fire({
                          title: "Entrenadores",
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
