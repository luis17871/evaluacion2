<?php
// TODO: Clase de Asistentes
require_once('../config/config.php');

class Asistentes
{
    // TODO: Implementar los métodos de la clase

    public function todos() // select * from asistentes
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `asistentes`";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function asistentesPorConferencia($idConferencia) // select * from asistentes where conferencia_id = $idConferencia
{
    try {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT a.* 
                   FROM `asistentes` a
                   JOIN `registroconferencia` r ON a.`asistente_id` = r.`asistente_id`
                   WHERE r.`conferencia_id` = $idConferencia";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    } catch (Exception $th) {
        return $th->getMessage();
    }
}

public function asistentesNoEnConferencia($idConferencia) // select * from asistentes where asistente_id not in (select asistente_id from registroconferencia where conferencia_id = $idConferencia)
{
    try {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT a.* 
                   FROM `asistentes` a
                   WHERE a.`asistente_id` NOT IN (
                       SELECT r.`asistente_id` 
                       FROM `registroconferencia` r 
                       WHERE r.`conferencia_id` = $idConferencia
                   )";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    } catch (Exception $th) {
        return $th->getMessage();
    }
}




    public function uno($idAsistente) // select * from asistentes where id = $idAsistente
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `asistentes` WHERE `asistente_id` = $idAsistente";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function insertar($nombre, $apellido, $email, $telefono) // insert into asistentes (nombre, apellido, email, telefono) values ($nombre, $apellido, $email, $telefono)
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "INSERT INTO `asistentes`(`nombre`, `apellido`, `email`, `telefono`) 
                       VALUES ('$nombre', '$apellido', '$email', '$telefono')";
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

    public function actualizar($idAsistente, $nombre, $apellido, $email, $telefono) // update asistentes set nombre = $nombre, apellido = $apellido, email = $email, telefono = $telefono where id = $idAsistente
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "UPDATE `asistentes` SET 
                       `nombre`='$nombre',
                       `apellido`='$apellido',
                       `email`='$email',
                       `telefono`='$telefono' 
                       WHERE `asistente_id` = $idAsistente";
            if (mysqli_query($con, $cadena)) {
                return $idAsistente; // Return the updated ID
            } else {
                return $con->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }

    public function eliminar($idAsistente) // delete from asistentes where id = $idAsistente
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "DELETE FROM `asistentes` WHERE `asistente_id`= $idAsistente";
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
