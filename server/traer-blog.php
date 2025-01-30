<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

header("Content-Type: text/html;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

$tabla = 'blog';
$filtro = 'no';
$filtro_por = 'id';
$orden = "ASC";
$limit = "999";

require_once 'class_sql.php';

$sql = new Sql;
$result = $sql->selectTablaNew($tabla,$filtro,$filtro_por,$orden,$limit);

if(count($result)===0){
    echo "[]";
}else{
    echo json_encode($result,JSON_UNESCAPED_UNICODE);
}
