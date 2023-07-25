<?php
    include_once '../includes/functions.php';
	include '../conexion.php';
	include_once '../includes/db_connect.php';
	$id_inst=base64_decode($_GET["1n5"]);
	$gestion=base64_decode($_GET["g3s"]);
	//echo $id_inst."- ".$gestion;
	$conexionj=conexj();
	$query="call pa_elimina_beca_inst($gestion,$id_inst)";

	if($resultado=$conexionj->query($query))
	{
		?>
		<script language="javascript">
            alert("Registro eliminado exitosamente.");
            location.href = "../FormBecas.php";
            
            </script>
	<?php
	}
	else
	{
		$error= "Fallo la eliminación de datos: (" . $conexionj->errno . ") " . $conexionj->error;
		?>
	<script language="javascript">
        //alert("Error al eliminar el registro, favor contactese con el administrador.");
        alert("No se puede eliminar el registro pues ya se tienen inscritos correspondientes a la institución.");
        location.href = "../FormBecas.php";
    </script>
	<?php
	}
?>