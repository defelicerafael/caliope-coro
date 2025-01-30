<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

header("Content-Type: text/html;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

$zonas = filter_input(INPUT_POST, 'zonas', FILTER_SANITIZE_SPECIAL_CHARS);
$terapia = filter_input(INPUT_POST, 'terapia', FILTER_SANITIZE_SPECIAL_CHARS);

require_once 'class_sql.php';



if(($zonas == 'todas')||($terapia == 'todas')){
    if($zonas === 'todas'){
        $zonas = '';
    }
    if($terapia === 'todas'){
        $terapia = '';
    }
    //echo "entre acá OR";
    $sql = new Sql;
    $result = $sql->buscarterapeutaOR($zonas);
}else{
    //echo "entre acá AND";
    $sql = new Sql;
    $result = $sql->buscarterapeutaAND($zonas,$terapia);
}


if ($result === null) {
    echo json_encode(["error" => "Hubo un error al obtener los terapeutas"]);
} 
 else {
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
}