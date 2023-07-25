<?php

 $conexion = new mysqli('localhost','u_consulta','u_consulta_ait','bd_transparencia',3306);
if ($conexion->connect_errno) {
    echo "Fall� la conexi�n a MySQL: (" . $conexion->connect_errno . ") " . $coenxion->connect_error;
}
$valor=$_POST["reservation"];
$t=explode('-',$valor);
$desde=trim($t[0]);
$hasta=trim($t[1]);
$arit=$_POST["arit"];
$tdesde=explode('/',$desde);
$thasta=explode('/',$hasta);
$desdef=$tdesde[2].'-'.$tdesde[1].'-'.$tdesde[0];
$hastaf=$thasta[2].'-'.$thasta[1].'-'.$thasta[0];

 //echo $arit." - ".$desdef." - ".$hastaf;
 
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/La_Paz');

if (PHP_SAPI == 'cli')
  die('Solo puede ejecutarse en un navegador web');


require_once 'PHPExcel.php';
require_once 'PHPExcel/IOFactory.php';

$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("F_1511.xls");
 

// Add some data
$objPHPExcel->getActiveSheet()->setCellValue('G16', $desde);
$objPHPExcel->getActiveSheet()->setCellValue('M16', $hasta);


$query="CALL pa_obtiene_quejas_rango_fechas('$desdef','$hastaf','$arit')";

$i=0;
$filaini=20;

if (mysqli_multi_query($conexion, $query)) {
    do {
        if ($result = mysqli_store_result($conexion)) {
            while ($row = mysqli_fetch_row($result)) {
                $i++;
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$filaini, $i);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$filaini, $row[0].'/'.$row[1]);
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$filaini, utf8_encode($row[13]));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$filaini, $row[9]);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$filaini, 'Buzón Virtual - Página Web');
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$filaini, $row[2]);
                if($row[8]=='SI')
                {
                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$filaini, 'X');
                }
                else
                {
                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$filaini, 'X');
                }
                $objPHPExcel->getActiveSheet()->setCellValue('P'.$filaini, $row[11]);
                if($row[10]!='' || $row[10] !=null)
                {
                    $objPHPExcel->getActiveSheet()->setCellValue('X'.$filaini, 'X');
                }
                else
                {
                    $objPHPExcel->getActiveSheet()->setCellValue('Y'.$filaini, 'X');
                }
                $filaini++;
            }
            mysqli_free_result($result);
        }

    } while ($conexion->more_results() && $conexion->next_result());
}


mysqli_close($conexion);






// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$filename="F-1511-".$desde."_".$hasta.".xls";
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
 

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>