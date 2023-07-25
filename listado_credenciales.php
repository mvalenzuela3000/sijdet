
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
	$valx=220;
	$valy=10;
	$pdf = new PDF('P','mm','Letter');
	$conexionj=conexj();
		$query="call pa_obtiene_listado_credenciales(2019)";

		 if (mysqli_multi_query($conexionj, $query)) {
	          do {
	              if ($result = mysqli_store_result($conexionj)) {
	                  while ($row = mysqli_fetch_row($result)) {
	                  	$pdf->AliasNbPages();
						$pdf->AddPage();
	                  	$pdf->SetFont('Helvetica','B',12);
						$pdf->CellFitSpace(100,20,$row[0],0,0,'C'); 
						$pdf->Ln(15);
						$pdf->CellFitSpace(100,20,'C.I.: '.$row[1],0,0,'C'); 
						$qr='http://chart.googleapis.com/chart?chs=50x50&cht=qr&chl=IDInscrito.'.$row[1].'.CodigoInscripcion.'.$row[2].'&.png';
						$pdf->Image($qr,150,10,40,40);
						//$valy=$valy+35;
	                  }
	                  mysqli_free_result($result);
	              }
	      
	          } while (mysqli_next_result($conexionj));
			$nombredoc='ListadoCredenciales';
			$pdf->Output($nombredoc.'.pdf','D');
	      }

	
?>
