<?php
   //include_once '../conexion.php';
   include_once '../includes/functions.php';
   include_once '../includes/funj.php';
    require_once '../includes/codigo.php';
	require 'class.phpmailer.php';
	require 'class.smtp.php';
   sec_session_start();
   
date_default_timezone_set("America/La_Paz");
function obtiene_desc_jornadas($gestion,$conexionj)
	{
		$query="select descripcion from ges_jornadas where gestion=$gestion";
		$resultado= $conexionj->query($query);
		if($fila2 = $resultado->fetch_array())
		{
			$valor=$fila2[0];
		}
		return $valor;
	}
function valida_fecha_monto_trans($ci,$conexionj,$prof,$fechadep,$monto)
	{
		$valor=0;
		$query="call pa_verifica_monto_fechatransf($prof, $monto, '".$fechadep."', '".$ci."')";
		if (mysqli_multi_query($conexionj, $query)) {
	      do {
	          if ($result = mysqli_store_result($conexionj)) {
	              while ($row = mysqli_fetch_row($result)) {
						$valor=$row[0];
	              }
	              mysqli_free_result($result);
	          }
	      } while (mysqli_next_result($conexionj));
	  	}
		else {
		$error= "Fallo la validación de datos fecha_monto: (" . $conexionj->errno . ") " . $conexionj->error;
		?>
		<script language="javascript">
			history.back(-1); 
			alert("<?php echo $error; ?>
		");
		</script>
		<?php
		exit;
		}
		return $valor;
	}
	function valida_deposito($ci,$conexionj,$prof,$numdep)
	{
		$valor=0;
		$query="call pa_verifica_monto_fecha_dep_carga_lista($prof, '".$numdep."', '".$ci."')";
		if (mysqli_multi_query($conexionj, $query)) {
	      do {
	          if ($result = mysqli_store_result($conexionj)) {
	              while ($row = mysqli_fetch_row($result)) {
						$valor=$row[0];
	              }
	              mysqli_free_result($result);
	          }
	      } while (mysqli_next_result($conexionj));
	  	}
		else {
		$error= "Fallo la validación de datos valida_deposito: (" . $conexionj->errno . ") " . $conexionj->error;
		?>
		<script language="javascript">
			history.back(-1); 
			alert("<?php echo $error; ?>
		");
		</script>
		<?php
		exit;
		}
		return $valor;
	}

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
				$descjornadas=obtiene_desc_jornadas(date("Y"),$cn);
				// Llenamos un arreglo con los datos del archivo xlsx
				$i=2; //celda inicial en la cual empezara a realizar el barrido de la grilla de excel
				$param=0;
				$contador=0;
				$regingresados=0;
                $contadorregistrados=0;
				$resp='';
				$mail = new PHPMailer();
				$colA=$objPHPExcel->getActiveSheet()->getCell('A1')->getCalculatedValue();
				$colB=$objPHPExcel->getActiveSheet()->getCell('B1')->getCalculatedValue();
				$colC=$objPHPExcel->getActiveSheet()->getCell('C1')->getCalculatedValue();
				$colD=$objPHPExcel->getActiveSheet()->getCell('D1')->getCalculatedValue();
                $colE=$objPHPExcel->getActiveSheet()->getCell('E1')->getCalculatedValue();
				if($colA=='NOMBRES' && $colB=='APELLIDOS' && $colC=='CI' && $colD=='EXPEDIDO' && $colE=='CORREO')
				{
					
				}
				else
				{
					?>
					<script language="javascript">
						alert("El archivo seleccionado no tiene el formato correcto.");
						location.href = "../FormCargaMasivaEGPP.php";
					</script>
					<?php
					exit;
				}
				while($param==0) //mientras el parametro siga en 0 (iniciado antes) que quiere decir que no ha encontrado un NULL entonces siga metiendo datos
				{
						
					$fechadeposito=date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getvalue() ));	

					$nombres=trim($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue());
					$apellidos=trim($objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue());
					$ci=trim($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue());
                    $expedido=trim($objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue());
					$correo=trim($objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue());
						
	        		if($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()==NULL) //pregunto que si ha encontrado un valor null en una columna inicie un parametro en 1 que indicaria el fin del ciclo while
					{
						$param=1; //para detener el ciclo cuando haya encontrado un valor NULL
					}
					else
					{	
                        //verifico si ya existe en registros
                        $query1="select count(*) from registrados where ci='".$ci."'";
                        $resultado1 = $cn->query($query1);
                        $row1 = mysqli_fetch_row($resultado1);
                        $contadorregi=$row1[0];
                        if($contadorregi>0){//si ya está registrado
                            //actualizo nombres y apellidos
                            $update="UPDATE registrados SET nombres='".utf8_encode($nombres)."',apellidos='".utf8_encode($apellidos)."' where ci='".$ci."'";
                            $cn->query($update);
                            //verifico si ya está inscrito
                            $query1="select count(*) from inscritos where ci='".$ci."' and gestion=year(now())";
                            $resultado1 = $cn->query($query1);
                            $row1 = mysqli_fetch_row($resultado1);
                            $contadorinscri=$row1[0];
                            if($contadorinscri>0){//si ya esta inscrito en la jornada
                                $resp.='El CI '.$ci.'. ya se encuentra inscrito.'.'\n';
                            }
                            else{//registro la inscripción
                                $valor=$ci.date("Y");	
								$cod= substr(hash_hmac("sha512", $valor, VALORENC), 1,20);
                                $c="INSERT INTO inscritos (ci,f_inscripcion,gestion,ip,estado,id_pago,id_tipo_inscrito,ruta_comprobante,cod_inscripcion,observaciones,correlativo)
                                     VALUES ($ci,now(),'".date("Y")."','".$_SERVER['REMOTE_ADDR']."',1,'123123123',1,'','".$cod."','','".obtiene_siguiente_correlativo_inscripcion()."')";
                                if($resultado = $cn->query($c))
                                {	
                                    $contador++;
                                }else{
                                    $resp.='El CI '.$ci.'. no se pudo inscribir.'.'\n';
                                }
                            }
                        }else{//si no esta registrado primero registro y luego inscribo
                            $query = "select id_dep from departamentos where nombre_dep='".$expedido."'";
                            $resultado = $cn->query($query);
                            $row = mysqli_fetch_row($resultado);
                            $extension=$row[0];
                            if($extension==null){
                                $extension=1;
                            }
                            $nombrecompleto=$nombres.' '.$apellidos;
                            $cr="INSERT INTO registrados (nombres, apellidos, ci, extension, email, dpto, profesion, otraprofesion, estado, ruta_matricula,f_update,ip_registro, fono, password, nit, razonsocial, institucion, otrainstitucion, id_pais)                           
                                VALUES ('".$nombres."','".$apellidos."',$ci,$extension,'".$correo."',$extension,0,'',1,'',now(),'".$_SERVER['REMOTE_ADDR']."',0,'1e272ed5a01ad2bb6a396f269428e307',$ci,'".$nombrecompleto."',0,'EGPP',1)";
                            if($resultado = $cn->query($cr))//si se ha insetado el nuevo registro
                            {	
                                $contadorregistrados++;
                                //ahora registramos la inscripción
                                $valor=$ci.date("Y");	
								$cod= substr(hash_hmac("sha512", $valor, VALORENC), 1,20);
                                $c="INSERT INTO inscritos (ci,f_inscripcion,gestion,ip,estado,id_pago,id_tipo_inscrito,ruta_comprobante,cod_inscripcion,observaciones,correlativo)
                                    VALUES ($ci,now(),'".date("Y")."','".$_SERVER['REMOTE_ADDR']."',1,'123123123',1,'','".$cod."','','".obtiene_siguiente_correlativo_inscripcion()."')";
                                if($resultado = $cn->query($c))
                                {	
                                    $contador++;
                                }else{
                                    $resp.='El CI '.$ci.'. no se pudo inscribir.'.'\n';
                                }
                            }else{
                                $resp.='El CI '.$ci.'. no se pudo registrar.'.'\n';
                            }
                        }
					}
					$i++;
				}
			} 
			else {
				?>
				<script language="javascript">
					alert("Primero seleccione el archivo excel");
					location.href = "../FormCargaMasivaEGPP.php";
				</script>
				<?php
				exit;
			}
			$mensaje='Inscritos ingresados correctamente: '.$contador.'\n';
            $mensaje.='Registros nuevos ingresados correctamente: '.$contadorregistrados.'\n';
			if($resp <>'')
			{
				$mensaje.='\n'.$resp;
			}
			?>
			<script language="javascript">
				alert("<?php echo $mensaje;?>");
				location.href = "../FormCargaMasivaEGPP.php";
			</script>
			<?php
			unlink($destino);
		}
	} 
	else {
	?>
		<script language="javascript">
		alert("Error al cargar la informacion, verifique que se cargó un archivo Excel.");
		location.href = "../FormCargaMasivaEGPP.php";
	</script>
		
	<?php
	exit;
	}
}
?>