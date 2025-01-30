<?php
include_once 'class_sql.php';

// Sanitize input
$id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_SANITIZE_SPECIAL_CHARS);
$id_empresa = filter_input(INPUT_GET, 'id_empresa', FILTER_SANITIZE_SPECIAL_CHARS);
$mes = filter_input(INPUT_GET, 'mes', FILTER_SANITIZE_SPECIAL_CHARS);

// Funcion para obtener el mes en español
function mesEsp($mes){
    $mesEsp = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    return $mesEsp[$mes - 1];
}

// Obtener fecha actual
$dia_hoy = date('d');
$mes_hoy = mesEsp(date('n'));
$anio_hoy = date('Y');

// Calcular mes siguiente
$mesDespuesP = mesEsp(date("n", strtotime('+1 month', strtotime(date('Y-m-01')))));
$anio_despues = $mesDespuesP == "Enero" ? $anio_hoy + 1 : $anio_hoy;

// Funcion reutilizable para consultas
function obtenerPedidos($sql, $id_usuario, $id_empresa, $mes, $anio) {
    $array = ['id_usuario' => $id_usuario, 'id_empresa' => $id_empresa, 'mes' => $mes, 'anio' => $anio];
    return $sql->selectTablaNew('pedidos', $array, 'id', 'ASC', '99999');
}

// Logica de consulta segun el día del mes
if ($mes_hoy == $mes) {
    $sql = new Sql;

    // Si el día del mes es menor a 20
    if ($dia_hoy < 20) {
        $pedidosHoy = obtenerPedidos($sql, $id_usuario, $id_empresa, $mes, $anio_hoy);
        $pedidosMesSiguiente = obtenerPedidos($sql, $id_usuario, $id_empresa, $mesDespuesP, $anio_despues);

        $pedidos = array_merge((array)$pedidosHoy, (array)$pedidosMesSiguiente);
        echo json_encode($pedidos ?: []);
    }

    // Si el día del mes es mayor o igual a 20
    if ($dia_hoy >= 20) {
        $pedidosHoy = obtenerPedidos($sql, $id_usuario, $id_empresa, $mes, $anio_hoy);
        $pedidosMesSiguiente = obtenerPedidos($sql, $id_usuario, $id_empresa, $mesDespuesP, $anio_despues);

        $pedidos = array_merge((array)$pedidosHoy, (array)$pedidosMesSiguiente);
        echo json_encode($pedidos ?: []);
    }
}
?>
 
