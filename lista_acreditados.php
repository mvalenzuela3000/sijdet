<?php

	include_once 'includes/funj.php';
	include_once 'PDFACREDITADOS.php';
	$gestion=$_POST["gestion"];
	$rango=$_POST["inscrito"];
	$valores=items_gestion($gestion);
	$terminos=inscritosyacreditados($gestion,$rango);
	function contaracreditados($terminos)
	{
		$cont=0;
		for($j=0;$j<count($terminos);$j++)
		{
			$t=explode('*', $terminos[$j]);
			if($t[2]==1){
				$cont++;
			}
		}
		return $cont;
	}

	$pdf = new PDF('L','mm','Letter');
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
	$pdf->Cell(50,10, 'TOTAL ACREDITADOS:   '.contaracreditados($terminos) ,0, 0 , 'R' );
    


	
	
	$nom="ListaAcreditados".$gestion.".pdf";
	$pdf->Output($nom,'D');


?>
