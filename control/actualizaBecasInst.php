<?php
	include '../conexion.php';
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
	$institucion=$_POST["institucion"];
	$gestion=$_POST["gestion"];
	$cupos=$_POST["cbeca"];
	
	$anio=explode('/',date('d/m/Y'));
	//$destination_path = "/var/www/html/jornadas/documentos";
	$destination_path = "../documentos";
	$ruta=$destination_path.'/'.$anio[2];
	//nota ait

	$notaaitnom=$_FILES["notaait"]["name"];
	$target_path2=$ruta.'_notabeca_ait_'.$institucion.'.pdf';

	if($notaaitnom !="")
	{
		if(move_uploaded_file($_FILES['notaait']['tmp_name'], $target_path2))
		{
		
		}
		else
		{
			?>
			<script language="javascript">
				history.back(-1);
				alert("Por favor revise que el tamño de la imagen del cheque o transacción sea inferior a 2 MB.");
			</script>
			<?php
			exit ;
		}
	}
	//nota resp
	$notaresp=$_FILES["notaresp"]["name"];
	$target_path3=$ruta.'_notarespbeca_'.$institucion.'_ait.pdf';
	if($notaresp !="")
	{
		if(move_uploaded_file($_FILES['notaresp']['tmp_name'], $target_path3))
		{
		
		}
		else
		{
			?>
			<script language="javascript">
				history.back(-1);
				alert("Por favor revise que el tamño de la imagen del cheque o transacción sea inferior a 2 MB.");
			</script>
			<?php
			exit ;
		}
	}

	
	$query="call pa_actualiza_becas_inst($gestion,$institucion,$cupos,'".$_SESSION['usuario']."')";

	if($resultado = $conexionj->query($query))
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
	$error= "Fallo la insercion de datos: (" . $conexionj->errno . ") " . $conexionj->error;
	?>
	<script language="javascript">
	history.back(-1);
	alert("<?php echo $error; ?>
		");
	
	</script>
	<?php
	}

	mysqli_close($conexionj);
?>