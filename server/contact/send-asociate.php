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
ValidarDatos($_POST['dni']);

ValidarDatos($_POST['reprocann']);
ValidarDatos($_POST['codigo_vinculacion']);
ValidarDatos($_POST['fechareprocann']);
   
ValidarDatos($_POST['codigopostal']);
ValidarDatos($_POST['calle']);
ValidarDatos($_POST['numero']);
ValidarDatos($_POST['departamento']);    
ValidarDatos($_POST['provincia']);
ValidarDatos($_POST['localidad']);    
    
    
$smtpHost = "c1431505.ferozo.com";  // Dominio alternativo brindado en el email de alta 
$smtpUsuario = "admin@larondaclub.org";  // Mi cuenta de correo
$smtpClave = 'FC9@Ctw2aB';  // Mi contraseña

$cuerpo = "Hola, han representado una solicitud de Asociado \n\n";
$cuerpo .= "DATOS DE CONTACTO. \n\n";
$cuerpo .= "Nombre: ".$_POST['nombre']."\n";
$cuerpo .= "Apellido: ".$_POST['apellido']."\n";
$cuerpo .= "Email: ".$_POST['email']."\n";
$cuerpo .= "Celular: ".$_POST['celular']."\n";
$cuerpo .= "Dni: ".$_POST['dni']."\n\n";
$cuerpo .= "REPROCANN. \n\n";
$cuerpo .= "Tiene Reprecann: ".$_POST['reprocann']."\n";
$cuerpo .= "Código de Vinvulación: ".$_POST['codigo_vinculacion']."\n";
$cuerpo .= "Fecha de vencimiento: ".$_POST['fechareprocann']."\n\n";
$cuerpo .= "DOMICILIO. \n\n";
$cuerpo .= "Provincia: ".$_POST['provincia']."\n";
$cuerpo .= "Localidad: ".$_POST['localidad']."\n";
$cuerpo .= "Calle: ".$_POST['calle']."\n";
$cuerpo .= "Número: ".$_POST['numero']."\n";
$cuerpo .= "Departamento: ".$_POST['departamento']."\n";
$cuerpo .= "Código postal: ".$_POST['codigopostal']."\n";

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
$mail->FromName = "socios@larondaclub.org";
$mail->AddAddress("socios@larondaclub.org"); 
                   
$mail->AddReplyTo($_POST['email']); // Esto es para que al recibir el correo y poner Responder, lo haga a la cuenta del visitante. 
$mail->Subject = "Han solicitado Asociarse"; // Este es el titulo del email.
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
        echo "0";
        
    } else {
        echo "1";
    }
        