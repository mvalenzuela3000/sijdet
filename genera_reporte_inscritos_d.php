<?php

$conexion = new mysqli('localhost','u_consulta','u_consulta_ait','bd_jornadas',3306);
if ($conexion->connect_errno) {
    echo "Fall� la conexi�n a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
}
$valor=base64_decode($_GET["1n5"]);
$gestion=base64_decode($_GET["g3s"]);

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/La_Paz');

if (PHP_SAPI == 'cli')
  die('Solo puede ejecutarse en un navegador web');

require_once 'PHPExcel.php';
require_once 'PHPExcel/IOFactory.php';

$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("ListaInscritos.xls");
 
$objPHPExcel->getActiveSheet()->setCellValue('A5', $gestion);

$query="CALL pa_genera_listado_inscritos('$gestion','$valor')";

$i=0;
$filaini=7;
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
if (mysqli_multi_query($conexion, $query)) {
    do {
        if ($result = mysqli_store_result($conexion)) {
            while ($row = mysqli_fetch_row($result)) {
                $i++;
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$filaini, $i);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$filaini, html_entity_decode($row[0]));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.$filaini, html_entity_decode($row[1]));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.$filaini, $row[2]);
				$objPHPExcel->getActiveSheet()->setCellValue('E'.$filaini, $row[3]);
				$objPHPExcel->getActiveSheet()->setCellValue('F'.$filaini, $row[4]);
				$objPHPExcel->getActiveSheet()->setCellValue('G'.$filaini, $row[5]);
				$objPHPExcel->getActiveSheet()->setCellValue('H'.$filaini, $row[6]);
				$objPHPExcel->getActiveSheet()->setCellValue('I'.$filaini, $row[19]);
				$objPHPExcel->getActiveSheet()->setCellValue('J'.$filaini, $row[7]);
				$objPHPExcel->getActiveSheet()->setCellValue('K'.$filaini, $row[8]);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$filaini, $row[9]);
				$objPHPExcel->getActiveSheet()->setCellValue('M'.$filaini, $row[10]);
				$objPHPExcel->getActiveSheet()->setCellValue('N'.$filaini, $row[11]);
				$objPHPExcel->getActiveSheet()->setCellValue('O'.$filaini, $row[12]);
				$objPHPExcel->getActiveSheet()->setCellValue('P'.$filaini, $row[13]);
				$objPHPExcel->getActiveSheet()->setCellValue('Q'.$filaini, $row[14]);
				$objPHPExcel->getActiveSheet()->setCellValue('R'.$filaini, $row[15]);
				$objPHPExcel->getActiveSheet()->setCellValue('S'.$filaini, $row[16]);
				$objPHPExcel->getActiveSheet()->setCellValue('T'.$filaini, $row[17]);
				$objPHPExcel->getActiveSheet()->setCellValue('U'.$filaini, $row[18]);
				$objPHPExcel->getActiveSheet()->setCellValue('V'.$filaini, $row[20]);
                $suma=$suma+$row[12];
                $filaini++;
            }
            mysqli_free_result($result);
        }

    } while ($conexion->more_results() && $conexion->next_result());
}
$objPHPExcel->getActiveSheet()->getStyle('N'.$filaini)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('O'.$filaini)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->setCellValue('N'.$filaini, 'TOTAL');
$objPHPExcel->getActiveSheet()->setCellValue('O'.$filaini, $suma);
mysqli_close($conexion);



$objPHPExcel->setActiveSheetIndex(0);

$filename="ListaInscritos-".$gestion.".xls";

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

header('Cache-Control: max-age=1');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>