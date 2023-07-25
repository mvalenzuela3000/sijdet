<?php
	include_once '../includes/functions.php';
	include '../conexion.php';
	include_once '../includes/db_connect.php';
	$id=base64_decode($_GET["1d"]);
	$conexionj=conexj();

	$query="select ((select ifnull((select count(*) from registrados r where r.institucion='".$id."'),0))+ (select ifnull((select count(*) from beca_institucion b where b.id_institucion='".$id."'),0))+ (select ifnull((select count(*) from cuentasxcobrar c where c.id_institucion='".$id."'),0)))";
	$resultado=$conexionj->query($query);
	$fila2 = $resultado->fetch_array();
	$contador=$fila2[0];
	if($contador>0)
	{
		?>
		<script language="javascript">
	        alert("No se puede eliminar el registro pues ya se tienen registros que se enlazan con el dato seleccionado.");
	        location.href = "../FormInstitucion.php";
	    </script>
		<?php
	}
	else
	{
		$query="delete from institucion where id_inst=$id";

		if($resultado=$conexionj->query($query))
		{
			?>
			<script language="javascript">
	            alert("Registro eliminado exitosamente.");
	            location.href = "../FormInstitucion.php";
	            
	            </script>
		<?php
		}
		else
		{
			$error= "Fallo la eliminación de datos: (" . $conexionj->errno . ") " . $conexionj->error;
			?>
		<script language="javascript">
            //alert("Error al eliminar el registro, favor contactese con el administrador.");
            alert("<?php echo $error; ?>
            location.href = "../FormInstitucion.php";
        </script>
		<?php
		}
	}
	
	
	
?>