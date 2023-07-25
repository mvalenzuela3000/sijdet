<?php
	include_once '../conexion.php';
	include_once '../includes/config.php';
	function nombreevento($gestion,$conexionj)
	{
		$query="select ifnull((select descripcion from ges_jornadas where gestion='".$gestion."'),'')";
		$resultado= $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		$valor=$fila2[0];
		return utf8_encode($valor);
	}
	function obtiene_mail_gaf($gestion,$conexionj)
	{
		$query="select emailgaf from ges_jornadas where gestion=$gestion";
		$resultado= $conexionj->query($query);
		if($fila2 = $resultado->fetch_array())
		{
			$valor=$fila2[0];
		}
		return $valor;
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
	function valida_fecha_monto_trans($ci,$conexionj,$prof,$fechadep,$monto)
	{
		$valor=0;
		$query="call pa_verifica_monto_fechatransf($prof, $monto, '".$fechadep."', $ci)";
		if (mysqli_multi_query($conexionj, $query)) {
	      do {
	          if ($result = mysqli_store_result($conexionj)) {
	              while ($row = mysqli_fetch_row($result)) {
						$valor=$row[0];
	              }
	              mysqli_free_result($result);
	          }
	      } while (mysqli_next_result($conexionj));
	  	}
		else {
		$error= "Fallo la validación de datos: (" . $conexionj->errno . ") " . $conexionj->error;
		?>
		<script language="javascript">
			history.back(-1); 
			alert("<?php echo $error; ?>
		");
		</script>
		<?php
		exit;
		}
		
		if($valor==1)
		{
		?>
		<script language="javascript">
			history.back(-1);
			alert("El monto del depósito es menor al estipulado según tipo (estudiante/profesional) o a la fecha en que fué depositado según los plazos de inscripción, por favor revise el monto depositado en su boleta en relación a la fecha en que se depósito y los montos establecidos para inscripción en jornadas."); 
		</script>
		<?php
		exit;
		}
		if ($valor==3) {
		?>
		<script language="javascript">
			alert("El monto del depósito es mayor al estipulado según tipo (estudiante/profesional) o a la fecha en que fué depositado según los plazos de inscripción.");
		</script>
		<?php
		}
	}

	function valida_deposito($ci,$conexionj,$prof,$numdep)
	{
		$valor=0;
		$query="call pa_verifica_monto_fechadep($prof, '".$numdep."', '".$ci."')";
		if (mysqli_multi_query($conexionj, $query)) {
	      do {
	          if ($result = mysqli_store_result($conexionj)) {
	              while ($row = mysqli_fetch_row($result)) {
						$valor=$row[0];
	              }
	              mysqli_free_result($result);
	          }
	      } while (mysqli_next_result($conexionj));
	  	}
		else {
		$error= "Fallo la validación de datos: (" . $conexionj->errno . ") " . $conexionj->error;
		?>
		<script language="javascript">
			history.back(-1); 
			alert("<?php echo $error; ?>
		");
		</script>
		<?php
		exit;
		}
		
		if($valor==1)
		{
		?>
		<script language="javascript">
			history.back(-1);
			alert("El monto número de depósito ingresado aún no se verificó o no es correcto, si está seguro del número ingresado, por favor tome en cuenta que desde la fecha y hora de depósito deben transcurrir 24 horas para verificar el mismo con el banco antes de que se le habilite para inscribirse."); 
		</script>
		<?php
		exit;
		}
		if ($valor==2) {
		?>
		<script language="javascript">
			history.back(-1);
			alert("Usted ya realizó su inscripción, no puede volver a registrarse, lo único que puede hacer es editar sus datos básicos en el caso de que fuera necesaria alguna correción.");
		</script>
		<?php
		exit;
		}
		if ($valor==4) {
		?>
		<script language="javascript">
			history.back(-1);
			alert("Ya se ha copado el máximo de inscritos para el depósito bancario ingresado.");
		</script>
		<?php
		exit;
		}
	}
function valida_deposito2($ci,$conexionj,$prof,$numdep)
	{
		$valor=0;
		$query="call pa_verifica_monto_fechadep($prof, '".$numdep."', '".$ci."')";
		if (mysqli_multi_query($conexionj, $query)) {
	      do {
	          if ($result = mysqli_store_result($conexionj)) {
	              while ($row = mysqli_fetch_row($result)) {
						$valor=$row[0];
	              }
	              mysqli_free_result($result);
	          }
	      } while (mysqli_next_result($conexionj));
	  	}
		else {
		$error= "Fallo la validación de datos: (" . $conexionj->errno . ") " . $conexionj->error;
		?>
		<script language="javascript">
			history.back(-1); 
			alert("<?php echo $error; ?>
		");
		</script>
		<?php
		exit;
		}
		
	
		if ($valor==2) {
		?>
		<script language="javascript">
			history.back(-1);
			alert("Usted ya realizó su inscripción, no puede volver a registrarse, lo único que puede hacer es editar sus datos básicos en el caso de que fuera necesaria alguna corrección.");
		</script>
		<?php
		exit;
		}
		if ($valor==4) {
		?>
		<script language="javascript">
			history.back(-1);
			alert("Ya se ha copado el máximo de inscritos para el depósito bancario ingresado.");
		</script>
		<?php
		exit;
		}
	}
	function valida_transferencia($ci,$conexionj,$prof,$numdep)
	{
		$valor=0;
		$query="call pa_verifica_monto_fechatransferencia($prof, '".$numdep."','".$ci."')";
		if (mysqli_multi_query($conexionj, $query)) {
	      do {
	          if ($result = mysqli_store_result($conexionj)) {
	              while ($row = mysqli_fetch_row($result)) {
						$valor=$row[0];
	              }
	              mysqli_free_result($result);
	          }
	      } while (mysqli_next_result($conexionj));
	  	}
		else {
		$error= "Fallo la validación de datos: (" . $conexionj->errno . ") " . $conexionj->error;
		?>
		<script language="javascript">
			history.back(-1); 
			alert("<?php echo $error; ?>
		");
		</script>
		<?php
		exit;
		}
		
		if($valor==1)
		{
		?>
		<script language="javascript">
			history.back(-1);
			alert("El monto número de depósito ingresado aún no se verificó o no es correcto, si está seguro del número ingresado, por favor tome en cuenta que desde la fecha y hora de depósito deben transcurrir 24 horas para verificar el mismo con el banco antes de que se le habilite para inscribirse."); 
		</script>
		<?php
		exit;
		}
		if ($valor==2) {
		?>
		<script language="javascript">
			history.back(-1);
			alert("Usted ya realizó su inscripción, no puede volver a registrarse, lo único que puede hacer es editar sus datos básicos en el caso de que fuera necesaria alguna correción.");
		</script>
		<?php
		exit;
		}
		if ($valor==4) {
		?>
		<script language="javascript">
			history.back(-1);
			alert("Ya se ha copado el máximo de inscritos para el depósito bancario ingresado.");
		</script>
		<?php
		exit;
		}
	}
	function verifica_cupos($prof,$conexionj)
	{
		$valor=0;
		$query="select fn_verificacupos_restantes($prof)";
		if($resultado = $conexionj->query($query))
		{
			$fila = $resultado->fetch_array();
			if ($fila[0]==0){
				?>
				<script language="javascript">
					history.back(-1); 
					alert("Ya no existen cupos disponibles, por favor contáctese con la Gerencia administrativa y Financiera de la AIT");
				</script>
				<?php
				exit;
			}
		}
		else
		{
			$error= "Fallo la validación de cupos: (" . $conexionj->errno . ") " . $conexionj->error;
			?>
			<script language="javascript">
				history.back(-1); 
				alert("<?php echo $error; ?>
			");
			</script>
			<?php
			exit;
		}
		
	}
	$conexionj=conexj();
	$emailgaf=obtiene_mail_gaf(date("Y"),$conexionj);
	verifica_cupos($_POST["prof"],$conexionj);
	$nombre=trim(mb_strtoupper($_POST["name"]));
	$apellido=trim(mb_strtoupper($_POST["apellido"]));
	$ci=$_POST["number"];
	//$ext=$_POST["extension"];
	$email=trim(mb_strtoupper($_POST["email"]));
	$dpto=$_POST["dpto"];
	$fono=$_POST["fono"];
	$evento=nombreevento(date("Y"),$conexionj);
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
				alert("Por favor revise que el tamaño de la imagen del cheque o transacción sea inferior a 2 MB.");
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
			$otrainst=trim(mb_strtoupper($_POST["otrainst"]));
			$inst=$_POST["institucion"];
		}
	}
	$rsocial=trim(mb_strtoupper($_POST["rsocial"]));
	$nit=trim($_POST["nitci"]);
	
	$conex = mysqli_connect(HOST, USER, PASSWORD, DATABASEJ); /* conexion*/
if($_POST["tipodep"]==0)
{
	$numdepo=$_POST["numdepo"];
	$deposito=$_FILES["file-1"]["name"];
	$query="select count(*) from pagos where id_pago='".$numdepo."' and id_tipo_pago=1 and gestion='".date("Y")."'";
	if($resultado = $conex->query($query))
	{
		$row = mysqli_fetch_row($resultado);
		if($row[0]==0)
		{
			if($prof==3){
				$querymont="select max(montoest) from rangos_fechas_inscripcion where gestion=year(now())";
				$resultadomont = $conex->query($querymont);
				$row = mysqli_fetch_row($resultadomont);
				$monto=$row[0];
			}
			else{
				$querymont="select max(monto) from rangos_fechas_inscripcion where gestion=year(now())";
				$resultadomont = $conex->query($querymont);
				$row = mysqli_fetch_row($resultadomont);
				$monto=$row[0];	
			}
			$fecha='1900-01-01 00:00:00';
			
			$depositonom=$_FILES["file-1"]["name"];
			$target_path2=$ruta.'_'.$depositonom;
			$ds_inf=basename($_FILES['file-1']['name']);
			$ds1_inf=$_FILES['file-1']['tmp_name'];
			$ext_inf=extension1($ds_inf);
			if($depositonom !="")
			{
				if(move_uploaded_file($_FILES['file-1']['tmp_name'], normaliza($target_path2)))
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
			//valida_fecha_monto_trans($ci, $conexionj, $prof, $fecha, $monto);	
			valida_deposito2($ci, $conexionj, $prof, $numdepo);
			
			if (mysqli_connect_errno()) {
				printf("Fallo en la conexion al servidor: %s\n", mysqli_connect_error());
				exit();
			}
			else
			{
				$valor=$ci.date("Y");	
				$cod= substr(hash_hmac("sha512", $valor, VALORENC), 1,20);
				$query="call pa_preinscripcion_nuevo_preregistrados('".$nombre."','".$apellido."','".$ci."','".$email."',$dpto,$prof,'".$otraprof."','".normaliza($matriculanom)."','".$_SERVER['REMOTE_ADDR']."','".$fono."','$inst','".$otrainst."','$nit','".$rsocial."','$numdepo','".normaliza($deposito)."',1,'',2,'".$cod."','')";
				if($resultado = $conex->query($query))
				{
					 
				?>
				
				<script language="javascript">
					alert("El número de deposito ingresado aún no se verificó, se verificará el mismo y se confirmará su inscripción en un plazo máximo de 48 horas contactándolo a través del correo electrónico que ha ingresado");
					location.href = "../FormDatosBasicos.php?c0d="+"<?php echo base64_encode($ci);?>";
				</script>
				<?php
				}
				else
				{
				//$error= "Fallo la insercion de datos de depositos: (" . $conex->errno . ") " . $conex->error;
				$error= "No se pudo proceder con la inscripción, revise su correo si no tiene algún mensaje de la anulación de su presinscripción y contáctese con la Gerencia Administrativa y Financiera de la AIT para cualquier consulta";
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
			$monto=0;
			$fecha='';
			$query2="select monto_pago,fecha_pago from pagos where id_pago='".$numdepo."' and id_tipo_pago=1 and gestion='".date("Y")."'";
			$resultado2 = $conex->query($query2);
			$row2 = mysqli_fetch_row($resultado2);
			$monto=$row2[0];
			$fecha=$row2[1];
			$depositonom=$_FILES["file-1"]["name"];
			$target_path2=$ruta.'_'.$depositonom;
			$ds_inf=basename($_FILES['file-1']['name']);
			$ds1_inf=$_FILES['file-1']['tmp_name'];
			$ext_inf=extension1($ds_inf);
			if($depositonom !="")
			{
				if(move_uploaded_file($_FILES['file-1']['tmp_name'], normaliza($target_path2)))
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
			valida_fecha_monto_trans($ci, $conexionj, $prof, $fecha, $monto);	
			valida_deposito($ci, $conexionj, $prof, $numdepo);
			if (mysqli_connect_errno()) {
				printf("Fallo en la conexion al servidor: %s\n", mysqli_connect_error());
				exit();
			}
			else
			{
				$valor=$ci.date("Y");	
				$cod= substr(hash_hmac("sha512", $valor, VALORENC), 1,20);
				$query="call pa_inscripcion_preregistro('".$nombre."','".$apellido."','".$ci."','".$email."',$dpto,$prof,'".$otraprof."','".normaliza($matriculanom)."','".$_SERVER['REMOTE_ADDR']."','".$fono."','$inst','".$otrainst."','$nit','".$rsocial."','$numdepo','".normaliza($depositonom)."',1,'".$cod."')";
				if($resultado = $conex->query($query))
				{
					$emailgaf=obtiene_mail_gaf(date("Y"),$conex);
					  $gestion=date('Y');
				       $pass=substr($nombre, 0,1).substr($apellido,0,1).$ci;
		       // $link="http://www.ait.gob.bo/sisjornadas/formulario.php?c1=".base64_encode($ci)."&c0d=".base64_encode($cod).""; //para desarrolllo 
			    $link="https://www.ait.gob.bo/sisjornadas/formIngreso.php"; //para desarrolllo 
		       // $link="192.168.18.126/jornadas/formIngreso.php"; //para desarrolllo 
		        $subject = "Constancia de Inscripción - ".$evento;
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
					alert("Inscripción realizada correctamente por favor revise su correo para imprimir su formulario de inscripción que debe presentar.");
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
			}
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
		$imgtrans=$_FILES["imgtrans"]["name"];
		$target_path2=$ruta.'_'.$imgtrans;
		$ds_inf=basename($_FILES['imgtrans']['name']);
		$ds1_inf=$_FILES['imgtrans']['tmp_name'];
		$ext_inf=extension1($ds_inf);
		if($imgtrans !="")
		{
			if(move_uploaded_file($_FILES['imgtrans']['tmp_name'], normaliza($target_path2)))
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
		valida_fecha_monto_trans($ci, $conexionj, $prof, $fechatrans, $montotrans);	
		valida_transferencia($ci, $conexionj, $prof, $numtrans);
		if (mysqli_connect_errno()) {
				printf("Fallo en la conexion al servidor: %s\n", mysqli_connect_error());
				exit();
		}
		else
		{
			$valor=$ci.date("Y");	
			$cod= substr(hash_hmac("sha512", $valor, VALORENC), 1,20);
			$query="call pa_inscripcion_preregistro_pago('".$nombre."','".$apellido."','".$ci."','".$email."',$dpto,$prof,'".$otraprof."','".normaliza($matriculanom)."','".$_SERVER['REMOTE_ADDR']."','".$fono."','$inst','".$otrainst."','$nit','".$rsocial."','$numtrans','".normaliza($imgtrans)."',1,'".$fechatrans."',$montotrans,'',2,'".$cod."','')";
			if($resultado = $conex->query($query))
			{
			?>
			<script language="javascript">
				alert("El número de transferencia ingresado aún no se verificó, se verificará el mismo y se confirmará su inscripción en un plazo máximo de 48 horas contactándolo a través del correo electrónico que ha ingresado");
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
		}
		
	}
elseif ($_POST["tipodep"]==2) {

		$numtrans=trim(strtoupper($_POST["numcheque"]));
		$fechatrans=formato_fecha($_POST["fechacheque"]);
		$montotrans=$_POST["montocheque"];
		$imgtrans=$_FILES["imgcheque"]["name"];
		$target_path2=$ruta.'_'.$imgtrans;
		$ds_inf=basename($_FILES['imgcheque']['name']);
		$ds1_inf=$_FILES['imgcheque']['tmp_name'];
		$ext_inf=extension1($ds_inf);
		if($imgtrans !="")
		{
			if(move_uploaded_file($_FILES['imgcheque']['tmp_name'], normaliza($target_path2)))
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
		valida_fecha_monto_trans($ci, $conexionj, $prof, $fechatrans, $montotrans);	
		valida_transferencia($ci, $conexionj, $prof, $numtrans);
		if (mysqli_connect_errno()) {
				printf("Fallo en la conexion al servidor: %s\n", mysqli_connect_error());
				exit();
		}
		else
		{
			$valor=$ci.date("Y");	
			$cod= substr(hash_hmac("sha512", $valor, VALORENC), 1,20);
			$query="call pa_inscripcion_preregistro_pago('".$nombre."','".$apellido."','".$ci."','".$email."',$dpto,$prof,'".$otraprof."','".normaliza($matriculanom)."','".$_SERVER['REMOTE_ADDR']."','".$fono."','$inst','".$otrainst."','$nit','".$rsocial."','$numtrans','".normaliza($imgtrans)."',1,'".$fechatrans."',$montotrans,'',3,'".$cod."','')";
			if($resultado = $conex->query($query))
			{
			?>
			<script language="javascript">
				alert("El número de cheque ingresado aún no se verificó, se verificará el mismo y se confirmará su inscripción en un plazo máximo de 48 horas contactándolo a través del correo electrónico que ha ingresado");
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
		}
		
	}

?>