<?php
	include_once '../includes/functions.php';
	include_once '../includes/db_connect.php';
	include_once '../conexion.php';
	sec_session_start();
	$idtermino=$_POST["pais"];
	$terminos=$_POST["textTerminos"];

	
	function formato_fecha($fecha)
	{
		$tfini=explode('/',$fecha);
		$tempfini=$tfini[2].'-'.$tfini[1].'-'.$tfini[0];
		return $tempfini;
	}

	$query="call pa_actualiza_terminos($idtermino,'".nl2br($terminos)."')";

	if($resultado=$conexionj->query($query))
			{
				?>
				<script language="javascript">
                    alert("Términos actualizados exitosamente.");
                    location.href = "../FormTerminos.php";
                    
                    </script>
			<?php
			}
			else
				{
					$error= "Fallo la eliminación de datos: (" . $conexionj->errno . ") " . $conexionj->error;
					?>
				<script language="javascript">
		            //alert("Error al modificar el registro, favor contactese con el administrador.");
		            alert("<?php echo $error; ?>");
                    location.href = "../FormTerminos.php";
		        </script>
				<?php
				}

?>