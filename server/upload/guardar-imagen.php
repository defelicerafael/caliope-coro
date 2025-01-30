<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $direccion  = "https://".$_SERVER['HTTP_HOST'];
} else {
    $direccion  = "http://".$_SERVER['HTTP_HOST'];
}
if($_SERVER['HTTP_HOST']==='localhost'){
    header("Access-Control-Allow-Origin: http://localhost:4200");
}else{
    header("Access-Control-Allow-Origin: $direccion");
}
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');
// Definir la ubicación para guardar las imágenes subidas

// LOCALHOST
if($_SERVER['HTTP_HOST']==='localhost'){
    $uploadDir = '../../src/assets/img/blog/';
    $target = $direcion.'/src/assets/img/blog/';
}else{
    $uploadDir = '../../assets/img/blog/';
    $target = $direccion.'/assets/img/blog/';
}


// ONLINE





if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['upload'])) {
    $uploadedFile = $_FILES['upload'];

    if ($uploadedFile['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($uploadedFile['name']);
        $targetPath = $uploadDir . $fileName;
        $targetP = $target. $fileName;

        if (move_uploaded_file($uploadedFile['tmp_name'], $targetPath)) {
            $response = array(
                'url' => $targetP,
            );
        } else {
            $response = array(
                'error' => array(
                    'message' => 'No se pudo mover el archivo a la ubicación de almacenamiento.'
                )
            );
        }
    } else {
        $response = array(
            'error' => array(
                'message' => 'Error al subir el archivo: ' . $uploadedFile['error']
            )
        );
    }
} else {
    $response = array(
        'error' => array(
            'message' => 'No se recibió ningún archivo.'
        )
    );
}

header('Content-Type: application/json');
echo json_encode($response);
?>