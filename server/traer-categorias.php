<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

header("Content-Type: text/html;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$tabla = filter_input(INPUT_GET, 'tabla', FILTER_SANITIZE_SPECIAL_CHARS);

require_once 'class_sql.php';

if($id==0){
    $sql = "SELECT * FROM categorias ORDER BY orden ASC";
    //echo $sql;
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->execute();
        $result = $stmt->get_result();
        while ($myrow = $result->fetch_assoc()) {
            $elementos[] = array(
                "id"=>$myrow['id'],
                "nombre"=>$myrow['nombre'],
                "img"=>$myrow['img'],
                "mostrar"=>$myrow['mostrar'],
                "orden"=>$myrow['orden'],
            );
        }
    }
}else{
    $sql = "SELECT * FROM categorias WHERE id=? ORDER BY orden ASC";
    //echo $sql;
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($myrow = $result->fetch_assoc()) {
            $elementos[] = array(
                "id"=>$myrow['id'],
                "nombre"=>$myrow['nombre'],
                "img"=>$myrow['img'],
                "mostrar"=>$myrow['mostrar'],
                "orden"=>$myrow['orden'],
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
