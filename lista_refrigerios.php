<?php

include_once 'includes/funj.php';
include_once 'PDFREFRIGERIOS.php';
$gestion = $_POST["gestion"];
$rango = $_POST["inscrito"];
$valores = array('18/10/2023 (M)','18/10/2023 (T)','19/10/2023 (M)','19/10/2023 (T)','20/10/2023 (M)','20/10/2023 (T)');
$terminos = inscritosyrefrigerios($gestion, $rango);
function contararefrigerios($terminos,$item)
{
	$cont = 0;
	for ($j = 0; $j < count($terminos); $j++) {
		$t = explode('*', $terminos[$j]);
		if ($t[$item] == 'X') {
			$cont++;
		}
	}
	return $cont;
}

$pdf = new PDF('L', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->titulo=nombreevento($gestion);
$numregistros = count($terminos);
$divide = ceil($numregistros / 15);
if ($numregistros == 0) {
	$pdf->AddPage();
	$pdf->SetFont('Arial', 'B', 8);
	$pdf->Cell(250, 10, 'TOTAL REFRIGERIOS ENTREGADOS: 18/10/2023 (M): ' . contararefrigerios($terminos,2).' 18/10/2023 (T): ' . contararefrigerios($terminos,3).' 19/10/2023 (M): ' . contararefrigerios($terminos,4).' 19/10/2023 (T): ' . contararefrigerios($terminos,5).' 20/10/2023 (M): ' . contararefrigerios($terminos,6).' 20/10/2023 (T): ' . contararefrigerios($terminos,7), 0, 0, 'R');
} else {
	$control = 1;
	$rfin = 0;
	while ($control <= $divide) {
		if ($control == $divide) {
			$rinicio = $rfin;
			$rfin = $numregistros;
			$pdf->AddPage();
			$pdf->Image('images/logoXjornadas.png', 10, 10, 26, 0);

			$pdf->SetFont('Arial', 'B', 10);

			$miCabecera = array();
			foreach ($valores as $col) {
				$miCabecera[] = $col;
			}
			$pdf->tablaHorizontal($miCabecera, $terminos, $rinicio, $rfin);
			$pdf->SetFont('Arial', 'B', 10);
		} else {
			$rinicio = $rfin;
			$rfin = $rinicio + 15;
			$pdf->AddPage();
			$pdf->Image('images/logoXjornadas.png', 10, 10, 26, 0);

			$pdf->SetFont('Arial', 'B', 10);

			$miCabecera = array();
			foreach ($valores as $col) {
				$miCabecera[] = $col;
			}
			$pdf->tablaHorizontal($miCabecera, $terminos, $rinicio, $rfin);
			$pdf->SetFont('Arial', 'B', 10);
		}
		$control++;
	}
	$pdf->Cell(250, 10, 'TOTAL REFRIGERIOS ENTREGADOS: 18/10/2023 (M): ' . contararefrigerios($terminos,2).' 18/10/2023 (T): ' . contararefrigerios($terminos,3).' 19/10/2023 (M): ' . contararefrigerios($terminos,4).' 19/10/2023 (T): ' . contararefrigerios($terminos,5).' 20/10/2023 (M): ' . contararefrigerios($terminos,6).' 20/10/2023 (T): ' . contararefrigerios($terminos,7), 0, 0, 'R');
}

$nom = "ListaEntregaRefrigerios" . $gestion . ".pdf";
$pdf->Output($nom, 'D');
