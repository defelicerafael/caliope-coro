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

/*
echo "<pre>";
print_r($result);
echo "<pre>";
*/
$postres = array();
$postres_fijos = array();

if (count($result) === 0) {
    echo "[]";
    exit; // Salir si no hay resultados
}else{
    //print_r($result);
    foreach ($result as $fila) { // Recorrer cada fila de resultados
        // Verificar si postres están habilitados
        if ($fila['postre_boolean'] == '1') {
            if($fila['postre_fijo_boolean'] == '1') {
            // Dividir los postres en un array
                $modulos_postres = explode(", ", $fila['postres_modulos_fijos']);
                foreach ($modulos_postres as $m) {
                    $cadenaSinCorchetes = trim($m, "[]");
                    //echo $cadenaSinCorchetes;
                    $postres[$cadenaSinCorchetes] = $consulta->traerPlatosDeUnModuloFijo($cadenaSinCorchetes);
                }
        }
    }
    
    /*echo "<pre>";
    print_r($postres);
    echo "<pre>";*/

    foreach ($postres as $modulo => $lista) { // Recorrer cada fila de resultados
        $arrayPlatos = explode("], [",$lista['platos_en_modulo']);
        foreach($arrayPlatos as $platos){
            $cadenaSinCorchetes = trim($platos, "[]");
            if($cadenaSinCorchetes != 0){
                $postres_fijos[$modulo][] = $consulta->traerPlatosPorNombre($cadenaSinCorchetes);
            }
        }
        
    }
}
    /*echo "<pre>";
    print_r($postres_fijos);
    echo "<pre>";
*/
    //unset($postres["platos_en_modulo"]);
    $menu_completo =  $postres_fijos;
    
    echo json_encode($menu_completo,JSON_UNESCAPED_UNICODE);
}



?>