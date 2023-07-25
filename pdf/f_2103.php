<?php
session_start();
include_once ('../conexion.php');
require_once ('class.ezpdf.php');
date_default_timezone_set("America/La_Paz");
$id = base64_decode($_GET["1d"]);
$ges=base64_decode($_GET["g35"]);
$queja=base64_decode($_GET["qu3j4"]);
$pruebas=base64_decode($_GET["pru"]);
$anonimo=base64_decode($_GET["an0"]);
$nombre=base64_decode($_GET["n0m"]);
$ci=base64_decode($_GET["c1"]);
$tel=base64_decode($_GET["t3l"]);
$email=base64_decode($_GET["m41l"]);
$direccion=base64_decode($_GET["d1r"]);
$reserva=base64_decode($_GET["r35"]);
$lugar=base64_decode($_GET["0f1"]);
$sinpruebas=base64_decode($_GET["5pr"]);
$nomservidor=base64_decode($_GET["n05"]);
$cargoservidor=base64_decode($_GET["c45"]);
$indpersona=base64_decode($_GET["1p5"]);

//$adjuntos=base64_decode($_GET["4dj"]);

$pdf = new Cezpdf('LETTER','portrait');
$pdf->selectFont('../fonts/Helvetica.afm');
$pdf->ezSetCmMargins(1,1,1,1.2);
function puntos_cm ($medida, $resolucion=72)
{
   //// 2.54 cm / pulgada
   return ($medida/(2.54))*$resolucion;
}


function validanum($numero)
{
	if($numero<10)
	{
		$valor="000".$numero;
		return ($valor);
	}
    if($numero>=10 && $numero <100)
	{
		$valor="00".$numero;
		return ($valor);
	}
	if($numero>=100 && $numero <1000)
	{
		$valor="0".$numero;
		return ($valor);
	}
	if($numero>=1000)
	{
		return ($numero);
	}
}

$txttit1= utf8_decode("Agradecemos a usted su cooperación para fortalecer la mejora continua en los servicios que le brinda la Autoridad de Impugnación Tributaria (AIT), por lo que es importante  conocer sus quejas y/o sugerencias sobre el servicio que reciben en esta institución.  En caso que usted haya advertido, la existencia de mala calidad en alguna de las actividades misionales y/o de apoyo que se relacionan directamente con el servicio que presta la institución en cualquiera de sus dependencias o problemas y/o deficiencias en los espacios físicos y condiciones de trabajo, para el desarrollo de los trámites de los/as recurrentes, agradeceremos llene y presente éste formulario.");
$pdf->ezImage("ENC-AUNI.png", 0, 200, 'none', 'left');

$pdf->setColor(0.8,0.8,0.8);
$pdf->setStrokeColor(0,0,0);
$pdf->setLineStyle(1,'round'); 
$pdf->rectangle (puntos_cm(13.7), puntos_cm(25.8), puntos_cm(3.2), puntos_cm(0.7));
$pdf->setColor(0, 0 ,0);
$pdf->addText(puntos_cm(14.5),puntos_cm(25.5),8,'No. de control');
//$pdf->addText(puntos_cm(23.9),puntos_cm(18.7),10,'(Fecha de sorteo)');
$pdf->addText(puntos_cm(14.4),puntos_cm(26),12,validanum($id).'/'.date(Y));//numero de control
$pdf->rectangle (puntos_cm(17.4), puntos_cm(25.8), puntos_cm(2.8), puntos_cm(0.7));
$pdf->setColor(0, 0 ,0);
$pdf->addText(puntos_cm(17.7),puntos_cm(25.5),8,'Cod. de la Norma');
$pdf->addText(puntos_cm(17.8),puntos_cm(26),12,' P/GC-005');
$pdf->addText(puntos_cm(18.2),puntos_cm(26.7),10,'F-1509');
$pdf->rectangle (puntos_cm(1.1), puntos_cm(24.2), puntos_cm(19.1), puntos_cm(1));
$pdf->addText(puntos_cm(2.5),puntos_cm(24.5),15,utf8_decode('FORMULARIO DE RECEPCIÓN DE QUEJAS Y/O SUGERENCIAS'));
$pdf->setLineStyle(0.8,'round');
$pdf->rectangle (puntos_cm(1), puntos_cm(22.3), puntos_cm(9), puntos_cm(0.6));
$pdf->addText(puntos_cm(1.3),puntos_cm(22.5),10,'LUGAR DONDE OCURRIO EL HECHO');
$pdf->rectangle (puntos_cm(1), puntos_cm(21.6), puntos_cm(9), puntos_cm(0.6));
$pdf->addText(puntos_cm(1.3),puntos_cm(21.8),10,'DATOS DE LA QUEJA O SUGERENCIA');
$pdf->rectangle (puntos_cm(1), puntos_cm(20.5), puntos_cm(19.1), puntos_cm(1));
$pdf->addText(puntos_cm(1.3),puntos_cm(21),8,'DESCRIBE TU QUEJA O SUGERENCIA.');
$pdf->addText(puntos_cm(6.6),puntos_cm(21),7,utf8_decode('(Por favor realizar una explicación breve y concreta de los hechos que dan lugar a su queja o sugerencia. Para ello tomar'));
$pdf->addText(puntos_cm(1.3),puntos_cm(20.7),7,utf8_decode('en cuenta las siguientes preguntas guía para exponer los hechos: ¿Qué ocurrió?, ¿Cuándo ocurrió?, ¿Cómo ocurrió?, ¿Dónde ocurrió?, ¿Quién lo hizo?'));
$pdf->rectangle (puntos_cm(1), puntos_cm(15), puntos_cm(19.1), puntos_cm(5.5));
$txtpruebas=$queja;//queja
$pdf->rectangle (puntos_cm(1), puntos_cm(13.3), puntos_cm(19.1), puntos_cm(0.6));
$pdf->addText(puntos_cm(1.1),puntos_cm(13.5),8,'PRUEBAS DE LA QUEJA.');
$pdf->addText(puntos_cm(4.5),puntos_cm(13.5),7,'(Sólo en caso de presentar una queja, por favor indicar las pruebas que presenta para respaldo');
$pdf->rectangle (puntos_cm(1), puntos_cm(9.9), puntos_cm(19.1), puntos_cm(3.3));
$pdf->addText(puntos_cm(1.3),puntos_cm(13),7,utf8_decode($pruebas));//pruebas de queja

