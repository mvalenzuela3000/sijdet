<?php
   include_once '../conexion.php';
   include_once '../includes/functions.php';
   sec_session_start();
   
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
				$i=1; //celda inicial en la cual empezara a realizar el barrido de la grilla de excel
				$param=0;
				$contador=0;
				$regingresados=0;
				$resp='';
				while($param==0) //mientras el parametro siga en 0 (iniciado antes) que quiere decir que no ha encontrado un NULL entonces siga metiendo datos
				{
					$codbeca=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
					$institucion=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();	
	        		if($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()==NULL) //pregunto que si ha encontrado un valor null en una columna inicie un parametro en 1 que indicaria el fin del ciclo while
					{
						$param=1; //para detener el ciclo cuando haya encontrado un valor NULL
					}
					else
					{
						$c="insert into becados values('".$codbeca."','".utf8_encode($institucion)."',now(),'".$_SESSION['usuario']."','".date("Y")."',null)";		
						if($resultado = $cn->query($c))
						{
							$regingresados ++;	
						}
						else
						{
							$resp.='El código de beca '.$codbeca.' ya se encuentra registrado.'.'\n';
						}
					}
					$i++;
				}
			} 
			else {
				?>
				<script language="javascript">
					alert("Primero seleccione el archivo excel");
					location.href = "../FormCargaBecas.php";
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
				location.href = "../FormCargaBecas.php";
			</script>
			<?php
			unlink($destino);
		}
	} 
	else {
	?>
		<script language="javascript">
		alert("Error al cargar la informacion, verifique que se cargó un archivo Excel.");
		location.href = "../FormCargaBecas.php";
	</script>
		
	<?php
	exit;
	}
}
?>