<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

require("class.phpmailer.php");
require("class.smtp.php");

/*
$_POST["nombre"] = 'Rafael';
$_POST["apellido"] = 'Defelice';
$_POST["email"] = 'defelicerafael@gmail.com';
$_POST["celular"] = '114437599';
$_POST["mensaje"] = '114437599';
*/
//print_r($_POST);



if(isset($_POST["nombre"]) && isset($_POST["email"])){

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
"cc:");

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
ValidarDatos($_POST['job']);     
ValidarDatos($_POST['industry']);     
ValidarDatos($_POST['company']);       
ValidarDatos($_POST['acepto']);    

$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$email =  $_POST["email"];
$celular = $_POST["celular"];
$texto = $_POST["mensaje"];

$job = $_POST["job"];
$industry = $_POST["industry"];
$company =  $_POST["company"];
$acepto = $_POST["acepto"];

$smtpHost = "c2162437.ferozo.com";  // Dominio alternativo brindado en el email de alta 
$smtpUsuario = "admin@psicologosenred.ar";  // Mi cuenta de correo
$smtpClave = 'tqe/Pk94vM';  // Mi contraseña



$cuerpo = "Hola, han realizado una consulta v&iacute;a web :) \n\n";
$cuerpo .= "$nombre $apellido se ha contactado por medio de nuestro formulario de contacto. \n\n";
if($email){
    $cuerpo .= "Su email es: ".$email."\n\n";
}
if($celular){
    $cuerpo .= "Celular: ".$celular."\n\n";
}
if($job){
    $cuerpo .= "Es ".$job." en la compañia: ".$company.".  \n De la industria ".$industry."\n\n";
    //$cuerpo .= $_POST;
}
if($acepto == 'true'){
    $cuerpo .= "ACEPTA que le enviemos información \n\n";
}else{
    $cuerpo .= "NO QUIERE que le enviemos información \n\n";
}
$cuerpo .=  "Mensaje: ".$texto."\n\n";
$cuerpo.= " - Eso es todo, que tengas una linda semana! - ";
   
                             
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

$mail->From = 'admin@psicologosenred.ar'; // Email desde donde envío el correo.
$mail->FromName = $nombre;

//$mail->AddAddress('enrique.gb@byontek.com'); 
$mail->AddAddress('defelicerafael@gmail.com');
//$mail->AddAddress('byontekform@gmail.com'); 

$mail->AddReplyTo($email); // Esto es para que al recibir el correo y poner Responder, lo haga a la cuenta del visitante. 
$mail->Subject = "Te han contactado desde la WEB :)"; // Este es el titulo del email.
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
        echo "1";
    } else {
        echo "0";
    }
}          