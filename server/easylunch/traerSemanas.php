<?php
function obtenerSemanas($semanasAtras, $semanasAdelante, $desde = null) {
    // La fecha de inicio será hoy
    $desde = $desde ? new DateTime($desde) : new DateTime('today');

    // Para obtener la fecha de ayer
    $ayer = clone $desde;
    $ayer->modify('-1 day');

    $resultado = [];

    // Arrays con los nombres de los días y meses en español
    $dias_es = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
    $meses_es = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

    // Obtener semanas hacia atrás
    for ($i = $semanasAtras; $i > 0; $i--) {
        for ($dia = 6; $dia >= 0; $dia--) {
            // Clonar la fecha de ayer para evitar modificar el original
            $fecha = clone $ayer;
            $fecha->modify("-$i week -$dia day");

            $numero_dia_semana = $fecha->format('w');
            $numero_mes = $fecha->format('n') - 1;

            $resultado[] = [
                'numero_dia' => $fecha->format('d'),
                'dia_texto' => $dias_es[$numero_dia_semana],
                'mes_texto' => $meses_es[$numero_mes],
                'mes_numero' => $fecha->format('m'),
                'numero_semana' => $fecha->format('W'),
                'anio' => $fecha->format('Y')
            ];
        }
    }

    // Agregar hoy solo si $semanasAdelante es mayor a 0
    if ($semanasAdelante > 0) {
        $numero_dia_semana = $desde->format('w');
        $numero_mes = $desde->format('n') - 1;

        $resultado[] = [
            'numero_dia' => $desde->format('d'),
            'dia_texto' => $dias_es[$numero_dia_semana],
            'mes_texto' => $meses_es[$numero_mes],
            'mes_numero' => $desde->format('m'),
            'numero_semana' => $desde->format('W'),
            'anio' => $desde->format('Y')
        ];
    }

    // Obtener semanas hacia adelante, pero omitir hoy si ya lo agregamos
    for ($i = 0; $i < $semanasAdelante; $i++) {
        // Para la primera semana, comenzamos en el día después de hoy
        $dia_inicio = ($i == 0) ? 1 : 0;

        for ($dia = $dia_inicio; $dia < 7; $dia++) {
            $fecha = clone $desde;
            $fecha->modify("+$i week +$dia day");

            $numero_dia_semana = $fecha->format('w');
            $numero_mes = $fecha->format('n') - 1;

            $resultado[] = [
                'numero_dia' => $fecha->format('d'),
                'dia_texto' => $dias_es[$numero_dia_semana],
                'mes_texto' => $meses_es[$numero_mes],
                'mes_numero' => $fecha->format('m'),
                'numero_semana' => $fecha->format('W'),
                'anio' => $fecha->format('Y')
            ];
        }
    }

    return $resultado;
}

// Llamar a la función, por ejemplo, para obtener 0 semanas hacia atrás y 1 hacia adelante
$semanas = obtenerSemanas(1, 1);

// Imprimir los resultados
echo "<pre>";
print_r($semanas);
echo "</pre>";
?>