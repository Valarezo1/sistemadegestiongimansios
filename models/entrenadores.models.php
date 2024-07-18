<?php
require_once('../config/conexion.php');

class Clase_Entrenador
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
            $consulta = "SELECT * FROM Entrenadores";
            $stmt = $this->conexion->prepare($consulta);
            
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
            }
            
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            if ($resultado === false) {
                throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
            }
            
            $entrenadores = array();
            while ($fila = $resultado->fetch_assoc()) {
                $entrenadores[] = $fila;
            }
            
            return $entrenadores;
        } catch (Exception $e) {
            error_log("Error en la consulta todos() de entrenadores: " . $e->getMessage());
            return false;
        }
    }

    public function insertar($nombre, $especialidad, $telefono, $email)
    {
        try {
            $consulta = "INSERT INTO Entrenadores (nombre, especialidad, telefono, email) VALUES (?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($consulta);
            
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
            }
            
            $stmt->bind_param("ssss", $nombre, $especialidad, $telefono, $email);
            $stmt->execute();
            
            if ($stmt->affected_rows != 1) {
                throw new Exception("Error al insertar entrenador");
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error al insertar entrenador: " . $e->getMessage());
            return false;
        }
    }

    public function actualizar($entrenador_id, $nombre, $especialidad, $telefono, $email)
    {
        try {
            $consulta = "UPDATE Entrenadores SET nombre=?, especialidad=?, telefono=?, email=? WHERE entrenador_id=?";
            $stmt = $this->conexion->prepare($consulta);
            
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
            }
            
            $stmt->bind_param("ssssi", $nombre, $especialidad, $telefono, $email, $entrenador_id);
            $stmt->execute();
            
            if ($stmt->affected_rows < 1) {
                throw new Exception("Error al actualizar entrenador o el entrenador no se encontró");
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error al actualizar entrenador: " . $e->getMessage());
            return false;
        }
    }

    public function eliminar($entrenador_id)
    {
        try {
            $consulta = "DELETE FROM Entrenadores WHERE entrenador_id=?";
            $stmt = $this->conexion->prepare($consulta);
            
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
            }
            
            $stmt->bind_param("i", $entrenador_id);
            $stmt->execute();
            
            if ($stmt->affected_rows == 0) {
                throw new Exception("No se encontró el entrenador con el ID proporcionado o no se pudo eliminar");
            }
            
            return true;
        } catch (Exception $e) {
            error_log("Error al eliminar entrenador: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerPorId($entrenador_id)
    {
        try {
            $consulta = "SELECT * FROM Entrenadores WHERE entrenador_id = ?";
            $stmt = $this->conexion->prepare($consulta);
            
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
            }
            
            $stmt->bind_param("i", $entrenador_id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            if ($resultado->num_rows != 1) {
                throw new Exception("No se encontró ningún entrenador con el ID proporcionado");
            }
            
            $entrenador = $resultado->fetch_assoc();
            
            return $entrenador;
        } catch (Exception $e) {
            error_log("Error al obtener entrenador por ID: " . $e->getMessage());
            return false;
        }
    }
}
?>
