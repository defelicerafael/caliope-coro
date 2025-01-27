<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

require_once "../class_sql.php";

$user = $_POST['user'];
$id_user = $_POST['id'];
$datos = $_POST['datos'];
$precio_envio = $_POST['precio_envio'];

$recien = getdate();
$horario = $recien['hours'].":".$recien['minutes'].":".$recien['seconds'];

$user_j = str_replace("null,", "", $user);
$user_json = json_decode($user_j, true);
$datos_j = str_replace("null,", "", $datos);
$datos_json = json_decode($datos_j, true);

$errores = array(
    'email_1'=>'no',
    'email_2'=>'no'
);
/*
echo "<pre>";
print_r($datos_json);
echo "</pre>";
echo "<pre>";
print_r($user_json);
echo "</pre>";
echo $precio_envio;
*/

// RECOJO LOS DATOS DE POST //
$nombre = $user_json['nombre'];
$apellido = $user_json['apellido'];
$email = $user_json['email'];
$telefono =  $user_json['celular'];
$envio = $user_json['envio'];
$calle = $user_json['calle'];
$calle_num = $user_json['numero'];
$inputPiso = $user_json['departamento'];
$provincia = $user_json['provincia'];
$partido = $user_json['partido'];
$localidad = $user_json['localidad'];
$dni = $user_json['dni'];
$codigo_postal = $user_json['codigopostal'];
$sede = $user_json['sede'];
$precio_envio = "Te lo diremos por email";
$delivery = $precio_envio;

$frase = 'Te contactaremos para arreglar en envío por Andreani.';

$cantidad_de_articulos = count($datos_json);
$preciototal = 0;
//echo $cantidad_de_articulos;
// CUANTOS ARTICULOS
for($i=0;$i<$cantidad_de_articulos;$i++){
    if(empty($datos_json[$i])){
        unset($datos_json[$i]);
    }
    if($datos_json[$i]['cantidad']>0){
      $preciototal+= $datos_json[$i]['precio'] * $datos_json[$i]['cantidad'];
    }

}
$cantidad_de_articulos = count($datos_json);

//PARA INGRESARA  A LA BASE PASO A UN ARRAY
$array['nombre'] = $nombre;
$array['apellido'] = $apellido;
$array['email'] = $email;
$array['celular'] = $telefono;
$array['envio'] = $envio;
$array['calle'] = $calle;
$array['calle_num'] = $calle_num;
$array['departamento'] = $inputPiso;
$array['provincia'] = $provincia;
$array['partido'] = $partido;
$array['localidad'] = $localidad;
$array['dni'] = $dni;
$array['codigopostal'] = $codigo_postal;
$array['pedido'] = $datos_j;
$array['cantidad'] = $cantidad_de_articulos;
$array['horario'] = $horario;
$array['delivery'] = $precio_envio;
$array['pago'] = 'no';
$array['formadepago'] = 'Mercado Pago';
$array['precio'] = $preciototal;
$array['sede'] = $sede;
$array['user_id'] = $id_user;


$sql = new Sql;
$insert = $sql->insert_array_sin_cero('pedidos',$array);
$id_de_referencia = $sql->getlastId('pedidos');

