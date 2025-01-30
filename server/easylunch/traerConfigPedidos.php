<?php
// Mostrar todos los errores durante el desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración de cabeceras para soporte CORS y codificación
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Authorization, Content-Type, Accept, Origin, User-Agent, DNT, Cache-Control, X-Mx-ReqToken, Keep-Alive, X-Requested-With, If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS');

// Importar las dependencias necesarias
require_once '../class_sql.php';
require_once 'validarToken.php';

// Validar token (descomentarlo si es necesario para la autenticación)
// validarToken('D3f3L1C3R4f43lYLuc1l4Alch0ur0nYP1mp0ll1n');

try {
    // Instanciar clase Sql para manejar la base de datos
    $sql = new Sql();
    
    // Obtener parámetros necesarios para la consulta (asegúrate de definirlos antes)
    $tabla = 'configuracion_pagos';
    $id = '1';
    $order = 'DESC';
    $by = 'id';

    // Obtener los datos de la tabla especificada
    $result = $sql->getTableData($tabla, $id, $order, $by);

    // Devolver los datos en formato JSON
    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (Exception $e) {
    // Manejar errores y devolver una respuesta JSON con el error
    http_response_code(400);
    echo json_encode(["error" => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?>