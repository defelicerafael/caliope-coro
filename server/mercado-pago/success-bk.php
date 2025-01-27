<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("../contact/class.phpmailer.php");
require("../contact/class.smtp.php");

    $collection_id = $_GET['collection_id'];
    $collection_status = $_GET['collection_status'];
    $payment_id = $_GET['payment_id'];
    $status = $_GET['status'];
    $external_reference = $_GET['external_reference'];
    $payment_type = $_GET['payment_type'];
    $preference_id = $_GET['preference_id'];
    $site_id = $_GET['site_id'];
    $processing_mode = $_GET['processing_mode'];
    $merchant_order_id = $_GET['comerciante_order_id'];
    $merchant_account_id = $_GET['merchant_account_id'];
 
    //HORARIO
    $recien = getdate();
    $horario = $recien['hours'].":".$recien['minutes'].":".$recien['seconds'];

    require("../class_sql.php");

    $sql = new Sql;
    $array['id_mercado_pago'] = $payment_id;
    $array['status'] = $status;
    $array['pago'] = "si"; 
    $array['payment_type'] = $payment_type; 

    

    foreach($array as $key=>$dato){
        $sql->edit('pedidos',$key,$dato,"id",$external_reference);
    }

    if($collection_status!='approved'){
        exit();
    }

    
    
    function visualizarJson($jsonString) {
        // Escapar las comillas dobles dentro de la cadena JSON
        $escapedJsonString = addslashes($jsonString);
    
        // Decodificar la cadena JSON
        $decodedJson = json_decode($escapedJsonString, true);
    
        // Imprimir la cadena decodificada
        print_r($decodedJson);
    }

    $external_reference = '20';

    $carro = new Sql;
    $filtro = array('id'=>$external_reference);
    $pedido = $carro->selectTablaNew('pedidos',$filtro,'id','ASC',1);
    
    $email = $pedido[0]['email'];
    $apellido = $pedido[0]['apellido'];
    $nombre= $pedido[0]['nombre'];
    $telefono = $pedido[0]['celular'];
    $calle = $pedido[0]['calle'];
    $calle_num = $pedido[0]['calle_num'];
    $barrio = $pedido[0]['localidad'];
    $inputPiso = $pedido[0]['departamento'];
    $pedidoweb = json_decode($pedido[0]['pedido'], true);
    $envio = $pedido[0]['envio'];
    $delivery = $pedido[0]['delivery'];
    $precio = $pedido[0]['precio'];
    /* ACA PONGO LA URL DE LA FICHA */
    
    $user_id = $pedido[0]['id_user'];

    $cantidad_de_articulos = count($pedidoweb);
    
    //echo $cantidad_de_articulos;
    
    $carro2 = new Sql;
    $usuario_final = $carro2->selectTablaNew('asociados',array('id'=>$user_id),'id','ASC',1);

    if (strlen($usuario_final[0]['ficha_email']) >= 3) {
        //echo $usuario_final[0]['ficha_email'];
        //echo "llegue hasta aca... es mayor que  letras...";
        $path = '../../'.$usuario_final[0]['ficha_email'];
    }
    
    
    /*echo "<pre>";
    print_r($pedidoweb);
    echo "</pre>";*/
    
   


    $smtpHost = "c1431505.ferozo.com";  // Dominio alternativo brindado en el email de alta 
    $smtpUsuario = "admin@larondaclub.org";  // Mi cuenta de correo
    $smtpClave = 'FC9@Ctw2aB';  // Mi contraseña
    $agrego_delivery = "";

    $cuerpo = "Hola! Entró un pedido a las $horario de HOY! \n";
    $cuerpo .= "<b>SE PAGO CON MERCADO PAGO! ID: ".$collection_id."</b>  \n";
    $cuerpo .= "<hr> \n";
    $cuerpo .=  "DATOS DEL CLIENTE\n\n";
    $cuerpo .=  "<b>Nombre y Apellido:</b> ".$nombre." ".$apellido."\n";
    $cuerpo .=  "<b>Email:</b> ".$email."\n";
    $cuerpo .=  "<b>Celular:</b> ".$telefono."\n";
    if($envio =="enviar"){
        $cuerpo .=  "<b>Direcci&oacute;n:</b> ".$calle." ".$calle_num.", ".$inputPiso.", ".$barrio."\n";
        //$cuerpo .=  "<b>Precio del envío:</b> $".$delivery." \n\n";
        $agrego_delivery = "- No Incluye envio -";
    }else{
        $cuerpo .=  "No Incluye envio \n";
    }
    $cuerpo .= "<b>EL PEDIDO:</b> \n\n";

    for($i=0;$i<$cantidad_de_articulos;$i++){
        $cuerpo.= "<b>ARTÍCULO:</b> ".$pedidoweb[$i]['nombre']."\n";
        $cuerpo.= "<b>CANTIDAD:</b> ".$pedidoweb[$i]['cantidad']."\n";
        $cuerpo.= "<b>PRECIO: </b> $".$pedidoweb[$i]['precio']."\n\n";
        $cuerpo.= "<br/>";
    }
    $cuerpo .= "\n <b>PRECIO FINAL ".$agrego_delivery." : $".$precio."</b>\n";
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
    $mail->AddAddress("defelicerafael@gmail.com"); 
    //$mail->AddAddress("larondaong@gmail.com"); 
    //$mail->AddAddress("pedidos@lagran7.com.ar"); 
                    //$mail->AddAddress($emailMili);
                    //$mail->AddAddress($emailJuli);// Esta es la dirección a donde enviamos los datos del formulario
    $mail->AddReplyTo("larondaong@gmail.com"); // Esto es para que al recibir el correo y poner Responder, lo haga a la cuenta del visitante. 
    $mail->Subject = "Ingresó un PEDIDO!"; // Este es el titulo del email.
    
    if (strlen($usuario_final[0]['ficha_email']) >= 3) {    
        $path = '../../'.$usuario_final[0]['ficha_email'];
        $mail->AddAttachment($path, $nombre);
    }

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
            $array2['email_enviado'] = "no";
            foreach($array2 as $key=>$dato){
                $sql->edit('pedidos',$key,$dato,"id",$id_de_referencia);
            }
        }
    
    // EMAIL PARA EL CLIENTE //
    $cuerpo2 = "Hola ".$nombre."! Entró tu pedido! \n";
    $cuerpo2 .= "<b>SE PAGO CON MERCADO PAGO! ID: ".$collection_id."</b>  \n";
    
    $cuerpo2 .= "<hr> \n";
    $cuerpo2 .=  "TUS DATOS:\n\n";
    $cuerpo2 .=  "<b>Nombre y Apellido:</b> ".$nombre." ".$apellido."\n";
    $cuerpo2 .=  "<b>Email:</b> ".$email."\n";
    $cuerpo2 .=  "<b>Celular:</b> ".$telefono."\n";
    
    if($envio =="enviar"){
        $cuerpo2 .=  "<b>Direcci&oacute;n:</b> ".$calle." ".$calle_num.", ".$inputPiso.", ".$barrio."\n";
        //$cuerpo2 .=  "<b>Precio del envío:</b> $".$delivery." \n\n";
        $agrego_delivery = "- NO INCLUYE ENVIO -";
    }else{
        $cuerpo2 .=  "- NO INCLUYE ENVIO -  \n";
    }
    
    $cuerpo2 .= "<b>EL PEDIDO:</b> \n\n";

    for($i=0;$i<$cantidad_de_articulos;$i++){
        $cuerpo2 .= "<b>ARTÍCULO:</b> ".$pedidoweb[$i]['nombre']."\n";
        $cuerpo2 .= "<b>CANTIDAD:</b> ".$pedidoweb[$i]['cantidad']."\n";
        $cuerpo2 .= "<b>PRECIO: </b> $".$pedidoweb[$i]['precio']."\n\n";
        $cuerpo2 .= "<br/>";
    }

    $cuerpo2 .= "\n <b>PRECIO FINAL ".$agrego_delivery." : $".$precio."</b>\n";
    $cuerpo2 .= "<hr> \n";
    $cuerpo2 .= "<br/><br/>Eso es todo!, Saludos!";
    $mail2 = new PHPMailer(true);
    //$mail->IsSMTP();
    $mail2->SMTPDebug = 2;
    $mail2->SMTPAuth = true;
    $mail2->Port = 587; 
    $mail2->IsHTML(true); 
    //$mail2->AddAttachment($path, $nombre); //Adds an attachment from a path on the filesystem
    $mail2->CharSet = "utf-8";

    $mail2->Host = $smtpHost; 
    $mail2->Username = $smtpUsuario; 
    $mail2->Password = $smtpClave;

    $mail2->From = $smtpUsuario; // Email desde donde envío el correo.
    $mail2->FromName = "La Ronda CLub - WEB";
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
    unlink($path);
    
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
        <script src="https://www.mercadopago.com/v2/security.js" view="home"></script>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
        
        <meta name="description" content="">
    
        <meta property="og:url"           content="" />
        <meta property="og:type"          content="website" />
        <meta property="og:title"         content="" />
        <meta property="og:description"   content="" />
        <meta property="og:image"         content="" />
    </head>
    <body>
        <div class="mt-md-5 mt-5 pt-5 text-center roboto-black"><h3 class="mt-5 pt-2">Hola <?php echo $nombre;?></h3></div>
        <h3 class="mt-md-3 mt-4 pt-3 text-center roboto-black">SU PAGO HA SIDO ACREDITADO!</h3>
        <h6 class="mt-md-1 mt-1 text-center p-3 roboto-bold">PROCEDEREMOS A INICIAR EL PEDIDO!</h6>
        <h6 class="mt-md-1 mt-1 text-center p-3 roboto-bold"><a href="https://larondaclub.org/tienda">VOLVER</a></h6>
        <script>
            sessionStorage.clear();
        <script> 
    </body>
</html>    