if($sede=='La Ronda Bariloche'){
    //$mail->AddAddress("hydromanopoint@gmail.com"); 
    $frase = 'Retira en: Punto de entrega Bariloche';
}

    require("../contact/class.phpmailer.php");
    require("../contact/class.smtp.php");
    
    
    /*echo "<pre>";
    print_r($pedidoWeb);
    echo "</pre>";*/

    $smtpHost = "c1431505.ferozo.com";  // Dominio alternativo brindado en el email de alta 
    $smtpUsuario = "admin@larondaclub.org";  // Mi cuenta de correo
    $smtpClave = 'FC9@Ctw2aB';  // Mi contraseña
    $agrego_delivery = "";

    $cuerpo = "Hola! Entró un pedido a las $horario de HOY! \n";
    $cuerpo .= "<hr> \n";
    $cuerpo .=  "DATOS DEL CLIENTE\n\n";
    $cuerpo .=  "<b>Nombre y Apellido:</b> ".$nombre." ".$apellido."\n";
    $cuerpo .=  "<b>Email:</b> ".$email."\n";
    $cuerpo .=  "<b>Celular:</b> ".$telefono."\n";
    $cuerpo .=  "<b>Sede:</b> ".$sede."\n";
    if($envio =="enviar"){
        $cuerpo .=  "<b>Direcci&oacute;n:</b> ".$calle." ".$calle_num.", ".$inputPiso.", ".$localidad."\n";
        $cuerpo .=  "<b>Provincia:</b> ".$provincia."\n";
        //$cuerpo .=  "<b>Precio del envío:</b>".$delivery." \n\n";
        $agrego_delivery = "- NO INCLUYE ENVIO A DOMICILIO -";
    }else{
        //$cuerpo .=  $frase."\n";
    }
    $cuerpo .= "<br/><b>EL PEDIDO:</b> \n\n";

    for($i=0;$i<$cantidad_de_articulos;$i++){
     if($datos_json[$i]['cantidad']>'0'){
        $precio_intermedio[$i] = $datos_json[$i]['cantidad'] * $datos_json[$i]['precio'];
        $cuerpo.= "<b>ARTICULO:</b> ".$datos_json[$i]['nombre']."\n";
        $cuerpo.= "<b>CANTIDAD:</b> ".$datos_json[$i]['cantidad']."\n";
        $cuerpo.= "<b>PRECIO: </b> $".$precio_intermedio[$i]."\n\n";
        $cuerpo.= "<br/>";
       }
    }
    $cuerpo .= "\n <b>PRECIO FINAL : $".$preciototal."</b>\n";
    $cuerpo .= "<hr> \n";
    $cuerpo .= "Eso es todo, Saludos!";

    //echo $cuerpo;

    $mail = new PHPMailer(true);
    //$mail->IsSMTP();
    $mail->SMTPDebug = 2;
    $mail->SMTPAuth = true;
    $mail->Port = 587; 
    $mail->IsHTML(true); 
    $mail->CharSet = "utf-8";

    $mail->Host = $smtpHost; 
    $mail->Username = $smtpUsuario; 
    $mail->Password = $smtpClave;

    $mail->From = $smtpUsuario; // Email desde donde envío el correo.
    $mail->FromName = "La Ronda Club - WEB";
    //$mail->AddAddress("defelicerafael@gmail.com"); 
    $mail->AddAddress("larondaong@gmail.com"); 
    
    $mail->AddReplyTo("larondaong@gmail.com"); // Esto es para que al recibir el correo y poner Responder, lo haga a la cuenta del visitante. 
    $mail->Subject = "Ingresó un PEDIDO!"; // Este es el titulo del email.
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
    // SE MANDO EL EMAIL?
    
    $estadoEnvio = $mail->Send(); 
        if($estadoEnvio){

            $array2['email_enviado'] = "si";
            foreach($array2 as $key=>$dato){
                $sql->edit('pedidos',$key,$dato,"id",$id_de_referencia);
            }
            
        } else {
            $errores['email_1'] = 'si';
            $array2['email_enviado'] = "no";
            foreach($array2 as $key=>$dato){
                $sql->edit('pedidos',$key,$dato,"id",$id_de_referencia);
            }
        }
    
    // EMAIL PARA EL CLIENTE //
    $cuerpo2 = "Hola ".$nombre."! Entró tu pedido! \n";
    $cuerpo2 .= "<b><h3>Para finalizar el pago tranferí al Alias: larondaclub y envíanos el comprobante por este medio.</h3></b><br/>";
    $cuerpo2 .= "<hr> \n";
    $cuerpo2 .=  "TUS DATOS:\n\n";
    $cuerpo2 .=  "<b>Nombre y Apellido:</b> ".$nombre." ".$apellido."\n";
    $cuerpo2 .=  "<b>Email:</b> ".$email."\n";
    $cuerpo2 .=  "<b>Celular:</b> ".$telefono."\n";
    $cuerpo2 .=  "<b>Sede:</b> ".$sede."\n";
    if($envio =="enviar"){
        $cuerpo2 .=  "<b>Direcci&oacute;n:</b> ".$calle." ".$calle_num.", ".$inputPiso.", ".$localidad."\n";
        $cuerpo2 .=  "<b>Provincia:</b> ".$provincia."\n";
        //$cuerpo2 .=  "<b>Precio del envío:</b> $".$delivery." \n\n";
        $agrego_delivery = "- NO INCLUYE ENVIO A DOMICILIO -";
    }else{
        $cuerpo2 .=  $frase;
    }
    
    $cuerpo2 .= "<br/><b>EL PEDIDO:</b> \n\n";

    for($i=0;$i<$cantidad_de_articulos;$i++){
      if($datos_json[$i]['cantidad']>'0'){
        $precio_intermedio[$i] = $datos_json[$i]['cantidad'] * $datos_json[$i]['precio'];
        $cuerpo2.= "<b>ARTICULO:</b> ".$datos_json[$i]['nombre']."\n";
        $cuerpo2.= "<b>CANTIDAD:</b> ".$datos_json[$i]['cantidad']."\n";
        $cuerpo2.= "<b>PRECIO: </b> $".$precio_intermedio[$i]."\n\n";
        $cuerpo2 .= "<br/>";
      }
    }

    $cuerpo2 .= "\n <b>PRECIO FINAL : $".$preciototal."</b>\n";
    $cuerpo2 .= "<hr> \n";
    
    $mail2 = new PHPMailer(true);
    //$mail->IsSMTP();
    $mail2->SMTPDebug = 2;
    $mail2->SMTPAuth = true;
    $mail2->Port = 587; 
    $mail2->IsHTML(true); 
    $mail2->CharSet = "utf-8";

    $mail2->Host = $smtpHost; 
    $mail2->Username = $smtpUsuario; 
    $mail2->Password = $smtpClave;

    $mail2->From = $smtpUsuario; // Email desde donde envío el correo.
    $mail2->FromName = "La Ronda Club - WEB";
    $mail2->AddAddress($email); 
    $mail2->AddReplyTo("larondaong@gmail.com"); // Esto es para que al recibir el correo y poner Responder, lo haga a la cuenta del visitante. 
    $mail2->Subject = "Ingresó tu PEDIDO!"; // Este es el titulo del email.
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
    // SE MANDO EL EMAIL?
    $estadoEnvio2 = $mail2->Send();    
    if($estadoEnvio2){
        $array2['envio_email_cliente'] = "si";
        foreach($array2 as $key=>$dato){
            $sql->edit('pedidos',$key,$dato,"id",$id_de_referencia);
        }
        
    } else {
        $errores['email_2'] = 'si';
        $array2['envio_email_cliente'] = "no";
        foreach($array2 as $key=>$dato){
            $sql->edit('pedidos',$key,$dato,"id",$id_de_referencia);
        }
    }
    echo json_encode($errores,JSON_UNESCAPED_UNICODE);
    
?>