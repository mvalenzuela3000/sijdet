<?php
    include_once '../includes/functions.php';
	include '../conexion.php';
	include_once '../includes/db_connect.php';
	$id=base64_decode($_GET["1d"]);

	$conexionj=conexj();
	$query="call pa_elimina_horario($id)";

	if($resultado=$conexionj->query($query))
	{
		?>
		<script language="javascript">
            alert("Registro eliminado exitosamente.");
            location.href = "../FormRegHorario.php";
            
            </script>
	<?php
	}
	else
	{
		$error= "Fallo la eliminación de datos: (" . $conexionj->errno . ") " . $conexionj->error;
		?>
	<script language="javascript">
        //alert("Error al eliminar el registro, favor contactese con el administrador.");
        alert("No se puede eliminar el registro.");
        location.href = "../FormRegHorario.php";
    </script>
	<?php
	}
?>