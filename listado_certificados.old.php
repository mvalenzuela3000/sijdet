
<?php
ini_set('max_execution_time', 900);
	include_once 'conexion.php';
	include_once 'includes/funj.php';
	include_once 'PDFCERT.php';

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

	$pdf = new PDF('L','mm','cert');
	$conexionj=conexj();
		$query="call pa_obtiene_listado_credenciales(2019)";
		$cont=1;
		 if (mysqli_multi_query($conexionj, $query)) {
	          do {
	              if ($result = mysqli_store_result($conexionj)) {
	                  while ($row = mysqli_fetch_row($result)) {
	                  	$pdf->AliasNbPages();
						$pdf->AddPage();
						$pdf->SetXY(20, 100);
	                  	$pdf->SetFont('Helvetica','B',22);
						$pdf->CellFitSpace(240,20,$row[0],0,0,'C'); 
						$pdf->Ln(15);
		
						$qr='http://chart.googleapis.com/chart?chs=50x50&cht=qr&chl=IDInscrito.'.$row[1].'.CodigoInscripcion.'.$row[2].'.NroCertificado.'.valida_correlativo($cont).'.Nombre.'.str_replace(' ','_',$row[0]).'&.png';
						//$pdf->Image($qr,30,190,30,30);
						$pdf->Image($qr,219,173,30,30);
		
						//$pdf->Ln(60);
						$pdf->SetFont('Helvetica','B',16);
						//$pdf->SetXY(230, 190);
						
						//$pdf->CellFitSpace(20,10,'Nro.: '.valida_correlativo($cont),0,0,'C'); 
						//$pdf->Text(220,205,'Nro.: '.valida_correlativo($cont));   --para tener correlativo secuencial
						$pdf->Text(220,205,'Nro.: '.valida_correlativo($row[3]));
						$cont++;
	                  }
	                  mysqli_free_result($result);
	              }
	      
	          } while (mysqli_next_result($conexionj));
			$nombredoc='ListaCertificados';
			$pdf->Output($nombredoc.'.pdf','D');
	      }

	
?>
