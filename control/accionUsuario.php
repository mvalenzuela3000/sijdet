<?php
	include '../includes/db_connect.php';
    $id=base64_decode($_GET["1d"]);
	$opt=base64_decode($_GET["0pt"]);

	if (isset($opt) && isset ($id))
	{
		$query="call pa_cambia_estado_usuario('".$id."','".$opt."')";
		if($resultado = $mysqli->query($query))
		{
			?>
				<script language="javascript">
					alert("Registro modificado satisfactoriamente.");
					location.href = "../FormRegUser.php"; 
				</script>
			<?php
		}
		else
		{
			$error= "Fallo la actualizacion de datos: (" . $mysqli->errno . ") " . $mysqli->error;
			?>
			<script language="javascript">
			history.back(-1);
			alert("<?php echo $error; ?>
				");
			
			</script>
			<?php
		}
	}
	else {
		
	}
?>