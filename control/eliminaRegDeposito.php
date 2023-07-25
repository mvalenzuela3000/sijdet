<?php
 include_once '../conexion.php';
   include_once '../includes/functions.php';
   sec_session_start();
    $id_pago=base64_decode($_GET["1d"]);
	$gestion=base64_decode($_GET["g3s"]);
	$usuario=$_SESSION["usuario"];
	//echo $id_pago." ".$gestion;
	$query="call pa_elimina_deposito_erroneo('".$id_pago."',$gestion,'".$usuario."')";

			if($resultado=$conexionj->query($query))
			{
				?>
				<script language="javascript">
                    alert("Registro eliminado exitosamente.");
                    location.href = "../FormCargaDepositos.php";
                    
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
                    location.href = "../FormCargaDepositos.php";
		        </script>
				<?php
				}
?>