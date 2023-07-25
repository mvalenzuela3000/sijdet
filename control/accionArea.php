<?php
	include_once '../includes/functions.php';
    include_once '../conexion.php';
    $id=base64_decode($_GET["1d"]);
	$opt=base64_decode($_GET["0pt"]);

	if (isset($opt) && isset ($id))
	{
        $tabla='areas';
		$query="update $tabla set activo=$opt where id=$id";
		if($resultado = $conexionp->query($query))
		{
			?>
				<script language="javascript">
					alert("Registro modificado satisfactoriamente.");
					location.href = "../FormRegArea.php"; 
				</script>
			<?php
		}
		else
		{
			$error= "Fallo la actualizacion de datos: (" . $conexionp->errno . ") " . $conexionp->error;
			?>
			<script language="javascript">
			history.back(-1);
			alert("<?php echo $error; ?>");
			
			</script>
			<?php
		}
	}
	else {
		
	}
?>