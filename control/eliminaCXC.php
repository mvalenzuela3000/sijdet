<?php
    include_once '../includes/functions.php';
	include '../conexion.php';
	include_once '../includes/db_connect.php';
	$id_inst=base64_decode($_GET["1n5"]);
	$gestion=base64_decode($_GET["g3s"]);
	//echo $id_inst."- ".$gestion;
	$conexionj=conexj();
	$query="select ifnull((select count(*) from inscritos i,registrados r where i.ci=r.ci and id_tipo_inscrito=5 and r.institucion='".$id_inst."' and i.gestion='".$gestion."'),0)";
	$resultado=$conexionj->query($query);
	$fila2 = $resultado->fetch_array();
	$contador=$fila2[0];
	if($contador>0)
	{
		?>
		<script language="javascript">
	        alert("No se puede eliminar el registro pues ya se tienen inscritos correspondientes a la institución.");
	        location.href = "../FormCuentasXCobrar.php";
	    </script>
		<?php
	}
	else {
		$query="call pa_elimina_CXC($gestion,$id_inst)";
		if($resultado=$conexionj->query($query))
		{
			?>
			<script language="javascript">
	            alert("Registro eliminado exitosamente.");
	            location.href = "../FormCuentasXCobrar.php";
	            
	            </script>
		<?php
		}
		else
		{
			$error= "Fallo la eliminación de datos: (" . $conexionj->errno . ") " . $conexionj->error;
			?>
		<script language="javascript">
	        //alert("Error al eliminar el registro, favor contactese con el administrador.");
	        alert("<?php echo $error;?>");
	        location.href = "../FormCuentasXCobrar.php";
	    </script>
		<?php
		}
	}
	
	
	
	

	
?>