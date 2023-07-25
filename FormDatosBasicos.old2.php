<?php
 //include 'conexion.php';
	include_once 'includes/db_connect.php';
	include_once 'includes/functions.php';
	include_once 'includes/funj.php';
sec_session_start();
if (!isset($_SESSION['usuario']))
{
	header("Location: formIngreso.php");
    exit();
}
$ci=base64_decode($_GET["c0d"]);
$valores=obtiene_datos_registrados($ci);
$tipoinscrito=obtienetipoinscrito($ci,date("Y"));

$conexionj=conexj();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Modificación Datos Básicos | Jornadas Bolivianas de Derecho Tributario</title>

    <!-- Include Bootstrap CSS -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- PNotify -->
    <link href="vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    
    <!-- Bootstrap_file_input -->
    <link href="css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <link href="css/jqueryui.css" type="text/css" rel="stylesheet"/>
    <script src="js/fileinput.min.js" type="text/javascript"></script>

     <link href="themes/explorer/theme.css" media="all" rel="stylesheet" type="text/css"/>
     
     <script type="text/javascript">
		function habilitar(form)
		{ 
				if (form.prof.value=="3"){
					 $('#imgmatricula').prop("required", true);
		           divC = document.getElementById("matricula");
		           divC.style.display = "";
		          
					divO = document.getElementById("otraprofesion");
		    			divO.style.display="none";
		      	}else{
		      		
		      	   divC = document.getElementById("matricula");
		           divC.style.display="none";
		           $('#imgmatricula').removeAttr("required");
					if (form.prof.value=="0"){
		         		divO=document.getElementById("otraprofesion");
		    			divO.style.display = "";
						$('#otraprof').prop("required", true);
		      		}else{
		
			           divO = document.getElementById("otraprofesion");
		    			divO.style.display="none";
		    			$('#otraprof').removeAttr("required");
		     		 }
		      }
		}
		function habilitar1(form)
		{ 
				
			if (form.institucion.value=="0"){
		        divO=document.getElementById("otrainstitucion");
		    	divO.style.display = "";
		    	$('#otrainst').prop("required", true);
		    	
		     }else{
			    divO = document.getElementById("otrainstitucion");
		    	divO.style.display="none";
		    	$('#otrainst').removeAttr("required");
		     }
		}
		
	</script>
	<script>

			document.getElementById('aLink').addEventListener('click',function(e){
			  e.preventDefault();
			  alert("Ya no hay cupos disponibles, cualquier duda o consulta favor comunicarse con la Gerencia Administrativa Financiera de la AIT.");
			});
		
	</script>

	<style>
        input {text-transform: uppercase;}
    </style>     
     <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/favicon.ico">
