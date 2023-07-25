<?php
	//include '../conexion.php';
	include '../includes/config.php';
	include_once '../includes/functions.php';
	include '../includes/funj.php';
	sec_session_start();
	$ci=base64_decode($_GET["c1"]);
	$tipodeposito=base64_decode($_GET["td"]);
	$gestion=base64_decode($_GET["g3s"]);
	$deposito=base64_decode($_GET["d3p"]);
	$nombre=base64_decode($_GET["n0m"]);
	$evento=nombreevento(date("Y"));
	$conex = mysqli_connect(HOST, USER, PASSWORD, DATABASEJ);
	//echo $ci."-".$tipodeposito."-".$gestion." - ".$deposito;
	
	
	function verifica_cupos2($ci,$conexionj)
	{
		$valor=0;
		$q="select profesion from registrados where ci='".$ci."'";
		$res=$conexionj->query($q);
		$fila2 = $res->fetch_array();
		$prof=$fila2[0];
		$query="select fn_verificacupos_restantes($prof)";
		if($resultado = $conexionj->query($query))
		{
			$fila = $resultado->fetch_array();
			if ($fila[0]==0){
				?>
				<script language="javascript">
					history.back(-1); 
					alert("Ya no existen cupos disponibles, para la confirmación de la inscripción.");
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
	
	function formato_fecha($fecha)
	{
		$tfini=explode('/',$fecha);
		$tempfini=$tfini[2].'-'.$tfini[1].'-'.$tfini[0];
		return $tempfini;
	}
	$emailgaf=obtiene_mail_gaf(date("Y"));
	
	if($tipodeposito>1){

		verifica_cupos2($ci,$conex);
		$correlativon=obtiene_siguiente_correlativo_inscripcion();
		$query="update inscritos set estado=1,correlativo=$correlativon where ci='".$ci."' and gestion=$gestion and id_pago='".$deposito."'";
		if($res = $conex->query($query)){
			$querye="select email from registrados where ci='".$ci."'";
			$res=$conex->query($querye);
			$row = mysqli_fetch_row($res);
			$email=$row[0];
			$querye="select cod_inscripcion from inscritos where ci='".$ci."'";
			$res=$conex->query($querye);
			$row = mysqli_fetch_row($res);
			$cod=$row[0];
			$gestion=date('Y');
		       $pass=obtieneprimerpass($ci);
				   // $link="http://www.ait.gob.bo/sisjornadas/formulario.php?c1=".base64_encode($ci)."&c0d=".base64_encode($cod).""; //para desarrolllo 
					 $link="https://www.ait.gob.bo/sisjornadas/formIngreso.php"; //para desarrolllo 
					//$link="192.168.18.126/jornadas/formIngreso.php"; //para desarrolllo 
					$subject = "Constancia de Inscripción - ".$evento.".";
					$body = "<b>Inscripción a las ".$evento."</b><br><br>".
						"<br><br>CI: <strong>$ci</strong><br>".
						"<br><br>Nombres: <strong>".$nombre."</strong><br>".
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
					alert("Inscripción confirmada correctamente.");
					location.href = "../FormValidaciones.php"; 
				</script>
				<?php
				
		}
		else {
			$error= "Fallo la operación de datos: (" . $conex->errno . ") " . $conex->error;
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
else {

		verifica_cupos2($ci,$conex);
	$q="select id_pago from pagos where id_pago='".$deposito."' and gestion=year(now())";
	if($resultado = $conex->query($q))
	{
		$fila = $resultado->fetch_array();
		if ($fila[0]==''){
			?>
			<script language="javascript">
				history.back(-1); 
				alert("Aún no se cargó el depósito en el módulo correspondiente.");
			</script>
			<?php
			exit;
		}
	}
	else
	{
		$error= "Fallo la verificación de depósito: (" . $conex->errno . ") " . $conex->error;
		?>
		<script language="javascript">
			history.back(-1); 
			alert("<?php echo $error; ?>
		");
		</script>
		<?php
		exit;
	}
		
		$query="update inscritos set estado=1,id_pago='".$deposito."' where ci='".$ci."' and gestion=$gestion ";
		if($res = $conex->query($query)){
			$querye="select email from registrados where ci='".$ci."'";
			$res=$conex->query($querye);
			$row = mysqli_fetch_row($res);
			$email=$row[0];
			$querye="select cod_inscripcion from inscritos where ci='".$ci."'";
			$res=$conex->query($querye);
			$row = mysqli_fetch_row($res);
			$cod=$row[0];
			$gestion=date('Y');

		           $pass=obtieneprimerpass($ci);
				   // $link="http://www.ait.gob.bo/sisjornadas/formulario.php?c1=".base64_encode($ci)."&c0d=".base64_encode($cod).""; //para desarrolllo 
					 $link="https://www.ait.gob.bo/sisjornadas/formIngreso.php"; //para desarrolllo 
					//$link="192.168.18.126/jornadas/formIngreso.php"; //para desarrolllo 
					$subject = "Constancia de Inscripción - ".$evento.".";
					$body = "<b>Inscripción a las ".$evento."</b><br><br>".
						"<br><br>CI: <strong>$ci</strong><br>".
						"<br><br>Nombres: <strong>".$nombre."</strong><br>".
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
					alert("Inscripción confirmada correctamente.");
					location.href = "../FormValidaciones.php"; 
				</script>
				<?php
				
		}
		else {
			$error= "Fallo la operación de datos: (" . $conex->errno . ") " . $conex->error;
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
	
?>