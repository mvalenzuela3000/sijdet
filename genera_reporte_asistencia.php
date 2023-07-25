<?php
ini_set('max_execution_time', 900);
include_once 'includes/funj.php';
	
    $tiporep=$_POST["criterio"];
	$f_desde=$_POST["fechaini"];
	$f_hasta=$_POST["fechafin"];
	function formato_fecha($fecha)
	{
		$tfini=explode('/',$fecha);
		$tempfini=$tfini[2].'-'.$tfini[1].'-'.$tfini[0];
		return $tempfini;
	}
	if(formato_fecha($f_hasta)<formato_fecha($f_desde)){
		?>
			<script>
				alert("La fecha 'Desde' no puede ser menor a la fecha 'Hasta', por favor revise");
				history.back(-1)
			</script>
		<?php
		exit;
	}
	
	if($tiporep==0)
	{
		include_once 'PDFASIST.php';
		$pdf = new PDF('P','mm','Letter');
		$pdf->AliasNbPages();
		$ci=$_POST["nombre"];
		$tvalor=obtiene_nom_inst_persona($ci);	
		$valor=explode('*',$tvalor);
		$terminos=marcado_individual($ci,formato_fecha($f_desde),formato_fecha($f_hasta));
		$total=obtiene_sum_total_atrasos($ci,formato_fecha($f_desde),formato_fecha($f_hasta));
		$pdf->AddPage();
		$pdf->Image('images/logoXjornadas.png',10,10,13,0);
		
		$pdf->SetFont('Arial','B',10);
		$pdf->SetXY(20,35);
		$pdf->RoundedRect(20, 35, 180, 10, 2, 'D');
        $pdf->CellFitSpace(180,10, 'Nombre: '.$valor[0].'      C.I.:'.$ci,0, 0 , 'L' );
		$pdf->SetXY(20,45);
		$pdf->RoundedRect(20, 45, 180, 10, 2, 'D');
        $pdf->CellFitSpace(180,10, 'Institución: '.$valor[1],0, 0 , 'L' );
		$pdf->tablaHorizontal($terminos,$total);
		$pdf->SetFont('Arial','B',10);	
		$nom="ListaAsistencia".$ci.".pdf";
		$pdf->Output($nom,'D');
		
		
	}
	elseif ($tiporep==1) {
		/*include_once 'PDFASIST.php';
		$pdf = new PDF('P','mm','Letter');
		$pdf->AliasNbPages();
		$institucion=$_POST["institucion"];
		$inscritos=inscritosxinstitucion($institucion,formato_fecha($f_desde),formato_fecha($f_hasta));
		for($j=0;$j<count($inscritos);$j++)
		{
			$tvalor=obtiene_nom_inst_persona($inscritos[$j]);
			$valor=explode('*',$tvalor);
			$terminos=marcado_individual($inscritos[$j],formato_fecha($f_desde),formato_fecha($f_hasta));
			$total=obtiene_sum_total_atrasos($inscritos[$j],formato_fecha($f_desde),formato_fecha($f_hasta));
			$pdf->AddPage();
			$pdf->Image('images/logoXjornadas.png',10,10,13,0);
			
			$pdf->SetFont('Arial','B',10);
			$pdf->SetXY(20,35);
			$pdf->RoundedRect(20, 35, 180, 10, 2, 'D');
	        $pdf->CellFitSpace(180,10, 'Nombre: '.$valor[0].'      C.I.:'.$inscritos[$j],0, 0 , 'L' );
			$pdf->SetXY(20,45);
			$pdf->RoundedRect(20, 45, 180, 10, 2, 'D');
	        $pdf->CellFitSpace(180,10, 'Institución: '.$valor[1],0, 0 , 'L' );
			$pdf->tablaHorizontal($terminos,$total);
			$pdf->SetFont('Arial','B',10);	
		}
		$nom="ListaAsistencia".$valor[1].".pdf";
		$pdf->Output($nom,'D');*/
		include_once 'PDFASISTLISTA.php';
		$pdf = new PDF('P','mm','Letter');
		$pdf->AliasNbPages();
		$institucion=$_POST["institucion"];
		$inscritos=inscritosxinstitucion($institucion,formato_fecha($f_desde),formato_fecha($f_hasta));
		$nominstitucion=obtiene_nom_inst($institucion);
		if($nominstitucion=='')
		{
			$nominstitucion=$institucion;
		}
		$numregistros=count($inscritos);
		$divide=ceil($numregistros/8);
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
				$pdf->SetXY(20,35);
				$pdf->RoundedRect(20, 35, 180, 10, 2, 'D');
				$pdf->CellFitSpace(180,10, 'Institución: '.$nominstitucion,0, 0 , 'L' );
				$pdf->cabeceraHorizontal();
				$ejeY=52;
				for($j=$rinicio;$j<$rfin;$j++)
				{
					$tvalor=obtiene_nom_inst_persona($inscritos[$j]);
					$valor=explode('*',$tvalor);
					$terminos=marcado_individual($inscritos[$j],formato_fecha($f_desde),formato_fecha($f_hasta));
					$total=obtiene_sum_total_atrasos($inscritos[$j],formato_fecha($f_desde),formato_fecha($f_hasta));
					
					$pdf->SetXY(20,$ejeY);
			        $pdf->SetFont('Arial','',8);
			        $pdf->SetFillColor(229, 229, 229); //Gris tenue de cada fila
			        $pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
					$ejeX = 20;
					$pdf->RoundedRect($ejeX, $ejeY, 60, 25, 2, 'FD');
					$pdf->CellFitSpace(60,25, $valor[0],0, 0 , 'C');
					$ejeX = $ejeX + 60;
					$pdf->RoundedRect($ejeX, $ejeY, 30, 25, 2, 'FD');
					$ejeYT=$ejeY;
					for($k=0;$k<count($terminos);$k++)
					{
						$pdf->SetXY($ejeX,$ejeYT);	
						$t=explode('-', $terminos[$k]);
						$t2=explode(' ',$t[0]);
			           	$pdf->CellFitSpace(30,8, $t2[0],0, 0 , 'C' );
			            $ejeYT = $ejeYT + 3;
					}
					$ejeX = $ejeX + 30;
					$ejeYT=$ejeY;
					$pdf->RoundedRect($ejeX, $ejeY, 30, 25, 2, 'FD');
					for($k=0;$k<count($terminos);$k++)
					{
						$pdf->SetXY($ejeX,$ejeYT);	
						$t=explode('-', $terminos[$k]);
						$t2=explode(' ',$t[0]);
			           	$pdf->CellFitSpace(30,8, $t2[1],0, 0 , 'C' );
			            $ejeYT = $ejeYT + 3;
					}
					$ejeX = $ejeX + 30;
					$ejeYT=$ejeY;
					$pdf->RoundedRect($ejeX, $ejeY, 30, 25, 2, 'FD');
					for($k=0;$k<count($terminos);$k++)
					{
						$pdf->SetXY($ejeX,$ejeYT);	
						$t=explode('-', $terminos[$k]);
						$t2=explode(' ',$t[0]);
			           	$pdf->CellFitSpace(30,8, $t[1],0, 0 , 'C' );
			            $ejeYT = $ejeYT + 3;
					}
					$ejeX = $ejeX + 30;
		
					$pdf->RoundedRect($ejeX, $ejeY, 30, 25, 2, 'FD');
					$pdf->CellFitSpace(30,15, $total. " minutos.",0, 0 , 'L');
				
					$ejeY = $ejeY + 25;
				}
			}
			else
			{
				$rinicio=$rfin;
				$rfin=$rinicio+8;
				$pdf->AddPage();
				$pdf->Image('images/logoXjornadas.png',10,10,13,0);
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(20,35);
				$pdf->RoundedRect(20, 35, 180, 10, 2, 'D');
				$pdf->CellFitSpace(180,10, 'Institución: '.$nominstitucion,0, 0 , 'L' );
				$pdf->cabeceraHorizontal();
				$ejeY=52;
				for($j=$rinicio;$j<$rfin;$j++)
				{
					$tvalor=obtiene_nom_inst_persona($inscritos[$j]);
					$valor=explode('*',$tvalor);
					$terminos=marcado_individual($inscritos[$j],formato_fecha($f_desde),formato_fecha($f_hasta));
					$total=obtiene_sum_total_atrasos($inscritos[$j],formato_fecha($f_desde),formato_fecha($f_hasta));
					
					$pdf->SetXY(20,$ejeY);
			        $pdf->SetFont('Arial','',8);
			        $pdf->SetFillColor(229, 229, 229); //Gris tenue de cada fila
			        $pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
					$ejeX = 20;
					$pdf->RoundedRect($ejeX, $ejeY, 60, 25, 2, 'FD');
					$pdf->CellFitSpace(60,25, $valor[0],0, 0 , 'C');
					$ejeX = $ejeX + 60;
					$pdf->RoundedRect($ejeX, $ejeY, 30, 25, 2, 'FD');
					$ejeYT=$ejeY;
					for($k=0;$k<count($terminos);$k++)
					{
						$pdf->SetXY($ejeX,$ejeYT);	
						$t=explode('-', $terminos[$k]);
						$t2=explode(' ',$t[0]);
			           	$pdf->CellFitSpace(30,8, $t2[0],0, 0 , 'C' );
			            $ejeYT = $ejeYT + 3;
					}
					$ejeX = $ejeX + 30;
					$ejeYT=$ejeY;
					$pdf->RoundedRect($ejeX, $ejeY, 30, 25, 2, 'FD');
					for($k=0;$k<count($terminos);$k++)
					{
						$pdf->SetXY($ejeX,$ejeYT);	
						$t=explode('-', $terminos[$k]);
						$t2=explode(' ',$t[0]);
			           	$pdf->CellFitSpace(30,8, $t2[1],0, 0 , 'C' );
			            $ejeYT = $ejeYT + 3;
					}
					$ejeX = $ejeX + 30;
					$ejeYT=$ejeY;
					$pdf->RoundedRect($ejeX, $ejeY, 30, 25, 2, 'FD');
					for($k=0;$k<count($terminos);$k++)
					{
						$pdf->SetXY($ejeX,$ejeYT);	
						$t=explode('-', $terminos[$k]);
						$t2=explode(' ',$t[0]);
			           	$pdf->CellFitSpace(30,8, $t[1],0, 0 , 'C' );
			           $ejeYT = $ejeYT + 3;
					}
					$ejeX = $ejeX + 30;
		
					$pdf->RoundedRect($ejeX, $ejeY, 30, 25, 2, 'FD');
					$pdf->CellFitSpace(30,15, $total. " minutos.",0, 0 , 'L');
				
					$ejeY = $ejeY + 25;
				}
			}	
			$control++;
		}
		
		
		

		
		
		$nom="ListaAsistencia".$nominstitucion.".pdf";
		$pdf->Output($nom,'D');
	}
	else {
		include_once 'PDFASISTLISTA.php';
		$pdf = new PDF('P','mm','Letter');
		$pdf->AliasNbPages();
		$deptamental=$_POST["ofiait"];
		$inscritos=inscritosait($deptamental,formato_fecha($f_desde),formato_fecha($f_hasta));
		
		$numregistros=count($inscritos);
		$divide=ceil($numregistros/8);
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
				$pdf->SetXY(20,35);
				$pdf->RoundedRect(20, 35, 180, 10, 2, 'D');
				$pdf->CellFitSpace(180,10, 'Institución: '.$deptamental,0, 0 , 'L' );
				$pdf->cabeceraHorizontal();
				//$ejeY=52;
				$ejeY=48;
				for($j=$rinicio;$j<$rfin;$j++)
				{
					$tvalor=obtiene_nom_inst_persona($inscritos[$j]);
					$valor=explode('*',$tvalor);
					$terminos=marcado_individual($inscritos[$j],formato_fecha($f_desde),formato_fecha($f_hasta));
					$total=obtiene_sum_total_atrasos($inscritos[$j],formato_fecha($f_desde),formato_fecha($f_hasta));
					
					$pdf->SetXY(20,$ejeY);
			        $pdf->SetFont('Arial','',8);
			        $pdf->SetFillColor(229, 229, 229); //Gris tenue de cada fila
			        $pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
					$ejeX = 20;
					$pdf->RoundedRect($ejeX, $ejeY, 60, 25, 2, 'FD');
					$pdf->CellFitSpace(60,25, $valor[0],0, 0 , 'C');
					$ejeX = $ejeX + 60;
					$pdf->RoundedRect($ejeX, $ejeY, 30, 25, 2, 'FD');
					$ejeYT=$ejeY;
					for($k=0;$k<count($terminos);$k++)
					{
						$pdf->SetXY($ejeX,$ejeYT);	
						$t=explode('-', $terminos[$k]);
						$t2=explode(' ',$t[0]);
			           	$pdf->CellFitSpace(30,8, $t2[0],0, 0 , 'C' );
			            $ejeYT = $ejeYT + 3;
					}
					$ejeX = $ejeX + 30;
					$ejeYT=$ejeY;
					$pdf->RoundedRect($ejeX, $ejeY, 30, 25, 2, 'FD');
					for($k=0;$k<count($terminos);$k++)
					{
						$pdf->SetXY($ejeX,$ejeYT);	
						$t=explode('-', $terminos[$k]);
						$t2=explode(' ',$t[0]);
			           	$pdf->CellFitSpace(30,8, $t2[1],0, 0 , 'C' );
			            $ejeYT = $ejeYT + 3;
					}
					$ejeX = $ejeX + 30;
					$ejeYT=$ejeY;
					$pdf->RoundedRect($ejeX, $ejeY, 30, 25, 2, 'FD');
					for($k=0;$k<count($terminos);$k++)
					{
						$pdf->SetXY($ejeX,$ejeYT);	
						$t=explode('-', $terminos[$k]);
						$t2=explode(' ',$t[0]);
			           	$pdf->CellFitSpace(30,8, $t[1],0, 0 , 'C' );
			            $ejeYT = $ejeYT + 3;
					}
					$ejeX = $ejeX + 30;
		
					$pdf->RoundedRect($ejeX, $ejeY, 30, 25, 2, 'FD');
					$pdf->CellFitSpace(30,15, $total. " minutos.",0, 0 , 'L');
				
					$ejeY = $ejeY + 25;
				}
			}
			else
			{
				$rinicio=$rfin;
				$rfin=$rinicio+8;
				$pdf->AddPage();
				$pdf->Image('images/logoXjornadas.png',10,10,13,0);
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY(20,35);
				$pdf->RoundedRect(20, 35, 180, 10, 2, 'D');
				$pdf->CellFitSpace(180,10, 'Institución: '.$deptamental,0, 0 , 'L' );
				$pdf->cabeceraHorizontal();
				$ejeY=52;
				for($j=$rinicio;$j<$rfin;$j++)
				{
					$tvalor=obtiene_nom_inst_persona($inscritos[$j]);
					$valor=explode('*',$tvalor);
					$terminos=marcado_individual($inscritos[$j],formato_fecha($f_desde),formato_fecha($f_hasta));
					$total=obtiene_sum_total_atrasos($inscritos[$j],formato_fecha($f_desde),formato_fecha($f_hasta));
					
					$pdf->SetXY(20,$ejeY);
			        $pdf->SetFont('Arial','',8);
			        $pdf->SetFillColor(229, 229, 229); //Gris tenue de cada fila
			        $pdf->SetTextColor(3, 3, 3); //Color del texto: Negro
					$ejeX = 20;
					$pdf->RoundedRect($ejeX, $ejeY, 60, 25, 2, 'FD');
					$pdf->CellFitSpace(60,25, $valor[0],0, 0 , 'C');
					$ejeX = $ejeX + 60;
					$pdf->RoundedRect($ejeX, $ejeY, 30, 25, 2, 'FD');
					$ejeYT=$ejeY;
					for($k=0;$k<count($terminos);$k++)
					{
						$pdf->SetXY($ejeX,$ejeYT);	
						$t=explode('-', $terminos[$k]);
						$t2=explode(' ',$t[0]);
			           	$pdf->CellFitSpace(30,8, $t2[0],0, 0 , 'C' );
			            $ejeYT = $ejeYT + 3;
					}
					$ejeX = $ejeX + 30;
					$ejeYT=$ejeY;
					$pdf->RoundedRect($ejeX, $ejeY, 30, 25, 2, 'FD');
					for($k=0;$k<count($terminos);$k++)
					{
						$pdf->SetXY($ejeX,$ejeYT);	
						$t=explode('-', $terminos[$k]);
						$t2=explode(' ',$t[0]);
			           	$pdf->CellFitSpace(30,8, $t2[1],0, 0 , 'C' );
			            $ejeYT = $ejeYT + 3;
					}
					$ejeX = $ejeX + 30;
					$ejeYT=$ejeY;
					$pdf->RoundedRect($ejeX, $ejeY, 30, 25, 2, 'FD');
					for($k=0;$k<count($terminos);$k++)
					{
						$pdf->SetXY($ejeX,$ejeYT);	
						$t=explode('-', $terminos[$k]);
						$t2=explode(' ',$t[0]);
			           	$pdf->CellFitSpace(30,8, $t[1],0, 0 , 'C' );
			           $ejeYT = $ejeYT + 3;
					}
					$ejeX = $ejeX + 30;
		
					$pdf->RoundedRect($ejeX, $ejeY, 30, 25, 2, 'FD');
					$pdf->CellFitSpace(30,15, $total. " minutos.",0, 0 , 'L');
				
					$ejeY = $ejeY + 25;
				}
			}	
			$control++;
		}
		
		
		

		
		
		$nom="ListaAsistencia".$deptamental.".pdf";
		$pdf->Output($nom,'D');
	}
?>
