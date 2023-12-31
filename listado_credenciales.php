<?php
ini_set('max_execution_time', 900);
	include_once 'includes/funj.php';
	include_once 'PDFCREDENCIAL.php';

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
	
	if(!isset($_POST["codigo"])){
		?>
		<script language="javascript">
			alert("Tiene que seleccionar al menos un elemento de la lista.");
			history.back(-1); 
		</script>
		<?php
		exit;
	}else{
		$valores=$_POST["codigo"];
		$cad='';
		foreach ($valores as $k => $val) {
			$cad.="'".$val."'".',';
		}
		$cad=substr($cad,0,-1);
		$conexionj=conexj();
		
		if(isset($_POST["todos"])){	
			$query="select r.nombres, r.apellidos as nombre, r.ci,i.cod_inscripcion,i.correlativo from inscritos i left join registrados r ON r.ci=i.ci where i.estado in (1,2) and i.gestion=year(now()) order by i.correlativo";
		}else{
			$query="select r.nombres, r.apellidos as nombre, r.ci,i.cod_inscripcion,i.correlativo from inscritos i left join registrados r ON r.ci=i.ci where i.estado in (1,2) and i.cod_inscripcion in (".$cad.") order by i.correlativo";
		}	
		$pdf = new PDF('P','mm','Letter');
		//$pdf->SetFont('Helvetica','B',13);
		$pdf->SetFont('Helvetica','B',15);
		$posicion=0;
		$cantidad=0;
		//$limite=14;
		$limite=10;
		if (mysqli_multi_query($conexionj, $query)) {
			do {
				if ($result = mysqli_store_result($conexionj)) {
					while ($row = mysqli_fetch_row($result)) {
						if($cantidad%$limite==0){
							$pdf->AddPage('P', 'Letter');
							/*$valx=5;
							$valy=18;*/
							$valx=0;
							$valy=13;
						}
						switch($posicion){
							/*case 0:
								$qr='https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=IDInscrito.'.$row[2].'.CodigoInscripcion.'.$row[3].'&.png';
								$pdf->Image($qr,$valx,$valy,35,35);
								$pdf->setXY($valx+30, $valy+2);
								$pdf->CellFitSpace(70, 15, utf8_decode($row[1]), 0,1,'C');
								$pdf->setXY($valx+30, $valy+9);
								$pdf->CellFitSpace(70, 15, utf8_decode($row[0]), 0,1,'C');
								$pdf->setXY($valx+30, $valy+22);
								$pdf->CellFitSpace(70, 7, 'C.I. '.utf8_decode($row[2]), 0,1,'C');
								$posicion++; //Aumenta posición
							break;
							case 1:
								$posicion = 0;
								$qr='https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=IDInscrito.'.$row[2].'.CodigoInscripcion.'.$row[3].'&.png';
								$pdf->Image($qr,$valx+109,$valy,35,35);
								$pdf->setXY($valx+139, $valy+2);
								$pdf->CellFitSpace(70, 15, utf8_decode($row[1]), 0,1,'C');
								$pdf->setXY($valx+139, $valy+9);
								$pdf->CellFitSpace(70, 15, utf8_decode($row[0]), 0,1,'C');
								$pdf->setXY($valx+139, $valy+22);
								$pdf->CellFitSpace(70, 7, 'C.I. '.utf8_decode($row[2]), 0,1,'C');
								$valy+=35;
							break;*/
							case 0:
								$qr='https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=IDInscrito.'.$row[2].'.CodigoInscripcion.'.$row[3].'&.png';
								$pdf->Image($qr,$valx,$valy,40,40);
								$pdf->setXY($valx+30, $valy+2);
								$pdf->CellFitSpace(70, 15, utf8_decode($row[1]), 0,1,'C');
								$pdf->setXY($valx+30, $valy+11);
								$pdf->CellFitSpace(70, 15, utf8_decode($row[0]), 0,1,'C');
								$pdf->setXY($valx+30, $valy+24);
								$pdf->CellFitSpace(70, 7, 'C.I. '.utf8_decode($row[2]), 0,1,'C');
								$posicion++; //Aumenta posición
							break;
							case 1:
								$posicion = 0;
								$qr='https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=IDInscrito.'.$row[2].'.CodigoInscripcion.'.$row[3].'&.png';
								$pdf->Image($qr,$valx+114,$valy,40,40);
								$pdf->setXY($valx+145, $valy+2);
								$pdf->CellFitSpace(70, 15, utf8_decode($row[1]), 0,1,'C');
								$pdf->setXY($valx+145, $valy+11);
								$pdf->CellFitSpace(70, 15, utf8_decode($row[0]), 0,1,'C');
								$pdf->setXY($valx+145, $valy+24);
								$pdf->CellFitSpace(70, 7, 'C.I. '.utf8_decode($row[2]), 0,1,'C');
								$valy+=53;
							break;
						}
						$cantidad++;
					}
					mysqli_free_result($result);
				}
			} while (mysqli_next_result($conexionj));
		  $nombredoc='Credenciales';
		  $pdf->Output($nombredoc.'.pdf','D');
		}
	}
?>
