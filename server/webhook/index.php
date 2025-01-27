
<?php
error_log("===========  POST  ============== ".print_r($_POST, true));
error_log("===========  REQUEST  ============== ".print_r($_REQUEST, true));

$id = $_POST['id'];
$type = $_POST['type'];

$recien = getdate();
$horario = $recien['hours'].":".$recien['minutes'].":".$recien['seconds'];

require __DIR__ .  '../mercado-pago/vendor/autoload.php';
require '../class_sql.php';
require '../contact/class.phpmailer.php';
require '../contact/class.smtp.php';

function visualizarJson($jsonString) {
    $escapedJsonString = addslashes($jsonString);
    $decodedJson = json_decode($escapedJsonString, true);
    print_r($decodedJson);
}

$smtpHost = "c1431505.ferozo.com";  // Dominio alternativo brindado en el email de alta 
$smtpUsuario = "admin@larondaclub.org";  // Mi cuenta de correo
$smtpClave = 'FC9@Ctw2aB';  // Mi contraseña
$agrego_delivery = "";

// TKEN LARONDA//
MercadoPago\SDK::setAccessToken("APP_USR-1393968036747088-121808-4f9d642c7f188b50c01760f56b113c95-1262329897");
    switch($type) {
        case 'payment':
            //echo "entre a payment <br/>";
            $payment = MercadoPago\Payment::find_by_id($id);
            var_dump($payment);
            $status = $payment->status;
            $id_de_referencia = $payment->external_reference;
               
                if($status=='approved'){
                        
                    //---------------------------
                    // Cargo en la base de datos
                    //----------------------------
                    $sql = new Sql;
                    $array['id_mercado_pago'] = $payment_id;
                    $array['status'] = $status;
                    $array['pago'] = "si"; 
                    $array['payment_type'] = $payment_type; 
                       
                    foreach($array as $key=>$dato){
                        $sql->edit('pagos',$key,$dato,"id",$id_de_referencia);
                    }
                    $carro = new Sql;
                    $filtro = array('id'=>$id_de_referencia);
                    $pedido = $carro->selectTablaNew('pedidos',$filtro,'id','ASC',1);

                    if($pedido[0]['email_enviado'] !='si'){   
                        
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
                            $path = '../../'.$usuario_final[0]['ficha_email'];
                        }
                        
                        $carro3= new Sql;
                        for($i=0;$i<$cantidad_de_articulos;$i++){
                            $carro3->edit('articulos','stock',$pedidoweb[$i]['stock'],"id",$pedidoweb[$i]['id']);
                        }
                        

                        

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
                            $precio_intermedio[$i] = $pedidoweb[$i]['cantidad'] * $pedidoweb[$i]['precio'];
                            $cuerpo.= "<b>ARTÍCULO:</b> ".$pedidoweb[$i]['nombre']."\n";
                            $cuerpo.= "<b>CANTIDAD:</b> ".$pedidoweb[$i]['cantidad']."\n";
                            $cuerpo.= "<b>PRECIO: </b> $".$precio_intermedio[$i]."\n\n";
                            $cuerpo.= "<br/>";
                        }
                        $cuerpo .= "\n <b>PRECIO FINAL ".$agrego_delivery." : $".$precio."</b>\n";
                        $cuerpo .= "<hr> \n";
                        $cuerpo .= "Eso es todo, Saludos!";

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
                        $mail->FromName = "La Ronda Club - WEB";
                        $mail->AddAddress("defelicerafael@gmail.com"); 
                        $mail->AddAddress("larondaong@gmail.com"); 
                        //$mail->AddAddress("pedidos@lagran7.com.ar"); 
                                        //$mail->AddAddress($emailMili);
                                        //$mail->AddAddress($emailJuli);// Esta es la dirección a donde enviamos los datos del formulario
                        $mail->AddReplyTo("larondaong@gmail.com"); // Esto es para que al recibir el correo y poner Responder, lo haga a la cuenta del visitante. 
                        $mail->Subject = "Ingresó un PEDIDO!"; // Este es el titulo del email.
                        if (strlen($usuario_final[0]['ficha_email']) >= 3) {    
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
                                $sql = new Sql;
                                $array2['email_enviado'] = "si";
                                foreach($array2 as $key=>$dato){
                                    $sql->edit('pedidos',$key,$dato,"id",$external_reference);
                                }
                                
                            } else {
                                $sql = new Sql;
                                $array2['email_enviado'] = "no";
                                foreach($array2 as $key=>$dato){
                                    $sql->edit('pedidos',$key,$dato,"id",$external_reference);
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
                            $precio_intermedio[$i] = $pedidoweb[$i]['cantidad'] * $pedidoweb[$i]['precio'];
                            $cuerpo2 .= "<b>ARTÍCULO:</b> ".$pedidoweb[$i]['nombre']."\n";
                            $cuerpo2 .= "<b>CANTIDAD:</b> ".$pedidoweb[$i]['cantidad']."\n";
                            $cuerpo2 .= "<b>PRECIO: </b> $".$precio_intermedio[$i]."\n\n";
                            $cuerpo2 .= "<br/>";
                        }

                        $cuerpo2 .= "\n <b>PRECIO FINAL ".$agrego_delivery." : $".$precio."</b>\n";
                        $cuerpo2 .= "<hr> \n";
                        $cuerpo2 .= "<br/><br/>Eso es todo!, Saludos!";

                        //echo $cuerpo2;

                        $mail2 = new PHPMailer(true);
                        $mail2->IsSMTP();
                        //$mail2->SMTPDebug = 2;
                        $mail2->SMTPAuth = true;
                        $mail2->Port = 587; 
                        $mail2->IsHTML(true); 
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
                        
                    }else{
                        $sql = new Sql;
                        $array['id_mercado_pago'] = $id;
                        $array['status'] = $status;
                       
                        foreach($array as $key=>$dato){
                            $sql->edit('pagos',$key,$dato,"id",$id_de_referencia);
                        }
                                $cuerpo3 = "Hola Amigos soy su Ecommece :) \n\n";
                                $cuerpo3 .= "Nos llegó una notificación de Mercado Pago. \n";
                                $cuerpo3 .= "ES DE LA VENTA CON ID DE MERCADO PAGO: ".strtoupper($id)."\n";
                                $cuerpo3 .= "CAMBIO EL ESTADO A: ".strtoupper($status)."\n\n";
                                
                                $cuerpo3 .= "Muchisimas Gracias! :)\n";
                                
                        
                                $mail3 = new PHPMailer(true);
                                $mail3->IsSMTP();
                                $mail3->SMTPAuth = true;
                                $mail3->Port = 587; 
                                $mail3->IsHTML(true); 
                                $mail3->CharSet = "utf-8";

                                $mail3->Host = $smtpHost; 
                                $mail3->Username = $smtpUsuario; 
                                $mail3->Password = $smtpClave;

                                $mail3->From = $smtpUsuario; // Email desde donde envío el correo.
                                $mail3->FromName = 'larondaong@gmail.com';
                                $mail3->AddAddress('larondaong@gmail.com'); 
                                
                                $mail3->AddReplyTo('larondaong@gmail.com'); // Esto es para que al recibir el correo y poner Responder, lo haga a la cuenta del visitante. 
                                $mail3->Subject = 'Webhook de Mercado Pago! :)'; // Este es el titulo del email.
                                $mensaje3 = $cuerpo3;
                                $mensajeHtml3 = nl2br($cuerpo3);
                                $mail3->Body = "{$mensajeHtml3}"; // Texto del email en formato HTML
                                $mail3->AltBody = "{$mensaje3}"; // Texto sin formato HTML
                                                    // FIN - VALORES A MODIFICAR //
                                                    //$mail->SMTPSecure = 'ssl';
                                $mail3->SMTPOptions = array(
                                    'ssl' => array(
                                        'verify_peer' => false,
                                        'verify_peer_name' => false,
                                        'allow_self_signed' => true
                                    )
                                );

                                $estadoEnvio3 = $mail3->Send(); 
                                echo 'HTTP STATUS 200 (OK)';
                                //echo "estoy en otro estatus";
                            

                    }
                

                }
               

        break;
        

        default:
            echo 'HTTP STATUS 200 (OK)'; 
           
    }

    