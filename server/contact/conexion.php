<?php
$mysqli = new mysqli("localhost", "c1992079_email", "pumino88MO", "c1992079_email");
mysqli_set_charset($mysqli ,"utf8");


    $sql = "INSERT INTO emails ('id,nombre', 'apellido', 'email', 'celular', 'que', 'a_quien') 
        VALUES (null,'$nombre', '$apellido', '$email', '$celular', '$que','info@fincasur.com.ar')";



if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("ss",$user,$pass);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($myrow = $result->fetch_assoc()) {
        $user = array(
            "user"=>$myrow['user'],
        );
    }
}

$stmt->close();
