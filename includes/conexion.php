<?php
    include_once 'config.php'; 

	function conexu()
	{
		$conexionu = mysqli_connect(HOST, USER, PASSWORD, DATABASE) or die("Ha sucedido un error inesperado en la conexion de la base de datos");
		return $conexionu;
	}
	
    $conexion = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    
    /* check connection */
    if (mysqli_connect_errno()) {
        printf("Fallo en la conexión al servidor: %s\n", mysqli_connect_error());
        exit();
    }
	
	function conexj()
	{
		$conexionj = mysqli_connect(HOST, USER, PASSWORD, DATABASEJ) or die("Ha sucedido un error inesperado en la conexion de la base de datos");
		return $conexionj;
	}
	function conexp()
	{
		$conexionp = mysqli_connect(HOST, USER, PASSWORD, DATABASEP) or die("Ha sucedido un error inexperado en la conexion de la base de datos");
		return $conexionp;
	}
	$conexionj = mysqli_connect(HOST, USER, PASSWORD, DATABASEJ);
    $conexionp = mysqli_connect(HOST, USER, PASSWORD, DATABASEP);
    /* check connection */
    if (mysqli_connect_errno()) {
        printf("Fallo en la conexión al servidor: %s\n", mysqli_connect_error());
        exit();
    }
    
   
   
    
?>