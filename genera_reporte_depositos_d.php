<?php

	include_once 'includes/funj.php';
	include_once 'PDFDEPO.php';
	$gestion=base64_decode($_GET["g3s"]);
	$criterio=base64_decode($_GET["cr5"]);
	$terminos=depositos($gestion,$criterio);


	function sumadepositos($terminos)
	{
		$cont=0;
		for($j=0;$j<count($terminos);$j++)
		{
			$t=explode('+', $terminos[$j]);
			$cont = $cont +  $t[3];
		}
		return $cont;
	}

	$pdf = new PDF('P','mm','Letter');
	$pdf->AliasNbPages();
	
	$numregistros=count($terminos);
	$divide=ceil($numregistros/21);
	
	$control=1;
	$rfin=0;
	if($divide==0){
		$pdf->AddPage();
			$pdf->Image('images/logoXjornadas.png',10,10,26,0);
			
			$pdf->SetFont('Arial','B',10);

			$pdf->SetFont('Arial','B',10);
	}
	while($control<=$divide)
	{
		if($control==$divide)
		{
			$rinicio=$rfin;
			$rfin=$numregistros;
			$pdf->AddPage();
			$pdf->Image('images/logoXjornadas.png',10,10,26,0);
			
			$pdf->SetFont('Arial','B',10);
			
			
			$pdf->tablaHorizontal($terminos,$rinicio,$rfin);
			$pdf->SetFont('Arial','B',10);
			
		}
		else
		{
			$rinicio=$rfin;
			$rfin=$rinicio+21;
			$pdf->AddPage();
			$pdf->Image('images/logoXjornadas.png',10,10,26,0);
			
			$pdf->SetFont('Arial','B',10);
			
			
			$pdf->tablaHorizontal($terminos,$rinicio,$rfin);
			$pdf->SetFont('Arial','B',10);
		}	
		$control++;
	}

	$pdf->CellFitSpace(195,10, 'TOTAL REGISTROS:  '.$numregistros.'    -    SUMA DEPOSITOS:  '.sumadepositos($terminos),0, 0 , 'C' );
	

	
	
	$nom="ListaDepositos".$gestion.".pdf";
	$pdf->Output($nom,'D');


?>
