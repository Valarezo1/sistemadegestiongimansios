<?php
require_once('../models/entrenadores.models.php');

$entrenador = new Clase_Entrenador();

if (isset($_GET['op'])) {
    switch ($_GET['op']) {
        case "todos":
            $datos = $entrenador->todos();
            if ($datos !== false) {
                echo json_encode($datos);
            } else {
                echo json_encode(["message" => "No se encontraron entrenadores."]);
            }
            break;

        case "insertar":
            if (isset($_POST["nombre"], $_POST["especialidad"], $_POST["telefono"], $_POST["email"])) {
                $nombre = $_POST["nombre"];
                $especialidad = $_POST["especialidad"];
                $telefono = $_POST["telefono"];
                $email = $_POST["email"];
                $resultado = $entrenador->insertar($nombre, $especialidad, $telefono, $email);
                if ($resultado) {
                    echo json_encode(["message" => "Entrenador insertado correctamente"]);
                } else {
                    echo json_encode(["message" => "Error al insertar el entrenador"]);
                }
            } else {
                echo json_encode(["message" => "Faltan parámetros para insertar el entrenador"]);
            }
            break;

        case "actualizar":
            if (isset($_POST["entrenador_id"], $_POST["nombre"], $_POST["especialidad"], $_POST["telefono"], $_POST["email"])) {
                $entrenador_id = $_POST["entrenador_id"];
                $nombre = $_POST["nombre"];
                $especialidad = $_POST["especialidad"];
                $telefono = $_POST["telefono"];
                $email = $_POST["email"];
                
                $resultado = $entrenador->actualizar($entrenador_id, $nombre, $especialidad, $telefono, $email);
                
                if ($resultado) {
                    // Obtener los datos actualizados del entrenador
                    $entrenadorActualizado = $entrenador->obtenerPorId($entrenador_id);
                    if ($entrenadorActualizado) {
                        echo json_encode($entrenadorActualizado);
                    } else {
                        echo json_encode(["message" => "Error al obtener el entrenador actualizado"]);
                    }
                } else {
                    echo json_encode(["message" => "Error al actualizar el entrenador"]);
                }
            } else {
                echo json_encode(["message" => "Faltan parámetros para actualizar el entrenador"]);
            }
            break;

        case "eliminar":
            if (isset($_POST["entrenador_id"])) {
                $entrenador_id = $_POST["entrenador_id"];
                $resultado = $entrenador->eliminar($entrenador_id);
                if ($resultado) {
                    echo json_encode(["message" => "Entrenador eliminado correctamente"]);
                } else {
                    echo json_encode(["message" => "Error al eliminar el entrenador"]);
                }
            } else {
                echo json_encode(["message" => "Falta el parámetro ID para eliminar el entrenador"]);
            }
            break;

        case "detalle":
            if (isset($_GET["id"])) {
                $entrenador_id = $_GET["id"];
                $entrenadorDetalle = $entrenador->obtenerPorId($entrenador_id);
                if ($entrenadorDetalle) {
                    echo json_encode($entrenadorDetalle);
                } else {
                    echo json_encode(["message" => "No se encontró el entrenador"]);
                }
            } else {
                echo json_encode(["message" => "Falta el parámetro ID para obtener el detalle del entrenador"]);
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
