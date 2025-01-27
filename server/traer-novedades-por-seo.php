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

$seo = filter_input(INPUT_GET, 'seo', FILTER_SANITIZE_SPECIAL_CHARS);


$sql = "SELECT * FROM novedades WHERE seo = ?";
//echo $sql;
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("s",$seo);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($myrow = $result->fetch_assoc()) {
        $ranking = 0;
        $eventos[] = array(
            "id"=>$myrow['id'],
            "titulo"=>$myrow['titulo'],
            "subtitulo"=>$myrow['subtitulo'],
            "resumen"=>$myrow['resumen'],
            "texto"=>$myrow['texto'],
            "boton_name"=>$myrow['boton_name'],
            "boton_url"=>$myrow['boton_url'],
            "boton_color"=>$myrow['boton_color'],
            "img"=>$myrow['img'],
            "categoria"=>$myrow['categoria'],
            "fecha"=>$myrow['fecha'],
            "seo"=>$myrow['seo']
        );
    }
}

$stmt->close();
if($result->num_rows===0){
    echo "[]";
}else{
    echo json_encode($eventos,JSON_UNESCAPED_UNICODE);
}
$mysqli->close();
