<?php
    include_once '../conexion.php';
include_once 'funcionesj.php';

sec_session_start(); // Our custom secure way of starting a PHP session.
$mysqli=conexj();
if (isset($_POST['id_user'], $_POST['password'])) {
   
    $password = $_POST['password']; // The hashed password.
    
    if (login($_POST['id_user'], $password, $mysqli) == true) {
        // Login success 
        $cod=base64_encode($_POST['id_user']);
        header("Location: ../FormDatosBasicos.php?c0d=$cod");
        exit();
    } else {
        // Login failed 
        header('Location: ../formIngreso.php?error=1');
        exit();
    }
} else {
    // The correct POST variables were not sent to this page. 
    header('Location: ../error.php?err=No se puede procesar login');
    exit();
}
?>