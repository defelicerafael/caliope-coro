<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
header('Content-Type: application/json'); // Indica que el contenido es JSON

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if($_SERVER['HTTP_HOST']==='localhost'){
        $targetDir = "../../src/assets/archivos/matriculas/";
    }else{
        $targetDir = "../../assets/archivos/matriculas/";
    }
    
    $uploadStatus = 1;
    $response = [];

    // Verificar si el campo 'file' está presente en $_FILES
    if (isset($_FILES['file'])) {
        $files = $_FILES['file'];
        
        // Si se envían múltiples archivos
        if (is_array($files['name'])) {
            foreach ($files['name'] as $key => $filename) {
                $targetFilePath = $targetDir . basename($filename);
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                // Validar tipo de archivo
                $allowedTypes = array('pdf', 'doc', 'docx', 'jpg', 'jpeg');
                if (!in_array(strtolower($fileType), $allowedTypes)) {
                    $response[] = [
                        "error" => 1,
                        "message" => "Error: Solo se permiten archivos PDF, DOC, DOCX, JPG."
                    ];
                    $uploadStatus = 0;
                }

                // Mover archivo a la carpeta destino
                if ($uploadStatus && move_uploaded_file($files["tmp_name"][$key], $targetFilePath)) {
                    $response[] = [
                        "error" => 0,
                        "message" => "$filename se ha subido correctamente."
                    ];
                } else {
                    $response[] = [
                        "error" => 1,
                        "message" => "Error al subir el archivo $filename."
                    ];
                }
            }
        } else {
            // Si solo se envía un archivo
            $filename = $files['name'];
            $targetFilePath = $targetDir . basename($filename);
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            // Validar tipo de archivo
            $allowedTypes = array('pdf', 'doc', 'docx', 'jpg', 'jpeg');
            if (!in_array(strtolower($fileType), $allowedTypes)) {
                $response[] = [
                    "error" => 1,
                    "message" => "Error: Solo se permiten archivos PDF, DOC, DOCX, JPG."
                ];
                $uploadStatus = 0;
            }

            // Mover archivo a la carpeta destino
            if ($uploadStatus && move_uploaded_file($files["tmp_name"], $targetFilePath)) {
                $response[] = [
                    "error" => 0,
                    "message" => "$filename se ha subido correctamente."
                ];
            } else {
                $response[] = [
                    "error" => 1,
                    "message" => "Error al subir el archivo $filename."
                ];
            }
        }
    } else {
        $response[] = [
            "error" => 1,
            "message" => "No se han recibido archivos."
        ];
    }

    echo json_encode($response); // Envía la respuesta como JSON
}