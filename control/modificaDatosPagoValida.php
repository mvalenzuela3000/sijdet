<?php
	include '../conexion.php';
	include_once '../includes/functions.php';
	sec_session_start();
	$ci=$_POST["cinum"];
	$gestion=$_POST["gestion"];
	$numdep=$_POST["numdep"];
	$fechadep=$_POST["fechadep"];
	$depanterior=$_POST["depanterior"];
	$prof=0;
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
	function obtiene_prof($ci)
	{
		$conexionj=conexj();
		$valor=0;
		$q="select profesion from registrados where ci='".$ci."'";
		$res=$conexionj->query($q);
		$fila2 = $res->fetch_array();
		return $fila2[0];
	}
	function verifica_deposito_cargado($numdep)
	{
		$conexionj=conexj();
		$query="select count(*) from pagos where id_pago='".$numdep."' and gestion=year(now())";
		$resultado = $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		return $fila2[0];
	}
	function obtiene_fecha_dep($numdep)
	{
		$conexionj=conexj();
		$query="select fecha_pago from pagos where id_pago='".$numdep."' and gestion=year(now())";
		$resultado = $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		return $fila2[0];
	}
	function obtiene_monto_dep($numdep)
	{
		$conexionj=conexj();
		$query="select monto_pago from pagos where id_pago='".$numdep."' and gestion=year(now())";
		$resultado = $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		return $fila2[0];
	}
	function verifica_cupos2($ci)
	{
		$conexionj=conexj();
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
	function valida_fecha_monto_trans($ci,$prof,$fechadep,$monto)
	{
		$conexionj=conexj();
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
	function obtiene_siguiente_correlativo_inscripcion(){
		$conexionj=conexj();
		$query="call pa_obtiene_correlativo_finscripcion('".date("Y")."')";
		$resultado= $conexionj->query($query);
		if($fila2 = $resultado->fetch_array())
		{
			$valor=$fila2[0];
		}
		return $valor;
	}
	function valida_existesaldo($ci,$prof,$numdep)
	{
		$conexionj=conexj();
		$valor=0;
		$query="select fn_verifica_deposito_cargado('".$numdep."',year(now()),'".$ci."',$prof)";
		$resultado= $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		$valor=$fila2[0];		
		if ($valor==2) {
		?>
		<script language="javascript">
			history.back(-1);
			alert("Ya se ha copado el máximo de inscritos para el depósito bancario ingresado.");
		</script>
		<?php
		exit;
		}
	}
	//echo $ci."- ".$gestion." - ".$numdep." - ".$fechadep." - ".formato_fecha($fechadep)." - ".$depanterior;
	$emailgaf=obtiene_mail_gaf(date("Y"));
	
	$conexionj=conexj();	
	
	if(verifica_deposito_cargado($numdep)>0)
	{
		$descjornadas=obtiene_desc_jornadas(date("Y"));
		valida_existesaldo($ci, obtiene_prof($ci), $numdep);
		$correlativon=obtiene_siguiente_correlativo_inscripcion();
		verifica_cupos2($ci);
		valida_fecha_monto_trans($ci, obtiene_prof($ci), obtiene_fecha_dep($numdep), obtiene_monto_dep($numdep));
		$query="update inscritos set estado=1,correlativo=$correlativon,id_pago='".$numdep."' where ci='".$ci."' and gestion=$gestion and id_pago='".$depanterior."'";
		if($res = $conexionj->query($query)){
			$queryn="select nombres,apellidos from registrados where ci='".$ci."'";
			$res=$conexionj->query($queryn);
			$row = mysqli_fetch_row($res);
			$nombre=$row[0];
			$apellido=$row[1];
			
			$querye="select email from registrados where ci='".$ci."'";
			$res=$conexionj->query($querye);
			$row = mysqli_fetch_row($res);
			$email=$row[0];
			$querye="select cod_inscripcion from inscritos where ci='".$ci."'";
			$res=$conexionj->query($querye);
			$row = mysqli_fetch_row($res);
			$cod=$row[0];
			$gestion=date('Y');
			  $pass=substr($nombre,0, 1).substr($apellido,0,1).$ci;
		        //$link="http://www.ait.gob.bo/sisjornadas/formulario.php?c1=".base64_encode($ci)."&c0d=".base64_encode($cod).""; //para desarrolllo 
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
					$mail->Host       = 'smtp.gmail.com';
					$mail->SMTPAuth   = true;
					$mail->Username   = USERMAILJ;
					$mail->Password   = PASSMAILJ;
					$mail->SMTPSecure = 'tls';
					$mail->Port       = 587;
					$mail->setFrom(USERMAILJ,$descjornadas);
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
					alert("Inscripción confirmada correctamente.");
					window.opener.document.location.reload();
					self.close();
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
		//$query="update inscritos set estado=1,correlativo=$correlativon where ci='".$ci."' and gestion=$gestion and id_pago='".$deposito."'";
		
	}	
	else
	{
		$query="update inscritos set id_pago='".$numdep."' where ci='".$ci."' and gestion=$gestion and id_pago='".$depanterior."'";
		if($res = $conexionj->query($query)){
			?>
				<script language="javascript">
					alert("Se modificó el número de depósito pero aún no se cargó en la plantilla el mismo por lo que aún no se inscribió al registrado.");
					window.opener.document.location.reload();
					self.close();
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