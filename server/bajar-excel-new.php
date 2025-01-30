<?php
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Reporte.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private", false);

// Sanitizar los inputs
$tabla = filter_input(INPUT_GET, 'tabla', FILTER_SANITIZE_SPECIAL_CHARS);

include_once 'class_sql.php';

// Consulta a la base de datos
$sql = new Sql;
$select = $sql->excel($tabla);

if (empty($select)) {
    echo "No se encontraron datos.";
    exit;
}

// Si hay resultados, generar la tabla Excel
?>
<table>
    <thead>
        <tr>
            <th><?php echo implode('</th><th>', array_map('htmlentities', array_keys(current($select)))); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($select as $row): ?>
            <tr>
                <td><?php echo implode('</td><td>', array_map('htmlentities', $row)); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
