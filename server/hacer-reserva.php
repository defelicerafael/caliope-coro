<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

require("contact/class.phpmailer.php");
require("contact/class.smtp.php");
require_once 'conexion.php';

header("Content-Type: text/html;charset=utf-8");
// CORS
if($actual_link==='localhost'){
    header("Access-Control-Allow-Origin: $localhost");
}else{
    header("Access-Control-Allow-Origin: $server");
}
header("Access-Control-Allow-Methods: GET");


$nombre = filter_input(INPUT_GET, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
$apellido = filter_input(INPUT_GET, 'apellido', FILTER_SANITIZE_SPECIAL_CHARS);
$celular = filter_input(INPUT_GET, 'celular', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
$id_evento = filter_input(INPUT_GET, 'id_evento', FILTER_SANITIZE_SPECIAL_CHARS);
$comensales = filter_input(INPUT_GET, 'comensales', FILTER_SANITIZE_SPECIAL_CHARS);
$evento = filter_input(INPUT_GET, 'evento', FILTER_SANITIZE_SPECIAL_CHARS);

$fecha = date("Y-m-d H:i:s");
$precio = 0;

$sql = "INSERT INTO reservas (id,nombre,apellido,celular,email,fecha,precio,comensales,evento,id_evento) 
VALUES (NULL,?,?,?,?,?,?,?,?,?)";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sssssiisi",$nombre,$apellido,$celular,$email,$fecha,$precio,$comensales,$evento,$id_evento);
$stmt->execute();
//printf($stmt->errno);

$anotadosAntes = 0;

$sql_traerEventos = "SELECT anotados FROM eventos WHERE id = ?";
$stmt = $mysqli->prepare($sql_traerEventos);
$stmt->bind_param("i",$id_evento);
$stmt->execute();
$result = $stmt->get_result();
while ($myrow = $result->fetch_assoc()) {
    $anotadosAntes  = $myrow['anotados'];
}
$total_Anotados = $anotadosAntes + $comensales;

$sql_eventos = "UPDATE eventos SET anotados = ? WHERE id = ?";
//echo $sql_eventos;
$stmt = $mysqli->prepare($sql_eventos);
$stmt->bind_param("ii",$total_Anotados,$id_evento);
$stmt->execute();

$eventoSql = "SELECT * FROM eventos WHERE id = ? ORDER BY id ASC";

if ($stmt = $mysqli->prepare($eventoSql)) {
    $stmt->bind_param("i",$id_evento);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($myrow = $result->fetch_assoc()) {
        $ranking = 0;
        $eventos = array(
            "id"=>$myrow['id'],
            "titulo"=>$myrow['titulo'],
            "fecha"=>$myrow['fecha'],
            "horario"=>$myrow['horario'],
            "precio"=>$myrow['precio'],
        );
    }
}
$diassemana = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
//secho $diassemana[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
//Salida: Miercoles 05 de Septiembre del 2016
$date = date_create($eventos['fecha']);
$fecha_evento = $diassemana[date_format($date, 'w')]." ".date_format($date, 'd')." de ".$meses[date_format($date, 'n')-1];

$stmt->close();
$mysqli->close();


$smtpHost = "c1781579.ferozo.com";  // Dominio alternativo brindado en el email de alta 
$smtpUsuario = "info@espacioanima.com.ar";  // Mi cuenta de correo
$smtpClave = 'estoEsEspacio4nima';  // Mi contraseña

$cuerpo = "Hola, han realizado una Reserva v&iacute;a web :) \n\n";
$cuerpo .=  $eventos['titulo']."\n";
$cuerpo .= "ID de la Experiencia es: ".$id_evento."\n";
$cuerpo .= "Fecha : ".$fecha_evento."\n\n";
$cuerpo .= "Nombre: ".$nombre."\n";
$cuerpo .= "Apellido: ".$apellido."\n";
$cuerpo .= "Email: ".$email."\n";
$cuerpo .= "Celular: ".$celular."\n";
$cuerpo .= "Reserva para: ".$comensales." persona/s. \n\n";
$cuerpo.= " - Eso es todo, que tengan una linda semana! - ";

$cuerpo2 = "Hola, ".$nombre.". Hemos recibido tu reserva correctamente.\n\n";
$cuerpo2 .= "Nombre de la experiencia: ".$eventos['titulo']."\n";
$cuerpo2 .= "Fecha :".$fecha_evento."\n";
$cuerpo2 .= "Comienza a las: ".$eventos['horario']."\n";
$cuerpo2 .= "El precio por persona es de: $".$eventos['precio']."\n\n";

$cuerpo2 .= "TUS DATOS:\n";
$cuerpo2 .= "Nombre: ".$nombre."\n";
$cuerpo2 .= "Apellido: ".$apellido."\n";
$cuerpo2 .= "Email: ".$email."\n";
$cuerpo2 .= "Celular: ".$celular."\n";
$cuerpo2 .= "Reserva para: ".$comensales." persona/s. \n\n";
$cuerpo2 .= " - Eso es todo, que tengas una linda semana! - ";
                            
$mail = new PHPMailer(true);
$mail->IsSMTP();
//$mail->SMTPDebug = 2;
$mail->SMTPAuth = true;
$mail->Port = 587; 
$mail->IsHTML(true); 
$mail->CharSet = "utf-8";

$mail->Host = $smtpHost; 
$mail->Username = $smtpUsuario; 
$mail->Password = $smtpClave;

$mail->From = $smtpUsuario; // Email desde donde envío el correo.
$mail->FromName = $nombre;
$mail->AddAddress("reservas@espacioanima.com.ar"); 
$mail->AddReplyTo("reservas@espacioanima.com.ar"); // Esto es para que al recibir el correo y poner Responder, lo haga a la cuenta del visitante. 
$mail->Subject = "Han realizado una Reserva web"; // Este es el titulo del email.
$mensaje = $cuerpo;
$mensajeHtml = nl2br($cuerpo);
$mail->Body = "{$mensajeHtml}"; // Texto del email en formato HTML
$mail->AltBody = "{$mensaje}"; // Texto sin formato HTML
                    // FIN - VALORES A MODIFICAR //
                    //$mail->SMTPSecure = 'ssl';
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

$mail2 = new PHPMailer(true);
$mail2->IsSMTP();
//$mail->SMTPDebug = 2;
$mail2->SMTPAuth = true;
$mail2->Port = 587; 
$mail2->IsHTML(true); 
$mail2->CharSet = "utf-8";

$mail2->Host = $smtpHost; 
$mail2->Username = $smtpUsuario; 
$mail2->Password = $smtpClave;

$mail2->From = $smtpUsuario; // Email desde donde envío el correo.
$mail2->FromName = "Reservas - Espacio Ánima";
$mail2->AddAddress($email); 
$mail2->AddReplyTo("reservas@espacioanima.com.ar"); // Esto es para que al recibir el correo y poner Responder, lo haga a la cuenta del visitante. 
$mail2->Subject = "Hemos recibido tu reserva."; // Este es el titulo del email.
$mensaje2 = $cuerpo2;
$mensajeHtml2 = nl2br($cuerpo2);
$mail2->Body = "{$mensajeHtml2}"; // Texto del email en formato HTML
$mail2->AltBody = "{$mensaje2}"; // Texto sin formato HTML
                    // FIN - VALORES A MODIFICAR //
                    //$mail->SMTPSecure = 'ssl';
$mail2->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$estadoEnvio = $mail->Send(); 
$estadoEnvio2 = $mail2->Send(); 
if(($estadoEnvio)&&($estadoEnvio2)){
    echo 1;
} else {
    echo 0;
}
  

