<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

require("class.phpmailer.php");
require("class.smtp.php");

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
ValidarDatos($_POST['tipo_de_terapia']);     
ValidarDatos($_POST['modalidad']);     
ValidarDatos($_POST['zona']);  
ValidarDatos($_POST['online']);     
ValidarDatos($_POST['presencial']);     
ValidarDatos($_POST['domicilio']);   
ValidarDatos($_POST['acepto']);    
ValidarDatos($_POST['email_terapeuta']);    

$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$email =  $_POST["email"];
$celular = $_POST["celular"];
$texto = $_POST["mensaje"];
$tipo_de_terapia = $_POST["tipo_de_terapia"];
$modalidad = $_POST["modalidad"];
$zona =  $_POST["zona"];
$online = $_POST["online"];
$presencial = $_POST["presencial"];
$domicilio =  $_POST["domicilio"];

$acepto = $_POST["acepto"];
$email_terapeuta =  $_POST["email_terapeuta"];

$smtpHost = "c2162437.ferozo.com";  // Dominio alternativo brindado en el email de alta 
$smtpUsuario = "admin@psicologosenred.ar";  // Mi cuenta de correo
$smtpClave = 'tqe/Pk94vM';  // Mi contraseña



$cuerpo = "Hola, te ha conctactado desde Psicólogos en Red! \n\n";

$cuerpo .= "Su Nombre: ".$nombre."\n";
$cuerpo .= "Su Apellido: ".$apellido."\n";
$cuerpo .= "Su email: ".$email."\n";

if($celular){
    $cuerpo .= "Su Celular: ".$celular."\n";
}else{
    $cuerpo .= "No nos dejó su Celular\n";
}
$cuerpo .= "El tipo de terapia que le intereza es: $tipo_de_terapia\n";
$cuerpo .= "La modalidad que le intereza es: $modalidad\n";

if($online == 'true'){
    $cuerpo .= "Puede hacer la terapia de forma ONLINE \n";
}
if($presencial == 'true'){
    $cuerpo .= "Puede hacer la terapia de forma PRESENCIAL \n";
    $cuerpo .= "Le conviene en la zona: $zona \n";
}
if($domicilio == 'true'){
    $cuerpo .= "Puede hacer la terapia en su DOMICILIO \n";
    $cuerpo .= "Le conviene en la zona: $zona \n";
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


//$mail->AddAddress('defelicerafael@gmail.com');
$mail->AddAddress($email_terapeuta); 

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