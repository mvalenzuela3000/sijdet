<?php
	include '../conexion.php';
	include_once '../includes/functions.php';
	sec_session_start();
    $fecha=$_POST["fecha"];
	$turno=$_POST["turno"];
	$hora=$_POST["hora"];
	$minuto=$_POST["minuto"];
	$tipo=$_POST["tipo"];
	$tolerancia=$_POST["tolerancia"];
	//echo $fecha." * ".$turno." * ".$hora." * ".$minuto." * ".$tipo." * ".$tolerancia;
	function formato_fecha($fecha)
	{
		$tfini=explode('/',$fecha);
		$tempfini=$tfini[2].'-'.$tfini[1].'-'.$tfini[0];
		return $tempfini;
	}
	function formato_hora($hora,$minuto)
	{
		return $hora.":".$minuto.":00";
	}

	$query="call pa_inserta_horarios('".date("Y")."','".formato_fecha($fecha)."','".formato_hora($hora,$minuto)."','".$turno."',$tolerancia,'".$tipo."','".$_SESSION['usuario']."')";

	if($resultado = $conexionj->query($query))
	{
	?>
		<script language="javascript">
            alert("Registro ingresado exitosamente.");
            location.href = "../FormRegHorario.php";
            
            </script>
	<?php
	}
	else
	{
	$error= "Fallo la insercion de datos: (" . $conexionj->errno . ") " . $conexionj->error;
	?>
	<script language="javascript">
	history.back(-1);
	alert("<?php echo $error; ?>");
	
	</script>
	<?php
	}
	
	mysqli_close($conexionj);
?>