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
	$valx=220;
	$valy=10;
	
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
		$pdf->AddPage();
		$pdf->SetFont('Helvetica','B',12);
		$posicion=0;
		if (mysqli_multi_query($conexionj, $query)) {
			do {
				if ($result = mysqli_store_result($conexionj)) {
					while ($row = mysqli_fetch_row($result)) {
						switch($posicion){
							case 0:
								$pdf->designUp();
								$qr='https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=IDInscrito.'.$row[2].'.CodigoInscripcion.'.$row[3].'&.png';
								$pdf->Image($qr,41,46,30,30);
								$pdf->setXY(15, 93);
								$pdf->Cell(80, 7, utf8_decode($row[1]), 0,1,'C');
								$pdf->setXY(15, 98);
								$pdf->Cell(80, 7, utf8_decode($row[0]), 0,1,'C');
								$pdf->setXY(15, 104);
								$pdf->Cell(80, 7, 'C.I. '.utf8_decode($row[2]), 0,1,'C');
								$posicion++; //Aumenta posición
							break;
							case 1:
								$pdf->designUp(100);
								$qr='https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=IDInscrito.'.$row[2].'.CodigoInscripcion.'.$row[3].'&.png';
								$pdf->Image($qr,141,46,30,30);
								$pdf->setXY(115, 93);
								$pdf->Cell(80, 7, utf8_decode($row[1]), 0,1,'C');
								$pdf->setXY(115, 98);
								$pdf->Cell(80, 7, utf8_decode($row[0]), 0,1,'C');
								$pdf->setXY(115, 104);
								$pdf->Cell(80, 7, 'C.I. '.utf8_decode($row[2]), 0,1,'C');
								$posicion++; //Aumenta posición
							break;
							case 2:
								$pdf->designDown();
								$qr='https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=IDInscrito.'.$row[2].'.CodigoInscripcion.'.$row[3].'&.png';
								$pdf->Image($qr,41,176,30,30);
								$pdf->setXY(15, 223);
								$pdf->Cell(80, 7, utf8_decode($row[1]), 0,1,'C');
								$pdf->setXY(15, 228);
								$pdf->Cell(80, 7, utf8_decode($row[0]), 0,1,'C');
								$pdf->setXY(15, 234);
								$pdf->Cell(80, 7, 'C.I. '.utf8_decode($row[2]), 0,1,'C');	 
								$posicion++;
							break;
							case 3:
								$posicion = 0;
								$pdf->designDown(100);
								$qr='https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=IDInscrito.'.$row[2].'.CodigoInscripcion.'.$row[3].'&.png';
								$pdf->Image($qr,141,176,30,30);
								$pdf->setXY(115, 223);
								$pdf->Cell(80, 7, utf8_decode($row[1]), 0,1,'C');
								$pdf->setXY(115, 228);
								$pdf->Cell(80, 7, utf8_decode($row[0]), 0,1,'C');
								$pdf->setXY(115, 234);
								$pdf->Cell(80, 7, 'C.I. '.utf8_decode($row[2]), 0,1,'C');
								$pdf->AddPage('P', 'Letter');
							break;
						}
					}
					mysqli_free_result($result);
				}
		
			} while (mysqli_next_result($conexionj));
		  $nombredoc='Credenciales';
		  $pdf->Output($nombredoc.'.pdf','D');
		}

	}

	
?>
