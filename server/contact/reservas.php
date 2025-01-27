<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("class.phpmailer.php");
require("class.smtp.php");

/*
$nombre = "Rafael";
$email = "defelicerafael@gmail.com";
$telefono = "1144370599";
$comentario = "Prueba";

*/

if(isset($_POST["nombre"]) && isset($_POST["apellido"])&& isset($_POST["email"]) && isset($_POST["comensales"]) && isset($_POST["telefono"])&& isset($_POST["evento"]) ){

function ValidarDatos($campo){
//Array con las posibles cabeceras a utilizar por un spammer
    $badHeads = array("Content-Type:",
        "MIME-Version:",
        "Content-Transfer-Encoding:",
        "Return-path:",
        "Subject:",
        "From:",
        "Envelope-to:",
        "To:",
        "bcc:",
        "cc:"
    );

    foreach($badHeads as $valor){
        if(strpos(strtolower($campo), strtolower($valor)) !== false){
            header( "HTTP/1.0 403 Forbidden");
            exit;
        }
    }
}
//Ejemplo de llamadas a la funcion
ValidarDatos($_POST['nombre']);
ValidarDatos($_POST['apellido']);
ValidarDatos($_POST['email']);
ValidarDatos($_POST['comensales']);    
ValidarDatos($_POST['telefono']);    
ValidarDatos($_POST['evento']);   
    
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$email =  $_POST["email"];
$telefono = $_POST["telefono"];
$comensales = $_POST["comensales"];
$evento = $_POST["evento"];
    
$smtpHost = "c1781579.ferozo.com";  // Dominio alternativo brindado en el email de alta 
$smtpUsuario = "info@espacioanima.com.ar";  // Mi cuenta de correo
$smtpClave = 'estoEsEspacio4nima';  // Mi contraseña

$cuerpo = "Hola, han realizado una Reserva v&iacute;a web :) \n\n";
$cuerpo .= "Nombre: ".$nombre."\n";
$cuerpo .= "Apellido: ".$apellido."\n";
$cuerpo .= "Email: ".$email."\n";
$cuerpo .= "Tel&eacute;fono: ".$telefono."\n";
$cuerpo .= "Reserva para: ".$comensales." persona/s. \n";
$cuerpo.= " - Eso es todo, que tengan una linda semana! - ";

                             
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

$estadoEnvio = $mail->Send(); 
    if($estadoEnvio){
        echo 1;
    } else {
        echo 0;
    }
}          