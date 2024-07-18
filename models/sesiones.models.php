<?php
require_once('../config/conexion.php');

class Clase_Sesion
{
    private $conexion;

    public function __construct()
    {
        $con = new Clase_Conectar();
        $this->conexion = $con->Procedimiento_Conectar();
    }

    public function todos()
    {
        try {
            // Modificar la consulta para incluir los nombres de los entrenadores y miembros
            $consulta = "
                SELECT 
                    s.sesion_id, 
                    s.entrenador_id, 
                    e.nombre AS nombre_entrenador, 
                    s.miembro_id, 
                    m.nombre AS nombre_miembro, 
                    s.fecha_sesion, 
                    s.duracion, 
                    s.notas_adicionales
                FROM 
                    Sesiones_Entrenamiento s
                LEFT JOIN 
                    Entrenadores e ON s.entrenador_id = e.entrenador_id
                LEFT JOIN 
                    Miembros m ON s.miembro_id = m.miembro_id
            ";
            $stmt = $this->conexion->prepare($consulta);
            
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
            }
            
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            if ($resultado === false) {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }
            
            $sesiones = array();
            while ($fila = $resultado->fetch_assoc()) {
                $sesiones[] = $fila;
            }
            
            return $sesiones;
        } catch (Exception $e) {
            error_log("Error en la consulta todos() de sesiones de entrenamiento: " . $e->getMessage());
            return false;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    public function insertar($entrenador_id, $miembro_id, $fecha_sesion, $duracion, $notas_adicionales)
    {
        try {
            $consulta = "INSERT INTO Sesiones_Entrenamiento (entrenador_id, miembro_id, fecha_sesion, duracion, notas_adicionales) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($consulta);
            
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
            }
            
            $stmt->bind_param("iisss", $entrenador_id, $miembro_id, $fecha_sesion, $duracion, $notas_adicionales);
            $stmt->execute();
            
            if ($stmt->affected_rows !== 1) {
                throw new Exception("Error al insertar sesión de entrenamiento");
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error al insertar sesión de entrenamiento: " . $e->getMessage());
            return false;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    public function actualizar($sesion_id, $entrenador_id, $miembro_id, $fecha_sesion, $duracion, $notas_adicionales)
    {
        try {
            $consulta = "UPDATE Sesiones_Entrenamiento SET entrenador_id=?, miembro_id=?, fecha_sesion=?, duracion=?, notas_adicionales=? WHERE sesion_id=?";
            $stmt = $this->conexion->prepare($consulta);
            
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
            }
            
            $stmt->bind_param("iisssi", $entrenador_id, $miembro_id, $fecha_sesion, $duracion, $notas_adicionales, $sesion_id);
            $stmt->execute();
            
            if ($stmt->affected_rows < 1) {
                throw new Exception("Error al actualizar sesión de entrenamiento");
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error al actualizar sesión de entrenamiento: " . $e->getMessage());
            return false;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    public function eliminar($sesion_id)
    {
        try {
            $consulta = "DELETE FROM Sesiones_Entrenamiento WHERE sesion_id=?";
            $stmt = $this->conexion->prepare($consulta);
            
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
            }
            
            $stmt->bind_param("i", $sesion_id);
            $stmt->execute();
            
            if ($stmt->affected_rows < 1) {
                throw new Exception("No se eliminó ninguna sesión de entrenamiento. Puede que el ID no exista.");
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error al eliminar sesión de entrenamiento: " . $e->getMessage());
            return false;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    public function obtenerPorId($sesion_id)
    {
        try {
            $consulta = "SELECT * FROM Sesiones_Entrenamiento WHERE sesion_id=?";
            $stmt = $this->conexion->prepare($consulta);
            
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
            }
            
            $stmt->bind_param("i", $sesion_id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            if ($resultado->num_rows !== 1) {
                throw new Exception("No se encontró ninguna sesión de entrenamiento con el ID proporcionado");
            }
            
            $sesion = $resultado->fetch_assoc();
            
            return $sesion;
        } catch (Exception $e) {
            error_log("Error al obtener sesión de entrenamiento por ID: " . $e->getMessage());
            return false;
        } finally {
            if (isset($stmt)) {
                $stmt->close();
            }
        }
    }

    public function __destruct()
    {
        if (isset($this->conexion)) {
            $this->conexion->close();
        }
    }
}
?>
