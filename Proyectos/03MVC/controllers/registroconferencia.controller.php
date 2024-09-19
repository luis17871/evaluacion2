<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    die();
}

require_once('../models/registroconferencia.model.php');
error_reporting(0);
$registroConferencia = new RegistroConferencia;

switch ($_GET["op"]) {
    
    case 'todos': // Procedimiento para cargar todos los registros de conferencias
        $datos = array();
        $datos = $registroConferencia->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'uno': // Procedimiento para obtener un registro específico
        if (!isset($_POST["registro_id"])) {
            echo json_encode(["error" => "Registro ID not specified."]);
            exit();
        }
        $registroId = intval($_POST["registro_id"]);
        $datos = array();
        $datos = $registroConferencia->uno($registroId);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar': // Procedimiento para insertar un nuevo registro de conferencia
        if (!isset($_POST["conferencia_id"]) || !isset($_POST["asistente_id"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }

        $conferenciaId = $_POST["conferencia_id"];
        $asistenteId = $_POST["asistente_id"];

        $datos = array();
        $datos = $registroConferencia->insertar($conferenciaId, $asistenteId);
        echo json_encode($datos);
        break;

    case 'actualizar': // Procedimiento para actualizar un registro de conferencia
        if (!isset($_POST["registro_id"]) || !isset($_POST["conferencia_id"]) || !isset($_POST["asistente_id"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }

        $registroId = intval($_POST["registro_id"]);
        $conferenciaId = $_POST["conferencia_id"];
        $asistenteId = $_POST["asistente_id"];

        $datos = array();
        $datos = $registroConferencia->actualizar($registroId, $conferenciaId, $asistenteId);
        echo json_encode($datos);
        break;

    case 'eliminar': // Procedimiento para eliminar un registro de conferencia
        if (!isset($_POST["conferencia_id"]) || !isset($_POST["asistente_id"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }

        $conferenciaId = $_POST["conferencia_id"];
        $asistenteId = $_POST["asistente_id"];

        $datos = array();
        $datos = $registroConferencia->eliminar($asistenteId, $conferenciaId);
        echo json_encode($datos);
        break;

    default:
        echo json_encode(["error" => "Invalid operation."]);
        break;
}
?>
