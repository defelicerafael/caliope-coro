<?php
error_reporting(E_ALL);
$actual_link = $_SERVER['HTTP_HOST'];
$localhost = "http://$actual_link:4200";
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $server  = "https://".$_SERVER['HTTP_HOST'];
} else {
    $server  = "http://".$_SERVER['HTTP_HOST'];
}

if($actual_link==='localhost'){
    header("Access-Control-Allow-Origin: $localhost");
}else{
    header("Access-Control-Allow-Origin: $server");
}
header("Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control,X-Mx-ReqToken,Keep-Alive,X-Requested-With,If-Modified-Since");
header('Access-Control-Allow-Methods: GET, POST, PUT');

$dir = filter_input(INPUT_GET, 'dir', FILTER_SANITIZE_SPECIAL_CHARS);
//echo $dir;

$directorio = $dir;
$ficheros1  = scandir($directorio);
$outp = "";
foreach($ficheros1 as $f){
    if (($f!==".")&&($f!=="..")){
        if ($outp != "") {$outp .= ",";}
            $outp .= '{"img":"'  . $f. '"}';
    }
}
$outp ='['.$outp.']';
echo($outp);


