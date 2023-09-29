<?php


include_once 'psl-config.php';   // Needed because functions.php is not included

$mysqli = new mysqli(HOSTU, USERU, PASSWORDU, DATABASEU);

if ($mysqli->connect_error) {
    header("Location: ../error.php?err=Unable to connect to MySQL");
    exit();
}