<?php
require_once('../models/miembros.models.php'); // Adjust the path as per your file structure

$miembro = new Clase_Miembro(); // Assuming you have a class defined for CRUD operations on Miembros

if (isset($_GET['op'])) {
    switch ($_GET['op']) {
        case "todos":
            $datos = $miembro->todos();
            if ($datos !== false) {
                echo json_encode($datos);
            } else {
                echo json_encode(["message" => "No se encontraron miembros."]);
            }
            break;
        case "insertar":
            if (isset($_POST["nombre"], $_POST["apellido"], $_POST["fecha_nacimiento"], $_POST["tipo_membresia"])) {
                $nombre = $_POST["nombre"];
                $apellido = $_POST["apellido"];
                $fecha_nacimiento = $_POST["fecha_nacimiento"];
                $tipo_membresia = $_POST["tipo_membresia"];
                $resultado = $miembro->insertar($nombre, $apellido, $fecha_nacimiento, $tipo_membresia);
                if ($resultado) {
                    echo json_encode(["message" => "Miembro insertado correctamente"]);
                } else {
                    echo json_encode(["message" => "Error al insertar el miembro"]);
                }
            } else {
                echo json_encode(["message" => "Faltan parámetros para insertar el miembro"]);
            }
            break;
        case "actualizar":
            if (isset($_POST["miembro_id"], $_POST["nombre"], $_POST["apellido"], $_POST["fecha_nacimiento"], $_POST["tipo_membresia"])) {
                $miembro_id = $_POST["miembro_id"];
                $nombre = $_POST["nombre"];
                $apellido = $_POST["apellido"];
                $fecha_nacimiento = $_POST["fecha_nacimiento"];
                $tipo_membresia = $_POST["tipo_membresia"];
                
                $resultado = $miembro->actualizar($miembro_id, $nombre, $apellido, $fecha_nacimiento, $tipo_membresia);
                
                if ($resultado) {
                    // Obtener los datos actualizados del miembro
                    $miembroActualizado = $miembro->obtenerPorId($miembro_id);
                    if ($miembroActualizado) {
                        echo json_encode($miembroActualizado);
                    } else {
                        echo json_encode(["message" => "Error al obtener el miembro actualizado"]);
                    }
                } else {
                    echo json_encode(["message" => "Error al actualizar el miembro"]);
                }
            } else {
                echo json_encode(["message" => "Faltan parámetros para actualizar el miembro"]);
            }
            break;
        case "eliminar":
            if (isset($_POST["miembro_id"])) {
                $miembro_id = $_POST["miembro_id"];
                $resultado = $miembro->eliminar($miembro_id);
                if ($resultado) {
                    echo json_encode(["message" => "Miembro eliminado correctamente"]);
                } else {
                    echo json_encode(["message" => "Error al eliminar el miembro"]);
                }
            } else {
                echo json_encode(["message" => "Falta el parámetro ID para eliminar el miembro"]);
            }
            break;
        case "detalle":
            if (isset($_GET["miembro_id"])) {
                $miembro_id = $_GET["miembro_id"];
                $miembroDetalle = $miembro->obtenerPorId($miembro_id);
                if ($miembroDetalle) {
                    echo json_encode($miembroDetalle);
                } else {
                    echo json_encode(["message" => "No se encontró el miembro"]);
                }
            } else {
                echo json_encode(["message" => "Falta el parámetro ID para obtener el detalle del miembro"]);
            }
            break;
        default:
            echo json_encode(["message" => "Operación no válida"]);
            break;
    }
} else {
    echo json_encode(["message" => "No se especificó la operación"]);
}
?>
