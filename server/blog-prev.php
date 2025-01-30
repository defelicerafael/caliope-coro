<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

header("Content-Type: text/html;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
// 'llega'.$id;
$id = (int) $id;
//echo 'convierto en:'.$id;

require_once 'class_sql.php';

$sql_prev  = 'SELECT * FROM blog WHERE id = (SELECT MAX(id) FROM blog WHERE id < '.$id.')';

$prev = new Sql;
$id_prev = $prev->doyLaConsulta($sql_prev);

if (is_array($id_prev) && count($id_prev) === 0) {
    echo "[]";
}else{
    echo json_encode($id_prev,JSON_UNESCAPED_UNICODE);
}


?>