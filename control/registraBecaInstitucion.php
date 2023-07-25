<?php
	include_once '../includes/config.php';
	include_once '../includes/funj.php';
	include_once '../includes/register.inc.php';
	include_once '../includes/functions.php';
	include_once '../includes/db_connect.php';
	sec_session_start();
	 if (!isset($_SESSION['usuario'],$_SESSION['cargo'])) 
	 {
	 	header("Location: ../index.php");
        exit();
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
	$inst=$_POST["institucion"];
	$cupos=$_POST["cbeca"];
	$cuposdisconibles=$_POST["cuposdisponibles"];
	
	$anio=explode('/',date('d/m/Y'));
	//$destination_path = "/var/www/html/jornadas/documentos";
	$destination_path = "../documentos";
	$ruta=$destination_path.'/'.$anio[2];
	//nota ait

	$notaaitnom=$_FILES["notaait"]["name"];
	$target_path2=$ruta.'_notabeca_ait_'.$inst.'.pdf';

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
				alert("Por favor revise que el tamaño de la imagen del cheque o transacción sea inferior a 2 MB.");
			</script>
			<?php
			exit ;
		}
	}
	//nota resp
	$notaresp=$_FILES["notaresp"]["name"];
	$target_path3=$ruta.'_notarespbeca_'.$inst.'_ait.pdf';
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
				alert("Por favor revise que el tamaño de la imagen del cheque o transacción sea inferior a 2 MB.");
			</script>
			<?php
			exit ;
		}
	}
	
	$conex=conexj();
	$query="call pa_inserta_becas_institucion('".$inst."','".$cupos."','".$_SESSION['usuario']."','".$notaresp."')";
	if($resultado = $conex->query($query))
	{
		  ?>
				<script language="javascript">
					alert("Registro insertado correctamente.");
					location.href = "../FormBecas.php"; 
				</script>
				<?php
	        }
	 else {
		$error= "Fallo la insercion de datos: (" . $conex->errno . ") " . $conex->error;
	?>
		<script language="javascript">
		history.back(-1);
		alert("<?php echo $error; ?>
			");
		
		</script>
		<?php
	}		
	
	
?>