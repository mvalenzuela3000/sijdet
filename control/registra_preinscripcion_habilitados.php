<?php
	include_once '../conexion.php';
	include_once '../includes/config.php';
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
	function obtiene_desc_jornadas($gestion,$conexionj)
	{
		$query="select descripcion from ges_jornadas where gestion=$gestion";
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
		$error= "Fallo la validación de datos TRANSFERENCIA: (" . $conexionj->errno . ") " . $conexionj->error;
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
	function verifica_cupos($prof,$deposito,$ci,$conexionj)
	{
		$valor=0;
		$query="select fn_verifica_cupos_restantes_habilitados($prof,$deposito,$ci)";
		/*if($prof==3){
			$query="select fn_obtiene_cantidad_cupos_est_web()";
			
		}
		else{
			$query="select fn_obtiene_cantidad_cupos_prof_web()";
		}*/
		
		if($resultado = $conexionj->query($query))
		{
			$fila = $resultado->fetch_array();
			if ($fila[0]<=0){
				?>
				<script language="javascript">
					alert("Ya no existen cupos disponibles, por favor contáctese con la Gerencia administrativa y Financiera de la AIT");
					history.back(-1); 
					
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
	function verifica_preinscripcion($ci,$conexionj)
	{
		$valor=0;
		$query="select fn_verifica_registrado('".$ci."')";
		if($resultado = $conexionj->query($query))
		{
			$fila = $resultado->fetch_array();
			if ($fila[0]==1){
				?>
				<script language="javascript">
					
					alert("Usted ya está registrado en el sistema, para proceder con su inscripción se le redireccionará a la ventana de login para que ingrese al sistema y pueda realizar la inscripción ingresando el número de su C.I. y la clave por defecto Inicial de su nombre,Inicial de su apellido en mayúsculasy su ci (Ej. MV123456)");
					location.href = "../formIngreso.php";
				</script>
				<?php
				exit;
			}
		}
	}
	$conexionj=conexj();
	$emailgaf=obtiene_mail_gaf(date("Y"),$conexionj);
	$descjornadas=obtiene_desc_jornadas(date("Y"),$conexionj);
	verifica_cupos($_POST["prof"],$_POST["numdepo"],$_POST["number"],$conexionj);
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
	$nit=trim($_POST["nitci"]);
	verifica_preinscripcion($ci,$conexionj);
	
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
				$query="call pa_registro_nuevo2('".$nombre."','".$apellido."','".$ci."',$ext,'".$email."',$dpto,$prof,'".$otraprof."','".normaliza($matriculanom)."','".$_SERVER['REMOTE_ADDR']."','".$fono."','$inst','".$otrainst."','".$nit."','".$rsocial."','$numdepo','".normaliza($depositonom)."',1,'".$cod."','$pais')";
				if($resultado = $conex->query($query))
				{
					
				?>
				
				<script language="javascript">
					alert("El número de depósito ingresado aún no se verificó o no es correcto, se verificará el mismo y se confirmará su inscripción en un plazo máximo de 48 horas contactándolo a través del correo electrónico que ha ingresado");
					location.href = "../inschabil.php"; 
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
				$query="call pa_registro_nuevo('".$nombre."','".$apellido."','".$ci."',$ext,'".$email."',$dpto,$prof,'".$otraprof."','".normaliza($matriculanom)."','".$_SERVER['REMOTE_ADDR']."','".$fono."','$inst','".$otrainst."','".$nit."','".$rsocial."','$numdepo','".normaliza($depositonom)."',1,'".$cod."','$pais')";
				if($resultado = $conex->query($query))
				{
					  $gestion=date('Y');
				        $pass=substr(strtoupper($nombre), 0,1).substr(strtoupper($apellido), 0,1).$ci;
				   // $link="http://www.ait.gob.bo/sisjornadas/formulario.php?c1=".base64_encode($ci)."&c0d=".base64_encode($cod).""; //para desarrolllo 
					 $link="https://www.ait.gob.bo/sisjornadas/formIngreso.php"; //para desarrolllo 
					//$link="192.168.18.126/jornadas/formIngreso.php"; //para desarrolllo 
					$subject = "Constancia de Inscripción - ".$descjornadas.".";
					$body = "<b>Inscripción a las ".$descjornadas."</b><br><br>".
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
							$mail->Host       = 'mail.ait.gob.bo';
							$mail->SMTPAuth   = true;
							$mail->Username   = USERMAILJ;
							$mail->Password   = PASSMAILJ;
							$mail->SMTPSecure = 'tls';
							$mail->Port       = 587;
							$mail->setFrom(USERMAIL,$descjornadas);
							if($email!="")
							{
							    $mail->addAddress($email, $descjornadas.' - Inscripción');
							}
							$mail->addAddress($emailgaf, $descjornadas.' - Inscripción');
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
					location.href = "../inschabil.php"; 
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
			$query="call pa_registro_nuevo_con_pagos('".$nombre."','".$apellido."','".$ci."',$ext,'".$email."',$dpto,$prof,'".$otraprof."','".normaliza($matriculanom)."','".$_SERVER['REMOTE_ADDR']."','".$fono."','$inst','".$otrainst."','".$nit."','".$rsocial."','$numtrans','".normaliza($imgtrans)."',1,'".$fechatrans."',$montotrans,'',2,'','".$cod."','$pais')";
			if($resultado = $conex->query($query))
			{
				
			?>
			
			<script language="javascript">
				alert("El número de transferencia ingresado aún no se verificó, se verificará el mismo y se confirmará su inscripción en un plazo máximo de 48 horas contactándolo a través del correo electrónico que ha ingresado");
				location.href = "../inschabil.php"; 
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
			$query="call pa_registro_nuevo_con_pagos('".$nombre."','".$apellido."','".$ci."',$ext,'".$email."',$dpto,$prof,'".$otraprof."','".normaliza($matriculanom)."','".$_SERVER['REMOTE_ADDR']."','".$fono."','$inst','".$otrainst."','".$nit."','".$rsocial."','$numtrans','".normaliza($imgtrans)."',1,'".$fechatrans."',$montotrans,'',3,'','".$cod."','$pais')";
			if($resultado = $conex->query($query))
			{
			
			?>
			
			<script language="javascript">
				alert("El número de cheque ingresado aún no se verificó, se verificará el mismo y se confirmará su inscripción en un plazo máximo de 48 horas contactándolo a través del correo electrónico que ha ingresado");
				location.href = "../inschabil.php"; 
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