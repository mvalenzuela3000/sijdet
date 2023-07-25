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
	function obtiene_desc_jornadas($gestion)
	{
		$conexionj=conexj();
		$query="select descripcion from ges_jornadas where gestion=$gestion";
		$resultado= $conexionj->query($query);
		if($fila2 = $resultado->fetch_array())
		{
			$valor=$fila2[0];
		}
		return $valor;
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
	function obtiene_mail_gaf($gestion)
	{
		$conexionj=conexj();
		$query="select emailgaf from ges_jornadas where gestion=$gestion";
		$resultado= $conexionj->query($query);
		if($fila2 = $resultado->fetch_array())
		{
			$valor=$fila2[0];
		}
		return $valor;
	}
	$conexionj=conexj();
	$evento=obtiene_desc_jornadas(date("Y"));
	$nombre=trim(strtoupper($_POST["name"]));
	$apellido=trim(strtoupper($_POST["apellido"]));
	$ci=$_POST["number"];
	$ext=$_POST["extension"];
	$email=trim(strtoupper($_POST["email"]));
	$pais=$_POST["pais"];
	if($pais==1){
		$dpto=$_POST["dpto"];
	}
	else {
		$dpto=0;
	}
	$fono=$_POST["fono"];
	$emailgaf=obtiene_mail_gaf(date("Y"));
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
	$inst=$_POST["institucion"];
	$otrainst='';
	
	
	$conex = mysqli_connect(HOST, USER, PASSWORD, DATABASEJ); /* conexion*/


	if (mysqli_connect_errno()) {
		printf("Fallo en la conexion al servidor: %s\n", mysqli_connect_error());
		exit();
	}
	else
	{
		$valor=$ci.date("Y");	
		$cod= substr(hash_hmac("sha512", $valor, VALORENC), 1,20);
		$query="call pa_registro_nuevo('".$nombre."','".$apellido."','".$ci."',$ext,'".$email."',$dpto,$prof,'".$otraprof."','".normaliza($matriculanom)."','".$_SERVER['REMOTE_ADDR']."','".$fono."','$inst','".$otrainst."',0,'','','',5,'".$cod."','$pais')";
		if($resultado = $conex->query($query))
		{
			  $gestion=date('Y');
		           $pass=substr(strtoupper($nombre), 0,1).substr(strtoupper($apellido), 0,1).$ci;
				   // $link="http://www.ait.gob.bo/sisjornadas/formulario.php?c1=".base64_encode($ci)."&c0d=".base64_encode($cod).""; //para desarrolllo 
					 $link="https://www.ait.gob.bo/sisjornadas/formIngreso.php"; //para desarrolllo 
					//$link="192.168.18.126/jornadas/formIngreso.php"; //para desarrolllo 
					$subject = "Constancia de Inscripción - ".$evento.".";
					$body = "<b>Inscripción a las ".$evento."</b><br><br>".
						"<br><br>CI: <strong>$ci</strong><br>".
						"<br><br>Nombres: <strong>".$nombre." ".$apellido."</strong><br>".
						"<br><br>C&oacute;digo de Inscripci&oacute;n: <strong>".$cod."</strong><br>".
					   " <br><br>Se confirmó el depósito realizado, para completar su inscripción agradeceremos ingrese al link  <strong>$link</strong> y posteriormente deberá imprimir el formulario de inscripción respectivo el mismo que deberá presentar al momento de su acreditación.".
						"<br><br><strong>Usuario: $ci</strong>".
						"<br><br><strong>Contraseña: $pass</strong><br><br>"; 
		            	
		        
		            require 'class.phpmailer.php';
		            require 'class.smtp.php';
		            	
			try {
			    require_once '../includes/codigo.php';
			
					$mail = new PHPMailer();
					$mail->IsSMTP();
					$mail->SMTPDebug  = 0;
					$mail->Host       = 'smtp.gmail.com';
					$mail->SMTPAuth   = true;
					$mail->Username   = USERMAILJ;
					$mail->Password   = PASSMAILJ;
					$mail->SMTPSecure = 'tls';
					$mail->Port       = 587;
					$mail->setFrom(USERMAIL,$evento);
					if($email!="")
					{
					    $mail->addAddress($email, $evento.' - Inscripción');
					}
					$mail->addAddress($emailgaf, $evento.' - Inscripción');
					$mail->Subject =$subject;
					$mail->MsgHTML($body);
		            $mail->IsHTML(true); // Enviar como HTML
					$mail->AltBody = 'Incripción Realizada';
					$mail->Send();//Enviar
		            
		        } catch (phpmailerException $e) {
		        echo $e->errorMessage();//Mensaje de error si se produciera.
		        }
		?>
		<script language="javascript">
			alert("Registro insertado correctamente.");
			location.href = "../formIngreso.php"; 
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
	

?>