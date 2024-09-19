<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    die();
}

require_once('../models/asistentes.model.php');
error_reporting(0);
$asistentes = new Asistentes;

switch ($_GET["op"]) {
    
    case 'todos': // Procedimiento para cargar todos los asistentes
        $datos = array();
        $datos = $asistentes->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
    case 'todosConferencia': // Procedimiento para cargar todos los asistentes
        if (!isset($_POST["conferencia_id"])) {
            echo json_encode(["error" => "Asistente ID not specified."]);
            exit();
        }
        $conferencia_id = intval($_POST["conferencia_id"]);
        $datos = array();
        $datos = $asistentes->asistentesPorConferencia($conferencia_id);
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
    case 'todosConferenciano': // Procedimiento para cargar todos los asistentes
        if (!isset($_POST["conferencia_id"])) {
            echo json_encode(["error" => "Asistente ID not specified."]);
            exit();
        }
        $conferencia_id = intval($_POST["conferencia_id"]);
        $datos = array();
        $datos = $asistentes->asistentesNoEnConferencia($conferencia_id);
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'uno': // Procedimiento para obtener un asistente específico
        if (!isset($_POST["asistente_id"])) {
            echo json_encode(["error" => "Asistente ID not specified."]);
            exit();
        }
        $idAsistente = intval($_POST["asistente_id"]);
        $datos = array();
        $datos = $asistentes->uno($idAsistente);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar': // Procedimiento para insertar un nuevo asistente
        if (!isset($_POST["nombre"]) || !isset($_POST["apellido"]) || !isset($_POST["email"]) || !isset($_POST["telefono"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }

        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $email = $_POST["email"];
        $telefono = $_POST["telefono"];

        $datos = array();
        $datos = $asistentes->insertar($nombre, $apellido, $email, $telefono);
        echo json_encode($datos);
        break;

    case 'actualizar': // Procedimiento para actualizar un asistente
        if (!isset($_POST["asistente_id"]) || !isset($_POST["nombre"]) || !isset($_POST["apellido"]) || !isset($_POST["email"]) || !isset($_POST["telefono"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }

        $idAsistente = intval($_POST["asistente_id"]);
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $email = $_POST["email"];
        $telefono = $_POST["telefono"];

        $datos = array();
        $datos = $asistentes->actualizar($idAsistente, $nombre, $apellido, $email, $telefono);
        echo json_encode($datos);
        break;

    case 'eliminar': // Procedimiento para eliminar un asistente
        if (!isset($_POST["asistente_id"])) {
            echo json_encode(["error" => "Asistente ID not specified."]);
            exit();
        }
        $idAsistente = intval($_POST["asistente_id"]);
        $datos = array();
        $datos = $asistentes->eliminar($idAsistente);
        echo json_encode($datos);
        break;

    default:
        echo json_encode(["error" => "Invalid operation."]);
        break;
}
?>
