<?php
	include '../conexion.php';
	include_once '../includes/functions.php';
	sec_session_start();
	$ci=$_POST["cih"];
	$nombre=$_POST["nombres"];
	$obs=$_POST["obs"];
	$opcion=$_POST["opcion"];
	// echo $ci ."- ".$nombre." - ".$obs;
	 
	function formato_fecha($fecha)
	{
		$tfini=explode('/',$fecha);
		$tempfini=$tfini[2].'-'.$tfini[1].'-'.$tfini[0];
		return $tempfini;
	}
	$cone=conexj();
	$querye="select email from registrados where ci='".$ci."'";
	$res=$cone->query($querye);
	$row = mysqli_fetch_row($res);
	$email=$row[0];
	function nombreevento($gestion)
	{
		$conexionj=conexj();	
		$query="select ifnull((select descripcion from ges_jornadas where gestion='".$gestion."'),'')";
		$resultado= $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		$valor=$fila2[0];
		return utf8_encode($valor);
	}
	function obtieneprimerpass($ci)
	{
		$conexionj=conexj();
		$query="call pa_obtiene_pass_inscrito('".$ci."')";
		$resultado= $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		$valor=$fila2[0];
		return $valor;
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
	$pass=obtieneprimerpass($ci);
	$emailgaf=obtiene_mail_gaf(date("Y"));
	//echo $pass." - ".$emailgaf;
	$evento=nombreevento(date("Y"));
	$query="call pa_anula_inscripcion('".$ci."','".date("Y")."',$opcion,'".$_SESSION['usuario']."','".$obs."')";

	if($resultado = $conexionj->query($query))
	{
	
		$gestion=date('Y');
		if($opcion==1){ $tit='Anulación'; $tit2='Anulada';}
		else { $tit='Eliminación'; $tit2='Eliminada';}
			
	        $link="http://www.ait.gob.bo/sisjornadas/formulario.php?c1=".base64_encode($ci)."&c0d=".base64_encode($cod).""; //para desarrolllo 
	        $subject = $tit." de Inscripción - ".$evento;
	        $body = "<b>".$tit." de Inscripción a las ".$evento."</b><br><br>".
	            "<br><br>CI: <strong>$ci</strong><br>".
	            "<br><br>Nombres: <strong>".$nombre."</strong><br>".
	            "<br><br><strong> Atención, su pre-inscripción a las ".$evento." ha sido ".$tit2." por ". $obs ." le pedimos por favor contactarse con la Gerencia Administrativa Financiera de la AIT para cualquier consulta o ingresar al link https://www.ait.gob.bo/sisjornadas/formIngreso.php para editar los datos ingresados con las credenciales: <br>
	            	Usuario: ".$ci."<br>
	            	Password: ".$pass." <br>en el caso de que hubiera algún error en la consignación de los mismos.</strong> <br>".
	            
	            "<br><br><strong>Gracias</strong><br><br>";

	            	
	        
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
				    $mail->addAddress($email, $evento.' - Inscripciones');
				}
				$mail->addAddress($emailgaf, $evento.' - Inscripciones');
				$mail->Subject =$subject;
				$mail->MsgHTML($body);
	            $mail->IsHTML(true); // Enviar como HTML
				$mail->AltBody = 'Inscripciones';
				$mail->Send();//Enviar
	            
	        } catch (phpmailerException $e) {
	        echo $e->errorMessage();//Mensaje de error si se produciera.
	        }
	       ?>
		<script language="javascript">
				window.opener.document.location.reload();
				self.close();
		</script>
	<?php
	}
	else
	{
	$error= "Fallo la operación de datos: (" . $conexionj->errno . ") " . $conexionj->error;
	?>
	<script language="javascript">
	history.back(-1);
	alert("<?php echo $error; ?>
		");
	
	</script>
	<?php
	}
	
	mysqli_close($conexionj);

?>