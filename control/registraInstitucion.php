<?php
    include '../conexion.php';
    $nombre=$_POST["name"];
	$query="call pa_registra_institucion('".strtoupper($nombre)."')";
	if($resultado = $conexionj->query($query))
	{
		?>
		<script language="javascript">
            alert("Registro ingresado exitosamente.");
            location.href = "../FormInstitucion.php";
            
            </script>
		<?php
	}
	else
		{
		$error= "Fallo la insercion de datos: (" . $conexionj->errno . ") " . $conexionj->error;
		?>
		<script language="javascript">
		history.back(-1);
		alert("<?php echo $error; ?>
			");
		</script>
		<?php
		}
		
?>