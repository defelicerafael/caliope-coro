<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

header("Content-Type: text/html;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');


include_once 'class_sql.php';

$tabla = filter_input(INPUT_POST, 'tabla', FILTER_SANITIZE_SPECIAL_CHARS);
$filtro_post = $_POST['datos'];
$array = json_decode($filtro_post,true);


$hashedPassword = password_hash($array['pass'], PASSWORD_DEFAULT);
$array['pass'] = $hashedPassword;
$array['email'] = strtolower($array['email']);

$sql = new Sql;

$duplicado = $sql->getTableDataBusqueda($tabla,array('email'=>$array['email']));
//print_r($duplicado);
if(count($duplicado)>0){
    $error_message = "Ya tenemos un usuario con ese email, INGRESE al sistema para completar la carga de datos.";
    $error_array = array('error' => $error_message,'last_id'=>$duplicado[0]['id']);
    $error_json = json_encode($error_array);
    echo $error_json;
    
}else{
    $insert = $sql->insert_array($tabla,$array,'si');
    $last_id_tabla = $sql->getlastId($tabla);
}








