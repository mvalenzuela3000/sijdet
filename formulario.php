
<?php
	//header("Content-Type: text/html; charset=iso-8859-1 ");
	//include_once 'conexion.php';
	include_once 'includes/funj.php';
	include_once 'PDF.php';
	$ci=base64_decode($_GET["c1"]);
	$cod=base64_decode($_GET["c0d"]);
	$valores[]="";
	$valores=valores($ci,$cod);
	$terminos=terminos($ci,$cod);
	$correlativo=obtiene_correlativo_formulario($ci,$cod);
	$titulo=nombreeventoxcixcod($ci,$cod);
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
	/*foreach ($valores as $key) {
		echo $key."<br>";
	}
	ECHO $terminos; */

	$pdf = new PDF('P','mm','Letter');
	
	$pdf->SetTitle(utf8_decode('Formulario de Inscripción').' Nro. '.valida_correlativo($correlativo));
	
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetXY(80, 15);
	//$pdf->Cell(15, 6, '10, 10', 0 , 1); 
	$pdf->CellFitSpace(50,20,'Nro. '.valida_correlativo($correlativo),0,0,'C'); 
	$pdf->Ln(15);
	$pdf->titulo=$titulo;
	$pdf->Image('images/logoXjornadas.png',10,10,17,25);
	$pdf->Image('images/AIT-VERTICAL.jpg',175,10,25,25);
	$pdf->SetFont('Arial','B',12);
	$pdf->CellFitSpace(50,30,'Datos de la Inscripción',0,0,'C');
	$pdf->Ln(8);
	$pdf->SetFont('Arial','B',10);
	$pdf->CellFitSpace(50,30,utf8_decode('Datos personales'),0,0,'C');
	$miCabecera = array( 'Nombre Completo', 'Carnet de Identidad', utf8_encode('Correo electrónico'),utf8_encode('País / Departamento'),utf8_encode('Profesión'),utf8_encode('Teléfono'),utf8_encode('Institución'),utf8_encode('Fecha Inscripcion'),utf8_encode('Código de Inscripción'));
	$pdf->cabeceraVertical($miCabecera);
	$datos=array(utf8_encode($valores[0]),utf8_encode($valores[1]),utf8_encode($valores[2]),utf8_encode($valores[3]),utf8_encode($valores[4]),utf8_encode($valores[5]),utf8_encode($valores[9]),utf8_encode($valores[10]),utf8_encode($valores[13]));
	$pdf->datosVertical($datos);
	$pdf->Ln(1);
	$pdf->SetFont('Arial','B',10);
	if($valores[15]==1)
	{
		$pdf->CellFitSpace(85,10,'Datos del depósito y para facturación',0,0,'C');
		$miCabecera = array( utf8_encode('Número de comprobante'), 'Fecha de pago','Monto pago', 'NIT',utf8_encode('Razón Social'));
		$pdf->cabeceraVertical2($miCabecera);
		$datos=array($valores[11],$valores[12],$valores[14],$valores[7],utf8_encode($valores[8]));
		$pdf->datosVertical2($datos);
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',12);
		$pdf->CellFitSpace(50,0,'Términos y condiciones',0,0,'C');
		$pdf->Ln(7);
		$pdf->SetFont('Arial','',8);
		
		$qr='http://chart.googleapis.com/chart?chs=50x50&cht=qr&chl=IDInscrito.'.$ci.'.CodigoInscripcion.'.$cod.'&.png';
		$terminos=str_replace("<br />", "", $terminos);
		$pdf->MultiCell(190,5,$terminos);
		$pdf->Image($qr,160,220,50,50);
		$pdf->Output();
	}
	else 
	{
		$pdf->CellFitSpace(55,10,'Tipo de inscripción',0,0,'C');
		$miCabecera = array( 'Tipo de Inscrito');
		$pdf->cabeceraVertical2($miCabecera);
		$datos=array($valores[16]);
		$pdf->datosVertical2($datos);
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',12);
		$pdf->CellFitSpace(50,0,'Términos y condiciones',0,0,'C');
		$pdf->Ln(7);
		$pdf->SetFont('Arial','',8);
		
		$qr='http://chart.googleapis.com/chart?chs=50x50&cht=qr&chl=IDInscrito.'.$ci.'.CodigoInscripcion.'.$cod.'&.png';
		$terminos=str_replace("<br />", "", $terminos);
		$pdf->MultiCell(190,5,$terminos);
		$pdf->Image($qr,160,220,50,50);
		$pdf->Output();
	}
	

?>
