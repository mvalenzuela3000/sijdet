<?php
	include_once '../includes/functions.php';
	include_once '../includes/db_connect.php';
	sec_session_start();
	$nombre=$_POST["name"];
	$apellido=$_POST["apellido"];
	$ci=$_POST["ci"];
	$cargo=$_POST["cargo"];
	$depen=$_POST["depen"];
	$iduser=$_POST["id"];
	
	function formato_fecha($fecha)
	{
		$tfini=explode('/',$fecha);
		$tempfini=$tfini[2].'-'.$tfini[1].'-'.$tfini[0];
		return $tempfini;
	}

	$query="call pa_actualiza_usuario($ci,'".$nombre."','".$apellido."',$cargo,$depen,'".$iduser."')";

	if($resultado = $mysqli->query($query))
	{
	?>
		<script language="javascript">
				window.opener.document.location.reload();
				self.close();
		</script>
	<?php
	}
	else
	{
	$error= "Fallo la insercion de datos: (" . $mysqli->errno . ") " . $mysqli->error;
	?>
	<script language="javascript">
	history.back(-1);
	alert("<?php echo $error; ?>
		");
	
	</script>
	<?php
	}
	
	mysqli_close($mysqli);

?>