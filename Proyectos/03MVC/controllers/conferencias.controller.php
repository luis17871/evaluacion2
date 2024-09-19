<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    die();
}

require_once('../models/conferencias.model.php');
error_reporting(0);
$conferencias = new Conferencias;

switch ($_GET["op"]) {
    
    case 'todos': // Procedimiento para cargar todas las conferencias
        $datos = array();
        $datos = $conferencias->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'uno': // Procedimiento para obtener una conferencia específica
        if (!isset($_POST["conferencia_id"])) {
            echo json_encode(["error" => "Conferencia ID not specified."]);
            exit();
        }
        $idConferencia = intval($_POST["conferencia_id"]);
        $datos = array();
        $datos = $conferencias->uno($idConferencia);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar': // Procedimiento para insertar una nueva conferencia
        if (!isset($_POST["nombre"]) || !isset($_POST["fecha"]) || !isset($_POST["ubicacion"]) || !isset($_POST["descripcion"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }

        $nombre = $_POST["nombre"];
        $fecha = $_POST["fecha"];
        $ubicacion = $_POST["ubicacion"];
        $descripcion = $_POST["descripcion"];

        $datos = array();
        $datos = $conferencias->insertar($nombre, $fecha, $ubicacion, $descripcion);
        echo json_encode($datos);
        break;

    case 'actualizar': // Procedimiento para actualizar una conferencia
        if (!isset($_POST["conferencia_id"]) || !isset($_POST["nombre"]) || !isset($_POST["fecha"]) || !isset($_POST["ubicacion"]) || !isset($_POST["descripcion"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }

        $idConferencia = intval($_POST["conferencia_id"]);
        $nombre = $_POST["nombre"];
        $fecha = $_POST["fecha"];
        $ubicacion = $_POST["ubicacion"];
        $descripcion = $_POST["descripcion"];

        $datos = array();
        $datos = $conferencias->actualizar($idConferencia, $nombre, $fecha, $ubicacion, $descripcion);
        echo json_encode($datos);
        break;

    case 'eliminar': // Procedimiento para eliminar una conferencia
        if (!isset($_POST["conferencia_id"])) {
            echo json_encode(["error" => "Conferencia ID not specified."]);
            exit();
        }
        $idConferencia = intval($_POST["conferencia_id"]);
        $datos = array();
        $datos = $conferencias->eliminar($idConferencia);
        echo json_encode($datos);
        break;

    default:
        echo json_encode(["error" => "Invalid operation."]);
        break;
}
?>
