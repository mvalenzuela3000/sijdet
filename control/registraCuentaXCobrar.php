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
	$cupos=$_POST["cupos"];
	$cuposdisconibles=$_POST["cupocuenta"];
	$email=$_POST["email"];
	$contcorreo=$_POST["obs"];
	
	$anio=explode('/',date('d/m/Y'));
	//$destination_path = "/var/www/html/jornadas/documentos";
	$destination_path = "../documentos";
	$ruta=$destination_path.'/'.$anio[2];
	//nota ait

	$notaaitnom=$_FILES["notainst"]["name"];
	$target_path2=$ruta.'_notainst_cxc_ait_'.$inst.'.pdf';
	$evento=nombreevento(date("Y"));
	if($notaaitnom !="")
	{
		if(move_uploaded_file($_FILES['notainst']['tmp_name'], $target_path2))
		{
		
		}
		else
		{
			?>
			<script language="javascript">
				history.back(-1);
				alert("Por favor revise que el tamaño del documento sea inferior a 2 MB.");
			</script>
			<?php
			exit ;
		}
	}
	$valor=$inst.date("Y");
	$id= substr(hash_hmac("sha512", $valor, VALORENC), 1,30);
	$conex=conexj();
	$query="call pa_inserta_cxc_institucion('".$id."','".$inst."','".$cupos."','".$_SESSION['usuario']."','".$email."','".$contcorreo."')";
	if($resultado = $conex->query($query))
	{
		 $gestion=date('Y');
        $link="https://www.ait.gob.bo/sisjornadas/formularioc.php?1d=".base64_encode($id).""; //para desarrolllo 
        $subject = "Formulario de Inscripción - ".$evento;
        $body = "<b>Inscripción a las ".$evento."</b><br><br>".
            "<p align=\"justify\">".$contcorreo."<br>".
            "<br><br>Link de Inscripción: <strong>$link</strong><br><br>";
            	
        
            require 'class.phpmailer.php';
            require 'class.smtp.php';
            	
	try {
	    require_once '../includes/codigo.php';
			$mailgaf=obtiene_mail_gaf(date("Y"));
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPDebug  = 0;
			$mail->Host       = 'smtp.gmail.com';
			$mail->SMTPAuth   = true;
			$mail->Username   = USERMAILJ;
			$mail->Password   = PASSMAILJ;
			$mail->SMTPSecure = 'tls';
			$mail->Port       = 587;
			$mail->setFrom(USERMAILJ,$evento);
			if($email!="")
			{
			    $mail->addAddress($email, $evento.' - Inscripción');
			}
			$mail->addAddress($mailgaf, $evento.' - Inscripción');
			$mail->Subject =$subject;
			$mail->MsgHTML($body);
            $mail->IsHTML(true); // Enviar como HTML
			$mail->AltBody = 'Pre-Incripción Realizada';
			$mail->Send();//Enviar
            
        } catch (phpmailerException $e) {
        echo $e->errorMessage();//Mensaje de error si se produciera.
        }
		  ?>
				<script language="javascript">
					alert("Registro insertado correctamente.");
					location.href = "../FormCuentasXCobrar.php"; 
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