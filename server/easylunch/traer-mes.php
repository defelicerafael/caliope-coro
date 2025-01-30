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
$id_empresa = filter_input(INPUT_GET, 'id_empresa', FILTER_SANITIZE_SPECIAL_CHARS);

require_once '../class_sql.php';
require_once 'validarToken.php';

//validarToken('D3f3L1C3R4f43lYLuc1l4Alch0ur0nYP1mp0ll1n');

$sql = new Sql;
$platosData = $sql->traerMesConMasInfo($dia, $mes, $anio);
$menuData = $sql->traerModulos($id_empresa);

/*
echo "<pre>";
echo "TRAER MES";
print_r($platosData);
echo "MENU DATA";
print_r($menuData);
echo "</pre>";
*/

$resultado = [];
if(empty($platosData)){
    echo "[]";
    exit;
}
$menuArray = json_decode($platosData[0]['menu'], true);
$modulos = explode(', ',$menuData[0]['modulos']);
$platos = [];

/*
echo "<pre>";
print_r($menuArray);
echo "</pre>";

echo "<pre>";
print_r($platosData);
echo "</pre>";
*/

foreach($modulos as $k => $v) {
    // Verificar si $menuArray[$v] es un array o un string
    if (is_array($menuArray[$v])) {
        // Si es un array, recorremos directamente
        foreach ($menuArray[$v] as $key => $value) {
            $palabraSinCorchetes = str_replace(["[", "]"], "", $value);
            $array = array('nombre' => $palabraSinCorchetes);
            $platos[$v][] = $sql->getTableDataBusqueda('platos', $array);
        }
    } elseif (is_string($menuArray[$v])) {
        // Si es un string, lo convertimos en un array separado por comas y luego lo recorremos
        $items = explode(',', $menuArray[$v]); // Convertir a array usando la coma como separador
        foreach ($items as $value) {
            //echo "$items, $value </br>";
            $palabraSinCorchetes = str_replace(["[", "]"], "", $value);
            $value = trim($palabraSinCorchetes); // Eliminar espacios en blanco alrededor de cada elemento
            $array = array('nombre' => $value);
            $platos[$v][] = $sql->getTableDataBusqueda('platos', $array);
        }
    }
}

/*
echo "<pre>";
print_r($platos);
echo "</pre>";
*/
$platos = array_filter($platos, function($item) {
    return !empty($item); // Dejar solo los que no estén vacíos
});

/*
echo "<pre>";
print_r($platos);
echo "</pre>";
*/


if(count($platos)===0){
    echo "[]";
}else{
    echo json_encode($platos,JSON_UNESCAPED_UNICODE);
}

