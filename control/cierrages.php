<?php
	include '../conexion.php';
	include_once '../includes/functions.php';
	sec_session_start();

	$gestion=base64_decode($_GET["g3s"]);
	
	function formato_fecha($fecha)
	{
		$tfini=explode('/',$fecha);
		$tempfini=$tfini[2].'-'.$tfini[1].'-'.$tfini[0];
		return $tempfini;
	}

	$query="call pa_cierra_gestion($gestion)";

	if($resultado=$conexionj->query($query))
	{
		?>
		<script language="javascript">
            alert("Gestión cerrada exitosamente.");
            location.href = "../FormInicio.php";
            
            </script>
	<?php
	}
	else
		{
			?>
		<script language="javascript">
            alert("Error al eliminar el registro, favor contactese con el administrador.");
            location.href = "../FormInicio.php";
        </script>
		<?php
		}
	
	mysqli_close($conexionj);
?>