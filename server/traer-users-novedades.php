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
    $sql = "SELECT * FROM novedades_socios ORDER BY id ASC";
   // echo $sql;
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->execute();
        $result = $stmt->get_result();
        while ($myrow = $result->fetch_assoc()) {
            $eventos[] = array(
                "id"=>$myrow['id'],
                "titulo"=>$myrow['titulo'],
                "subtitulo"=>$myrow['subtitulo'],
                "texto"=>$myrow['texto'],
                "link"=>$myrow['link'],
                "mostrar"=>$myrow['mostrar']
            );
        }
    }
}else{
    $sql = "SELECT * FROM novedades_socios WHERE id = ?";
    //echo $sql;
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($myrow = $result->fetch_assoc()) {
            $ranking = 0;
            $eventos[] = array(
                "id"=>$myrow['id'],
                "titulo"=>$myrow['titulo'],
                "subtitulo"=>$myrow['subtitulo'],
                "texto"=>$myrow['texto'],
                "link"=>$myrow['link'],
                "mostrar"=>$myrow['mostrar']
            );
        }
    }
}
$stmt->close();
if($result->num_rows===0){
    echo "[]";
}else{
    echo json_encode($eventos,JSON_UNESCAPED_UNICODE);
}
$mysqli->close();
