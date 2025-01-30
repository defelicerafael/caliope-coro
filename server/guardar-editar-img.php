<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

header("Content-Type: text/html;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');




$tabla = filter_input(INPUT_POST, 'tabla', FILTER_SANITIZE_SPECIAL_CHARS);
$id_tabla = filter_input(INPUT_POST, 'id_tabla', FILTER_SANITIZE_SPECIAL_CHARS);
$base = base64_decode(filter_input(INPUT_POST, 'base', FILTER_SANITIZE_URL));
require_once 'class_sql.php';

/*echo "<pre>";
print_r($base);
echo "</pre>";*/

function base64_to_jpeg($base64_string, $output_file) {
    $actual_link = $_SERVER['HTTP_HOST'];
    if($actual_link=='localhost'){
        $dir = "../public/assets/img/upload/".$output_file;
    }else{
        $dir = "../assets/img/upload/".$output_file;
    }
    
    $ifp = fopen(  $dir, 'wb' ); 
    $data = explode( ',', $base64_string );
    fwrite( $ifp, base64_decode( $data[1] ) );
    fclose( $ifp ); 
    return 'admin/assets/img/upload/'.$output_file;
}

$n=10;

function getRandomString($n) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
  
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
  
    return $randomString;
}
  
$nombre_foto = getRandomString($n).'.webp';

$foto = base64_to_jpeg($base,$nombre_foto);

$sql = new Sql;
$result = $sql->edit('carousel','img',$foto,'id_elemento',$id_tabla);
$result2 = $sql->edit($tabla,'img',$foto,'id',$id_tabla);
$mal = $sql->getMal();
if($mal>0){
    echo 1;
}else{
    echo 0;
}
