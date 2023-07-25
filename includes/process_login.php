<?php

include_once 'db_connect.php';
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['id_user'], $_POST['p'])) {
   
    $password = $_POST['p']; // The hashed password.
    
    if (login($_POST['id_user'], $password, $mysqli) == true) {
        // Login success 
        
        header("Location: ../".pag_inicio($_POST['id_user'],$mysqli));
        exit();
    } else {
        // Login failed 
        header('Location: ../index.php?error=1');
        exit();
    }
} else {
    // The correct POST variables were not sent to this page. 
    header('Location: ../error.php?err=No se puede procesar login');
    exit();
}