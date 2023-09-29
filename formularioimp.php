<?php
	//include_once 'conexion.php';
	include_once 'includes/funj.php';
	include_once 'PDF.php';
	
	$ci=base64_decode($_GET["c0d"]);
	$tipoinscrito=obtienetipoinscrito($ci,date("Y"));
	verifica_inscripcion($ci);
	/*if($tipoinscrito!=4)
	{
		verificaregistrosesionparalelareg($ci);
	}*/
	
	//$cod=base64_decode($_GET["c0d"]);
	$cod=verifica_inscripcion($ci);
	if($cod=="")
	{
		?>
			<script language="javascript">
		       	alert("Existen problemas con su inscripción por favor contáctese con la Gerencia Administrativa Financiera de la AIT.");
		       	location.href = "FormDatosBasicos.php?c0d="+"<?php echo base64_encode($ci);?>";
			</script>
		<?php
		exit;
	} 
	$correlativo=obtiene_correlativo_formulario($ci,$cod);
	function valida_correlativo($correlativo)
	{
		if($correlativo<10){
			return '000'.$correlativo;
		}
		elseif ($correlativo>=10 && $correlativo<100) {
			return '00'.$correlativo;
		}
		else {
			return '0'.$correlativo;
		}
	}

	
	$valores[]="";
	$valores=valores($ci,$cod);
	$terminos=terminos($ci,$cod);
	$correlativo=obtiene_correlativo_formulario($ci,$cod);
	$titulo=nombreeventoxcixcod($ci,$cod);
	//$sesinscritas=sesionesxinscrito($ci);
	//$pdf = new PDF();
	$pdf = new PDF('P','mm','Letter');
	$pdf->SetTitle(utf8_decode('Formulario de Inscripción').' Nro. '.valida_correlativo($correlativo));
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetXY(80, 15);
	$pdf->titulo=$titulo;
	//$pdf->Cell(15, 6, '10, 10', 0 , 1); 
	$pdf->CellFitSpace(50,20,'Nro. '.valida_correlativo($correlativo),0,0,'C'); 
	$pdf->Ln(13);
	$pdf->Image('images/logoXjornadas.png',10,10,30,12);
	$pdf->Image('images/AIT-VERTICAL.jpg',175,10,25,25);
	$pdf->SetFont('Arial','B',12);
	$pdf->Ln(6);
	$pdf->CellFitSpace(50,12,'Datos de la Inscripción',0,0,'C');
	$pdf->Ln(6);
	$pdf->SetFont('Arial','B',10);
	$pdf->CellFitSpace(50,10,utf8_decode('Datos personales'),0,0,'C');
	//$miCabecera = array( 'Nombre Completo', 'Carnet de Identidad', 'Correo electrónico','Departamento.','Profesión','Teléfono','Usuario','NIT','Razon Social','Institucion','Fecha Inscripcion','Número comprobante','Fecha Pago','Cod. Inscripcion');
	$miCabecera = array( 'Nombre Completo', 'Carnet de Identidad', utf8_encode('Correo electrónico'),utf8_encode('País / Departamento'),utf8_encode('Profesión'),utf8_encode('Teléfono'),utf8_encode('Institución'),utf8_encode('Fecha Inscripcion'),utf8_encode('Código de Inscripción'));
	$pdf->cabeceraVertical($miCabecera);
	$datos=array(utf8_encode($valores[0]),utf8_encode($valores[1]),utf8_encode($valores[2]),utf8_encode($valores[3]),utf8_encode($valores[4]),utf8_encode($valores[5]),utf8_encode($valores[9]),utf8_encode($valores[10]),utf8_encode($valores[13]));
	$pdf->datosVertical($datos);
	//$pdf->datosVertical($valores);
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',10);
	if($valores[15]==1)
	{
		$pdf->CellFitSpace(85,10,'Datos del depósito y para facturación',0,0,'C');
		$miCabecera = array( utf8_encode('Datos del comprobante'), utf8_encode('Datos Facturación'));
		$pdf->cabeceraVertical2($miCabecera);
		$datos=array('Nro. '.$valores[11].' / Fecha de pago: '.$valores[12].' / Monto depositado: '.$valores[14],'NIT: '.$valores[7].' / Razon social: '.utf8_encode($valores[8]));
		$pdf->datosVertical2($datos);
		$pdf->Ln(7);
		$pdf->SetFont('Arial','B',12);
		/*$pdf->CellFitSpace(80,0,'Sesiones Paralelas elegidas',0,0,'C');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',8);
		for($i=0;$i<count($sesinscritas);$i++)
		{
			$pdf->CellFitSpace(200,0,html_entity_decode($sesinscritas[$i]),0,0,'L');
			$pdf->Ln(5);
		}*/
	$pdf->Ln(5);
		$pdf->SetFont('Arial','B',12);
		$pdf->CellFitSpace(50,0,'Términos y condiciones',0,0,'C');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',7);
		$qr='http://chart.googleapis.com/chart?chs=50x50&cht=qr&chl=IDInscrito.'.$ci.'.CodigoInscripcion.'.$cod.'&.png';
		$terminos=str_replace("<br />", "", $terminos);
		$pdf->MultiCell(190,5,$terminos);
		$pdf->Image($qr,160,220,40,40);
		$pdf->Ln(30);
		$pdf->CellFitSpace(190,0,'Firma: '.utf8_encode($valores[0]) ,0,0,'C');
		//$pdf->Line(80,120,140,120);

		$nombredoc='FormularioInscripcion'.$ci;
		$pdf->Output($nombredoc.'.pdf','D');
	}
	else 
	{
		$pdf->CellFitSpace(55,10,'Tipo de inscripción',0,0,'C');
		$miCabecera = array( 'Tipo de Inscrito');
		$pdf->cabeceraVertical2($miCabecera);
		$datos=array($valores[16]);
		$pdf->datosVertical2($datos);
		$pdf->Ln(7);
		$pdf->SetFont('Arial','B',12);
		/*$pdf->CellFitSpace(80,0,'Sesiones Paralelas elegidas',0,0,'C');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',8);
		for($i=0;$i<count($sesinscritas);$i++)
		{
			$pdf->CellFitSpace(200,0,html_entity_decode($sesinscritas[$i]),0,0,'L');
			$pdf->Ln(5);
		}*/
		
		$pdf->SetFont('Arial','B',12);
		$pdf->CellFitSpace(50,0,'Términos y condiciones',0,0,'C');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','',7);
		$qr='http://chart.googleapis.com/chart?chs=50x50&cht=qr&chl=IDInscrito.'.$ci.'.CodigoInscripcion.'.$cod.'&.png';
		$terminos=str_replace("<br />", "", $terminos);
		$pdf->MultiCell(190,5,$terminos);
		$pdf->Image($qr,160,220,40,40);
		$pdf->Ln(20);
		$pdf->CellFitSpace(190,0,'Firma: '.utf8_encode($valores[0]) ,0,0,'C');
		//$pdf->Line(80,120,140,120);
		$nombredoc='FormularioInscripcion'.$ci;
		$pdf->Output($nombredoc.'.pdf','D');
	}
		
?>
<html>
	<head>
		<link rel="shortcut icon" href="images/favicon.ico">
	</head>
</html>