<?php
	include_once '../conexion.php';
	include_once '../includes/config.php';
	include_once '../includes/functions.php';
	sec_session_start();
	function formato_fecha($fecha)
	{
		$tfini=explode('/',$fecha);
		$tempfini=$tfini[2].'-'.$tfini[1].'-'.$tfini[0];
		return $tempfini;
	}
	function extension1($filename)
	{
		$ext1= substr(strrchr($filename, '.'), 1);
		return $ext1;
	}
	function normaliza ($cadena){
		$originales = 'Ã€Ã�Ã‚ÃƒÃ„Ã…Ã†Ã‡ÃˆÃ‰ÃŠÃ‹ÃŒÃ�ÃŽÃ�Ã�Ã‘Ã’Ã“Ã”Ã•Ã–Ã˜Ã™ÃšÃ›ÃœÃ�Ãž
		ÃŸÃ Ã¡Ã¢Ã£Ã¤Ã¥Ã¦Ã§Ã¨Ã©ÃªÃ«Ã¬Ã­Ã®Ã¯Ã°Ã±Ã²Ã³Ã´ÃµÃ¶Ã¸Ã¹ÃºÃ»Ã½Ã½Ã¾Ã¿Å”Å•';
		$modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
		bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
		$cadena = utf8_decode($cadena);
		$cadena = strtr($cadena, utf8_decode($originales), $modificadas);
		$cadena = strtolower($cadena);
		$cadena=preg_replace('[\s+]','',$cadena);
		return utf8_encode($cadena);
	}
	$numdepo=$_POST["numdepo"];
	$institucion=$_POST["institucion"];
	$conex = mysqli_connect(HOST, USER, PASSWORD, DATABASEJ); /* conexion*/
if($_POST["tipodep"]==0)
{
	
	
	$query="select fecha_pago from pagos where id_pago='".$numdepo."'  and gestion='".date("Y")."'";
	if($resultado = $conex->query($query))
	{
		$row = mysqli_fetch_row($resultado);

		if (mysqli_connect_errno()) {
			printf("Fallo en la conexion al servidor: %s\n", mysqli_connect_error());
			exit();
		}
		else
		{

			$query="call pa_actualiza_datos_CXC('".$numdepo."','".$institucion."')";
			if($resultado = $conex->query($query))
			{
				 
			?>
			
			<script language="javascript">
				window.opener.document.location.reload();
					self.close();
			</script>
			<?php
			}
			else
			{
			$error= "Fallo la actualización de datos: (" . $conex->errno . ") " . $conex->error;
			?>
			<script language="javascript">
			history.back(-1);
			alert("<?php echo $error; ?>
				");
			
			</script>
			<?php
			}
			
			mysqli_close($conexion);
		}			
	}
	else
	{
		
		?>
		<script language="javascript">
			history.back(-1);
			alert("Error la ptm.");
		</script>
		<?php
		exit ;
	}

}
elseif ($_POST["tipodep"]==1) {

		$numtrans=trim(strtoupper($_POST["numtrans"]));
		$fechatrans=formato_fecha($_POST["fechatrans"]);
		$montotrans=$_POST["montotrans"];

		if (mysqli_connect_errno()) {
				printf("Fallo en la conexion al servidor: %s\n", mysqli_connect_error());
				exit();
		}
		else
		{
			$query="call pa_actualiza_inserta_CXC('".$numtrans."','".$institucion."','".$fechatrans."',$montotrans,'".$_SESSION['usuario']."',2)";
			if($resultado = $conex->query($query))
			{
				
			?>
			
			<script language="javascript">
				window.opener.document.location.reload();
					self.close();
			</script>
			<?php
			}
			else
			{
			$error= "Fallo la insercion de datos: (" . $conex->errno . ") " . $conex->error;
			?>
			<script language="javascript">
			history.back(-1);
			alert("<?php echo $error; ?>
				");
			
			</script>
			<?php
			}
			
			mysqli_close($conexion);
		}
		
	}
elseif ($_POST["tipodep"]==2) {

		$numtrans=trim(strtoupper($_POST["numcheque"]));
		$fechatrans=formato_fecha($_POST["fechacheque"]);
		$montotrans=$_POST["montocheque"];

		if (mysqli_connect_errno()) {
				printf("Fallo en la conexion al servidor: %s\n", mysqli_connect_error());
				exit();
		}
		else
		{
			$query="call pa_actualiza_inserta_CXC('".$numtrans."','".$institucion."','".$fechatrans."',$montotrans,'".$_SESSION['usuario']."',3)";
			if($resultado = $conex->query($query))
			{
				
			?>
			
			<script language="javascript">
				window.opener.document.location.reload();
					self.close();
			</script>
			<?php
			}
			else
			{
			$error= "Fallo la insercion de datos: (" . $conex->errno . ") " . $conex->error;
			?>
			<script language="javascript">
			history.back(-1);
			alert("<?php echo $error; ?>
				");
			
			</script>
			<?php
			}
			
			mysqli_close($conexion);
		}
		
	}
		


?>