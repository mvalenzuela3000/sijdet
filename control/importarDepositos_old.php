<?php
   include_once '../conexion.php';
   include_once '../includes/functions.php';
    require_once '../includes/codigo.php';
	require 'class.phpmailer.php';
	require 'class.smtp.php';
   sec_session_start();
   
date_default_timezone_set("America/La_Paz");
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
function obtieneprimerpass($ci,$conexionj)
{
		$query="call pa_obtiene_pass_inscrito('".$ci."')";
		$resultado= $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		$valor=$fila2[0];
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
	
				// Llenamos un arreglo con los datos del archivo xlsx
				$i=2; //celda inicial en la cual empezara a realizar el barrido de la grilla de excel
				$param=0;
				$contador=0;
				$regingresados=0;
				$resp='';
				$mail = new PHPMailer();
				$colA=$objPHPExcel->getActiveSheet()->getCell('A1')->getCalculatedValue();
				$colB=$objPHPExcel->getActiveSheet()->getCell('B1')->getCalculatedValue();
				$colC=$objPHPExcel->getActiveSheet()->getCell('C1')->getCalculatedValue();
				$colD=$objPHPExcel->getActiveSheet()->getCell('D1')->getCalculatedValue();
				IF($colA=='FECHA' && $colB=='DOCUMENTO' && $colC=='DEPOSITANTE' && $colD=='MONTO')
				{
					
				}
				else
				{
					?>
					<script language="javascript">
						alert("El archivo seleccionado no tiene el formato correcto.");
						location.href = "../FormCargaDepositos.php";
					</script>
					<?php
					exit;
				}
				while($param==0) //mientras el parametro siga en 0 (iniciado antes) que quiere decir que no ha encontrado un NULL entonces siga metiendo datos
				{
						
					$fechadeposito=date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getvalue() ));	
					/*$fechade=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getValue();
					$tfechad=PHPExcel_Shared_Date::ExcelToPHP($fechade);
					$fechadeposito=date("Y-m-d",$tfechad);*/
					
					//$fechade=$objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
					/*if($fechade <>'')
					{
						$tfechad=explode('/',$fechade);
						$fechadeposito=$tfechad[2].'-'.$tfechad[1].'-'.$tfechad[0];
					}
					else {
						?>
						<script language="javascript">
							alert("El archivo contiene fechas incorrectas por favor revise que esten en formato dd/mm/aaaa.");
							location.href = "../FormCargaDepositos.php";
						</script>
						<?php
					exit;
					}*/
					$nrodeposito=$objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
					$depositante=$objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
					$importe=$objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
					$importe=str_replace(',', '', $importe);
					$importe=str_replace('.', ',', $importe);

					//$observacion=$objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();		
	        		if($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()==NULL) //pregunto que si ha encontrado un valor null en una columna inicie un parametro en 1 que indicaria el fin del ciclo while
					{
						$param=1; //para detener el ciclo cuando haya encontrado un valor NULL
					}
					else
					{	
						if(substr($depositante, 0,3)=='TRA')
						{
							$c="insert into pagos values('".$nrodeposito."',DATE_ADD('".$fechadeposito."',INTERVAL 1 DAY),'".$importe."','".date("Y-m-d H:i:s")."','".$_SESSION['usuario']."','".utf8_encode($depositante)."','".date("Y")."',2)";
						}
						elseif (substr($depositante, 0,3)=='CHE') {
							$c="insert into pagos values('".$nrodeposito."',DATE_ADD('".$fechadeposito."',INTERVAL 1 DAY),'".$importe."','".date("Y-m-d H:i:s")."','".$_SESSION['usuario']."','".utf8_encode($depositante)."','".date("Y")."',3)";
						}
						else {
							$c="insert into pagos values('".$nrodeposito."',DATE_ADD('".$fechadeposito."',INTERVAL 1 DAY),'".$importe."','".date("Y-m-d H:i:s")."','".$_SESSION['usuario']."','".utf8_encode($depositante)."','".date("Y")."',1)";	
						}
								
						if($resultado = $cn->query($c))
						{	
						
							// verifico si hay varios inscritos 
							$query2="select count(*) from inscritos where estado=3 and id_pago='".$nrodeposito."' and gestion=year(now())";
							$resultado2 = $cn->query($query2);
							$row2 = mysqli_fetch_row($resultado2);
							$contadorregi=$row2[0];
							if($contadorregi==1)
							{
								// agrego condicion para actualizar
								//$query="select ifnull((select ci from inscritos where estado=3 and id_pago='".$nrodeposito."' and gestion=year(now())),'NO')";
								$query3="select ci from inscritos where estado=3 and id_pago='".$nrodeposito."' and gestion=year(now())";
								$resultado3 = $cn->query($query3);
								$row3 = mysqli_fetch_row($resultado3);
								// si hay un registro de ci con ese deposito	
								$ci=$row3[0];
								//echo $ci."<br>";
								$query4="select profesion from registrados where ci='".$ci."'";
								$resultado4 = $cn->query($query4);
								$row4 = mysqli_fetch_row($resultado4);
								$prof=$row4[0];
								 
								if(valida_fecha_monto_trans($ci, $cn, $prof, $fechadeposito, $importe)>1)
								{
									if((valida_deposito($ci, $cn, $prof, $nrodeposito)!=2) && (valida_deposito($ci, $cn, $prof, $nrodeposito)!=4))
									{
										$query3="select email,concat(nombres,' ',apellidos) from registrados where ci='".$ci."'";
										$resultado3= $cn->query($query3);
										if($fila3 = $resultado3->fetch_array())
										{
											$email=$fila3[0];
											$nomcompleto=$fila3[1];
										}
										$query4="select emailgaf from ges_jornadas where gestion=year(now()) ";
										$resultado4= $cn->query($query4);
										if($fila4 = $resultado4->fetch_array())
										{
											$emailgaf=$fila4[0];
										}
										$query5="call pa_registra_inscripcion_confirma_sist('".$ci."','".$nrodeposito."')  ";
										if($resultado5= $cn->query($query5))
										{
											$valor=$ci.date("Y");	
											$cod= substr(hash_hmac("sha512", $valor, VALORENC), 1,20);
											$cn2=conexj();
											$pass=obtieneprimerpass($ci,$cn2);
											   // $link="http://www.ait.gob.bo/sisjornadas/formulario.php?c1=".base64_encode($ci)."&c0d=".base64_encode($cod).""; //para desarrolllo 
												 $link="https://www.ait.gob.bo/sisjornadas/formIngreso.php"; //para desarrolllo 
												//$link="192.168.18.126/jornadas/formIngreso.php"; //para desarrolllo 
												$subject = "Constancia de Inscripción - X Jornadas Bolivianas de Derecho Tributario.";
												$body = "<b>Inscripción a las X Jornadas Bolivianas de Derecho Tributario</b><br><br>".
													"<br><br>CI: <strong>$ci</strong><br>".
													"<br><br>Nombres: <strong>".$nomcompleto."</strong><br>".
													"<br><br>C&oacute;digo de Inscripci&oacute;n: <strong>".$cod."</strong><br>".
												   " <br><br>Se confirmó el depósito realizado, para completar su inscripción agradeceremos ingrese al link  <strong>$link</strong> y elija las sesiones paralelas a las cuales asistirá y posteriormente deberá imprimir el formulario de inscripción respectivo el mismo que deberá presentar al momento de su acreditación.".
													"<br><br><strong>Usuario: $ci</strong>".
													"<br><br><strong>Contraseña: $pass</strong><br><br>";
											$mail->IsSMTP();
											$mail->SMTPDebug  = 0;
											$mail->Host       = 'mail.ait.gob.bo';
											$mail->SMTPAuth   = true;
											$mail->Username   = USERMAILJ;
											$mail->Password   = PASSMAILJ;
											$mail->SMTPSecure = 'tls';
											$mail->Port       = 587;
											$mail->setFrom(USERMAIL,'X Jornadas de Derecho Tributario Bolivia');
											
											if($email!="")
											{
											    $mail->addAddress($email, 'X Jornadas de Derecho Tributario Bolivia - Inscripción');
											}
											$mail->addAddress($emailgaf, 'X Jornadas de Derecho Tributario - Inscripción');
											$mail->Subject =$subject;
											$mail->MsgHTML($body);
								            $mail->IsHTML(true); // Enviar como HTML
											$mail->AltBody = 'Incripción Realizada';
											$mail->Send();//Enviar
										}
										else{
											$resp.='No se pudo inscribir ni enviar email al C.I. '.$ci.' ya se encuentra registrado.'.'\n';
										}
	
									
										
									}
									else
									{
										if(valida_deposito($ci, $cn, $prof, $nrodeposito)==2)
										{
											$resp.='El monto del depósito '.$nrodeposito.' ya fue utilizado para inscripción.'.'\n';
										}
										if(valida_deposito($ci, $cn, $prof, $nrodeposito)==4)
										{
											$resp.='Ya se han copado los cupos para el depósito '.$nrodeposito.'.'.'\n';
										}
									}
									
								}
								else
								{
									if(valida_fecha_monto_trans($ci, $cn, $prof, $fechadeposito, $importe)==1)
									{
										$resp.='El monto del depósito '.$nrodeposito.' es menor al establecido o no esta en el rango de fechas.'.'\n';
									}
								}	
							}
							elseif ($contadorregi>1) {
								// agrego condicion para actualizar
								//$query="select ifnull((select ci from inscritos where estado=3 and id_pago='".$nrodeposito."' and gestion=year(now())),'NO')";
								$query="select ci from inscritos where estado=3 and id_pago='".$nrodeposito."' and gestion=year(now())";
								$resultado = $cn->query($query);
							
								While ($row = mysqli_fetch_array($resultado))
					  			{
									// guardo en la variable ci lso ci	
									$ci=$row[0];
									//echo $ci."<br>";
									$query2="select profesion from registrados where ci='".$ci."'";
									$resultado2 = $cn->query($query2);
									$row2 = mysqli_fetch_row($resultado2);
									$prof=$row2[0];
									//echo $prof."<br>";
									 
									if(valida_fecha_monto_trans($ci, $cn, $prof, $fechadeposito, $importe)>1)
									{
										//echo 'Si monto_trans <br>';
										if((valida_deposito($ci, $cn, $prof, $nrodeposito)!=2) && (valida_deposito($ci, $cn, $prof, $nrodeposito)!=4))
										{
											//echo 'Si valida_deposito <br>';
											$query3="select email,concat(nombres,' ',apellidos) from registrados where ci='".$ci."'";
											$resultado3= $cn->query($query3);
											if($fila3 = $resultado3->fetch_array())
											{
												$email=$fila3[0];
												$nomcompleto=$fila3[1];
											}
											$query4="select emailgaf from ges_jornadas where gestion=year(now()) ";
											$resultado4= $cn->query($query4);
											if($fila4 = $resultado4->fetch_array())
											{
												$emailgaf=$fila4[0];
											}
											$query5="call pa_registra_inscripcion_confirma_sist('".$ci."','".$nrodeposito."')  ";
											if($resultado5= $cn->query($query5))
											{
												$valor=$ci.date("Y");	
												$cod= substr(hash_hmac("sha512", $valor, VALORENC), 1,20);
												$cn2=conexj();
												$pass=obtieneprimerpass($ci,$cn2);
												$link="http://www.ait.gob.bo/sisjornadas/formulario.php?c1=".base64_encode($ci)."&c0d=".base64_encode($cod).""; //para desarrolllo
												//$link="192.168.18.126/jornadas/formIngreso.php"; //para desarrolllo 
												$subject = "Constancia de Inscripción - X Jornadas Bolivianas de Derecho Tributario.";
												$body = "<b>Inscripción a las X Jornadas Bolivianas de Derecho Tributario</b><br><br>".
													"<br><br>CI: <strong>$ci</strong><br>".
													"<br><br>Nombres: <strong>".$nomcompleto."</strong><br>".
													"<br><br>C&oacute;digo de Inscripci&oacute;n: <strong>".$cod."</strong><br>".
												   " <br><br>Se confirmó el depósito realizado, para completar su inscripción agradeceremos ingrese al link  <strong>$link</strong> y elija las sesiones paralelas a las cuales asistirá y posteriormente deberá imprimir el formulario de inscripción respectivo el mismo que deberá presentar al momento de su acreditación.".
													"<br><br><strong>Usuario: $ci</strong>".
													"<br><br><strong>Contraseña: $pass</strong><br><br>"; 
										      
												$mail->IsSMTP();
												$mail->SMTPDebug  = 0;
												$mail->Host       = 'mail.ait.gob.bo';
												$mail->SMTPAuth   = true;
												$mail->Username   = USERMAILJ;
												$mail->Password   = PASSMAILJ;
												$mail->SMTPSecure = 'tls';
												$mail->Port       = 587;
												$mail->setFrom(USERMAIL,'X Jornadas de Derecho Tributario Bolivia');
												
												if($email!="")
												{
												    $mail->addAddress($email, 'X Jornadas de Derecho Tributario Bolivia - Inscripción');
												}
												$mail->addAddress($emailgaf, 'X Jornadas de Derecho Tributario - Inscripción');
												$mail->Subject =$subject;
												$mail->MsgHTML($body);
									            $mail->IsHTML(true); // Enviar como HTML
												$mail->AltBody = 'Incripción Realizada';
												$mail->Send();//Enviar
											}
											else{
												$resp.='No se pudo inscribir ni enviar email al C.I. '.$ci.' ya se encuentra registrado.'.'\n';
											}
		
										
											
										}
										else
										{
											if(valida_deposito($ci, $cn, $prof, $nrodeposito)==2)
											{
												$resp.='El monto del depósito '.$nrodeposito.' ya fue utilizado para inscripción.'.'\n';
											}
											if(valida_deposito($ci, $cn, $prof, $nrodeposito)==4)
											{
												$resp.='Ya se han copado los cupos para el depósito '.$nrodeposito.'.'.'\n';
											}
										}
										
									}
									else
									{
										if(valida_fecha_monto_trans($ci, $cn, $prof, $fechadeposito, $importe)==1)
										{
											$resp.='El monto del depósito '.$nrodeposito.' es menor al establecido.'.'\n';
										}
									}
								}
							}
							$regingresados ++;	
						}
						else
						{
							//$resp.='El depósito '.$nrodeposito.' ya se encuentra registrado.'."Fallo la insercion de datos: (" . $cn->errno . ") " . $cn->error.'\n';
							$resp.='El depósito '.$nrodeposito.' ya se encuentra registrado.'.'\n';
							$query2="select count(*) from inscritos where estado=3 and id_pago='".$nrodeposito."' and gestion=year(now())";
							$resultado2 = $cn->query($query2);
							$row2 = mysqli_fetch_row($resultado2);
							$contadorregi=$row2[0];
							if($contadorregi==1)
							{
								// agrego condicion para actualizar
								//$query="select ifnull((select ci from inscritos where estado=3 and id_pago='".$nrodeposito."' and gestion=year(now())),'NO')";
								$query3="select ci from inscritos where estado=3 and id_pago='".$nrodeposito."' and gestion=year(now())";
								$resultado3 = $cn->query($query3);
								$row3 = mysqli_fetch_row($resultado3);
								// si hay un registro de ci con ese deposito	
								$ci=$row3[0];
								//echo $ci."<br>";
								$query4="select profesion from registrados where ci='".$ci."'";
								$resultado4 = $cn->query($query4);
								$row4 = mysqli_fetch_row($resultado4);
								$prof=$row4[0];
								 
								if(valida_fecha_monto_trans($ci, $cn, $prof, $fechadeposito, $importe)>1)
								{
									if((valida_deposito($ci, $cn, $prof, $nrodeposito)!=2) && (valida_deposito($ci, $cn, $prof, $nrodeposito)!=4))
									{
										$query3="select email,concat(nombres,' ',apellidos) from registrados where ci='".$ci."'";
										$resultado3= $cn->query($query3);
										if($fila3 = $resultado3->fetch_array())
										{
											$email=$fila3[0];
											$nomcompleto=$fila3[1];
										}
										$query4="select emailgaf from ges_jornadas where gestion=year(now()) ";
										$resultado4= $cn->query($query4);
										if($fila4 = $resultado4->fetch_array())
										{
											$emailgaf=$fila4[0];
										}
										$query5="call pa_registra_inscripcion_confirma_sist('".$ci."','".$nrodeposito."')  ";
										if($resultado5= $cn->query($query5))
										{
											$valor=$ci.date("Y");	
											$cod= substr(hash_hmac("sha512", $valor, VALORENC), 1,20);
											$cn2=conexj();
											$pass=obtieneprimerpass($ci,$cn2);
											   // $link="http://www.ait.gob.bo/sisjornadas/formulario.php?c1=".base64_encode($ci)."&c0d=".base64_encode($cod).""; //para desarrolllo 
												 $link="https://www.ait.gob.bo/sisjornadas/formIngreso.php"; //para desarrolllo 
												//$link="192.168.18.126/jornadas/formIngreso.php"; //para desarrolllo 
												$subject = "Constancia de Inscripción - X Jornadas Bolivianas de Derecho Tributario.";
												$body = "<b>Inscripción a las X Jornadas Bolivianas de Derecho Tributario</b><br><br>".
													"<br><br>CI: <strong>$ci</strong><br>".
													"<br><br>Nombres: <strong>".$nomcompleto."</strong><br>".
													"<br><br>C&oacute;digo de Inscripci&oacute;n: <strong>".$cod."</strong><br>".
												   " <br><br>Se confirmó el depósito realizado, para completar su inscripción agradeceremos ingrese al link  <strong>$link</strong> y elija las sesiones paralelas a las cuales asistirá y posteriormente deberá imprimir el formulario de inscripción respectivo el mismo que deberá presentar al momento de su acreditación.".
													"<br><br><strong>Usuario: $ci</strong>".
													"<br><br><strong>Contraseña: $pass</strong><br><br>";
											$mail->IsSMTP();
											$mail->SMTPDebug  = 0;
											$mail->Host       = 'mail.ait.gob.bo';
											$mail->SMTPAuth   = true;
											$mail->Username   = USERMAILJ;
											$mail->Password   = PASSMAILJ;
											$mail->SMTPSecure = 'tls';
											$mail->Port       = 587;
											$mail->setFrom(USERMAIL,'X Jornadas de Derecho Tributario Bolivia');
											
											if($email!="")
											{
											    $mail->addAddress($email, 'X Jornadas de Derecho Tributario Bolivia - Inscripción');
											}
											$mail->addAddress($emailgaf, 'X Jornadas de Derecho Tributario - Inscripción');
											$mail->Subject =$subject;
											$mail->MsgHTML($body);
								            $mail->IsHTML(true); // Enviar como HTML
											$mail->AltBody = 'Incripción Realizada';
											$mail->Send();//Enviar
										}
										else{
											$resp.='No se pudo inscribir ni enviar email al C.I. '.$ci.' ya se encuentra registrado.'.'\n';
										}
	
									
										
									}
									else
									{
										if(valida_deposito($ci, $cn, $prof, $nrodeposito)==2)
										{
											$resp.='El monto del depósito '.$nrodeposito.' ya fue utilizado para inscripción.'.'\n';
										}
										if(valida_deposito($ci, $cn, $prof, $nrodeposito)==4)
										{
											$resp.='Ya se han copado los cupos para el depósito '.$nrodeposito.'.'.'\n';
										}
									}
									
								}
								else
								{
									if(valida_fecha_monto_trans($ci, $cn, $prof, $fechadeposito, $importe)==1)
									{
										$resp.='El monto del depósito '.$nrodeposito.' es menor al establecido.'.'\n';
									}
								}		
							}
							elseif ($contadorregi>1) {
								// agrego condicion para actualizar
								//$query="select ifnull((select ci from inscritos where estado=3 and id_pago='".$nrodeposito."' and gestion=year(now())),'NO')";
								$query="select ci from inscritos where estado=3 and id_pago='".$nrodeposito."' and gestion=year(now())";
								$resultado = $cn->query($query);
							
								While ($row = mysqli_fetch_array($resultado))
					  			{
									// guardo en la variable ci lso ci	
									$ci=$row[0];
									//echo $ci."<br>";
									$query2="select profesion from registrados where ci='".$ci."'";
									$resultado2 = $cn->query($query2);
									$row2 = mysqli_fetch_row($resultado2);
									$prof=$row2[0];
									//echo $prof."<br>";
									 
									if(valida_fecha_monto_trans($ci, $cn, $prof, $fechadeposito, $importe)>1)
									{
										//echo 'Si monto_trans <br>';
										if((valida_deposito($ci, $cn, $prof, $nrodeposito)!=2) && (valida_deposito($ci, $cn, $prof, $nrodeposito)!=4))
										{
											//echo 'Si valida_deposito <br>';
											$query3="select email,concat(nombres,' ',apellidos) from registrados where ci='".$ci."'";
											$resultado3= $cn->query($query3);
											if($fila3 = $resultado3->fetch_array())
											{
												$email=$fila3[0];
												$nomcompleto=$fila3[1];
											}
											$query4="select emailgaf from ges_jornadas where gestion=year(now()) ";
											$resultado4= $cn->query($query4);
											if($fila4 = $resultado4->fetch_array())
											{
												$emailgaf=$fila4[0];
											}
											$query5="call pa_registra_inscripcion_confirma_sist('".$ci."','".$nrodeposito."')  ";
											if($resultado5= $cn->query($query5))
											{
												$valor=$ci.date("Y");	
												$cod= substr(hash_hmac("sha512", $valor, VALORENC), 1,20);
												$cn2=conexj();
												$pass=obtieneprimerpass($ci,$cn2);
											   // $link="http://www.ait.gob.bo/sisjornadas/formulario.php?c1=".base64_encode($ci)."&c0d=".base64_encode($cod).""; //para desarrolllo 
												 $link="https://www.ait.gob.bo/sisjornadas/formIngreso.php"; //para desarrolllo 
												//$link="192.168.18.126/jornadas/formIngreso.php"; //para desarrolllo 
												$subject = "Constancia de Inscripción - X Jornadas Bolivianas de Derecho Tributario.";
												$body = "<b>Inscripción a las X Jornadas Bolivianas de Derecho Tributario</b><br><br>".
													"<br><br>CI: <strong>$ci</strong><br>".
													"<br><br>Nombres: <strong>".$nomcompleto."</strong><br>".
													"<br><br>C&oacute;digo de Inscripci&oacute;n: <strong>".$cod."</strong><br>".
												   " <br><br>Se confirmó el depósito realizado, para completar su inscripción agradeceremos ingrese al link  <strong>$link</strong> y elija las sesiones paralelas a las cuales asistirá y posteriormente deberá imprimir el formulario de inscripción respectivo el mismo que deberá presentar al momento de su acreditación.".
													"<br><br><strong>Usuario: $ci</strong>".
													"<br><br><strong>Contraseña: $pass</strong><br><br>";
												$mail->IsSMTP();
												$mail->SMTPDebug  = 0;
												$mail->Host       = 'mail.ait.gob.bo';
												$mail->SMTPAuth   = true;
												$mail->Username   = USERMAILJ;
												$mail->Password   = PASSMAILJ;
												$mail->SMTPSecure = 'tls';
												$mail->Port       = 587;
												$mail->setFrom(USERMAIL,'X Jornadas de Derecho Tributario Bolivia');
												
												if($email!="")
												{
												    $mail->addAddress($email, 'X Jornadas de Derecho Tributario Bolivia - Inscripción');
												}
												$mail->addAddress($emailgaf, 'X Jornadas de Derecho Tributario - Inscripción');
												$mail->Subject =$subject;
												$mail->MsgHTML($body);
									            $mail->IsHTML(true); // Enviar como HTML
												$mail->AltBody = 'Incripción Realizada';
												$mail->Send();//Enviar
											}
											else{
												$resp.='No se pudo inscribir ni enviar email al C.I. '.$ci.' ya se encuentra registrado.'.'\n';
											}
		
										
											
										}
										else
										{
											if(valida_deposito($ci, $cn, $prof, $nrodeposito)==2)
											{
												$resp.='El monto del depósito '.$nrodeposito.' ya fue utilizado para inscripción.'.'\n';
											}
											if(valida_deposito($ci, $cn, $prof, $nrodeposito)==4)
											{
												$resp.='Ya se han copado los cupos para el depósito '.$nrodeposito.'.'.'\n';
											}
										}
										
									}
									else
									{
										if(valida_fecha_monto_trans($ci, $cn, $prof, $fechadeposito, $importe)==1)
										{
											$resp.='El monto del depósito '.$nrodeposito.' es menor al establecido.'.'\n';
										}
									}
								}
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
					location.href = "../FormCargaDepositos.php";
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
				location.href = "../FormCargaDepositos.php";
			</script>
			<?php
			unlink($destino);
		}
	} 
	else {
	?>
		<script language="javascript">
		alert("Error al cargar la informacion, verifique que se cargó un archivo Excel.");
		location.href = "../FormCargaDepositos.php";
	</script>
		
	<?php
	exit;
	}
}
?>