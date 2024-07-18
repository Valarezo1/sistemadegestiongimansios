<?php
require_once('../config/conexion.php');

class Clase_Miembro
{
    public function todos()
    {
        try {
            $con = new Clase_Conectar();
            $conexion = $con->Procedimiento_Conectar();
            
            $consulta = "SELECT * FROM Miembros";
            $stmt = $conexion->prepare($consulta);
            
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $conexion->error);
            }
            
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            if ($resultado === false) {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }
            
            $miembros = array();
            while ($fila = $resultado->fetch_assoc()) {
                $miembros[] = $fila;
            }
            
            return $miembros;
        } catch (Exception $e) {
            error_log("Error en la consulta todos() de miembros: " . $e->getMessage());
            return false;
        } finally {
            if (isset($stmt) && $stmt !== false) {
                $stmt->close();
            }
            if (isset($conexion)) {
                $conexion->close();
            }
        }
    }

    public function insertar($nombre, $apellido, $fecha_nacimiento, $tipo_membresia)
    {
        try {
            $con = new Clase_Conectar();
            $conexion = $con->Procedimiento_Conectar();
            
            $consulta = "INSERT INTO Miembros (nombre, apellido, fecha_nacimiento, tipo_membresia) VALUES (?, ?, ?, ?)";
            $stmt = $conexion->prepare($consulta);
            
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $conexion->error);
            }
            
            $stmt->bind_param("ssss", $nombre, $apellido, $fecha_nacimiento, $tipo_membresia);
            $stmt->execute();
            
            if ($stmt->affected_rows != 1) {
                throw new Exception("Error al insertar miembro");
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error al insertar miembro: " . $e->getMessage());
            return false;
        } finally {
            if (isset($stmt) && $stmt !== false) {
                $stmt->close();
            }
            if (isset($conexion)) {
                $conexion->close();
            }
        }
    }

    public function actualizar($miembro_id, $nombre, $apellido, $fecha_nacimiento, $tipo_membresia)
    {
        try {
            $con = new Clase_Conectar();
            $conexion = $con->Procedimiento_Conectar();
            
            $consulta = "UPDATE Miembros SET nombre=?, apellido=?, fecha_nacimiento=?, tipo_membresia=? WHERE miembro_id=?";
            $stmt = $conexion->prepare($consulta);
            
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $conexion->error);
            }
            
            $stmt->bind_param("ssssi", $nombre, $apellido, $fecha_nacimiento, $tipo_membresia, $miembro_id);
            $stmt->execute();
            
            if ($stmt->affected_rows === 0) {
                throw new Exception("No se actualizó ningún miembro. Verifique si el ID es correcto.");
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error al actualizar miembro: " . $e->getMessage());
            return false;
        } finally {
            if (isset($stmt) && $stmt !== false) {
                $stmt->close();
            }
            if (isset($conexion)) {
                $conexion->close();
            }
        }
    }

    public function eliminar($miembro_id)
    {
        try {
            $con = new Clase_Conectar();
            $conexion = $con->Procedimiento_Conectar();
            
            $consulta = "DELETE FROM Miembros WHERE miembro_id=?";
            $stmt = $conexion->prepare($consulta);
            
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $conexion->error);
            }
            
            $stmt->bind_param("i", $miembro_id);
            $stmt->execute();
            
            if ($stmt->affected_rows != 1) {
                throw new Exception("Error al eliminar miembro");
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error al eliminar miembro: " . $e->getMessage());
            return false;
        } finally {
            if (isset($stmt) && $stmt !== false) {
                $stmt->close();
            }
            if (isset($conexion)) {
                $conexion->close();
            }
        }
    }

    public function obtenerPorId($miembro_id)
    {
        try {
            $con = new Clase_Conectar();
            $conexion = $con->Procedimiento_Conectar();
            
            $consulta = "SELECT * FROM Miembros WHERE miembro_id = ?";
            $stmt = $conexion->prepare($consulta);
            
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $conexion->error);
            }
            
            $stmt->bind_param("i", $miembro_id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            if ($resultado->num_rows != 1) {
                throw new Exception("No se encontró ningún miembro con el ID proporcionado");
            }
            
            $miembro = $resultado->fetch_assoc();
            
            return $miembro;
        } catch (Exception $e) {
            error_log("Error al obtener miembro por ID: " . $e->getMessage());
            return false;
        } finally {
            if (isset($stmt) && $stmt !== false) {
                $stmt->close();
            }
            if (isset($conexion)) {
                $conexion->close();
            }
        }
    }
}
?>
