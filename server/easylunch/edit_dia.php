<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

header("Content-Type: text/html;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');


include_once '../class_sql.php';

$tabla = filter_input(INPUT_POST, 'tabla', FILTER_SANITIZE_SPECIAL_CHARS);
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$where = filter_input(INPUT_POST, 'where', FILTER_SANITIZE_SPECIAL_CHARS);

$filtro_post = $_POST['datos'];
$filtro = str_replace("'", "&#39;", $filtro_post);
$array = json_decode($filtro,true);
$menu = json_encode($array['menu'],JSON_UNESCAPED_UNICODE);

//print_r($menu);

$array['menu'] = $menu;


$ccsi = new Sql;

foreach($array as $key=>$dato){
    $dato = str_replace("'", "&#39;", $dato);
    $ccsi->edit($tabla,$key,$dato,$where,$id);
}

$mal = $ccsi->getMal();
if($mal>0){
    echo 1;
}else{
    echo 0;
}





