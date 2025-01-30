<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

header("Content-Type: text/html;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$tabla = filter_input(INPUT_GET, 'tabla', FILTER_SANITIZE_SPECIAL_CHARS);

require_once 'class_sql.php';

$sql = new Sql;
$result = $sql->delete($tabla, 'id', $id);