</head>
<body class="nav-md">
	<div class="container body">
		<div class="main_container">
			<div class="col-md-3 left_col">
	          <div class="left_col scroll-view">
	            <div class="navbar nav_title" style="border: 0;">
	              <a href="https://www.ait.gob.bo/jornadas" class="site_title"><span>Jornadas - AIT</span></a>
	            </div>
	
	            <div class="clearfix"></div>
	
	            <!-- menu profile quick info -->
	            <div class="profile clearfix">
	              <div class="profile_pic">
	                <img src="images/user.png" alt="..." class="img-circle profile_img">
	              </div>
	               <div class="profile_info">
								<span>Bienvenido(a)</span>
								<h2><?php if (isset($_SESSION['username']))
											{
												$usuario=$_SESSION['usuario'];
												$param=base64_encode($usuario);
												echo htmlentities($_SESSION['username']);
												$ins='formRInscripcion.php?c0d='.$param;
												$bas='FormDatosBasicos.php?c0d='.$param;
												$selec='FormEleccionSesion.php?c0d='.$param;
												$form='formularioimp.php?c0d='.$param;
											} 
											else {echo 'Invitado';
												$usuario='';}
											?></h2>
							</div>
	            </div>
	            <!-- /menu profile quick info -->
	
	            <br />
	
	            <!-- sidebar menu -->
	            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
	              <div class="menu_section">
	                <h3>Men&uacute;</h3>
	                <ul class="nav side-menu">
	                 
	                  <li><a><i class="fa fa-edit"></i>Registro e inscripción <span class="fa fa-chevron-down"></span></a>
	                    <ul class="nav child_menu">
	                      <li><a href="<?php echo $bas;?>">Modificación de datos básicos</a></li>
						  <li><a href="#" id="aLink">Inscripción a Jornadas</a></li>
	                      <!--<li><a href="<?php //echo $ins;?>">Inscripción a Jornadas</a></li>-->
	                     <!--<?php if ($tipoinscrito!=4){?> <li><a href="<?php echo $selec;?>">Selección de Sesiones Paralelas</a></li><?php } ?>-->
	                      <li><a href="<?php echo $form;?>">Imprimir formulario de inscripción</a></li>
	                      
	                    </ul>
	                    
	                  </li>
	                  <li><a data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-key"></i>Cambio Password</a></li>
  							<li><a href="logoutj.php"><i class="fa fa-sign-out"></i>Salir</a></li>
	             
	                </ul>
	              </div>
	            </div>
	            <!-- /sidebar menu -->          
	          </div>
        	</div>
        	<!-- top navigation -->
	        <div class="top_nav">
	          <div class="nav_menu">
	            <nav>
	              <div class="nav toggle">
	                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
	              </div>        
	            </nav>
	          </div>
	        </div>
	        <!-- /top navigation -->
	        <!-- page content -->
        	<div class="right_col" role="main">
        		<div class="">
        			<div class="page-title">
		              <div class="title_left">
		                <h3>Modificación Datos básicos - Jornadas Bolivianas de Derecho Tributario</h3>
		              </div>
		            </div>
		            <div class="clearfix"></div>
		            <div class="row">
		            	<div class="col-md-12 col-sm-12 col-xs-12">
		            		<div class="x_panel">
		            			<div class="x_title">
				                	<h2>Datos básicos <small>Usuarios</small></h2>
				                    <ul class="nav navbar-right panel_toolbox">
				                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
				                      </li>
				                      <li><a class="close-link"><i class="fa fa-close"></i></a>
				                      </li>
				                    </ul>
				                    <div class="clearfix"></div>
				              	</div>
				              	<div class="x_content" data-toggle="validator">
				              		
				              		<span class="section">Por favor ingrese sus datos con mucho cuidado, pues los mismos serán consignados en su certificado de participación y también serán comparados con el depósito bancario que realice.</span>
							        <form class="form-horizontal form-label-left" enctype="multipart/form-data" id="myForm" role="form" data-toggle="validator" action="control/modificaDatosBasicos.php" method="post">
			            	    		<div class="item form-group">
			                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nombre(s) <span class="required">*</span>
			                        		</label>
			                        		<div class="col-md-6 col-sm-6 col-xs-12">
			                          			<input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="2"  name="name" placeholder="Ingrese su(s) nombre(s)..." required="required" type="text" value="<?php echo $valores[0];?>" autofocus>
			                          			<div class="help-block with-errors"></div>
			                        		</div>
			                      		</div>
			                      		<div class="item form-group">
			                       			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="apellido">Apellido(s) <span class="required">*</span>
			                        		</label>
			                        		<div class="col-md-6 col-sm-6 col-xs-12">
			                          			<input id="apellido" class="form-control col-md-7 col-xs-12" data-validate-length-range="2" name="apellido" placeholder="Ingrese su(s) apellido(s)..." required="required" value="<?php echo $valores[1];?>" type="text">
			                          			<div class="help-block with-errors"></div>
			                        		</div>
			                      		</div>
			                      
			                      		<div class="item form-group">
			                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
			                        		</label>
			                        		<div class="col-md-6 col-sm-6 col-xs-12">
			                          			<input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $valores[5];?>">
			                          			<div class="help-block with-errors"></div>
			                        		</div>
			                      		</div>
			                       		<div class="item form-group">
			                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="dpto">Departamento <span class="required">*</span>
			                        		</label>
			                        		<div class="col-md-3 col-sm-6 col-xs-12">
			                          			<select id="dpto" name="dpto" class="form-control" required="required">
			                            			<option value="<?php echo $valores[6];?>"><?php echo $valores[7];?></option>
								                      <?php
								        	              $query = "select id_dep,nombre_dep,ext_dep from departamentos";
											              if (mysqli_multi_query($conexionj, $query)) {
														 	do {
														    	if ($result = mysqli_store_result($conexionj)) {
														        	while ($row = mysqli_fetch_row($result)) {
																		echo "<option value=".$row[0].">".$row[1]."</option>";
														            }
														            mysqli_free_result($result);
														         }
														    } while (mysqli_next_result($conexionj));
														 }
														  else
														  	echo mysqli_error();                     
								                           ?>
			                          			</select>
			                        		</div>
			                      		</div>
			                      		<?php
			                      			if($valores[8]==0)
											{
												?>
												<div class="item form-group">
					                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Profesión <span class="required">*</span>
					                        		</label>
					                       			<div class="col-md-3 col-sm-6 col-xs-12">
					                          			<select id="prof" name="prof" class="form-control" onChange="habilitar(this.form)" required="required">
					                            			<option value="0"  selected="selected">Otro</option>
										                      <?php
										                        $query = "select id_prof,nombre_prof from profesiones";
													                if (mysqli_multi_query($conexionj, $query)) {
												                      do {
												                          if ($result = mysqli_store_result($conexionj)) {
												                               while ($row = mysqli_fetch_row($result)) {
																												//por estudiante
																												if($row[0]<>3){
																														echo "<option value=".$row[0].">".$row[1]."</option>";
																												}
												                            }
												                           mysqli_free_result($result);
												                          }
												                       } while (mysqli_next_result($conexionj));
												                    }
																  else
																  	echo mysqli_error();                   
										                           ?>
					                 						
					                          			</select>
					                        		</div>
					                      		</div>
					                      		<div class="item form-group" id="otraprofesion" style="display:;">
								        	       	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="otraprof">Especifique otra profesión </label>
					        			            <div class="col-md-3 col-sm-6 col-xs-12">
					                        			<input type="text" id="otraprof" name="otraprof" placeholder="Ingrese otra profesión..." class="form-control col-md-7 col-xs-12" value="<?php echo $valores[10];?>">
					                        		</div>
					                      		</div>
					                      		<div class="item form-group" id="matricula" style="display:none;">
					                  				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="imgmatricula">Matrícula vigente de estudio (imagen, escaneado) <span class="required">*</span>
						                       		</label>
					 								<div class="col-md-3 col-sm-6 col-xs-12">
						                       			<input id="imgmatricula" name="imgmatricula" type="file" class="file" data-preview-file-type="any" data-allowed-file-extensions='["jpg", "png","bmp","doc","docx","pdf"]' accept="application/pdf,image/png, .jpeg, .jpg, .bmp" >
						                       		</div>
					                  	 		</div>
					                      		<?php
											}
											else{
												?>
												<div class="item form-group">
					                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Profesión <span class="required">*</span>
					                        		</label>
					                       			<div class="col-md-3 col-sm-6 col-xs-12">
					                          			<select id="prof" name="prof" class="form-control" onChange="habilitar(this.form)" required="required">
					                            			<option value="<?php echo $valores[8];?>"  selected="selected"><?php echo $valores[9];?></option>
										                      <?php
										                        $query = "select id_prof,nombre_prof from profesiones";
													                if (mysqli_multi_query($conexionj, $query)) {
												                      do {
												                          if ($result = mysqli_store_result($conexionj)) {
												                               while ($row = mysqli_fetch_row($result)) {
																												 //por estudiantes
																												 if($row[0]<>3){
																													  echo "<option value=".$row[0].">".$row[1]."</option>";
																												 }
																			 
												                            }
												                           mysqli_free_result($result);
												                          }
												                       } while (mysqli_next_result($conexionj));
												                    }
																  else
																  	echo mysqli_error();                   
										                           ?>
					                 						<option value="0">Otro</option>
					                          			</select>
					                        		</div>
					                      		</div>
					                      		<?php
					                      		if($valores[8]==3){
					                      			?>
					                      				<div class="item form-group" id="otraprofesion" style="display:none;">
										        	       	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="otraprof">Especifique otra profesión </label>
							        			            <div class="col-md-3 col-sm-6 col-xs-12">
							                        			<input type="text" id="otraprof" name="otraprof" placeholder="Ingrese otra profesión..." class="form-control col-md-7 col-xs-12" >
							                        		</div>
							                      		</div>
					                      				<div class="item form-group" id="matricula" style="display;">
							                  				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="imgmatricula">Matrícula vigente de estudio (imagen, escaneado) <span class="required">*</span>
								                       		</label>
							 								<div class="col-md-3 col-sm-6 col-xs-12">
								                       			<input id="imgmatricula" name="imgmatricula" type="file" class="file" data-preview-file-type="any" data-allowed-file-extensions='["jpg", "png","bmp","doc","docx","pdf"]' accept="application/pdf,image/png, .jpeg, .jpg, .bmp" >
								                       		</div>
							                  	 		</div>
					                      			<?php
					                      		}
												else {
													?>
														
					                      				<div class="item form-group" id="otraprofesion" style="display:none;">
										        	       	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="otraprof">Especifique otra profesión </label>
							        			            <div class="col-md-3 col-sm-6 col-xs-12">
							                        			<input type="text" id="otraprof" name="otraprof" placeholder="Ingrese otra profesión..." class="form-control col-md-7 col-xs-12" >
							                        		</div>
							                      		</div>
							                      		<div class="item form-group" id="matricula" style="display:none;">
							                  				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="imgmatricula">Matrícula vigente de estudio (imagen, escaneado) <span class="required">*</span>
								                       		</label>
							 								<div class="col-md-3 col-sm-6 col-xs-12">
								                       			<input id="imgmatricula" name="imgmatricula" type="file" class="file" data-preview-file-type="any" data-allowed-file-extensions='["jpg", "png","bmp","doc","docx","pdf"]' accept="application/pdf,image/png, .jpeg, .jpg, .bmp" >
								                       		</div>
							                  	 		</div>
					                      			<?php
												}	
					                      
											}
										
										if($valores[11]==0){
											?>
											<div class="item form-group">
				                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="institucion">Institución <span class="required">*</span>
				                        		</label>
				                       			<div class="col-md-3 col-sm-6 col-xs-12">
				                          			<select id="institucion" name="institucion" class="form-control" onChange="habilitar1(this.form)" required>
				                            			<option value="0"  selected="selected">Otro</option>
									                      <?php
									                        $query = "select id_inst,nombre_inst from institucion order by nombre_inst";
												                if (mysqli_multi_query($conexionj, $query)) {
											                      do {
											                          if ($result = mysqli_store_result($conexionj)) {
											                               while ($row = mysqli_fetch_row($result)) {
																		  echo "<option value=".$row[0].">".$row[1]."</option>";
											                            }
											                           mysqli_free_result($result);
											                          }
											                       } while (mysqli_next_result($conexionj));
											                    }
															  else
															  	echo mysqli_error();                   
									                           ?>
				                          			</select>
				                        		</div>
				                      		</div>
				                      		
				                      		<div class="item form-group" id="otrainstitucion" style="display:;">
							        	       	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="otrainst">Especifique otra institución </label>
				        			            <div class="col-md-3 col-sm-6 col-xs-12">
				                        			<input type="text" id="otrainst" name="otrainst" placeholder="Ingrese otra institución..." class="form-control col-md-7 col-xs-12" value="<?php echo $valores[13];?>" >
				                        		</div>
				                      		</div>
											
											<?php
										}
										else{
											?>
											<div class="item form-group">
				                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="institucion">Institución <span class="required">*</span>
				                        		</label>
				                       			<div class="col-md-3 col-sm-6 col-xs-12">
				                          			<select id="institucion" name="institucion" class="form-control" onChange="habilitar1(this.form)" required>
				                            			<option value="<?php echo $valores[11];?>"  selected="selected"><?php echo $valores[12];?></option>
									                      <?php
									                        $query = "select id_inst,nombre_inst from institucion order by nombre_inst";
												                if (mysqli_multi_query($conexionj, $query)) {
											                      do {
											                          if ($result = mysqli_store_result($conexionj)) {
											                               while ($row = mysqli_fetch_row($result)) {
																											
																												 echo "<option value=".$row[0].">".$row[1]."</option>";
																											 
																		  
											                            }
											                           mysqli_free_result($result);
											                          }
											                       } while (mysqli_next_result($conexionj));
											                    }
															  else
															  	echo mysqli_error();                   
									                           ?>
				                 						<option value="0">Otro</option>
				                          			</select>
				                        		</div>
				                      		</div>
				                      		
				                      		<div class="item form-group" id="otrainstitucion" style="display:none;">
							        	       	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="otrainst">Especifique otra institución </label>
				        			            <div class="col-md-3 col-sm-6 col-xs-12">
				                        			<input type="text" id="otrainst" name="otrainst" placeholder="Ingrese otra institución..." class="form-control col-md-7 col-xs-12" >
				                        		</div>
				                      		</div>
											<?php
										}		
			                      		?>
			                      		
			                      		
			                      		
			                      		
											
										<div class="item form-group">
			                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="fono">Teléfono / Celular de referencia <span class="required">*</span>
			                        		</label>
			                        		<div class="col-md-6 col-sm-6 col-xs-12">
			                        			<input id="fono" class="form-control col-md-7 col-xs-12" name="fono" placeholder="Ingrese su(s) números(s) telefónico(s)..." required="required" type="text" value="<?php echo $valores[14];?>">
			                        			<div class="help-block with-errors"></div>
			                        		</div>
			                      		</div>
										<?php
											if($tipoinscrito!=2 && $tipoinscrito!=3 &&	 $tipoinscrito!=4)
											{
												?>
												<div id="divfact" style="display:;" >
							                      	<span class="section">Datos para la factura</span>
					                        		<div class="item form-group">
					                        			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Razón Social <span class="required">*</span>
					                        			</label>'
					                        			<div class="col-md-6 col-sm-6 col-xs-12">
					                          				<input id="rsocial" class="form-control col-md-7 col-xs-12" data-validate-length-range="2"  name="rsocial" placeholder="Ingrese su razón social..." required="required" type="text" value="<?php echo $valores[15];?>">
					                          				<div class="help-block with-errors"></div>
					                        			</div>
					                      			</div>
					                         		<div class="item form-group">
														<label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">NIT / C.I. <span class="required">*</span></label>
														<div class="col-md-2 col-sm-6 col-xs-12">
															<input type="number" id="nitci" name="nitci" required="required"  class="form-control col-md-7 col-xs-12" value="<?php echo $valores[16];?>">
															<div class="help-block with-errors"></div>
														</div>
													</div>
												</div>
												
												
												<?php
											}
											else
												{
													?>
													<input type="hidden" name="rsocial" value="" />
													<input type="hidden" name="nitci" value="0" />
													<?php
												}
										?>
			                        	
										
					         			<div class="ln_solid"></div>
					                      <div class="form-group">
					                        <div class="col-md-6 col-md-offset-3">
					                        	<input type="hidden" value="<?php echo $ci;?>" name="ci" id="ci"/>
					                          <button type="reset"class="btn btn-primary">Cancelar</button>
					                          <input type="submit" class="btn btn-success" value="Guardar"  />
					                        </div>
					                      </div>
					        		</form>
				              	</div>
		            		</div>
		            	</div>
		            </div>
        		</div>
        	</div>
        	<!-- /page content -->
			<!-- Small modal -->

                <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">�</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2">Cambio de Password</h4>
                        </div>
                        <form class="form-horizontal form-label-left" novalidate method="post" name="cambia_pass_form" action="includes/update_pass_j.php">
                        <div class="modal-body">
                          <div class="item form-group">
	                        <label for="password" class="control-label col-md-6">Password actual</label>
	                        <div class="col-md-6">
	                          <input id="passworda" type="password" name="passworda" class="form-control col-md-3" required="required">
	                        </div>
	                      </div>	
                          <div class="item form-group">
	                        <label for="password" class="control-label col-md-6">Nuevo Password</label>
	                        <div class="col-md-6">
	                          <input id="passwordn" type="password" name="passwordn" class="form-control col-md-3" required="required">
	                        </div>
	                      </div>
	                      <div class="item form-group">
	                        <label for="password2" class="control-label col-md-6">Repita Nuevo Password</label>
	                        <div class="col-md-6">
	                          <input id="password2n" type="password" name="password2n" data-validate-linked="passwordn" class="form-control col-md-7 col-xs-12" required="required">
	                        </div>
	                      </div>
                        </div>
                        <div class="modal-footer">
                        	<div class="item form-group">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          <button type="submit" class="btn btn-primary">Guardar cambios</button>
                          </div>
                        </div>
						</form>
                      </div>
                    </div>
            </div>
                  <!--final modal-->
	        
	        
	        <!-- footer content -->
	         <footer>
	          <div class="pull-right">
	            Autoridad de Impugnación Tributaria <a href="https://www.ait.gob.bo">A.I.T.</a>
	          </div>
	          <div class="clearfix"></div>
	        </footer>
	        <!-- /footer content -->
		</div>	
	</div>
	
	

    
    <!-- Include jQuery -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <!-- Include jQuery Validator plugin -->
    <script src="js/validator.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
    
    <!-- bootstrap-daterangepicker -->
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
 <!-- PNotify -->
    <script src="vendors/pnotify/dist/pnotify.js"></script>
    <script src="vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="vendors/pnotify/dist/pnotify.nonblock.js"></script>

     <!-- bootstrap-daterangepicker -->

    <script>
      $(document).ready(function() {
        $('#fechatrans').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
      $(document).ready(function() {
        $('#fechacheque').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>
    <!-- /bootstrap-daterangepicker --> 
    
   

    <!-- Custom Notification -->
    <script>
      $(document).ready(function() {
        var cnt = 10;

        TabbedNotification = function(options) {
          var message = "<div id='ntf" + cnt + "' class='text alert-" + options.type + "' style='display:none'><h2><i class='fa fa-bell'></i> " + options.title +
            "</h2><div class='close'><a href='javascript:;' class='notification_close'><i class='fa fa-close'></i></a></div><p>" + options.text + "</p></div>";

          if (!document.getElementById('custom_notifications')) {
            alert('doesnt exists');
          } else {
            $('#custom_notifications ul.notifications').append("<li><a id='ntlink" + cnt + "' class='alert-" + options.type + "' href='#ntf" + cnt + "'><i class='fa fa-bell animated shake'></i></a></li>");
            $('#custom_notifications #notif-group').append(message);
            cnt++;
            CustomTabs(options);
          }
        };

        CustomTabs = function(options) {
          $('.tabbed_notifications > div').hide();
          $('.tabbed_notifications > div:first-of-type').show();
          $('#custom_notifications').removeClass('dsp_none');
          $('.notifications a').click(function(e) {
            e.preventDefault();
            var $this = $(this),
              tabbed_notifications = '#' + $this.parents('.notifications').data('tabbed_notifications'),
              others = $this.closest('li').siblings().children('a'),
              target = $this.attr('href');
            others.removeClass('active');
            $this.addClass('active');
            $(tabbed_notifications).children('div').hide();
            $(target).show();
          });
        };

        CustomTabs();

        var tabid = idname = '';

        $(document).on('click', '.notification_close', function(e) {
          idname = $(this).parent().parent().attr("id");
          tabid = idname.substr(-2);
          $('#ntf' + tabid).remove();
          $('#ntlink' + tabid).parent().remove();
          $('.notifications a').first().addClass('active');
          $('#notif-group div').first().css('display', 'block');
        });
      });
    </script>
    <!-- /Custom Notification -->
</body>

</html>
