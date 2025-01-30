<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *"); // Permite todos los orígenes
header("Content-Type: text/html;charset=utf-8");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

$id_empresa = filter_input(INPUT_GET, 'id_empresa', FILTER_SANITIZE_SPECIAL_CHARS);
$id_user = filter_input(INPUT_GET, 'id_user', FILTER_SANITIZE_SPECIAL_CHARS);

$tabla = 'configuracion_dias_empresas';

require_once '../class_sql.php';
require_once 'validarToken.php';

//validarToken('D3f3L1C3R4f43lYLuc1l4Alch0ur0nYP1mp0ll1n');

$array = array('id_empresa' => $id_empresa);

$consulta = new Sql;
$result = $consulta->getTableDataBusqueda($tabla, $array);

if (count($result) === 0) {
    echo "[]";
    exit; // Salir si no hay resultados
}

// Obtener configuración
$config = $result[0];
$diasAtras = (int)$config['dias_anteriores'];
$diasAdelante = (int)$config['dias_despues'];
$numeroDeshabilitados = (int)$config['deshabilitar'];
$excluirDias = explode(',', $config['array']); // Separar los días a excluir
$empezar = (int)$config['empezar'];

/*echo "<pre>";
print_r($excluirDias);
echo "</pre>";*/

function obtenerDias($diasAtras, $diasAdelante, $excluirDias = [], $numeroDeshabilitados = 0, $desde = null, $empezar = 0) {
    // La fecha de inicio será hoy
    $desde = $desde ? new DateTime($desde) : new DateTime('today');
    
    if ($empezar > 0) {
        $desde->modify("+$empezar days");
    }
    
    $resultado = [];

    // Arrays con los nombres de los días y meses en español
    $dias_es = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
    $meses_es = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    // Normalizar los días a excluir a minúsculas para facilitar la comparación
    $excluirDias = array_map(function($dia) {
        return strtolower(trim($dia));
    }, $excluirDias);

    // Contador para deshabilitar los primeros días
    $contadorDias = 0;

    // Obtener días hacia atrás
    for ($i = $diasAtras; $i > 0; $i--) {
        // Clonar la fecha de inicio para evitar modificar el original
        $fecha = clone $desde;
        $fecha->modify("-$i day");

        $numero_dia_semana = $fecha->format('w');
        $numero_mes = $fecha->format('n') - 1;

        // Comprobar si el día debe ser excluido
        if (!in_array($dias_es[$numero_dia_semana], $excluirDias)) {
            $esHabilitado = ($contadorDias < $numeroDeshabilitados) ? 0 : 1;

            $resultado[] = [
                'numero_dia' => $fecha->format('d'),
                'dia_texto' => $dias_es[$numero_dia_semana],
                'mes_texto' => $meses_es[$numero_mes],
                'mes_numero' => $fecha->format('m'),
                'numero_semana' => $fecha->format('W'),
                'anio' => $fecha->format('Y'),
                'habilitado' => $esHabilitado
            ];
            $contadorDias++;
        }
    }

    // Agregar hoy (no se modifica)
    $numero_dia_semana = $desde->format('w');
    $numero_mes = $desde->format('n') - 1;
    $esHabilitado = ($contadorDias < $numeroDeshabilitados) ? 0 : 1;

    if (!in_array($dias_es[$numero_dia_semana], $excluirDias)) {
        $resultado[] = [
            'numero_dia' => $desde->format('d'),
            'dia_texto' => $dias_es[$numero_dia_semana],
            'mes_texto' => $meses_es[$numero_mes],
            'mes_numero' => $desde->format('m'),
            'numero_semana' => $desde->format('W'),
            'anio' => $desde->format('Y'),
            'habilitado' => $esHabilitado
        ];
        $contadorDias++;
    }

    // Obtener días hacia adelante
    for ($i = 1; $i <= $diasAdelante; $i++) {
        $fecha = clone $desde;
        $fecha->modify("+$i day");

        $numero_dia_semana = $fecha->format('w');
        $numero_mes = $fecha->format('n') - 1;

        // Comprobar si el día debe ser excluido
        if (!in_array($dias_es[$numero_dia_semana], $excluirDias)) {
            $esHabilitado = ($contadorDias < $numeroDeshabilitados) ? 0 : 1;

            $resultado[] = [
                'numero_dia' => $fecha->format('d'),
                'dia_texto' => $dias_es[$numero_dia_semana],
                'mes_texto' => $meses_es[$numero_mes],
                'mes_numero' => $fecha->format('m'),
                'numero_semana' => $fecha->format('W'),
                'anio' => $fecha->format('Y'),
                'habilitado' => $esHabilitado
            ];
            $contadorDias++;
        }
    }

    return $resultado;
}

