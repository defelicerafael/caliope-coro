<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

header("Content-Type: text/html;charset=utf-8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

//echo $_POST['base'];

$id_tabla = filter_input(INPUT_POST, 'id_tabla', FILTER_SANITIZE_SPECIAL_CHARS);
$base = base64_decode(filter_input(INPUT_POST, 'base', FILTER_SANITIZE_URL));

$tabla = 'carousel';

include_once 'class_sql.php';

function base64_to_jpeg($base64_string, $output_file,$tabla) {
    $actual_link = $_SERVER['HTTP_HOST'];
    if($actual_link=='localhost'){
        $dir = "../src/assets/img/imagenes/".$tabla."/".$output_file;
    }else{
        $dir = "../assets/img/imagenes/".$tabla."/".$output_file;
    }

    

    $ifp = fopen(  $dir, 'wb' ); 

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

    // clean up the file resource
    fclose( $ifp ); 

    return 'assets/img/imagenes/'.$tabla.'/'.$output_file;
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

$foto = base64_to_jpeg($base,$nombre_foto,$tabla);

$sql = new Sql;

$array = array('img'=>$foto,'orden'=>'99','mostrar'=>'1','id_elemento'=>$id_tabla);
$insert = $sql->insert_array('carousel',$array,'si');

