<?php
	include_once '../includes/functions.php';
	include '../conexion.php';
	include_once '../includes/db_connect.php';
	$id=base64_decode($_GET["1d"]); 
	 
	$query="delete from rangos_fechas_inscripcion where id='".$id."'";

			if($resultado=$conexionj->query($query))
			{
				?>
				<script language="javascript">
                    alert("Registro eliminado exitosamente.");
                    location.href = "../FormRegFechaInscrip.php";
                    
                    </script>
			<?php
			}
			else
				{
					$error= "Fallo la eliminación de datos: (" . $conexionj->errno . ") " . $conexionj->error;
					?>
				<script language="javascript">
		            //alert("Error al eliminar el registro, favor contactese con el administrador.");
		            alert("<?php echo $error; ?>");
                    location.href = "../FormRegItems.php";
		        </script>
				<?php
				}
	
?>