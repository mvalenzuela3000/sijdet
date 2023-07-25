<?php
require('fpdf/fpdf.php');
 
class PDF extends FPDF
{
	public $numero;
	public $suma;
    function cabeceraHorizontal()
    {
        $this->SetXY(10, 30);
        $this->SetFont('Arial','B',8);
        $this->SetFillColor(2,157,116);//Fondo verde de celda
        $this->SetTextColor(240, 255, 240); //Letra color blanco
        $ejeX = 10;
		$this->RoundedRect($ejeX, 30, 20, 7, 2, 'FD');
		$this->CellFitSpace(20,7, 'Nro. DOCUMENTO',0, 0 , 'C');
		$ejeX = $ejeX + 20;
		$this->RoundedRect($ejeX, 30, 20, 7, 2, 'FD');
		$this->CellFitSpace(20,7, 'FECHA',0, 0 , 'C');
		$ejeX = $ejeX + 20;
		
		$this->RoundedRect($ejeX, 30, 80, 7, 2, 'FD');
		$this->CellFitSpace(80,7, 'DEPOSITANTE',0, 0 , 'C');
		$ejeX = $ejeX + 80;
		$this->RoundedRect($ejeX, 30, 30, 7, 2, 'FD');
		$this->CellFitSpace(30,7, 'TIPO DOCUMENTO',0, 0 , 'C');
		$ejeX = $ejeX + 30;
		$this->RoundedRect($ejeX, 30, 15, 7, 2, 'FD');
		$this->CellFitSpace(15,7, 'MONTO',0, 0 , 'C');
		$ejeX = $ejeX + 15;
		$this->RoundedRect($ejeX, 30, 15, 7, 2, 'FD');
		$this->CellFitSpace(15,7, 'INSC',0, 0 , 'C');
		$ejeX = $ejeX + 15;
		$this->RoundedRect($ejeX, 30, 15, 7, 2, 'FD');
		$this->CellFitSpace(15,7, 'ESTADO',0, 0 , 'C');
		$ejeX = $ejeX + 15;
	
    }
	
 
    function datosHorizontal($datos,$inicio,$fin)
    {
        $this->SetXY(10,37);
        $this->SetFont('Arial','',8);
        $this->SetFillColor(229, 229, 229); //Gris tenue de cada fila
        $this->SetTextColor(3, 3, 3); //Color del texto: Negro
        $ejeY = 37; //Aquí se encuentra la primer CellFitSpace e irá incrementando
        $cont=$inicio+1;
		$numero=0;
		$suma=0;
        for($j=$inicio;$j<$fin;$j++)
		{
			$t=explode('+', $datos[$j]);
			$numero++;
            $this->RoundedRect(10, $ejeY, 195, 10, 2, 'D');
            $this->CellFitSpace(20,10, $t[0],0, 0 , 'C' );
            $this->CellFitSpace(20,10, $t[2],'LR', 0 , 'C' );
            
			$this->CellFitSpace(80,10, $t[7],'LR', 0 , 'L' );
			$this->CellFitSpace(30,10, $t[4],'LR', 0 , 'C' );
			$this->CellFitSpace(15,10, $t[3],'LR', 0 , 'C' );
			$this->CellFitSpace(15,10, $t[5],'LR', 0 , 'C' );
 			$this->CellFitSpace(15,10, $t[6],0, 0 , 'L' );
            $this->Ln();
			$suma=$suma+$t[3];
			$cont++;
            $ejeY = $ejeY + 10;
		}
		$this->SetFont('Arial','B',10);
		//$this->RoundedRect(10, $ejeY, 195, 10, 2, 'D');
		//$this->CellFitSpace(195,10, 'TOTAL REGISTROS:  '.$numero.'    -    SUMA DEPOSITOS:  '.$suma,0, 0 , 'C' );
    }
 	function datosVertical($datos)
    {
        $this->SetXY(70, 60); //40 = 10 posiciónX_anterior + 30ancho Celdas de cabecera
        $this->SetFont('Arial','',10); //Fuente, Normal, tamaño
        $this->SetFillColor(240, 240, 240); //Gris tenue de cada fila
        $this->SetTextColor(18, 20, 66); //Color del texto: Negro
        $ejeY=60;
        foreach($datos as $columna)
        {
        	$this->RoundedRect(70, $ejeY, 120, 7, 2, 'FD');
            $this->CellFitSpace(120,7, utf8_decode($columna),0, 2 , 'L' );
			$ejeY = $ejeY + 7;
        }
    }
	function datosVertical2($datos)
    {
        $this->SetXY(70, 135); //40 = 10 posiciónX_anterior + 30ancho Celdas de cabecera
        $this->SetFont('Arial','',10); //Fuente, Normal, tamaño
         $this->SetFillColor(240, 240, 240); //Gris tenue de cada fila
        $this->SetTextColor(18, 20, 66); //Color del texto: Negro
        $ejeY=135;
        foreach($datos as $columna)
        {
        	$this->RoundedRect(70, $ejeY, 120, 7, 2, 'FD');
            $this->CellFitSpace(80,7, utf8_decode($columna),0, 2 , 'L' );
			$ejeY = $ejeY + 7;
        }
    }
 
