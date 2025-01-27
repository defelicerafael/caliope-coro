<?php
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $direccion  = "https://".$_SERVER['HTTP_HOST'];
} else {
    $direccion  = "http://".$_SERVER['HTTP_HOST'];
}

if($_SERVER['HTTP_HOST']==='localhost'){
    header("Access-Control-Allow-Origin: http://localhost:4200");
}else{
    header("Access-Control-Allow-Origin: $direccion");
}
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include_once '../class_sql.php';

require("class.phpmailer.php");
require("class.smtp.php");

$n=10;
/*
$_POST['nombre'] = "Rafael";
$_POST['email'] = "defelicerafael@gmail.com";
$_POST['id'] = "2";
*/

function getRandomString($n) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#*@';
    $randomString = '';
  
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
  
    return $randomString;
}
  
$pass = getRandomString($n);

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
ValidarDatos($_POST['email']);

$link = "https://larondaclub.org/socios/login";

    
$smtpHost = "c1431505.ferozo.com";  // Dominio alternativo brindado en el email de alta 
$smtpUsuario = "admin@larondaclub.org";  // Mi cuenta de correo
$smtpClave = 'FC9@Ctw2aB';  // Mi contraseña


$cuerpo = "Hola, ".$_POST['nombre']." ¿Cómo estás?\n";
$cuerpo .= "Ya sos parte de la comunidad La Ronda\n Ahora podes loguearte en nuestra web, te dejamos tu usuario y password: 
\n\n";
$cuerpo .= "Usuario: ".$_POST['email']."\n";
$cuerpo .= "Password: ".$pass."\n\n";
$cuerpo .= "¿Quieres loguearte ahora? Aquí te dejamos el link: <a href='".$link."' alt='logueate como socio'>LogIn</a> \n\n";
$cuerpo .= "Una vez logueado encontraras alli todas las novedades sobre nuestros cursos, talleres y productos a los que vas a poder acceder.\n\n";

$cuerpo.= " - Eso es todo! Saludos! - ";

//echo $cuerpo;    
                             
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
$mail->FromName = 'Socios -  La Ronda';
$mail->AddAddress($_POST['email']); 
                   
$mail->AddReplyTo("larondaong@gmail.com"); // Esto es para que al recibir el correo y poner Responder, lo haga a la cuenta del visitante. 
$mail->Subject = "Ya podes loguearte en nuestra WEB"; // Este es el titulo del email.
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
        $ccsi = new Sql;
        $ccsi->edit('asociados','pass',$pass,'id',$_POST['id']);
        $ccsi->edit('asociados','usuario','si','id',$_POST['id']);
        
        echo "0";
        
    } else {
        echo "1";
    }
        