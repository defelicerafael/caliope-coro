<?php
include_once 'class_sql.php';

// Sanitize inputs
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$que = filter_input(INPUT_GET, 'que', FILTER_SANITIZE_SPECIAL_CHARS);

setlocale(LC_TIME, "es_ES");

// Definir funciones reutilizables para los meses y días
function semanaEsp($dia) {
    $dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes"];
    return $dias[$dia - 1] ?? null;
}

function mesEsp($mes) {
    $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    return $meses[$mes - 1] ?? null;
}

// Obtener fechas relevantes
$dia_hoy = date('d');
$mes_hoy = mesEsp(date('n'));
$anio_hoy = date('Y');
$mes_hoy_en = date('F');

$mesAnterior = date("n", strtotime('-1 month'));
$mesDespues = date("n", strtotime('+1 month'));

$anoAnterior = date("Y", strtotime('-1 year'));
$anoDespues = date("Y", strtotime('+1 year'));

$mesAntesP = mesEsp($mesAnterior);
$mesDespuesP = mesEsp($mesDespues);

// Calcular lunes y viernes relevantes
$primerLunesDespues = date("d", strtotime("third Monday of $mes_hoy_en $anio_hoy"));
$ultimoLunesAnterior = date("d", strtotime("last Monday of $mesAntesP $anoAnterior"));
$primerViernesDespues = date("j", strtotime("first Friday of $mesDespuesP $anoDespues"));

// Funcion para obtener datos de la tabla
function obtenerDatos($sql, $condiciones) {
    return $sql->selectTablaNew('mes', $condiciones, 'dia', 'ASC', '99999');
}

// Switch para manejar los diferentes casos de "que"
$sql = new Sql;
switch ($que) {
    case "todo":
        $select = obtenerDatos($sql, ['mostrar' => 'si']);
        break;

    case "id":
        $select = obtenerDatos($sql, ["id" => $id, "mostrar" => 'si']);
        break;

    case "anio":
        $select = obtenerDatos($sql, ["anio" => $id, "mostrar" => 'si']);
        break;

    case "dia":
        $select = obtenerDatos($sql, ["dia" => $id, "mostrar" => 'si']);
        break;

    case "mes":
        if ($mes_hoy === $id) {
            if ($dia_hoy < 20) {
                // Datos del mes actual y anterior
                $select3 = obtenerDatos($sql, ["mes" => $id, "mostrar" => 'si', "anio" => $anio_hoy]);
                $select2 = obtenerDatos($sql, ["mes" => $mesAntesP, "mostrar" => 'si', "anio" => $anoAnterior]);

                // Filtrar los días del mes anterior
                foreach ($select2 as $key => $valor) {
                    if ($valor['dia'] < $ultimoLunesAnterior && $valor['mes'] === $mesAntesP) {
                        unset($select2[$key]);
                    }
                }

                // Datos del mes siguiente
                $select4 = obtenerDatos($sql, ["mes" => $mesDespuesP, "mostrar" => 'si', "anio" => $anoDespues]);

                // Filtrar los días del mes siguiente
                foreach ($select4 as $key => $valor) {
                    if ($valor['dia'] > $primerViernesDespues && $valor['mes'] === $mesDespuesP) {
                        unset($select4[$key]);
                    }
                }

                // Combinar todos los datos
                $select = array_merge($select2, $select3, $select4);
            } elseif ($dia_hoy >= 20) {
                // Datos del mes actual y siguiente
                $select3 = obtenerDatos($sql, ["mes" => $id, "mostrar" => 'si', "anio" => $anio_hoy]);
                $select2 = obtenerDatos($sql, ["mes" => $mesDespuesP, "mostrar" => 'si', "anio" => $anoDespues]);

                // Filtrar los días del mes actual
                foreach ($select as $key => $valor) {
                    if ($valor['dia'] < $primerLunesDespues && $valor['mes'] === $mes_hoy) {
                        unset($select[$key]);
                    }
                }

                // Ordenar los datos
                usort($select, fn($a, $b) => $a['dia'] <=> $b['dia']);
            }
        }
        break;

    case "fecha":
        $porciones = explode("/", $id);
        if (count($porciones) === 3) {
            $select = obtenerDatos($sql, [
                "dia" => $porciones[0],
                "mes" => $porciones[1],
                "anio" => $porciones[2],
                "mostrar" => 'si'
            ]);
        }
        break;
}

// Ordenar el menú si existe y formatearlo
$cuantos_datos_en_select = count($select ?? []);
for ($i = 0; $i < $cuantos_datos_en_select; $i++) {
    $menuArray = json_decode($select[$i]['menu'], true);
    ksort($menuArray);
    $select[$i]['menu'] = json_encode($menuArray, JSON_UNESCAPED_UNICODE);
}

// Mostrar el resultado en JSON o un array vacío si no hay datos
echo isset($select) && !is_null($select) ? $sql->jsonConverter($select) : "[]";
?>
