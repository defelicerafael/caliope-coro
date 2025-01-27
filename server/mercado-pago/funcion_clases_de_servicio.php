<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$clase = 'Clase de servicio Server';
require_once '../shop/conexion.php';
$sql = "SELECT * FROM articulos WHERE categoria = ? ORDER BY orden ASC";
//echo $sql;
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("s",$clase);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($myrow = $result->fetch_assoc()) {
        $elementos[] = array(
            "nombre"=>$myrow['nombre'],
            "precio"=>$myrow['precio'],
            "categoria"=>$myrow['categoria']
        );
    }
}

/*
echo "<pre>";
print_r($elementos);
echo "<pre/>";
*/
function obtenerClase($precio, $clases) {
    $clase = "";
    foreach ($clases as $claseActual) {
      if ($precio >= $claseActual["precio"]) {
        $clase = $claseActual["nombre"];
        break;
      }
    }
    return $clase;
  }

  //$clase_nombre = obtenerClase('51000', $elementos);
  //echo $clase_nombre;

?>