$fechaInicio = (new DateTime('today'))->modify("+$empezar days");

// Llamar a la función con el parámetro numeroDeshabilitados
$dias = obtenerDias($diasAtras, $diasAdelante, $excluirDias, $numeroDeshabilitados,$fechaInicio->format('Y-m-d'));


for($i=0; $i<count($dias); $i++){
    $array_desc = array("dia"=>$dias[$i]['numero_dia'],"mes"=>$dias[$i]['mes_texto'],"anio"=>$dias[$i]['anio'],"id_usuario"=>$id_user);
    $descubrir = $consulta->getTableDataBusqueda('pedidos', $array_desc);
    if (count($descubrir) === 0) {
        $dias[$i]['id_user'] = $id_user;
        $dias[$i]['plato_principal'] = 'no';
        $dias[$i]['plato_id'] = '';
        $dias[$i]['nombre_plato'] = '';
        $dias[$i]['pedido_id'] = '0';
    }else{
        $dias[$i]['id_user'] = $id_user;
        $dias[$i]['plato_principal'] = 'si'; 
        $dias[$i]['plato_id'] = $descubrir[0]['id_plato'];
        $dias[$i]['nombre_plato'] = $descubrir[0]['plato'];
        $dias[$i]['pedido_id'] = $descubrir[0]['id'];
    }
}

for($i=0; $i<count($dias); $i++){
    $array_desc = array("dia"=>$dias[$i]['numero_dia'],"mes"=>$dias[$i]['mes_texto'],"anio"=>$dias[$i]['anio'],"id_usuario"=>$id_user);
    $descubrir = $consulta->getTableDataBusqueda('pedidos_bebidas', $array_desc);
    if (count($descubrir) === 0) {
        $dias[$i]['bebida'] = 'no';
        $dias[$i]['id_bebida'] = '';
        $dias[$i]['nombre_bebida'] = '';
        $dias[$i]['pedido_bebida_id'] = '0';
    }else{
        $dias[$i]['bebida'] = 'si'; 
        $dias[$i]['id_bebida'] = $descubrir[0]['id_bebida'];
        $dias[$i]['nombre_bebida'] = $descubrir[0]['bebida'];
        $dias[$i]['pedido_bebida_id'] = $descubrir[0]['id'];
    }
}

for($i=0; $i<count($dias); $i++){
    $array_desc = array("dia"=>$dias[$i]['numero_dia'],"mes"=>$dias[$i]['mes_texto'],"anio"=>$dias[$i]['anio'],"id_usuario"=>$id_user);
    $descubrir = $consulta->getTableDataBusqueda('pedidos_postres', $array_desc);
    if (count($descubrir) === 0) {
        $dias[$i]['postre'] = 'no';
        $dias[$i]['postre_id'] = '';
        $dias[$i]['nombre_postre'] = '';
        $dias[$i]['pedido_postre_id'] = '0';
        
    }else{
        $dias[$i]['postre'] = 'si'; 
        $dias[$i]['postre_id'] = $descubrir[0]['id_plato'];
        $dias[$i]['nombre_postre'] = $descubrir[0]['plato'];
        $dias[$i]['pedido_postre_id'] = $descubrir[0]['id'];
    }
}

echo json_encode($dias,JSON_UNESCAPED_UNICODE);


?>