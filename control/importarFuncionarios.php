<?php
   include_once '../conexion.php';
   include_once '../includes/functions.php';
   sec_session_start();
   function verifica_extension($valor,$cn)
   {
   		$respuesta=0;
   		$c="select id_dep from departamentos where ext_dep='".$valor."'";		
		if($resultado = $cn->query($c))
		{
			$fila2 = $resultado->fetch_array();
			if($fila2[0]<>""){
				$respuesta=$fila2[0];
			}
			else{
				$respuesta=0;
			}
		}
		else
		{
			$respuesta=0;
		}
		return $respuesta;
   }
   function departamento($valor)
   {
   		$respuesta=0;
		
   }
date_default_timezone_set("America/La_Paz");
if ($_POST["action"] == "upload") {
// obtenemos los datos del archivo
	$tamano = $_FILES["excel"]['size'];
	$tipo = $_FILES["excel"]['type'];
	$archivo = $_FILES["excel"]['name'];
	$prefijo = substr(md5(uniqid(rand())),0,6);	
	if ($archivo != "") {
		// guardamos el archivo a la carpeta files
		$destino = "bak_".$archivo;
		if (copy($_FILES['excel']['tmp_name'],$destino)) {
			if (file_exists ("bak_".$archivo)){ 
				/* Clases necesarias */
				require_once('../PHPExcel.php');
				require_once('../PHPExcel/Reader/Excel2007.php');
				require_once('../PHPExcel/Cell/AdvancedValueBinder.php');
				PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
				// Cargando la hoja de cálculo
				$objReader = new PHPExcel_Reader_Excel2007();
				$objPHPExcel = $objReader->load("bak_".$archivo);
				$objFecha = new PHPExcel_Shared_Date();    
			
				// Asignar hoja de excel activa
				$objPHPExcel->setActiveSheetIndex(0); 
				    
				//conectamos con la base de datos 
				$cn=conexj();
	
				// Llenamos un arreglo con los datos del archivo xlsx
				$i=2; //celda inicial en la cual empezara a realizar el barrido de la grilla de excel
				$param=0;
				$contador=0;
				$regingresados=0;
				$resp='';
				$colA=$objPHPExcel->getActiveSheet()->getCell('A1')->getCalculatedValue();
				$colB=$objPHPExcel->getActiveSheet()->getCell('B1')->getCalculatedValue();
				$colC=$objPHPExcel->getActiveSheet()->getCell('C1')->getCalculatedValue();
				$colD=$objPHPExcel->getActiveSheet()->getCell('D1')->getCalculatedValue();
				$colE=$objPHPExcel->getActiveSheet()->getCell('E1')->getCalculatedValue();
				$colF=$objPHPExcel->getActiveSheet()->getCell('F1')->getCalculatedValue();
				$colG=$objPHPExcel->getActiveSheet()->getCell('G1')->getCalculatedValue();
				IF($colA=='NOMBRES' && $colB=='APELLIDOS' && $colC=='CI' && $colD=='EXT' && $colE=='EMAIL' && $colF=='DEPENDENCIA')
				{
					
				}
				else
				{
					?>
					<script language="javascript">
						alert("El archivo seleccionado no tiene el formato correcto.");
						location.href = "../FormInscripcionFuncAITL.php";
					</script>
					<?php
					exit;
				}
				while($param==0) //mientras el parametro siga en 0 (iniciado antes) que quiere decir que no ha encontrado un NULL entonces siga metiendo datos
				{
					$nombres=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
					$apellidos=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
					$ci=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
					$ext=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
					$email=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
					$dependencia=$objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
					$extension=verifica_extension(strtoupper($ext), $cn);
					if ($dependencia=='AGIT' ||$dependencia=='ARITLPZ')
					{
						$dpto=1;
					}
					elseif($dependencia=='ARITSCZ')
					{
						$dpto=2;
					}
					elseif($dependencia=='ARITCBA')
					{
						$dpto=3;
					}
					else
					{
						$dpto=4;		
					}
		
	        		if($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()==NULL) //pregunto que si ha encontrado un valor null en una columna inicie un parametro en 1 que indicaria el fin del ciclo while
					{
						$param=1; //para detener el ciclo cuando haya encontrado un valor NULL
					}
					else
					{
						$valor=$ci.date("Y")."AIT";	
						$cod= substr(hash_hmac("sha512", $valor, VALORENC), 1,20);
						$c="call pa_solo_registro_ait('".utf8_encode(strtoupper($nombres))."','".utf8_encode(strtoupper($apellidos))."','".$ci."','".$extension."','".strtoupper($email)."',$dpto,'".$_SERVER['REMOTE_ADDR']."','',0,'".$dependencia."',3,'".$cod."',1)";		
						if($resultado = $cn->query($c))
						{
							$regingresados ++;	
						}
						else
						{
							$resp.='El registro con C.I. '.$ci.' ya se encuentra registrado.'.'\n';
						}
					}
					$i++;
				}
			} 
			else {
				?>
				<script language="javascript">
					alert("Primero seleccione el archivo excel");
					location.href = "../FormInscripcionFuncAITL.php";
				</script>
				<?php
				exit;
			}
			$mensaje='Registros ingresados correctamente: '.$regingresados;
			if($resp <>'')
			{
				$mensaje.='\n'.$resp;
			}
			?>
			<script language="javascript">
				alert("<?php echo $mensaje;?>");
				location.href = "../FormInscripcionFuncAITL.php";
			</script>
			<?php
			unlink($destino);
		}
	} 
	else {
	?>
		<script language="javascript">
		alert("Error al cargar la informacion, verifique que se cargó un archivo Excel.");
		location.href = "../FormInscripcionFuncAITL.php";
	</script>
		
	<?php
	exit;
	}
}
?>