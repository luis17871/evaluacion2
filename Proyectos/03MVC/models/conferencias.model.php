<?php
// TODO: Clase de Conferencias
require_once('../config/config.php');

class Conferencias
{
    // TODO: Implementar los métodos de la clase

    public function todos() // select * from conferencias
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `conferencias`";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function uno($idConferencia) // select * from conferencias where id = $idConferencia
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `conferencias` WHERE `conferencia_id` = $idConferencia";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function insertar($nombre, $fecha, $ubicacion, $descripcion) // insert into conferencias (nombre, fecha, ubicacion, descripcion) values ($nombre, $fecha, $ubicacion, $descripcion)
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "INSERT INTO `conferencias`(`nombre`, `fecha`, `ubicacion`, `descripcion`) 
                       VALUES ('$nombre', '$fecha', '$ubicacion', '$descripcion')";
            if (mysqli_query($con, $cadena)) {
                return $con->insert_id; // Return the inserted ID
            } else {
                return $con->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }

    public function actualizar($idConferencia, $nombre, $fecha, $ubicacion, $descripcion) // update conferencias set nombre = $nombre, fecha = $fecha, ubicacion = $ubicacion, descripcion = $descripcion where id = $idConferencia
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "UPDATE `conferencias` SET 
                       `nombre`='$nombre',
                       `fecha`='$fecha',
                       `ubicacion`='$ubicacion',
                       `descripcion`='$descripcion' 
                       WHERE `conferencia_id` = $idConferencia";
            if (mysqli_query($con, $cadena)) {
                return $idConferencia; // Return the updated ID
            } else {
                return $con->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }

    public function eliminar($idConferencia) // delete from conferencias where id = $idConferencia
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "DELETE FROM `conferencias` WHERE `conferencia_id`= $idConferencia";
            if (mysqli_query($con, $cadena)) {
                return 1; // Success
            } else {
                return $con->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }
}
?>
