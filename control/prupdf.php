<?php 
/*function genera_pdf()
{
	ob_start();
   include('../vista/formInscripcion.php');
    $content = ob_get_clean();
 
    //Se obtiene la librería
    include('html2pdf/html2pdf.class.php');
 
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'es', true, 'UTF-8', 3);
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $html2pdf->Output('exemple03.pdf','D');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
}*/
 
echo substr('TRANSFERENCIA', 0,3);
 
?>