<?php
	include_once '../includes/functions.php';
	include '../conexion.php';
	include_once '../includes/db_connect.php';
	$id=base64_decode($_GET["1d"]);
	$conexionp=conexp();

    $query="delete from areas where id=$id";

    if($resultado=$conexionp->query($query))
    {
        ?>
        <script language="javascript">
            alert("Registro eliminado exitosamente.");
            location.href = "../FormRegArea.php";
            
            </script>
    <?php
    }
    else
    {
        ?>
        <script language="javascript">
            alert("Fallo la eliminación de datos, el área tiene cargos registrados");
            location.href = "../FormRegArea.php";    
        </script>
    <?php
    }

	
	
?>