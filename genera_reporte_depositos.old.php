<?php

	include_once 'includes/funj.php';
	include_once 'PDFDEPO.php';
	$gestion=$_POST["gestion"];
	$criterio=$_POST["deposito"];
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
	while($control<=$divide)
	{
		if($control==$divide)
		{
			$rinicio=$rfin;
			$rfin=$numregistros;
			$pdf->AddPage();
			$pdf->Image('images/logoXjornadas.png',10,10,13,0);
			
			$pdf->SetFont('Arial','B',10);
			
			
			$pdf->tablaHorizontal($terminos,$rinicio,$rfin);
			$pdf->SetFont('Arial','B',10);
			
		}
		else
		{
			$rinicio=$rfin;
			$rfin=$rinicio+21;
			$pdf->AddPage();
			$pdf->Image('images/logoXjornadas.png',10,10,13,0);
			
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
