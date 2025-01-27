<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("class.phpmailer.php");
require("class.smtp.php");

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
ValidarDatos($_POST['celular']); 
ValidarDatos($_POST['mensaje']);

    
$smtpHost = "c1431505.ferozo.com";  // Dominio alternativo brindado en el email de alta 
$smtpUsuario = "admin@larondaclub.org";  // Mi cuenta de correo
$smtpClave = 'FC9@Ctw2aB';  // Mi contraseña

$cuerpo = "Hola, han dejado un mensaje vía Web \n\n";
$cuerpo .= "DATOS DE CONTACTO. \n\n";
$cuerpo .= "Nombre: ".$_POST['nombre']."\n";
$cuerpo .= "Apellido: ".$_POST['apellido']."\n";
$cuerpo .= "Email: ".$_POST['email']."\n";
$cuerpo .= "Celular: ".$_POST['celular']."\n\n";
$cuerpo .= "MENSAJE: \n\n";
$cuerpo .= $_POST['mensaje']."\n\n";

$cuerpo.= " - Eso es todo! - ";

    
                             
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
$mail->FromName = $_POST['nombre'];
$mail->AddAddress("larondaong@gmail.com"); 
                   
$mail->AddReplyTo($_POST['email']); // Esto es para que al recibir el correo y poner Responder, lo haga a la cuenta del visitante. 
$mail->Subject = "Han dejado un mensaje"; // Este es el titulo del email.
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
        echo "1";// CORRECTO
        
    } else {
        echo "0"; // INCORRECTO
    }