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
	$descripcion=strtoupper($_POST["nombre"]);
	$cinscritos=$_POST["inscritos"];
	$cinscritose=$_POST["inscritose"];
	$cbecados=$_POST["becados"];
	$cbecadosait=$_POST["becadosait"];
	$gestion=$_POST["gestion"];
	$mail=$_POST["email"];
	$cexpyaut=$_POST["becadosexpyaut"];
	if($_FILES['imgres']['name']!='')
	{
		$anio=explode('/',date('d/m/Y'));
		//$destination_path = "/var/www/html/jornadas/documentos";
		$destination_path = "../documentos";
		$ruta=$destination_path.'/'.$anio[2];
		$ruta.="_ResAdmJornadas.pdf";
		$resadmnom=$_FILES["imgres"]["name"];
		$target_path2=$ruta;
		$ds_inf=basename($_FILES['imgres']['name']);
		$ds1_inf=$_FILES['imgres']['tmp_name'];
		$ext_inf=extension1($ds_inf);
	
		if(move_uploaded_file($_FILES['imgres']['tmp_name'], $target_path2))
		{
			$query="call pa_actualiza_ini_gestion($gestion,'".$descripcion."',$cbecados,$cinscritos,$cinscritose,'".$_SESSION['usuario']."',$cbecadosait,'".$mail."',$cexpyaut)";
		
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
		}
		else
		{
			?>
			<script language="javascript">
				history.back(-1);
				alert("Por favor revise que el tamaño de la Resolución Administrativa sea inferior a 2 MB.");
			</script>
			<?php
			exit ;
		}
		
	}
else{
	$query="call pa_actualiza_ini_gestion($gestion,'".$descripcion."',$cbecados,$cinscritos,$cinscritose,'".$_SESSION['usuario']."',$cbecadosait,'".$mail."',$cexpyaut)";
			
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
}
	
	
	
	
	

	
	
	mysqli_close($conexionj);
?>