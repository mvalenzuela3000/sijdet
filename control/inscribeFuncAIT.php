<?php
	//include_once '../conexion.php';
	include_once '../includes/config.php';
	include_once '../includes/funj.php';
	include_once '../includes/db_connect.php';
	include_once '../includes/functions.php';
	   require_once '../includes/codigo.php';
	     require 'class.phpmailer.php';
				            require 'class.smtp.php';
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
	$evento=nombreevento(date("Y"));
	if (isset($_POST["checkbox1"]))
	{
		$emailgaf=obtiene_mail_gaf(date("Y"));
		$registro=$_POST["checkbox1"];
		$cantidad=count($_POST["checkbox1"]);
		if($cantidad>verifica_cupos_institucion(0,3))
		{
			?>
			
			<script>
				history.back(-1);
				alert("La cantidad de registros marcados excede a la cantidad de cupos disponibles, se tienen "+"<?php echo verifica_cupos_institucion(0,3);?>"+" cupos.");
			</script>
			<?php
			exit;
		}
		else
		{
			$exito='';
			$malos='';
			$conex = conexj();	
			$mail = new PHPMailer();
			for($i=0;$i<$cantidad;$i++)
			{
				$t=explode('*', $registro[$i]);
				$ci=$t[0];
				$nombres=$t[1];
				$email=$t[2];
				$valor=$ci.date("Y")."AIT";	
				$cod= substr(hash_hmac("sha512", $valor, VALORENC), 1,20);
				$query="call pa_solo_inscripcion_ait('".$ci."','".$cod."','".$_SERVER['REMOTE_ADDR']."')";
				//echo $query;
				if($resultado = $conex->query($query))
				{
					  $gestion=date('Y');
				   
							
						   $pass=obtieneprimerpass($ci);
						   // $link="http://www.ait.gob.bo/sisjornadas/formulario.php?c1=".base64_encode($ci)."&c0d=".base64_encode($cod).""; //para desarrolllo 
							 $link="https://www.ait.gob.bo/sisjornadas/formIngreso.php"; //para desarrolllo 
							//$link="192.168.18.126/jornadas/formIngreso.php"; //para desarrolllo 
							$subject = "Constancia de Inscripción - ".$evento;
							$body = "<b>Inscripción a las ".$evento."</b><br><br>".
								"<br><br>CI: <strong>$ci</strong><br>".
								"<br><br>Nombres: <strong>".$nombres."</strong><br>".
								"<br><br>C&oacute;digo de Inscripci&oacute;n: <strong>".$cod."</strong><br>".
							   " <br><br>Se confirmó el depósito realizado, para completar su inscripción agradeceremos ingrese al link  <strong>$link</strong> y posteriormente deberá imprimir el formulario de inscripción respectivo el mismo que deberá presentar al momento de su acreditación.".
								"<br><br><strong>Usuario: $ci</strong>".
								"<br><br><strong>Contraseña: $pass</strong><br><br>";
	
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
							$mail->addAddress($emailgaf, $evento.' - Inscripción');
							$mail->Subject =$subject;
							$mail->MsgHTML($body);
				            $mail->IsHTML(true); // Enviar como HTML
							$mail->AltBody = 'Incripción Realizada';
							$mail->Send();//Enviar

					$exito.= $ci." ";
				}
				else
				{
					$malos.=$ci." ";
				}
				//echo $query."- ".$nombres."<br>";
			}
	
			$mensaje='C.I. inscritos correctamente: '.$exito;
			if($malos <>'')
			{
				$mensaje.='\n'.'C.I. que no se pudieron inscribir: '.$malos;
			}
			
			?>
			<script language="javascript">
				alert("<?php echo $mensaje;?>");
				location.href = "../FormInscripcionFuncAITL.php";
			</script>
			<?php	
		}
	}
	else
	{
		?>
		
		<script>
			history.back(-1);
			alert("No ha seleccionado ningún registro para inscribir.");
		</script>
		<?php
		exit;		
	}
	
	
	



		
		

?>