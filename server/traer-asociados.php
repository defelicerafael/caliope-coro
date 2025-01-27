<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

require_once 'conexion.php';

header("Content-Type: text/html;charset=utf-8");
// CORS
if($actual_link==='localhost'){
    header("Access-Control-Allow-Origin: $localhost");
}else{
    header("Access-Control-Allow-Origin: $server");
}

header("Access-Control-Allow-Methods: GET");
//header("Content-Type: application/json");

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

if($id==0){
    $sql = "SELECT * FROM asociados ORDER BY id ASC";
    //echo $sql;
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->execute();
        $result = $stmt->get_result();
        while ($myrow = $result->fetch_assoc()) {
            $elementos[] = array(
                "id"=>$myrow['id'],
                "nombre"=>$myrow['nombre'],
                "apellido"=>$myrow['apellido'],
                "celular"=>$myrow['celular'],
                "email"=>$myrow['email'],
                "dni"=>$myrow['dni'],
                "reprocann"=>$myrow['reprocann'],
                "codidoreprocann"=>$myrow['codidoreprocann'],
                "fechareprocann"=>$myrow['fechareprocann'],
                "codigopostal"=>$myrow['codigopostal'],
                "calle"=>$myrow['calle'],
                "numero"=>$myrow['numero'],
                "departamento"=>$myrow['departamento'],
                "provincia"=>$myrow['provincia'],
                "localidad"=>$myrow['localidad'],
                "fichareprocann"=>$myrow['fichareprocann'],
                "activo"=>$myrow['activo'],
                "categoriareprocann"=>$myrow['categoriareprocann'],
                "habilitado"=>$myrow['habilitado'],
                "usuario"=>$myrow['usuario'],
                "pass"=>$myrow['pass']
                
            );
        }
    }
}else{
    $sql = "SELECT * FROM asociados WHERE id=? ORDER BY id ASC";
    //echo $sql;
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($myrow = $result->fetch_assoc()) {
            $elementos[] = array(
                "id"=>$myrow['id'],
                "nombre"=>$myrow['nombre'],
                "apellido"=>$myrow['apellido'],
                "celular"=>$myrow['celular'],
                "email"=>$myrow['email'],
                "dni"=>$myrow['dni'],
                "reprocann"=>$myrow['reprocann'],
                "codidoreprocann"=>$myrow['codidoreprocann'],
                "fechareprocann"=>$myrow['fechareprocann'],
                "codigopostal"=>$myrow['codigopostal'],
                "calle"=>$myrow['calle'],
                "numero"=>$myrow['numero'],
                "departamento"=>$myrow['departamento'],
                "provincia"=>$myrow['provincia'],
                "localidad"=>$myrow['localidad'],
                "fichareprocann"=>$myrow['fichareprocann'],
                "activo"=>$myrow['activo'],
                "categoriareprocann"=>$myrow['categoriareprocann'],
                "habilitado"=>$myrow['habilitado'],
                "usuario"=>$myrow['usuario'],
                "pass"=>$myrow['pass']
                
            );
        }
    }
}



$stmt->close();
if($result->num_rows===0){
    echo "[]";
}else{
    echo json_encode($elementos,JSON_UNESCAPED_UNICODE);
}
$mysqli->close();
