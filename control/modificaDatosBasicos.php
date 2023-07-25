<?php
	include_once '../conexion.php';
	include_once '../includes/config.php';
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
	
	$nombre=trim(strtoupper($_POST["name"]));
	$apellido=trim(strtoupper($_POST["apellido"]));
	$ci=$_POST["ci"];

	$email=trim(strtoupper($_POST["email"]));
	$dpto=$_POST["dpto"];
	$fono=$_POST["fono"];
	
	$anio=explode('/',date('d/m/Y'));
	//$destination_path = "/var/www/html/jornadas/documentos";
	$destination_path = "../documentos";
	$ruta=$destination_path.'/'.$anio[2];
	$ruta.="_".$ci;
	$matriculanom=$_FILES["imgmatricula"]["name"];
	$target_path2=$ruta.'_'.$matriculanom;
	$ds_inf=basename($_FILES['imgmatricula']['name']);
	$ds1_inf=$_FILES['imgmatricula']['tmp_name'];
	$ext_inf=extension1($ds_inf);
	if($matriculanom !="")
	{
		if(move_uploaded_file($_FILES['imgmatricula']['tmp_name'], normaliza($target_path2)))
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
	
	if($_POST["prof"]>0)
	{
		$prof=$_POST["prof"];
		$otraprof="";
	}
	else {
		if($_POST["otraprof"]=="")
		{
			?>
			<script language="javascript">
				alert("Si seleccionó otra profesión, debe ingresar la misma necesariamente");
				history.back(-1);
			</script>
			<?php
			exit;
		}
		else {
			$otraprof=trim(strtoupper($_POST["otraprof"]));
			$prof=$_POST["prof"];
		}
	}
	if($_POST["institucion"]>0)
	{
		$inst=$_POST["institucion"];
		$otrainst="";
	}
	else {
		if($_POST["otrainst"]=="")
		{
			?>
			<script language="javascript">
				history.back(-1);
				alert("Si seleccionó otra institución, debe ingresar la misma necesariamente"); 
			</script>
			<?php
			exit;
		}
		else {
			$otrainst=trim(strtoupper($_POST["otrainst"]));
			$inst=$_POST["institucion"];
		}
	}
	$rsocial=trim(strtoupper($_POST["rsocial"]));
	$nit=trim(strtoupper($_POST["nitci"]));
	
	$conex = mysqli_connect(HOST, USER, PASSWORD, DATABASEJ); /* conexion*/
	
	$query="call pa_modifica_datos_basicos('".$nombre."','".$apellido."','".$ci."','".$email."',$dpto,$prof,'".$otraprof."','".normaliza($matriculanom)."','".$_SERVER['REMOTE_ADDR']."','".$fono."','$inst','".$otrainst."','$nit','".$rsocial."')";
	if($resultado = $conex->query($query))
	{
		  
		?>
		<script language="javascript">
			alert("Registro modificado correctamente.");
			location.href = "../FormDatosBasicos.php?c0d="+"<?php echo base64_encode($ci);?>"; 
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

?>