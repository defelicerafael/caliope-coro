<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: text/html;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

$id_empresa = filter_input(INPUT_POST, 'empresa', FILTER_SANITIZE_SPECIAL_CHARS);

require_once '../class_sql.php';
require_once 'validarToken.php';

//echo $id_empresa;

//validarToken('D3f3L1C3R4f43lYLuc1l4Alch0ur0nYP1mp0ll1n');

$consulta = new Sql;
$result = $consulta->traerModulos($id_empresa);

$postres = array();
$bebidas = array();
$plato_principal = array();

if (count($result) === 0) {
    echo "[]";
    exit; // Salir si no hay resultados
}else{
    //print_r($result);
    foreach ($result as $fila) { // Recorrer cada fila de resultados

        // Verificar si postres están habilitados
        if ($fila['postre_boolean'] == '1') {
            // Dividir los postres en un array
            $modulos_postres = explode(", ", $fila['postres']);
            foreach ($modulos_postres as $m) {
                // Añadir el postre al array de postres
                $postres[] = $consulta->traerPlatos($m);
            }
        }

        // Verificar si el módulo (plato principal) está habilitado
        if ($fila['modulo_boolean'] == '1') {
            // Dividir los platos principales en un array
            $modulos_plato = explode(", ", $fila['modulos']);
            foreach ($modulos_plato as $m) {
                // Añadir el plato principal al array de platos principales
                $plato_principal[] = $consulta->traerPlatos($m);
            }
        }

        // Verificar si las bebidas están habilitadas
        if ($fila['bebida_boolean'] == '1') {
            // Dividir las bebidas en un array
            $modulos_bebidas = explode(", ", $fila['bebidas']);
            foreach ($modulos_bebidas as $m) {
                // Añadir la bebida al array de bebidas
                $bebidas[] = $consulta->getTableDataBusqueda('bebida_empresa', array('nombre' => $m));
            }
        }
    }
    
    $menu_completo = array(
        "postres" => $postres,
        "bebidas" => $bebidas,
        "plato_principal" => $plato_principal
    );
    
    echo json_encode($menu_completo,JSON_UNESCAPED_UNICODE);
}



?>