<?php
	//include '../includes/funj.php';
	include '../conexion.php';
	include_once '../includes/functions.php';
	 require_once '../includes/codigo.php';
	require 'class.phpmailer.php';
	require 'class.smtp.php';
	
	sec_session_start();
	$ci=trim($_POST["ci"],';');
	$numfactura=$_POST["numfac"];
	$fechafac=$_POST["fechafac"];
	//$factura=$_FILES["imgfactura"]["name"];
	$factura=$_FILES["imgfactura"]['tmp_name'];
	$facturasubir=$_FILES["imgfactura"]['tmp_name'];
	$nomfactura=basename($_FILES["imgfactura"]['name']);
	$obs=$_POST["obs"];
	$numdepo=trim($_POST["numdepo"],';');
	//echo $factura ."<br>";
	function nombreevento($gestion)
	{
		$conexionj=conexj();
		$query="select ifnull((select descripcion from ges_jornadas where gestion='".$gestion."'),'')";
		$resultado= $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		$valor=$fila2[0];
		return utf8_encode($valor);
	}
	function formato_fecha($fecha)
	{
		$tfini=explode('/',$fecha);
		$tempfini=$tfini[2].'-'.$tfini[1].'-'.$tfini[0];
		return $tempfini;
	}
	function obtiene_email($ci)
	{
		$conexionj=conexj();
		
		$query="select email from registrados where ci='".$ci."'";
		$resultado= $conexionj->query($query);
		if($fila2 = $resultado->fetch_array())
		{
			$valor=$fila2[0];
		}
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
	function valida_factura($numero)
	{
		$conexionj=conexj();
		$query="select count(*) from facturas where num_factura=$numero and gestion=year(now())";
		$resultado= $conexionj->query($query);
		if($fila2 = $resultado->fetch_array())
		{
			$valor=$fila2[0];
		}
		if($valor>0)
		{
			
			?>
			<script language="javascript">
			//history.back(-1);
			alert("El número de factura ya está registrado, por favor revise");
			self.close();
			</script>
			<?php
			exit;
		}
	}
	$tci=explode(';', $ci);
	$tdepo=explode(';', $numdepo);
	$contador=count($tci);
	//echo $ci."<br>".$numdepo;
	$emailgaf=obtiene_mail_gaf(date("Y"));
	valida_factura($numfactura);
	$mail = new PHPMailer();
	$evento=nombreevento(date("Y"));
	for($i=0;$i<$contador;$i++)
	{
	
		
		//envio la factuar por email
		$query="call pa_registra_factura('".$tci[$i]."','".$tdepo[$i]."',$numfactura,'".formato_fecha($fechafac)."','".$_SESSION['usuario']."','".$obs."')";
		//echo $query."<br>";
		if($resultado = $conexionj->query($query))
		{
			$email=obtiene_email($tci[$i]);
			$gestion=date('Y'); 
	        $subject = "Factura por inscripción - ".$evento;
	        $body = "<b>Se adjunta la factura por concepto de inscripción a las ".$evento."</b><br><br>";

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
				$mail->AddAttachment($factura,$nomfactura);
				$mail->Subject =$subject;
				$mail->MsgHTML($body);
	            $mail->IsHTML(true); // Enviar como HTML
				$mail->AltBody = 'Envío de factura Realizado';
				$mail->Send();//Enviar
				$target_path="../documentos/".date("Y")."_".$tci[$i]."_FACTURA.pdf";
				//cargo la factura al serv
				move_uploaded_file($facturasubir, $target_path);
		}
		else
		{
		$error= "Fallo la insercion de datos: (" . $conexionj->errno . ") " . $conexionj->error;
		?>
		<script language="javascript">
		//history.back(-1);
		alert("<?php echo $error; ?>
			");
		self.close();
		</script>
		<?php
		}
		
		
	}
	?>
			<script language="javascript">
					window.opener.document.location.reload();
					self.close();
			</script>
		<?php
	mysqli_close($conexionj);
?>