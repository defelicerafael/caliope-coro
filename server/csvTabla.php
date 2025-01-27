<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

include_once 'class_sql.php';

$tabla = filter_input(INPUT_GET, 'tabla', FILTER_SANITIZE_SPECIAL_CHARS);
$archivo = filter_input(INPUT_GET, 'archivo', FILTER_SANITIZE_SPECIAL_CHARS);
$archivos = "../download/".$archivo.".csv";

$ccsi = new Sql;
$ccsi->exportarATexto($tabla,$archivos);





