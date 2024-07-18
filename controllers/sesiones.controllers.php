<?php
require_once('../models/sesiones.models.php');

$sesion = new Clase_Sesion();

if (isset($_GET['op'])) {
    switch ($_GET['op']) {
        case "todos":
            $datos = $sesion->todos();
            if ($datos !== false) {
                echo json_encode($datos);
            } else {
                echo json_encode(["message" => "No se encontraron sesiones de entrenamiento."]);
            }
            break;
        case "insertar":
            if (isset($_POST["entrenador_id"], $_POST["miembro_id"], $_POST["fecha_sesion"], $_POST["duracion"], $_POST["notas_adicionales"])) {
                $entrenador_id = $_POST["entrenador_id"];
                $miembro_id = $_POST["miembro_id"];
                $fecha_sesion = $_POST["fecha_sesion"];
                $duracion = $_POST["duracion"];
                $notas_adicionales = $_POST["notas_adicionales"];
                
                $resultado = $sesion->insertar($entrenador_id, $miembro_id, $fecha_sesion, $duracion, $notas_adicionales);
                if ($resultado) {
                    echo json_encode(["message" => "Sesión de entrenamiento insertada correctamente"]);
                } else {
                    echo json_encode(["message" => "Error al insertar la sesión de entrenamiento"]);
                }
            } else {
                echo json_encode(["message" => "Faltan parámetros para insertar la sesión de entrenamiento"]);
            }
            break;
        case "actualizar":
            if (isset($_POST["sesion_id"], $_POST["entrenador_id"], $_POST["miembro_id"], $_POST["fecha_sesion"], $_POST["duracion"], $_POST["notas_adicionales"])) {
                $sesion_id = $_POST["sesion_id"];
                $entrenador_id = $_POST["entrenador_id"];
                $miembro_id = $_POST["miembro_id"];
                $fecha_sesion = $_POST["fecha_sesion"];
                $duracion = $_POST["duracion"];
                $notas_adicionales = $_POST["notas_adicionales"];
                
                $resultado = $sesion->actualizar($sesion_id, $entrenador_id, $miembro_id, $fecha_sesion, $duracion, $notas_adicionales);
                
                if ($resultado) {
                    // Obtener los datos actualizados de la sesión
                    $sesionActualizada = $sesion->obtenerPorId($sesion_id);
                    if ($sesionActualizada) {
                        echo json_encode($sesionActualizada);
                    } else {
                        echo json_encode(["message" => "Error al obtener la sesión de entrenamiento actualizada"]);
                    }
                } else {
                    echo json_encode(["message" => "Error al actualizar la sesión de entrenamiento"]);
                }
            } else {
                echo json_encode(["message" => "Faltan parámetros para actualizar la sesión de entrenamiento"]);
            }
            break;
        case "eliminar":
            if (isset($_POST["sesion_id"])) {
                $sesion_id = $_POST["sesion_id"];
                $resultado = $sesion->eliminar($sesion_id);
                if ($resultado) {
                    echo json_encode(["message" => "Sesión de entrenamiento eliminada correctamente"]);
                } else {
                    echo json_encode(["message" => "Error al eliminar la sesión de entrenamiento"]);
                }
            } else {
                echo json_encode(["message" => "Falta el parámetro ID para eliminar la sesión de entrenamiento"]);
            }
            break;
        case "detalle":
            if (isset($_GET["sesion_id"])) {
                $sesion_id = $_GET["sesion_id"];
                $sesionDetalle = $sesion->obtenerPorId($sesion_id);
                if ($sesionDetalle) {
                    echo json_encode($sesionDetalle);
                } else {
                    echo json_encode(["message" => "No se encontró la sesión de entrenamiento"]);
                }
            } else {
                echo json_encode(["message" => "Falta el parámetro ID para obtener el detalle de la sesión de entrenamiento"]);
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