$pdf->rectangle (puntos_cm(1), puntos_cm(13.3), puntos_cm(19.1), puntos_cm(0.6));
$pdf->addText(puntos_cm(1.1),puntos_cm(13.5),8,'PRUEBAS DE LA QUEJA.');
$pdf->addText(puntos_cm(4.5),puntos_cm(13.5),7,'(Sólo en caso de presentar una queja, por favor indicar las pruebas que presenta para respaldo');
$pdf->rectangle (puntos_cm(1), puntos_cm(9.9), puntos_cm(19.1), puntos_cm(3.3));
$pdf->addText(puntos_cm(1.3),puntos_cm(13),7,utf8_decode($pruebas));//funciionario

$pdf->rectangle (puntos_cm(1), puntos_cm(9), puntos_cm(9), puntos_cm(0.6));
$pdf->addText(puntos_cm(1.3),puntos_cm(9.2),10,'DATOS DEL/LA GENERADOR/A DE LA QUEJA');
$pdf->rectangle (puntos_cm(1), puntos_cm(7.8), puntos_cm(19.1), puntos_cm(1));
$pdf->addText(puntos_cm(1.3),puntos_cm(8.4),8,'IDENTIFICACI�N.');
$pdf->addText(puntos_cm(3.7),puntos_cm(8.4),7,'(Por favor indique sus datos personales para poder contactarlo en caso de requerir mayor informaci�n e/o informarle sobre el desarrollo del caso.');
$pdf->addText(puntos_cm(1.3),puntos_cm(8.0),7,'Tambi�n puede presentar �ste formulario de forma AN�NIMA y no ingresar ning�n dato)');
$pdf->addText(puntos_cm(1.3),puntos_cm(7.4),8,'Nota: El tratamiento y acci�n derivada de la presente queja, ser� respondida formalmente mediante la respectiva nota de respuesta de acuerdo a los ');
$pdf->addText(puntos_cm(1.3),puntos_cm(7.1),8,'datos que el/la denunciante proporcione. ');
if($anonimo=='SI')
{
    $pdf->addText(puntos_cm(3.8),puntos_cm(6.4),9,'Nombre:');
    $pdf->addText(puntos_cm(1.5),puntos_cm(5.9),9,'Documento de identidad:');
    $pdf->addText(puntos_cm(2.6),puntos_cm(5.4),9,'Tel�fono/Celular:');
    $pdf->addText(puntos_cm(2.3),puntos_cm(4.9),9,'Correo electr�nico:');
    $pdf->addText(puntos_cm(3.6),puntos_cm(4.4),9,'Direcci�n:');
}
else 
{
    $pdf->addText(puntos_cm(3.8),puntos_cm(6.4),9,'Nombre: '.utf8_decode($nombre));
    $pdf->addText(puntos_cm(1.5),puntos_cm(5.9),9,'Documento de identidad: '.$ci);
    $pdf->addText(puntos_cm(2.6),puntos_cm(5.4),9,'Tel�fono/Celular: '.$tel);
    $pdf->addText(puntos_cm(2.3),puntos_cm(4.9),9,'Correo electr�nico: '.utf8_decode($email));
    $pdf->addText(puntos_cm(3.6),puntos_cm(4.4),9,'Direcci�n: '.utf8_decode($direccion));
}

$pdf->addText(puntos_cm(14),puntos_cm(5.9),9,'�Mantener en reserva su identidad?');
if($reserva=="SI")
{
    $pdf->addText(puntos_cm(15.2),puntos_cm(5.4),9,'SI    X');
    $pdf->addText(puntos_cm(17.2),puntos_cm(5.4),9,'NO');
}
else
{
    $pdf->addText(puntos_cm(15.2),puntos_cm(5.4),9,'SI');
    $pdf->addText(puntos_cm(17.2),puntos_cm(5.4),9,'NO    X');
}

$pdf->rectangle (puntos_cm(15.7), puntos_cm(5.3), puntos_cm(0.5), puntos_cm(0.5));
$pdf->rectangle (puntos_cm(17.9), puntos_cm(5.3), puntos_cm(0.5), puntos_cm(0.5));
$pdf->line(puntos_cm(1),puntos_cm(1.5),puntos_cm(20),puntos_cm(1.5));
$pdf->addText(puntos_cm(1.5),puntos_cm(1.2),8,'Fecha: '.date("d/m/Y").'    Hora: '.date("H:i:s"));

//fin encabezado
		
	$pdf->ezText("\n\n", 08);
$pdf->ezText(utf8_encode($txttit1),6);

$pdf->ezText("\n\n\n\n\n", 10);
$pdf->ezText($txtpruebas,8);
$pdf->ezText("\n\n\n\n\n\n\n\n\n", 10);


ob_end_clean();
$pdf->ezStream();
?>

