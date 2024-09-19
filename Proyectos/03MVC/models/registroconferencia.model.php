<?php
// TODO: Clase de RegistroConferencia
require_once('../config/config.php');

class RegistroConferencia
{
    // TODO: Implementar los métodos de la clase

    public function todos() // select * from registroconferencia
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `registroconferencia`";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function uno($registroId) // select * from registroconferencia where registro_id = $registroId
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `registroconferencia` WHERE `registro_id` = $registroId";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function insertar($conferenciaId, $asistenteId) // insert into registroconferencia (conferencia_id, asistente_id) values ($conferenciaId, $asistenteId)
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "INSERT INTO `registroconferencia`(`conferencia_id`, `asistente_id`) 
                       VALUES ('$conferenciaId', '$asistenteId')";
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

    public function actualizar($registroId, $conferenciaId, $asistenteId) // update registroconferencia set conferencia_id = $conferenciaId, asistente_id = $asistenteId where registro_id = $registroId
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "UPDATE `registroconferencia` SET 
                       `conferencia_id`='$conferenciaId',
                       `asistente_id`='$asistenteId'
                       WHERE `registro_id` = $registroId";
            if (mysqli_query($con, $cadena)) {
                return $registroId; // Return the updated ID
            } else {
                return $con->error;
            }
        } catch (Exception $th) {
            return $th->getMessage();
        } finally {
            $con->close();
        }
    }

    public function eliminar($asistenteId, $conferenciaId) // delete from registroconferencia where registro_id = $registroId
    {
        try {
            $con = new ClaseConectar();
            $con = $con->ProcedimientoParaConectar();
            $cadena = "DELETE FROM `registroconferencia` WHERE `conferencia_id`= $conferenciaId AND asistente_id=$asistenteId";
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
