<?php
function validarToken($tokenSecreto) {
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (strpos($authHeader, 'Bearer ') === 0) {
        $token = substr($authHeader, 7);  // Extrae el token sin el "Bearer "
        if ($token !== $tokenSecreto) {
            die('Acceso no autorizado');
        }
        if ($token === $tokenSecreto) {
            //echo "son iguales";
        }
    } else {
        die('Token no provisto o inválido');
    }
}

/*function validarToken($tokenSecreto) {
    $headers = apache_request_headers();
    $authHeader = $headers['Authorization'] ?? '';

    echo "Authorization Header: " . $authHeader . "<br/>";

    if (strpos($authHeader, 'Bearer ') === 0) {
        $token = substr($authHeader, 7);  // Extrae el token sin el "Bearer "
        echo "Token recibido: " . $token . "<br/>";
        echo "Token esperado: " . $tokenSecreto . "<br/>";

        if ($token !== $tokenSecreto) {
            die('Acceso no autorizado');
        } else {
            //echo "¡Tokens coinciden!";
        }
    } else {
        die('Token no provisto o inválido');
    }
}*/


?>