    function tablaHorizontal($terminos,$inicio,$fin)
    {
        $this->cabeceraHorizontal();
        $this->datosHorizontal($terminos,$inicio,$fin);
    }
	function tablaVertical($cabeceraVertical, $datosVertical)
    {
        $this->cabeceraVertical($cabeceraVertical);
        $this->datosVertical($datosVertical);
    }
 
    //**************************************************************************************************************
    function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
    {
        //Get string width
        $str_width=$this->GetStringWidth($txt);
		if($str_width==0){
			$str_width=1;
		}
 
        //Calculate ratio to fit cell
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $ratio = ($w-$this->cMargin*2)/$str_width;
 
        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit)
        {
            if ($scale)
            {
                //Calculate horizontal scaling
                $horiz_scale=$ratio*100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
            }
            else
            {
                //Calculate character spacing in points
                $char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET',$char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }
 
        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);
 
        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
    }
 
    function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
    }
 
    //Patch to also work with CJK double-byte text
    function MBGetStringLength($s)
    {
        if($this->CurrentFont['type']=='Type0')
        {
            $len = 0;
            $nbbytes = strlen($s);
            for ($i = 0; $i < $nbbytes; $i++)
            {
                if (ord($s[$i])<128)
                    $len++;
                else
                {
                    $len++;
                    $i++;
                }
            }
            return $len;
        }
        else
            return strlen($s);
    }
//**********************************************************************************************
 
 function RoundedRect($x, $y, $w, $h, $r, $style = '', $angle = '1234')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' or $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2f %.2f m', ($x+$r)*$k, ($hp-$y)*$k ));
 
        $xc = $x+$w-$r;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l', $xc*$k, ($hp-$y)*$k ));
        if (strpos($angle, '2')===false)
            $this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k, ($hp-$y)*$k ));
        else
            $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
 
        $xc = $x+$w-$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k, ($hp-$yc)*$k));
        if (strpos($angle, '3')===false)
            $this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k, ($hp-($y+$h))*$k));
        else
            $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
 
        $xc = $x+$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l', $xc*$k, ($hp-($y+$h))*$k));
        if (strpos($angle, '4')===false)
            $this->_out(sprintf('%.2f %.2f l', ($x)*$k, ($hp-($y+$h))*$k));
        else
            $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
 
        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l', ($x)*$k, ($hp-$yc)*$k ));
        if (strpos($angle, '1')===false)
        {
            $this->_out(sprintf('%.2f %.2f l', ($x)*$k, ($hp-$y)*$k ));
            $this->_out(sprintf('%.2f %.2f l', ($x+$r)*$k, ($hp-$y)*$k ));
        }
        else
            $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }
 
    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }
	
	function Header()
 
	{
	   
	       // seteamos el tipo de letra Arial Negrita 16
	    $this->SetFont('Arial','B',12);
	 
	    // ponemos una celda sin contenido para centrar el titulo o la celda del titulo a la derecha
	    $this->Cell(40);
	 
	    // definimos la celda el titulo
	    $this->CellFitSpace(120,20,'DEPOSITOS REGISTRADOS',0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','I',10);
		$this->Cell(40);
	 	$this->CellFitSpace(120,20,utf8_decode('XII Jornadas Bolivianas de Derecho Tributario 2019'),0,0,'C');
	    // Salto de línea salta 20 lineas
	    $this->Ln(10);
	 
	}
	 
	// utilizamos la funcion Footer() y la personalizamos para que muestre el pie de página
	function Footer()
	 
	{
	    // Seteamos la posicion de la proxima celda en forma fija a 1,5 cm del final de la pagina
	 
	    $this->SetY(-15);
	    // Seteamos el tipo de letra Arial italica 10
	 
	    $this->SetFont('Arial','I',8);
	    // Número de página
	 
	    $this->Cell(0,8,'Página '.$this->PageNo().' de {nb}   - - - -   Impreso el ' . date('d/m/Y') . ' a las ' . date('H:i:s') . ' hora del servidor','T',0,'C');
	}
} // FIN Class PDF

?>