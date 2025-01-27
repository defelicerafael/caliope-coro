<?php
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

require_once "../class_sql.php";
require_once "funcion_clases_de_servicio.php";

$recien = getdate();
$horario = $recien['hours'].":".$recien['minutes'].":".$recien['seconds'];

//echo $_POST['activo'];

$user = $_POST['user'];
$id_user = $_POST['id'];
$activo = $_POST['activo'];
$datos = $_POST['datos'];
$precio_envio = $_POST['precio_envio'];

$recien = getdate();
$horario = $recien['hours'].":".$recien['minutes'].":".$recien['seconds'];

$user_j = str_replace("null,", "", $user);
$user_json = json_decode($user_j, true);
$datos_j = str_replace("null,", "", $datos);
$datos_json = json_decode($datos_j, true);


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
$cantidad_de_articulos = count($datos_json);
$precio_envio = "Te lo diremos por email";
$preciototal = 0;
$frase = 'Te contactaremos para arreglar en envío por Andreani.';
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

//$claseElegida = obtenerClase($preciototal, $elementos);

//

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
$array['id_user'] = $id_user;


$sql = new Sql;
$insert = $sql->insert_array_sin_cero('pedidos',$array);
$id_de_referencia = $sql->getlastId('pedidos');

//echo $insert;
//echo "<br/>";
//echo $id_de_referencia;

// FORMATEO LOS DATOS DEL PEDIDO //
for($i=0;$i<$cantidad_de_articulos;$i++){
    $id[$i] = $datos_json[$i]['id'];
    $articulo[$i] = $datos_json[$i]['nombre'];
    $cantidad[$i] = $datos_json[$i]['cantidad'];
    $foto[$i] = $datos_json[$i]['img'];
    $precio[$i] = $datos_json[$i]['precio'];
    $total[$i] = $datos_json[$i]['precio'][0] * $datos_json[$i]['cantidad'];
}

//adherente_beneficiario

if (require __DIR__ .  '/vendor/autoload.php'){
  // echo "estamos con el vendor";
}else{
  // echo "no estamos con el vendor";
}

//credenciales de prueba: TEST-1393968036747088-121808-0ff7eb08e405dab90813ab2f0c7de65f-1262329897
//credenciales produccion APP_USR-1393968036747088-121808-4f9d642c7f188b50c01760f56b113c95-1262329897
MercadoPago\SDK::setAccessToken('APP_USR-1393968036747088-121808-4f9d642c7f188b50c01760f56b113c95-1262329897');
MercadoPago\SDK::setIntegratorId("dev_a0c4acb0b23111eaa3110242ac130004");

$preference = new MercadoPago\Preference();

// acá me fijo si es adherente_beneficiario //

    if($activo=='adherente_beneficiario'){
        $claseElegida = obtenerClase($preciototal, $elementos);
        // es adherente_beneficiario beneficiario, entonces le creo un item yo.
        $item = new MercadoPago\Item();
        $item_id[0] = $id[0];
        $item_nombre[0] = $claseElegida;
        $item_cantidad[0] = 1;
        $item_precio[0] = $preciototal;
        $item_description[0] = "Articulos varios: $claseElegida";
        $item_picture[0] = "https://larondaclub.org/assets/img/logo/Logo_verde.webp";

        $item->id = $item_id[0];
        $item->title = $item_nombre[0];
        $item->quantity = $item_cantidad[0];
        $item->currency_id = "ARS";
        $item->unit_price = $item_precio[0];
        $item->description = $item_description[0];
        $item->picture_url = $item_picture[0];
        
        $pedidos [] = $item;

    }else{
        // no es adherente_beneficiario beneficiario, entonces recorro el array...
        for ($i=0;$i<$cantidad_de_articulos;$i++){
            
            $item = new MercadoPago\Item();
            
            $item_id[$i] = $id[$i];
            $item_nombre[$i] = $articulo[$i];
            $item_cantidad[$i] = $cantidad[$i];
            $item_precio[$i] = $precio[$i];
            $item_description[$i] = "";
            $item_picture[$i] = "https://larondaclub.org/".$foto[$i];
        
            $item->id = $item_id[$i];
            $item->title = $item_nombre[$i];
            $item->quantity = $item_cantidad[$i];
            $item->currency_id = "ARS";
            $item->unit_price = $item_precio[$i];
            $item->description = $item_description[$i];
            $item->picture_url = $item_picture[$i];
            
            $pedidos [] = $item;
        }
    }



    // AGREGO EL DELIVERY
    if($envio =='enviar'){
        $item = new MercadoPago\Item();
        $item->id = 'Delivery';
        $item->title = 'Envio a Domicilio por Andreani';
        $item->quantity = 1;
        $item->currency_id = "ARS";
        $item->unit_price = $precio_envio;
        $item->description = "Envio a domicilio";

        $pedidos [] = $item;
    }

    $preference->items = $pedidos;

    $payer = new MercadoPago\Payer();
    $payer->name = $nombre; //$nombre
    $payer->surname = $apellido;
    $payer->email = $email;
    $cod_area = "";
    $payer->phone = array(
        "area_code" => $cod_area,
        "number" => $telefono
    );
    $cp = $codigo_postal;
    if($envio == 'casa'){
        $calle = "victoria, buenos aires";
        $calle_num = "2350";
    }
    
    $payer->address = array(
        "street_name" => $calle,
        "street_number" => $calle_num,
        "zip_code" => $cp
    );
    $preference->payer = $payer;
    $preference->external_reference = $id_de_referencia;
    
    $preference->back_urls = array(
        "success" => "https://larondaclub.org/server/mercado-pago/success.php",
        "failure" => "https://larondaclub.org/server/mercado-pago/failure.php",
        "pending" => "https://larondaclub.org/server/mercado-pago/pending.php"
    );
    $preference->auto_return = "approved";
    $preference->notification_url = "https://larondaclub.org/webhook/index.php";
    
    $preference->save();
    $link_mp = $preference->init_point;
    echo json_encode($link_mp,JSON_UNESCAPED_UNICODE);
   

?>

