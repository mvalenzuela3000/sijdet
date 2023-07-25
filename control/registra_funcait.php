<?php
	//include_once '../conexion.php';
	include_once '../includes/config.php';
	include_once '../includes/funj.php';
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
	$emailgaf=obtiene_mail_gaf(date("Y"));
	$nombre=trim(strtoupper($_POST["name"]));
	$apellido=trim(strtoupper($_POST["apellido"]));
	$ci=$_POST["number"];
	$ext=$_POST["extension"];
	$email=trim(strtoupper($_POST["email"]));
	$dependencia=$_POST["depen"];
	
	$anio=explode('/',date('d/m/Y'));
	//$destination_path = "/var/www/html/jornadas/documentos";
	$destination_path = "../documentos";
	$ruta=$destination_path.'/'.$anio[2];
	$ruta.="_".$ci;
	
	$dpto=0;
	$pais=1;
	if ($dependencia=='AGIT' ||$dependencia=='ARITLPZ')
	{
		$dpto=1;
	}
	elseif($dependencia=='ARITSCZ')
	{
		$dpto=2;
	}
	elseif($dependencia=='ARITCBA')
	{
		$dpto=3;
	}
	else
	{
		$dpto=4;		
	}
	
	if(verifica_cupos_institucion(0,3)==0)
	{
		?>
		
		<script>
			history.back(-1);
			alert("Ya no hay cupos de becas para la institución señalada.");
		</script>
		<?php
		exit;
	}
	
	$conex = conexj();

	verifica_inscripcion_becado($ci,date("Y"));
	if (mysqli_connect_errno()) {
		printf("Fallo en la conexion al servidor: %s\n", mysqli_connect_error());
		exit();
	}
	else
	{
		$valor=$ci.date("Y")."AIT";	
		$cod= substr(hash_hmac("sha512", $valor, VALORENC), 1,20);
		$query="call pa_registro_becados('".$nombre."','".$apellido."','".$ci."',$ext,'".$email."',$dpto,'".$_SERVER['REMOTE_ADDR']."','',0,'".$dependencia."',3,'".$cod."',$pais)";
		if($resultado = $conex->query($query))
		{
			  $gestion=date('Y');
		           $pass=obtieneprimerpass($ci);
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
			
					
					//Crear una instancia de PHPMailer
					$mail = new PHPMailer();
					//Definir que vamos a usar SMTP
					$mail->IsSMTP();
					//Esto es para activar el modo depuración. En entorno de pruebas lo mejor es 2, en producción siempre 0
					// 0 = off (producción)
					// 1 = client messages
					// 2 = client and server messages
					$mail->SMTPDebug  = 0;
					//Ahora definimos gmail como servidor que aloja nuestro SMTP
					$mail->Host       = 'smtp.gmail.com';
					//Tenemos que usar gmail autenticados, así que esto a TRUE
					$mail->SMTPAuth   = true;
					//Definimos la cuenta que vamos a usar. Dirección completa de la misma
					$mail->Username   = USERMAILJ;
					//Introducimos nuestra contraseña de gmail
					$mail->Password   = PASSMAILJ;
					
					//Definmos la seguridad como TLS
					$mail->SMTPSecure = 'tls';
					//El puerto será el 587 ya que usamos encriptación TLS
					$mail->Port       = 587;
				
					//Definimos el remitente (dirección y, opcionalmente, nombre)
					$mail->setFrom(USERMAIL,$evento);
					
					if($email!="")
					{
					    //Esta línea es por si queréis enviar copia a alguien (dirección y, opcionalmente, nombre)
					 
					    $mail->addAddress($email, $evento.' - Inscripción');
					}
					
					//Y, ahora sí, definimos el destinatario (dirección y, opcionalmente, nombre)
					$mail->addAddress($emailgaf, $evento.' - Inscripción');
					//Definimos el tema del email
					$mail->Subject =$subject;
					//Para enviar un correo formateado en HTML lo cargamos con la siguiente función. Si no, puedes meterle directamente una cadena de texto.
					//$mail->MsgHTML(file_get_contents('correomaquetado.html'), dirname(ruta_al_archivo));
					$mail->MsgHTML($body);
		            $mail->IsHTML(true); // Enviar como HTML
					//Y por si nos bloquean el contenido HTML (algunos correos lo hacen por seguridad) una versión alternativa en texto plano (también será válida para lectores de pantalla)
					$mail->AltBody = 'Incripción Realizada';
					$mail->Send();//Enviar
		            
		        } catch (phpmailerException $e) {
		        echo $e->errorMessage();//Mensaje de error si se produciera.
		        }
		?>
		<script language="javascript">
			alert("Registro insertado correctamente.");
			location.href = "../FormInscripcionFunc.php"; 
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