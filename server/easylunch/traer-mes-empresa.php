<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Access-Control-Allow-Origin: *"); // Permite todos los orígenes
header("Content-Type: text/html;charset=utf-8");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

$dia = filter_input(INPUT_GET, 'dia', FILTER_SANITIZE_SPECIAL_CHARS);
$mes = filter_input(INPUT_GET, 'mes', FILTER_SANITIZE_SPECIAL_CHARS);
$anio = filter_input(INPUT_GET, 'anio', FILTER_SANITIZE_SPECIAL_CHARS);
$empresa = filter_input(INPUT_GET, 'empresa', FILTER_SANITIZE_SPECIAL_CHARS);

$tabla = 'mes';
$array = array('dia'=>$dia,'mes'=>$mes,'anio'=>$anio,'mostrar'=>'si');

require_once '../class_sql.php';
require_once 'validarToken.php';

//validarToken('D3f3L1C3R4f43lYLuc1l4Alch0ur0nYP1mp0ll1n');

$sql = new Sql;
$result = $sql->getTableDataBusquedaOrderBy($tabla,$array,'dia','DESC');

if(count($result)===0){
    echo "[]";
}else{
    echo json_encode($result,JSON_UNESCAPED_UNICODE);
}

