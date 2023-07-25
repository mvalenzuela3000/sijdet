<?php
	include_once '../includes/functions.php';
	include '../conexion.php';
	$valor=$_POST['items'];
	if ($valor=='')
	{
		?>
				<script language="javascript">
				history.back(-1);
				alert("No se ha seleccionado ningún item para registrar.");

			</script>
		<?php
		exit;
	}
	else
		{
			$flag=0;
			$i=0;
			$arrayitem=explode(',',$valor);
			for ($i=0;$i<count($arrayitem);$i++)
			{
				$query="call pa_registra_item('".$arrayitem[$i]."')";
				$conexionj->query($query);
				$flag ++;
			}
		
			if($flag>0)
			{
				?>
				<script language="javascript">
                    alert("Items registrados exitosamente.");
                    location.href = "../FormRegItems.php";
                    
                    </script>
			<?php
			}
			else
				{
					?>
				<script language="javascript">
		            alert("Error al registrar el (los) items, favor contactese con el administrador.");
                    location.href = "../FormRegItems.php";
		        </script>
				<?php
				}
		}

?>