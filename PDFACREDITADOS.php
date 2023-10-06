<?php
require('fpdf/fpdf.php');
 
class PDF extends FPDF
{
    public $titulo;
    function cabeceraHorizontal($cabecera)
    {
        $this->SetXY(10, 30);
        $this->SetFont('Arial','B',8);
        $this->SetFillColor(2,157,116);//Fondo verde de celda
        $this->SetTextColor(240, 255, 240); //Letra color blanco
        $ejeX = 10;
		$this->RoundedRect($ejeX, 30, 8, 7, 2, 'FD');
		$this->CellFitSpace(8,7, 'Nro',0, 0 , 'C');
		$ejeX = $ejeX + 8;
		$this->RoundedRect($ejeX, 30, 80, 7, 2, 'FD');
		$this->CellFitSpace(80,7, 'NOMBRES Y APELLIDOS',0, 0 , 'C');
		$ejeX = $ejeX + 80;
		$this->RoundedRect($ejeX, 30, 20, 7, 2, 'FD');
		$this->CellFitSpace(20,7, 'C.I.',0, 0 , 'C');
		$ejeX = $ejeX + 20;
		$num=count($cabecera);
		$tam=100/$num;
		$this->SetFont('Arial','B',6);
        foreach($cabecera as $fila)
        {
            $this->RoundedRect($ejeX, 30, $tam, 7, 2, 'FD');
            $this->CellFitSpace($tam,7, utf8_decode($fila),0, 0 , 'C');
            $ejeX = $ejeX + $tam;
        }
		$this->SetFont('Arial','B',8);
		$this->RoundedRect($ejeX, 30, 50, 7, 2, 'FD');
		$this->CellFitSpace(50,7, 'FIRMA',0, 0 , 'C');
		$ejeX = $ejeX + 50;
    }
	function cabeceraVertical($cabecera)
	{
		$this->SetXY(20, 60);
        $this->SetFont('Arial','B',10);
		 $this->SetFillColor(80,160,8);//Fondo verde de celda
        $this->SetTextColor(255, 255, 255); //Letra color blanco
		
        $ejeX = 20;
		$ejeY=60;
        foreach($cabecera as $columna)
        {
        	$this->RoundedRect($ejeX, $ejeY, 50, 7, 2, 'FD');
        	$this->CellFitSpace(50,7, utf8_decode($columna),0, 2 , 'L' );
			$ejeY=$ejeY+7;
		}
	}
	function cabeceraVertical2($cabecera)
	{
		$this->SetXY(20, 135);
        $this->SetFont('Arial','B',10);
		$this->SetFillColor(80,160,8);//Fondo verde de celda
        $this->SetTextColor(255, 255, 255); //Letra color blanco
     	 $ejeX = 20;
		$ejeY=135;
        foreach($cabecera as $columna)
        {
            //Parámetro con valor 2, hace que la cabecera sea vertical
            $this->RoundedRect($ejeX, $ejeY, 50, 7, 2, 'FD');
			$this->CellFitSpace(50,7, utf8_decode($columna),0, 2 , 'L'); //
			$ejeY=$ejeY+7;
        }
	}
 
    function datosHorizontal($datos,$cabecera,$inicio,$fin)
    {
        $this->SetXY(10,37);
        $this->SetFont('Arial','',8);
        $this->SetFillColor(229, 229, 229); //Gris tenue de cada fila
        $this->SetTextColor(3, 3, 3); //Color del texto: Negro
        $ejeY = 37; //Aquí se encuentra la primer CellFitSpace e irá incrementando
        $cont=$inicio+1;
		$contacre=0;
		$num=count($cabecera);
		$tam=100/$num;
      
        for($j=$inicio;$j<$fin;$j++)
		{
			$t=explode('*', $datos[$j]);
			
            $this->RoundedRect(10, $ejeY, 258, 10, 2, 'D');
            $this->CellFitSpace(8,10, $cont,0, 0 , 'C' );
            $this->CellFitSpace(80,10, $t[0],'LR', 0 , 'L' );
            $this->CellFitSpace(20,10, $t[1],0, 0 , 'L' );
			
 			for($i=0;$i<$num;$i++)
			{
				if($t[2]==1){
					$this->CellFitSpace($tam,10, 'X','LR', 0 , 'C' );
					$contacre++;
				}
				else {
					$this->CellFitSpace($tam,10, '','LR', 0 , 'C' );
				}
			}
            $this->CellFitSpace(50,10, 'Registro mediante sistema.',0, 0 , 'C');
            $this->Ln();
			$cont++;
            $ejeY = $ejeY + 10;
		}
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
 
    function tablaHorizontal($miCabecera,$terminos,$inicio,$fin)
    {
        $this->cabeceraHorizontal($miCabecera);
        $this->datosHorizontal($terminos,$miCabecera,$inicio,$fin);
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
	    $this->Cell(70);
	 
	    // definimos la celda el titulo
	    $this->CellFitSpace(120,20,'ACREDITACION DE PARTICIPANTES',0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','I',10);
		$this->Cell(70);
        $this->CellFitSpace(120,20,utf8_decode($this->titulo),0,0,'C');
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