<?php
	include '../conexion.php';
	include_once '../includes/functions.php';
	sec_session_start();
	$descripcion=strtoupper($_POST["nombre"]);
	$cprofesionales=$_POST["inscritos"];
	$cestudiantes=$_POST["inscritose"];
	$cbecados=$_POST["becados"];
	$cbecadosait=$_POST["becadosait"];
	$cexpyaut=$_POST["becadosexpyaut"];
	$mail=$_POST["email"];
	$gestion=date("Y");
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
	if($resadmnom !="")
	{
		if(move_uploaded_file($_FILES['imgres']['tmp_name'], $target_path2))
		{
		
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

	$query="call pa_inserta_ini_gestion($gestion,'".$descripcion."',$cbecados,$cprofesionales,$cestudiantes,'".$_SESSION['usuario']."',$cbecadosait,'".$mail."',$cexpyaut)";
	//echo $query;
	if($resultado=$conexionj->query($query))
			{
		?>
		<script language="javascript">
            alert("Gestión iniciada exitosamente.");
            location.href = "../FormInicio.php";
            
            </script>
	<?php
	}
	else
		{
			?>
		<script language="javascript">
            alert("Error al iniciar la gestión, favor contactese con el administrador.");
            location.href = "../FormInicio.php";
        </script>
		<?php
		}
	mysqli_close($conexionj);
?>