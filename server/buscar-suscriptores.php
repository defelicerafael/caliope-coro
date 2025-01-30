<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

header("Content-Type: text/html;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

$tabla = filter_input(INPUT_POST, 'tabla', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);

$array = array('email'=>$email);

require_once 'class_sql.php';

$consulta = new Sql;
$result = $consulta->getTableDataBusqueda($tabla,$array);
/*echo "<pre>";
print_r($result);
echo "</pre>";*/
if(count($result)===0){
    $insert = $consulta->insert_array($tabla,array('email'=>$email,'enviar'=>'si'));
}else{
    echo 1;
}
?>