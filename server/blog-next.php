<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

header("Content-Type: text/html;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
//echo 'llega'.$id;
$id = (int) $id;
//echo 'convierto en:'.$id;

require_once 'class_sql.php';

$sql_next  = 'SELECT * FROM blog WHERE id = (SELECT MIN(id) FROM blog WHERE id > '.$id.')';
//echo $sql_next;
$next = new Sql;
$id_next = $next->doyLaConsulta($sql_next);

if(is_array($id_next) && count($id_next)===0){
    echo "[]";
}else{
    echo json_encode($id_next,JSON_UNESCAPED_UNICODE);
}


?>