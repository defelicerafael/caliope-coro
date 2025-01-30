<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: text/html;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

$id_empresa = filter_input(INPUT_GET, 'id_empresa', FILTER_SANITIZE_SPECIAL_CHARS);

require_once '../class_sql.php';
require_once 'validarToken.php';

//validarToken('D3f3L1C3R4f43lYLuc1l4Alch0ur0nYP1mp0ll1n');

$consulta = new Sql;
$result = $consulta->traerModulos($id_empresa);

if (count($result) === 0) {
    echo "[]";
    exit; // Salir si no hay resultados
}else{
    echo json_encode($result,JSON_UNESCAPED_UNICODE);
}
/*
echo "<pre>";
print_r($dias);
echo "</pre>";
*/

?>