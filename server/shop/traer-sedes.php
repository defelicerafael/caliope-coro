<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

require_once 'conexion.php';

header("Content-Type: text/html;charset=utf-8");
// CORS
if($actual_link==='localhost'){
    header("Access-Control-Allow-Origin: $localhost");
}else{
    header("Access-Control-Allow-Origin: $server");
}

header("Access-Control-Allow-Methods: GET");
//header("Content-Type: application/json");

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

if($id==0){
    $sql = "SELECT * FROM sedes ORDER BY nombre ASC";
    //echo $sql;
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->execute();
        $result = $stmt->get_result();
        while ($myrow = $result->fetch_assoc()) {
            $elementos[] = array(
                "id"=>$myrow['id'],
                "nombre"=>$myrow['nombre'],
                "direccion"=>$myrow['direccion'],
                "nombre_contacto"=>$myrow['nombre_contacto'],
                "email_contacto"=>$myrow['email_contacto'],
                "celu_contacto"=>$myrow['celu_contacto'],
                
            );
        }
    }
}else{
    $sql = "SELECT * FROM sedes WHERE id=? ORDER BY nombre ASC";
    //echo $sql;
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($myrow = $result->fetch_assoc()) {
            $elementos[] = array(
                "id"=>$myrow['id'],
                "nombre"=>$myrow['nombre'],
                "direccion"=>$myrow['direccion'],
                "nombre_contacto"=>$myrow['nombre_contacto'],
                "email_contacto"=>$myrow['email_contacto'],
                "celu_contacto"=>$myrow['celu_contacto'],
            );
        }
    }
}



$stmt->close();
if($result->num_rows===0){
    echo "[]";
}else{
    echo json_encode($elementos,JSON_UNESCAPED_UNICODE);
}
$mysqli->close();
