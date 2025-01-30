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

//echo $id_empresa;

//validarToken('D3f3L1C3R4f43lYLuc1l4Alch0ur0nYP1mp0ll1n');

$consulta = new Sql;
$result = $consulta->traerModulos($id_empresa);

//print_r($result);

$bebidas = array();

if (count($result) === 0) {
    echo "[]";
    exit; // Salir si no hay resultados
}else{
    foreach ($result as $fila) { // Recorrer cada fila de resultados
        if ($fila['bebida_boolean'] == '1') {
            $modulos_bebidas = explode(", ", $fila['bebidas']);
            foreach ($modulos_bebidas as $m) {
                $bebidas[$m] = $consulta->getTableDataBusqueda('bebida_empresa', array('nombre' => $m));
            }
        }
    }
    
    $menu_completo =  $bebidas;
    
    echo json_encode($menu_completo,JSON_UNESCAPED_UNICODE);
}



?>