<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

header("Content-Type: text/html;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

$tabla = filter_input(INPUT_POST, 'tabla', FILTER_SANITIZE_SPECIAL_CHARS);
$order = filter_input(INPUT_POST, 'order', FILTER_SANITIZE_SPECIAL_CHARS);
$by = filter_input(INPUT_POST, 'by', FILTER_SANITIZE_SPECIAL_CHARS);

$filtro_post = $_POST['data'];
$filtro = str_replace("'", "&#39;", $filtro_post);
$array = json_decode($filtro_post,true);



if(count($array[0])==0){
    echo "[]"; 
}else{
   
    require_once 'class_sql.php';
    $consulta = new Sql;
    $filtrados = $consulta->filterFilters($array);

    $result = $consulta->getTableDataBusquedaOrderBy($tabla,$filtrados[0],$order,$by);

    if(count($result)===0){
        echo "[]";
    }else{
        echo json_encode($result,JSON_UNESCAPED_UNICODE);
    }
}
?>