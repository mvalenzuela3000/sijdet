<?php
	include_once 'conexion.php';
	function nombreevento($gestion)
	{
		$conexionj=conexj();
		$query="select ifnull((select descripcion from ges_jornadas where gestion='".$gestion."'),'')";
		$resultado= $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		$valor=$fila2[0];
		return utf8_encode($valor);
	}
	function obtienetipoinscrito($ci,$gestion)
	{
		$conexionj=conexj();
		$query="select ifnull((select id_tipo_inscrito from inscritos where ci='".$ci."' and gestion=$gestion),0)";
		$resultado= $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		$valor=$fila2[0];
		return $valor;
	}
	function obtienedescsesion($gestion,$idsesion)
	{
		$conexionj=conexj();
		$query="select descripcion from sesiones_paralelas where id_sesion=$idsesion and gestion=$gestion";
		$resultado= $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		$valor=$fila2[0];
		return $valor;
	}
	function listasesionesxinscritos($gestion,$idsesion)
	{
		$conexionj=conexj();
		$query="call pa_obtiene_sesionesxinscrito('".$gestion."','".$idsesion."')";
		$valores=array();
		 if (mysqli_multi_query($conexionj, $query)) {
	          do {
	              if ($result = mysqli_store_result($conexionj)) {
	                  while ($row = mysqli_fetch_row($result)) {
	                  		$valores[]=$row[0];     
	                  }
	                  mysqli_free_result($result);
	              }
	      
	          } while (mysqli_next_result($conexionj));
	      }
		else {
			?>
				<script>
					alert("El registro no fue encontrado por favor revise su enlace o conexión con internet.")
				</script>
			<?php
		}
		return $valores;
	}
	function obtieneprimerpass($ci)
	{
		$conexionj=conexj();
		$query="call pa_obtiene_pass_inscrito('".$ci."')";
		$resultado= $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		$valor=$fila2[0];
		return $valor;
	}
	function sesionesxinscrito($ci)
	{
		$conexionj=conexj();
		$query="call pa_obtiene_sesiones_inscritas('".$ci."')";
		$valores=array();
		 if (mysqli_multi_query($conexionj, $query)) {
	          do {
	              if ($result = mysqli_store_result($conexionj)) {
	                  while ($row = mysqli_fetch_row($result)) {
	                  		$valores[]=$row[3].'  -  '.$row[1];     
	                  }
	                  mysqli_free_result($result);
	              }
	      
	          } while (mysqli_next_result($conexionj));
	      }
		else {
			?>
				<script>
					alert("El registro no fue encontrado por favor revise su enlace o conexión con internet.")
				</script>
			<?php
		}
		return $valores;
	}
	function verificaregistrosesionparalela($ci)
	{
		$conexionj=conexj();
		$query="select count(*) from sesiones_inscrito where ci='".$ci."' and gestion=year(now())";
		$resultado= $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		$valor=$fila2[0];
			if($valor>0)
			{
				?>
		            <script language="javascript">
		            alert("Usted ya realizó la elección de las Sesiones Paralelas a las que asistirá.");
		            location.href = "FormDatosBasicos.php?c0d="+"<?php echo base64_encode($ci);?>";
		            
		        	</script>
	       		 <?php 
	       		 exit;
			}
	}
	function verificaregistrosesionparalelareg($ci)
	{
		$conexionj=conexj();
		$query="select count(*) from sesiones_inscrito where ci='".$ci."' and gestion=year(now())";
		$resultado= $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		$valor=$fila2[0];
			if($valor==0)
			{
				?>
		            <script language="javascript">
		            alert("Usted aún no realizó la elección de las Sesiones Paralelas a las que asistirá, por lo tanto antes de imprimir su formulario de inscripción debe preceder con la selección requerida, se le reconducirá al formulario para que elija las sesiones paralelas a las que asistirá.");
		            location.href = "FormEleccionSesion.php?c0d="+"<?php echo base64_encode($ci);?>";
		            
		        	</script>
	       		 <?php 
	       		 exit;
			}
	}
	function inscritosyacreditados($gestion,$rango)
	{
		$conexionj=conexj();
		$query="call pa_obtiene_inscritos_acreditados($gestion,$rango)";
		$valores=array();
		 if (mysqli_multi_query($conexionj, $query)) {
	          do {
	              if ($result = mysqli_store_result($conexionj)) {
	                  while ($row = mysqli_fetch_row($result)) {
	                  		$valores[]=$row[0].'*'.$row[1].'*'.$row[2];     
	                  }
	                  mysqli_free_result($result);
	              }
	      
	          } while (mysqli_next_result($conexionj));
	      }
		else {
			?>
				<script>
					alert("El registro no fue encontrado por favor revise su enlace o conexión con internet.")
				</script>
			<?php
		}
		return $valores;
	}
	function inscritosait($inst,$desde,$hasta)
	{
		$conexionj=conexj();
		$query="call pa_obtiene_inscritos_ait('".$inst."','".$desde."','".$hasta."')";
		$valores=array();
		 if (mysqli_multi_query($conexionj, $query)) {
	          do {
	              if ($result = mysqli_store_result($conexionj)) {
	                  while ($row = mysqli_fetch_row($result)) {
	                  		$valores[]=$row[2];     
	                  }
	                  mysqli_free_result($result);
	              }
	      
	          } while (mysqli_next_result($conexionj));
	      }
		else {
			?>
				<script>
					alert("El registro no fue encontrado por favor revise su enlace o conexión con internet.")
				</script>
			<?php
		}
		return $valores;
	}
	function inscritosxinstitucion($inst,$desde,$hasta)
	{
		$conexionj=conexj();
		if(is_numeric($inst))
		{
			$query="call pa_obtiene_inscritos_por_institucion('".$inst."','".$desde."','".$hasta."')";
		}
		else
		{
			$query="call pa_obtiene_inscritos_por_institucion_t('".$inst."','".$desde."','".$hasta."')";
		}	
		
		$valores=array();
		 if (mysqli_multi_query($conexionj, $query)) {
	          do {
	              if ($result = mysqli_store_result($conexionj)) {
	                  while ($row = mysqli_fetch_row($result)) {
	                  		$valores[]=$row[2];     
	                  }
	                  mysqli_free_result($result);
	              }
	      
	          } while (mysqli_next_result($conexionj));
	      }
		else {
			?>
				<script>
					alert("El registro no fue encontrado por favor revise su enlace o conexión con internet.")
				</script>
			<?php
		}
		return $valores;
	}
	function obtiene_sum_total_atrasos($ci,$desde,$hasta)
	{
		$conexionj=conexj();
		$query="call pa_obtiene_total_atraso('".$ci."','".$desde."','".$hasta."')";
		$resultado= $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		$valor=$fila2[0];
		return $valor;
	}
	function obtiene_nom_inst_persona($ci)
	{
		$conexionj=conexj();
		$query="select concat(r.apellidos,' ',r.nombres),case when r.institucion=0 then r.otrainstitucion else (select nombre_inst from institucion where id_inst=r.institucion) end as insti from registrados r where r.ci='".$ci."'";
		$resultado= $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		$valor=$fila2[0]."*".$fila2[1];
		return $valor;
	}
	function marcado_individual($ci,$desde,$hasta)
	{
		$conexionj=conexj();
		$query="call pa_obtiene_marcados('".$ci."','".$desde."','".$hasta."')";
		$valores=array();
		 if (mysqli_multi_query($conexionj, $query)) {
	          do {
	              if ($result = mysqli_store_result($conexionj)) {
	                  while ($row = mysqli_fetch_row($result)) {
	                  		$valores[]=$row[3].'-'.$row[2];     
	                  }
	                  mysqli_free_result($result);
	              }
	      
	          } while (mysqli_next_result($conexionj));
	      }
		else {
			?>
				<script>
					alert("El registro no fue encontrado por favor revise su enlace o conexión con internet.")
				</script>
			<?php
		}
		return $valores;
	}
	function obtiene_siguiente_correlativo_inscripcion(){
		$conexionj=conexj();
		$query="call pa_obtiene_correlativo_finscripcion('".date("Y")."')";
		$resultado= $conexionj->query($query);
		if($fila2 = $resultado->fetch_array())
		{
			$valor=$fila2[0];
		}
		return $valor;
	}
	function obtiene_correlativo_formulario($ci,$cod)
	{
		$conexionj=conexj();
		$query="select correlativo from inscritos where ci='".$ci."' and cod_inscripcion='".$cod."'";
		$resultado= $conexionj->query($query);
		if($fila2 = $resultado->fetch_array())
		{
			$valor=$fila2[0];
		}
		return $valor;
	}
	function obtiene_mail_gaf($gestion)
	{
		$conexionj=conexj();
		$query="select emailgaf from ges_jornadas where gestion=$gestion";
		$resultado= $conexionj->query($query);
		if($fila2 = $resultado->fetch_array())
		{
			$valor=$fila2[0];
		}
		return $valor;
	}
	function inscritos($gestion)
	{
		$conexionj=conexj();
		$query="call pa_obtiene_inscritos($gestion)";
		$valores=array();
		 if (mysqli_multi_query($conexionj, $query)) {
	          do {
	              if ($result = mysqli_store_result($conexionj)) {
	                  while ($row = mysqli_fetch_row($result)) {
	                  		$valores[]=$row[0].'-'.$row[1];     
	                  }
	                  mysqli_free_result($result);
	              }
	      
	          } while (mysqli_next_result($conexionj));
	      }
		else {
			?>
				<script>
					alert("El registro no fue encontrado por favor revise su enlace o conexión con internet.")
				</script>
			<?php
		}
		return $valores;
	}
	function inscritosxletra($gestion,$rango)
	{
		$conexionj=conexj();
		$query="call pa_obtiene_inscritosxletra($gestion,$rango)";
		$valores=array();
		 if (mysqli_multi_query($conexionj, $query)) {
	          do {
	              if ($result = mysqli_store_result($conexionj)) {
	                  while ($row = mysqli_fetch_row($result)) {
	                  		$valores[]=$row[0].'*'.$row[1];     
	                  }
	                  mysqli_free_result($result);
	              }
	      
	          } while (mysqli_next_result($conexionj));
	      }
		else {
			?>
				<script>
					alert("El registro no fue encontrado por favor revise su enlace o conexión con internet.")
					window.history.back();
				</script>
			<?php
			exit;
		}
		return $valores;
	}
	function depositos($gestion,$criterio)
	{
		$conexionj=conexj();
		$query="call pa_obtiene_estado_depositos($gestion,$criterio)";
		$valores=array();
		 if (mysqli_multi_query($conexionj, $query)) {
	          do {
	              if ($result = mysqli_store_result($conexionj)) {
	                  while ($row = mysqli_fetch_row($result)) {
	                  		$valores[]=$row[0].'+'.$row[1].'+'.$row[2].'+'.$row[3].'+'.$row[4].'+'.$row[5].'+'.$row[6].'+'.$row[7];     
	                  }
	                  mysqli_free_result($result);
	              }
	      
	          } while (mysqli_next_result($conexionj));
	      }
		else {
			?>
				<script>
					alert("El registro no fue encontrado por favor revise su enlace o conexión con internet.")
				</script>
			<?php
			exit;
		}
		return $valores;
	}
	function items_gestion($gestion)
	{
		$conexionj=conexj();
		$query="call pa_obtiene_itemsxgestion($gestion)";
		$valores=array();
		 if (mysqli_multi_query($conexionj, $query)) {
	          do {
	              if ($result = mysqli_store_result($conexionj)) {
	                  while ($row = mysqli_fetch_row($result)) {
	                  		$valores[]=$row[0];     
	                  }
	                  mysqli_free_result($result);
	              }
	      
	          } while (mysqli_next_result($conexionj));
	      }
		else {
			?>
				<script>
					alert("El registro no fue encontrado por favor revise su enlace o conexión con internet.")
				</script>
			<?php
			exit;
		}
		return $valores;
	}
	function obtiene_email($ci)
	{
		$conexionj=conexj();
		
		$query="select email from registrados where ci='".$ci."'";
		$resultado= $conexionj->query($query);
		if($fila2 = $resultado->fetch_array())
		{
			$valor=$fila2[0];
		}
		return $valor;
	}
	function verifica_cupos_institucion($inst,$tipoinscrito)
	{
		$cupos=0;
		$cuposocupados=0;
		$valor=0;
		$conexionj=conexj();
		if($tipoinscrito==2){
			$query="select cupos from beca_institucion where id_institucion=$inst and gestion=year(now())";
			$resultado= $conexionj->query($query);
			if($fila2 = $resultado->fetch_array())
			{
				$cupos=$fila2[0];
			}
			$query="select count(*) as cuposo from inscritos i,registrados r where i.ci=r.ci and i.id_tipo_inscrito=2 and i.gestion=year(now()) and i.estado=1 and r.institucion=$inst ";
			$resultado= $conexionj->query($query);
			if($fila2 = $resultado->fetch_array())
			{
				$cuposocupados=$fila2[0];
			}
			$valor=$cupos-$cuposocupados;
		}
		elseif ($tipoinscrito==4) {
			$query="select n_expyaut from ges_jornadas where gestion=year(now())";
			$resultado= $conexionj->query($query);
			if($fila2 = $resultado->fetch_array())
			{
				$cupos=$fila2[0];
			}
			$query="select count(*) as cuposo from inscritos where id_tipo_inscrito=$tipoinscrito and gestion=year(now()) and estado=1";
			$resultado= $conexionj->query($query);
			if($fila2 = $resultado->fetch_array())
			{
				$cuposocupados=$fila2[0];
			}
			$valor=$cupos-$cuposocupados;
		}
		elseif ($tipoinscrito==3) {
			$query="select n_ait from ges_jornadas where gestion=year(now())";
			$resultado= $conexionj->query($query);
			if($fila2 = $resultado->fetch_array())
			{
				$cupos=$fila2[0];
			}
			$query="select count(*) as cuposo from inscritos where id_tipo_inscrito=$tipoinscrito and gestion=year(now()) and estado=1";
			$resultado= $conexionj->query($query);
			if($fila2 = $resultado->fetch_array())
			{
				$cuposocupados=$fila2[0];
			}
			$valor=$cupos-$cuposocupados;
		}
		else{
			$query="select n_deposito from ges_jornadas where gestion=year(now())";
			$resultado= $conexionj->query($query);
			if($fila2 = $resultado->fetch_array())
			{
				$cupos=$fila2[0];
			}
			$query="select count(*) as cuposo from inscritos where id_tipo_inscrito=$tipoinscrito and gestion=year(now()) and estado=1";
			$resultado= $conexionj->query($query);
			if($fila2 = $resultado->fetch_array())
			{
				$cuposocupados=$fila2[0];
			}
			$valor=$cupos-$cuposocupados;
		}
	return $valor;
		
	}
	function verifica_cupos_reg($anio,$tipo,$ci)
	{
		
		$conexionj=conexj();
		$qprof="select profesion from registrados where ci='".$ci."'";
		$resulprof= $conexionj->query($qprof);
		$filaprof = $resulprof->fetch_array();
		$prof=$filaprof[0];
		
		$query="select fn_verifica_cupos($anio,$tipo,$prof)";
		$resultado= $conexionj->query($query);
		if($fila2 = $resultado->fetch_array())
		{
			$valor=$fila2[0];
			if($valor==0)
			{
				?>
		            <script language="javascript">
		           	 alert("Ya no hay cupos para la inscripción si tiene cualquier consulta favor comuníquese con la Gerencia Administrativa Financiera de la AIT, gracias.");
		           	 location.href = "FormDatosBasicos.php?c0d="+"<?php echo base64_encode($ci);?>";
		        	</script>
	       		 <?php 
	       		 exit;
			}
		}

	}
	function verifica_cupos_cxc($inst)
	{
		$conexionj=conexj();
		$query="select((select ifnull((select cupos from cuentasxcobrar where gestion=year(now()) and id_institucion=$inst and estado>0),0))-(select ifnull((select count(*) from inscritos i,registrados r where i.estado>0 and i.gestion=year(now()) and i.id_tipo_inscrito=5 and i.ci=r.ci and r.institucion=$inst),0)))";
		$resultado= $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		$valor=$fila2[0];
		return $valor;
	}
	function obtiene_inst_cxc($id)
	{
		$conexionj=conexj();
		$query="select id_institucion from cuentasxcobrar where id='".$id."'";
		$resultado= $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		$valor=$fila2[0];
		return $valor;
	}
	function obtiene_nom_inst($inst)
	{
		$conexionj=conexj();
		$query="select nombre_inst from institucion where id_inst='".$inst."'";
		$resultado= $conexionj->query($query);
		$fila2 = $resultado->fetch_array();
		$valor=$fila2[0];
		return $valor;
	}

	function verifica_cupos($anio,$tipo,$prof)
	{
		
		$conexionj=conexj();
		
		$query="select fn_verifica_cupos($anio,$tipo,$prof)";
		$resultado= $conexionj->query($query);
		if($fila2 = $resultado->fetch_array())
		{
			$valor=$fila2[0];
			if($valor==0)
			{
				?>
		            <script language="javascript">
		            alert("Ya no hay cupos para la inscripción si tiene cualquier consulta favor comuníquese con la Gerencia Administrativa Financiera de la AIT, gracias.");
		            location.href = "https://www.ait.gob.bo/jornadas";
		            
		        	</script>
	       		 <?php 
	       		 exit;
			}
		}
		return $valor;
	}
	function verifica_cupos_b($anio,$tipo,$prof)
	{
		
		$conexionj=conexj();
		
		$query="select fn_verifica_cupos($anio,$tipo,$prof)";
		$resultado= $conexionj->query($query);
		if($fila2 = $resultado->fetch_array())
		{
			$valor=$fila2[0];
			if($valor==0)
			{
				?>
		            <script language="javascript">
		            alert("Ya no hay cupos para la inscripción si tiene cualquier consulta favor comuníquese con la Gerencia Administrativa Financiera de la AIT, gracias.");
		            location.href = "FormInicio.php";
		            
		        	</script>
	       		 <?php 
	       		 exit;
			}
		}
		return $valor;
	}
	function verifica_gestion_activa($anio)
	{
		$conexionj=conexj();
		$query2="select count(*) from ges_jornadas where gestion=$anio";
		$resultado= $conexionj->query($query2);
		if($fila3 = $resultado->fetch_array())
		{
			if($fila3[0]==0){
				return 0;
			}
			else {
				$query3="select estado from ges_jornadas where gestion=$anio";
				$resultado2= $conexionj->query($query3);
				if($fila4 = $resultado2->fetch_array())
				{
					if($fila4[0]==0){
						return 2;
					}
					else {
						return 1;
					}
				}

			}
		}	
	}
	function verifica_inscripcion_becado($ci,$anio)
	{
		$conexionj=conexj();
		$query2="select count(*) from inscritos where ci='".$ci."' and gestion=$anio";
		$resultado= $conexionj->query($query2);
		if($fila3 = $resultado->fetch_array())
		{
			$valor2=$fila3[0];
			if($valor2>0)
			{
				?>
		            <script language="javascript">
			           
			            alert("El CI "+"<?php echo $ci;?>"+" se ha inscrito de manera regular por lo que no se puede registrar como becado.");
			            history.back(-1);
		        	</script>
	       		 <?php 
	       		 exit;
			}
		}	
	}
	function verifica_jornada_inscripcion($ci,$anio)
	{
		$conexionj=conexj();
		$query="select fn_verifica_jornada_inscrito('".$ci."',$anio)";
		$resultado= $conexionj->query($query);
		if($fila2 = $resultado->fetch_array())
		{
			$valor=$fila2[0];
			if($valor==1)
			{
				?>
		            <script language="javascript">
		            alert("Aún no se habilitaron las inscripciones o las mismas ya están cerradas.");
		            location.href = "FormDatosBasicos.php?c0d="+"<?php echo base64_encode($ci);?>";
		            
		        	</script>
	       		 <?php 
	       		 exit;
			}
			elseif($valor==3)
			{
				?>
		            <script language="javascript">
		            alert("Usted ya está inscrito.");
		            location.href = "FormDatosBasicos.php?c0d="+"<?php echo base64_encode($ci);?>";
		             
		        	</script>
	       		 <?php 
	       		 exit;
			}	
			elseif($valor==4)
			{
				?>
		            <script language="javascript">
		            alert("Su inscripción está en proceso de verificación por favor revise su correo para verificar el estado de la misma.");
		            location.href = "FormDatosBasicos.php?c0d="+"<?php echo base64_encode($ci);?>";
		             
		        	</script>
	       		 <?php 
	       		 exit;
			}
		}
		return $valor;
	}
	function verifica_inscripcion($ci)
	{
		$conexionj=conexj();
		//$query="select cod_inscripcion from inscritos where ci='".$ci."' and gestion=year(now()))";
		$query="select fn_verifica_jornada_inscrito('".$ci."','".date("Y")."')";
		$resultado= $conexionj->query($query);
		if($fila2 = $resultado->fetch_array())
		{
			$valor=$fila2[0];
			if($valor==3)
			{
				$query="select cod_inscripcion from inscritos where ci='".$ci."' and gestion='".date("Y")."'";
				$resultado= $conexionj->query($query);
				if($fila3 = $resultado->fetch_array())
				{
					$val=$fila3[0];
				}
				else {
					$val="";
				}
			}
			else
			{
				?>
		            <script language="javascript">
		            	alert("Usted no está inscrita(o).");
		            	location.href = "FormDatosBasicos.php?c0d="+"<?php echo base64_encode($ci);?>";
		        	</script>
	       		 <?php 
	       		 exit;
			}	
		}
		return $val;
	}
	function valida_registro_previo($ci)
	{
		$conexionj=conexj();
		$query2="call pa_verifica_registro($ci)";
		$resultado2 = $conexionj->query($query2);
		if($fila2 = $resultado2->fetch_assoc())
		{
			 ?>
	            <script language="javascript">
	             
	             alert("Usted ya se encuentra registrado.");
	        	</script>
       		 <?php 
		}
		
	}
	function valores($ci,$cod)
	{
		$conexionj=conexj();
		$valores[]="";
		$query = "CALL pa_obtiene_datos_form_inscripcion('".$ci."','".$cod."')";
		 if (mysqli_multi_query($conexionj, $query)) {
	          do {
	              if ($result = mysqli_store_result($conexionj)) {
	                  while ($row = mysqli_fetch_row($result)) {
	                  		$valores=$row;     
	                  }
	                  mysqli_free_result($result);
	              }
	      
	          } while (mysqli_next_result($conexionj));
	      }
		else {
			?>
				<script>
					alert("El registro no fue encontrado por favor revise su enlace o conexión con internet.")
				</script>
			<?php
		}
		return $valores;
	}
	function terminos($ci,$cod)
	{
		$conexionj=conexj();
		$valores="";
		$query = "CALL pa_obtiene_terminosycond('".$ci."','".$cod."')";
		 if (mysqli_multi_query($conexionj, $query)) {
	          do {
	              if ($result = mysqli_store_result($conexionj)) {
	                  while ($row = mysqli_fetch_row($result)) {
	                  		$valores=$row[0];     
	                  }
	                  mysqli_free_result($result);
	              }
	      
	          } while (mysqli_next_result($conexionj));
	      }
		else {
			?>
				<script>
					alert("El registro no fue encontrado por favor revise su enlace o conexión con internet.")
				</script>
			<?php
		}
		return $valores;
	}
	function obtiene_datos_registrados($ci)
	{
		$conexionj=conexj();
		$valores[]="";
		$query = "CALL pa_obtiene_registrado('".$ci."')";
                      
	      if (mysqli_multi_query($conexionj, $query)) {
	          do {
	              /* store first result set */
	              if ($result = mysqli_store_result($conexionj)) {
	                  while ($row = mysqli_fetch_row($result)) {
							$valores=$row;
	                  }
	                  mysqli_free_result($result);
	              }
	      
	          } while (mysqli_next_result($conexionj));
	      }
		else {
			?>
				<script>
					alert("Usted no se encuentra registrado.");
				</script>
			<?php	
			exit;
		}
		return $valores;
	}
	function nombreeventoxcixcod($ci,$cod)
	{
		$conexionj=conexj();
		$query2="select gestion from inscritos where ci='".$ci."' and cod_inscripcion='".$cod."'";
		$resultado= $conexionj->query($query2);
		$fila2 = $resultado->fetch_array();
		$valor=$fila2[0];
		return nombreevento($valor);
	}
	function inscritosyrefrigerios($gestion,$rango)
	{
		$conexionj=conexj();
		$query="call pa_obtiene_inscritos_refrigerios($gestion,$rango)";
		$valores=array();
		 if (mysqli_multi_query($conexionj, $query)) {
	          do {
	              if ($result = mysqli_store_result($conexionj)) {
	                  while ($row = mysqli_fetch_row($result)) {
	                  		$valores[]=$row[0].'*'.$row[1].'*'.$row[2].'*'.$row[3].'*'.$row[4].'*'.$row[5].'*'.$row[6].'*'.$row[7];     
	                  }
	                  mysqli_free_result($result);
	              }
	      
	          } while (mysqli_next_result($conexionj));
	      }
		else {
			?>
				<script>
					alert("El registro no fue encontrado por favor revise su enlace o conexión con internet.")
				</script>
			<?php
		}
		return $valores;
	}
	mysqli_close($conexionj);
?>