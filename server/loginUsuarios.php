<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$actual_link = $_SERVER['HTTP_HOST'];
//echo $actual_link."<br/>";
if($actual_link=='localhost'){
    $mysqli = new mysqli("localhost", "root", "manjarlo1", "raca");
}else{
    $mysqli = new mysqli("localhost", "c1431505_laronda", "wevi92baZO", "c1431505_laronda");
}

$user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_SPECIAL_CHARS);
$pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_SPECIAL_CHARS);

//echo $user;
//echo $pass;

$sql = "SELECT * FROM asociados WHERE email=? AND pass=? ORDER BY id ASC";


if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("ss",$user,$pass);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($myrow = $result->fetch_assoc()) {
        $user = array(
            "user"=>$myrow['email'],
            "nombre"=>utf8_encode($myrow['nombre']),
            "apellido"=>utf8_encode($myrow['apellido']),
            "id"=>$myrow['id'],
            "sede"=>$myrow['sede'],
            "activo"=>$myrow['activo'],
            "categoria_servicio"=>$myrow['categoria_servicio'],
            "categoria_servicio_pago"=>$myrow['categoria_servicio_pago']
        );
    }
}

$stmt->close();
if($result->num_rows===0){
    echo "[]";
}else{
    echo json_encode($user,JSON_UNESCAPED_UNICODE);
}
$mysqli->close();
