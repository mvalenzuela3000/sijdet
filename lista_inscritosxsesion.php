<?php

	include_once 'includes/funj.php';
	include_once 'PDFSES.php';
	$gestion=$_POST["gestion"];
	$idsesion=$_POST["sesion"];

	$terminos=listasesionesxinscritos($gestion,$idsesion);
	$cantidad=count($terminos);

	$pdf = new PDF('P','mm','Letter');
	$pdf->AliasNbPages();
	
	$numregistros=count($terminos);
	$divide=ceil($numregistros/20);
	
	$control=1;
	$rfin=0;
	while($control<=$divide)
	{
		if($control==$divide)
		{
			$rinicio=$rfin;
			$rfin=$numregistros;
			$pdf->AddPage();
			
			$pdf->Image('images/logoXjornadas.png',10,10,13,0);
			
			$pdf->SetFont('Arial','B',10);
			$pdf->SetXY(15, 32);
			$pdf->CellFitSpace(180,7, 'Sesión: '.html_entity_decode(obtienedescsesion($gestion,$idsesion)),0, 2 , 'L'); 
			$pdf->tablaHorizontal($terminos,$rinicio,$rfin);
			$pdf->SetFont('Arial','B',10);
			
		}
		else
		{
			$rinicio=$rfin;
			$rfin=$rinicio+20;
			$pdf->AddPage();
			$pdf->Image('images/logoXjornadas.png',10,10,13,0);
			
			$pdf->SetFont('Arial','B',10);
			$pdf->SetXY(15, 32);
			$pdf->CellFitSpace(180,7, 'Sesión: '.html_entity_decode(obtienedescsesion($gestion,$idsesion)),0, 2 , 'L'); 
			$pdf->tablaHorizontal($terminos,$rinicio,$rfin);
			$pdf->SetFont('Arial','B',10);
		}	
		$control++;
	}
	$pdf->Ln();
	$pdf->CellFitSpace(160,8, 'TOTAL PARTICIPANTES A LA SESIÓN:       '.$cantidad,0, 2 , 'L');


	
	
	$nom="ListaSesionxInscrito".$gestion.".pdf";
	$pdf->Output($nom,'D');


?>
