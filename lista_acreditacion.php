<?php

	include_once 'includes/funj.php';
	include_once 'PDFACRE.php';
	$gestion=$_POST["gestion"];
	$rango=$_POST["inscrito"];
	$valores=items_gestion($gestion);
	$terminos=inscritosxletra($gestion,$rango);

	$pdf = new PDF('L','mm','Letter');
	$pdf->titulo=nombreevento($gestion);
	$pdf->AliasNbPages();
	
	$numregistros=count($terminos);
	$divide=ceil($numregistros/15);
	
	$control=1;
	$rfin=0;
	while($control<=$divide)
	{
		if($control==$divide)
		{
			$rinicio=$rfin;
			$rfin=$numregistros;
			$pdf->AddPage();
			$pdf->Image('images/logoXjornadas.png',10,10,26,0);
			
			$pdf->SetFont('Arial','B',10);
			
			$miCabecera = array();
			foreach($valores as $col){
				$miCabecera[]=$col;
			}
			$pdf->tablaHorizontal($miCabecera,$terminos,$rinicio,$rfin);
			$pdf->SetFont('Arial','B',10);
			
		}
		else
		{
			$rinicio=$rfin;
			$rfin=$rinicio+15;
			$pdf->AddPage();
			$pdf->Image('images/logoXjornadas.png',10,10,26,0);
			
			$pdf->SetFont('Arial','B',10);
			
			$miCabecera = array();
			foreach($valores as $col){
				$miCabecera[]=$col;
			}
			$pdf->tablaHorizontal($miCabecera,$terminos,$rinicio,$rfin);
			$pdf->SetFont('Arial','B',10);
		}	
		$control++;
	}



	
	
	$nom="ListaAcreditacion".$gestion.".pdf";
	$pdf->Output($nom,'D');


?>
