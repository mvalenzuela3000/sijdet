<?php
	include_once '../includes/functions.php';
	include '../conexion.php';
	include_once '../includes/db_connect.php';
    $fini=$_POST["fechaini"];
	$ffin=$_POST["fechafin"];
	$montoprof=$_POST["monto"];
	$montoest=$_POST["montoest"];
	$descuento=$_POST["descuento"];
	$partanterior=$_POST["partanteriores"];
	function formato_fecha($fecha)
	{
		$tfini=explode('/',$fecha);
		$tempfini=$tfini[2].'-'.$tfini[1].'-'.$tfini[0];
		return $tempfini;
	}
	if($montoest > $montoprof)
	{
		?>
			<script language="javascript">
             history.back(-1);
             alert("El monto para Estudiantes no puede ser mayor al monto para Profesionales, por favor revise.");
        </script>
		<?php
	}
	else {
		if(verifica_fecha($fini,$ffin)==0)
		{
			?>
			 <script language="javascript">
           	  history.back(-1);
     	        alert("La fecha inicial no puede ser mayor a la fecha final, por favor revise.");
     		   </script>
			
			<?php		
		}
		else {

			$query="call pa_registra_rango_fecha_inscripcion('".formato_fecha($fini)."','".formato_fecha($ffin)."','".$montoprof."','".$montoest."','".$descuento."','".$partanterior."')";

			if($resultado=$conexionj->query($query))
			{
				?>
				<script language="javascript">
                    alert("Rango de fechas registrado exitosamente.");
                    location.href = "../FormRegFechaInscrip.php";
                    
                    </script>
			<?php
			}
			else
				{
					$error= "Fallo la eliminación de datos: (" . $conexionj->errno . ") " . $conexionj->error;
					?>
				<script language="javascript">
		            alert("Error al registrar el rango de fechas"+"<?php echo $error;?>");
                    location.href = "../FormRegFechaInscrip.php";
		        </script>
				<?php
				}
			
		}
	}
	
	
?>