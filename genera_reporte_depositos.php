<?php
	if(isset($_POST["excel"])){
		$conexion = new mysqli('localhost','u_consulta','u_consulta_ait','bd_jornadas',3306);
		if ($conexion->connect_errno) {
		    echo "Fall� la conexi�n a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
		}
		/*$valor=base64_decode($_GET["1n5"]);
		$gestion=base64_decode($_GET["g3s"]);*/
		$gestion=$_POST["gestion"];
		$criterio=$_POST["deposito"];

		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		date_default_timezone_set('America/La_Paz');

		if (PHP_SAPI == 'cli')
		  die('Solo puede ejecutarse en un navegador web');

		require_once 'PHPExcel.php';
		require_once 'PHPExcel/IOFactory.php';

		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = $objReader->load("ListaDepositos.xls");
		 
		$objPHPExcel->getActiveSheet()->setCellValue('A5', $gestion);

		$query="call pa_obtiene_estado_depositos($gestion,$criterio)";

		$i=0;
		$filaini=5;
		$suma=0;
		$styleArray = array(
		    'font' => array(
		        'bold' => true,
		    ),
		    'alignment' => array(
		        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
		    ),
		    'borders' => array(
		        'top' => array(
		            'style' => PHPExcel_Style_Border::BORDER_THIN,
		        ),
		    ),
		    'fill' => array(
		        'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
		        'rotation' => 90,
		        'startcolor' => array(
		            'argb' => 'FFA0A0A0',
		        ),
		        'endcolor' => array(
		            'argb' => 'FFFFFFFF',
		        ),
		    ),
		);
		$objPHPExcel->getActiveSheet()->setCellValue('B3', $gestion);
		if (mysqli_multi_query($conexion, $query)) {
		    do {
		        if ($result = mysqli_store_result($conexion)) {
		            while ($row = mysqli_fetch_row($result)) {
		                $i++;
		                $objPHPExcel->getActiveSheet()->setCellValue('A'.$filaini, $i);
		                $objPHPExcel->getActiveSheet()->setCellValue('B'.$filaini, $row[0]);
						$objPHPExcel->getActiveSheet()->setCellValue('C'.$filaini, $row[2]);
						$objPHPExcel->getActiveSheet()->setCellValue('D'.$filaini, html_entity_decode($row[7]));
						$objPHPExcel->getActiveSheet()->setCellValue('E'.$filaini, $row[4]);
						$objPHPExcel->getActiveSheet()->setCellValue('F'.$filaini, $row[3]);
						$objPHPExcel->getActiveSheet()->setCellValue('G'.$filaini, $row[5]);
						$objPHPExcel->getActiveSheet()->setCellValue('H'.$filaini, $row[6]);
		                $suma=$suma+$row[3];
		                $filaini++;
		            }
		            mysqli_free_result($result);
		        }

		    } while ($conexion->more_results() && $conexion->next_result());
		}
		$objPHPExcel->getActiveSheet()->getStyle('E'.$filaini)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->getStyle('F'.$filaini)->applyFromArray($styleArray);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$filaini, 'TOTAL');
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$filaini, $suma);
		mysqli_close($conexion);



		$objPHPExcel->setActiveSheetIndex(0);

		$filename="ListaDepositos-".$gestion.".xls";

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		header('Cache-Control: max-age=1');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
	}else{
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

	}
	
	

?>
