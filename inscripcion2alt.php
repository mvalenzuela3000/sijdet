<?php
 include 'includes/funj.php';
	include_once 'includes/db_connect.php';
	include_once 'includes/functions.php';
	verifica_cupos(date("Y"),6,1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inscripciones | Jornadas Bolivianas de Derecho Tributario</title>

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
		function habilitarp(form)
		{ 
				if (form.pais.value=="1"){
					 $('#dpto').prop("required", true);
		           divC = document.getElementById("departamento");
		           divC.style.display = "";

		      	}else{
		      		
		      	   divC = document.getElementById("departamento");
		           divC.style.display="none";
		           $('#dpto').removeAttr("required");
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
	       	$(document).ready(function(){ 	
				$( "#numdepo" ).autocomplete({
      				source: "buscardeposito.php",
      				minLength: 2
    			});
    			
    			$("#numdepo").focusout(function(){
    				$.ajax({
    					url:'depositos.php',
    					type:'POST',
    					dataType:'json',
    					data:{ deposito:$('#numdepo').val()}
    				}).done(function(respuesta){
    					$("#fechadep").val(respuesta.fechadepo);
    					$("#montodepo").val(respuesta.montodepo);
    				});
    			});    			    		
			});
 	</script>

     <script>
     	
		function habilitaradio(value)
		{
			if(value=="0")
			{
				// habilitamos
				$('#numdepo').prop("required", true);
				$('#file-1').prop("required", true);
				$('#nitci').prop("required", true);
				$('#rsocial').prop("required", true);
				$('#numtrans').removeAttr("required");
				$('#fechatrans').removeAttr("required");
				$('#montotrans').removeAttr("required");
				$('#imgtrans').removeAttr("required");
				$('#numcheque').removeAttr("required");
				$('#fechacheque').removeAttr("required");
				$('#montocheque').removeAttr("required");
				$('#imgcheque').removeAttr("required");
				$('#numbeca').removeAttr("required");
				$('#codver').removeAttr("required");

				$("#div1dep").show();
				$("#divfact").show();
				$("#div2dep").hide();
			    $("#div3dep").hide();
			    $("#div4dep").hide();
			}else if(value=="1"){
				// deshabilitamos
				$('#numtrans').prop("required", true);
				$('#imgtrans').prop("required", true);
				$('#fechatrans').prop("required", true);
				$('#montotrans').prop("required",true);
				$('#nitci').prop("required", true);
				$('#rsocial').prop("required", true);
				$('#numcheque').removeAttr("required");
				$('#fechacheque').removeAttr("required");
				$('#montocheque').removeAttr("required");
				$('#imgcheque').removeAttr("required");
				$('#numdepo').removeAttr("required");
				$('#file-1').removeAttr("required");
				$('#numbeca').removeAttr("required");
				$('#codver').removeAttr("required");

				$("#div1dep").hide();
			    $("#div2dep").show();
			    $("#divfact").show();
			    $("#div3dep").hide();
			    $("#div4dep").hide();
			}else if(value=="2"){
				// deshabilitamos
				$('#numcheque').prop("required", true);
				$('#imgcheque').prop("required", true);
				$('#fechacheque').prop("required", true);
				$('#montocheque').prop("required",true);
				$('#nitci').prop("required", true);
				$('#rsocial').prop("required", true);
				$('#numdepo').removeAttr("required");
				$('#file-1').removeAttr("required");
				$('#numtrans').removeAttr("required");
				$('#imgtrans').removeAttr("required");
				$('#fechatrans').removeAttr("required");
				$('#montotrans').removeAttr("required");
				$('#numbeca').removeAttr("required");
				$('#codver').removeAttr("required");
				$("#div1dep").hide();
			    $("#div2dep").hide();
			    $("#div3dep").show();
			    $("#divfact").show();
			    $("#div4dep").hide();
			}else if(value=="3"){
				// deshabilitamos
				$('#numbeca').prop("required", true);
				$('#codver').prop("required", true);
				$('#numdepo').removeAttr("required");
				$('#file-1').removeAttr("required");
				$('#numtrans').removeAttr("required");
				$('#imgtrans').removeAttr("required");
				$('#fechatrans').removeAttr("required");
				$('#montotrans').removeAttr("required");
				$('#numcheque').removeAttr("required");
				$('#fechacheque').removeAttr("required");
				$('#montocheque').removeAttr("required");
				$('#imgcheque').removeAttr("required");
				$('#nitci').removeAttr("required");
				$('#rsocial').removeAttr("required");
				$("#div1dep").hide();
			    $("#div2dep").hide();
			    $("#div3dep").hide();
			    $("#divfact").hide();
			    $("#div4dep").show();
			}
		}
	</script>
	<style>p.indent{ padding-left: 1.8em }</style>
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
	              <a href="http://www.ait.gob.bo/jornadas" class="site_title"><span>JBDT - AIT</span></a>
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
												echo htmlentities($_SESSION['username']);} 
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
	                 
	                  <li><a><i class="fa fa-edit"></i> Inscripción <span class="fa fa-chevron-down"></span></a>
	                    <ul class="nav child_menu">
	                      <li><a href="inscripcion.php">Formulario de Inscripción</a></li>
	                    </ul>
	                  </li>
	             
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
		                <h3>Inscripciones - Jornadas Bolivianas de Derecho Tributario</h3>
		              </div>
		            </div>
		            <div class="clearfix"></div>
		            <div class="row">
		            	<div class="col-md-12 col-sm-12 col-xs-12">
		            		<div class="x_panel">
		            			<div class="x_title">
				                	<h2>Datos de Inscripción <small>Usuarios</small></h2>
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
							        <form class="form-horizontal form-label-left" enctype="multipart/form-data" id="myForm" role="form" data-toggle="validator" action="control/registra_preinscripcion2.php" method="post">
			            	    		<script>
											function soloLetras(e) {
											    key = e.keyCode || e.which;
											    tecla = String.fromCharCode(key).toLowerCase();
											    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
											    especiales = [8, 37, 39, 46];
											
											    tecla_especial = false
											    for(var i in especiales) {
											        if(key == especiales[i]) {
											            tecla_especial = true;
											            break;
											        }
											    }
											
											    if(letras.indexOf(tecla) == -1 && !tecla_especial)
											        return false;
											}
											
											function limpianom() {
											    var val = document.getElementById("name").value;
											    var tam = val.length;
											    for(i = 0; i < tam; i++) {
											        if(!isNaN(val[i]))
											            document.getElementById("name").value = '';
											    }
											}
											function limpiaape() {
											    var val = document.getElementById("apellido").value;
											    var tam = val.length;
											    for(i = 0; i < tam; i++) {
											        if(!isNaN(val[i]))
											            document.getElementById("apellido").value = '';
											    }
											}
										</script>
			            	    		<div class="item form-group">
			                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nombre(s) <span class="required">*</span>
			                        		</label>
			                        		<div class="col-md-6 col-sm-6 col-xs-12">
			                          			<input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="2" onkeypress="return soloLetras(event)"   name="name" placeholder="Ingrese su(s) nombre(s)..." required="required" type="text" autofocus>
			                          			<div class="help-block with-errors"></div>
			                        		</div>
			                      		</div>
			                      		<div class="item form-group">
			                       			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="apellido">Apellido(s) <span class="required">*</span>
			                        		</label>
			                        		<div class="col-md-6 col-sm-6 col-xs-12">
			                          			<input id="apellido" class="form-control col-md-7 col-xs-12" data-validate-length-range="2" onkeypress="return soloLetras(event)"  name="apellido" placeholder="Ingrese su(s) apellido(s)..." required="required" type="text">
			                          			<div class="help-block with-errors"></div>
			                        		</div>
			                      		</div>
			                      		<div class="item form-group">
			                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">C.I. <span class="required">*</span></label>
			                        		<div class="col-md-2 col-sm-6 col-xs-12">
			                          			<input type="number" id="number" name="number" required="required" class="form-control col-md-7 col-xs-12">
			                          			<div class="help-block with-errors"></div>
			                        		</div>
			                        		<label  class="control-label col-md-1 col-sm-3 col-xs-12" for="extension">Extensión <span class="required">*</span></label>
			                        		<div class="col-md-1 col-sm-6 col-xs-12">
			                          			<select id="extension" name="extension" class="form-control" required>
			                            			<option value="">Seleccione..</option>
								                       <?php
								                       	$conexionj=conexj();
								                         $query = "select id_dep,nombre_dep,ext_dep from departamentos";
								        	           	 if (mysqli_multi_query($conexionj, $query)) {
														 	do {
														    	if ($result = mysqli_store_result($conexionj)) {
														        	while ($row = mysqli_fetch_row($result)) {
																		echo "<option value=".$row[0].">".$row[2]."</option>";
														            }
														            mysqli_free_result($result);
														        }
														    } while (mysqli_next_result($conexionj));
														 }
														 else
														  	echo mysqli_error();
								                       ?>                 
			                          			</select>
												<div class="help-block with-errors"></div>
			                        		</div>
			                     		</div>
			                      		<div class="item form-group">
			                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
			                        		</label>
			                        		<div class="col-md-6 col-sm-6 col-xs-12">
			                          			<input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12" data-toggle="tooltip" data-placement="right" title="El correo electrónico se guarda con mayúsculas, no intente ingresar minúsculas">
			                          			<div class="help-block with-errors"></div>
			                        		</div>
			                      		</div>
			                      		<div class="item form-group" id="pais">
			                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="pais">País de origen <span class="required">*</span>
			                        		</label>
			                        		<div class="col-md-3 col-sm-6 col-xs-12">
			                          			<select id="pais" name="pais" class="form-control" required="required" onChange="habilitarp(this.form)">
			                            			<option value="">Seleccione..</option>
								                      <?php
								        	              $query = "select id_pais,nombre from pais";
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
			                       		<div class="item form-group" id="departamento" style="display:;">
			                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="dpto">Departamento de Residencia<span class="required">*</span>
			                        		</label>
			                        		<div class="col-md-3 col-sm-6 col-xs-12">
			                          			<select id="dpto" name="dpto" class="form-control" required="required" data-toggle="tooltip" data-placement="right" title="En caso de no recoger el Certificado se enviará el mismo a la regional de este departamento">
			                            			<option value="">Seleccione..</option>
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
			                      		<div class="item form-group">
			                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Profesión <span class="required">*</span>
			                        		</label>
			                       			<div class="col-md-3 col-sm-6 col-xs-12">
			                          			<select id="prof" name="prof" class="form-control" onChange="habilitar(this.form)" required="required">
			                            			<option value=""  selected="selected">Seleccione..</option>
								                      <?php
								                        $query = "select id_prof,nombre_prof from profesiones";
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
				                       			<input id="imgmatricula" name="imgmatricula" type="file" class="file" data-preview-file-type="any" data-allowed-file-extensions='["jpg","jpeg", "png","bmp","doc","docx","pdf"]' accept="application/pdf,image/png, .jpeg, .jpg, .bmp" >
				                       		</div>
			                  	 		</div>
			                      		<div class="item form-group">
			                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="institucion">Institución <span class="required">*</span>
			                        		</label>
			                       			<div class="col-md-3 col-sm-6 col-xs-12">
			                          			<select id="institucion" name="institucion" class="form-control" onChange="habilitar1(this.form)" required>
			                            			<option value=""  selected="selected">Seleccione..</option>
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
											
										<div class="item form-group">
			                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="fono">Teléfono / Celular de referencia <span class="required">*</span>
			                        		</label>
			                        		<div class="col-md-6 col-sm-6 col-xs-12">
			                        			<input id="fono" class="form-control col-md-7 col-xs-12" name="fono" placeholder="Ingrese su(s) números(s) telefónico(s)..." required="required" type="text">
			                        			<div class="help-block with-errors"></div>
			                        		</div>
			                      		</div>
										<span class="section">Datos del Depósito Bancario, de la Transferencia o de la Beca, por favor seleccione el modo de pago</span>
						            
		                         		<div class="item form-group">
		                         			<div class="col-md-4 col-sm-6 col-xs-12">
		                            			<h2><label> 
					                        		Depósito Bancario: <input type="radio"  name="tipodep" id="deposito" value="0" checked="" onchange="habilitaradio(this.value);" required />
		                          				</label></h2>
		                          			</div>
		                          			<div class="col-md-4 col-sm-6 col-xs-12">
		                            			<h2><label> 
					                        		Transferencia Bancaria: <input type="radio"  name="tipodep" id="transf" onchange="habilitaradio(this.value);" value="1" />
					                        	</label></h2>
		                          			</div>
		                          			<div class="col-md-4 col-sm-6 col-xs-12">
		                            			<h2><label> 
					                        		Cheque ajeno al Banco Unión: <input type="radio"  name="tipodep" id="cheque" onchange="habilitaradio(this.value);" value="2" />
					                        	</label></h2>
		                          			</div>
		                          			<!--<div class="col-md-3 col-sm-6 col-xs-12">
		                            			<h2><label>
					                        		Beca: <input type="radio"  name="tipodep" id="beca" onchange="habilitaradio(this.value);" value="3" />
					                        	</label></h2>
		                          			</div>-->
		                         		</div>
		
			                        	<div id="div1dep" style="display:;">
				                          	<div class="item form-group">
					                        	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="numdepo">Número de Depósito <span class="required">*</span>
					                        	</label>
					                        	<div class="col-md-6 col-sm-6 col-xs-12">
					                          		<input id="numdepo" class="form-control col-md-7 col-xs-12"  name="numdepo" required="" type="number" >
					                        	</div>
					                       	</div>
					                        <div class="form-group" >
					                  			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="file-1">Comprobante de Depósito (imagen, escaneado) <span class="required">*</span>
						                    	</label>
					 							<div class="col-md-3 col-sm-6 col-xs-12">
						                    		<input id="file-1" name="file-1" type="file" class="file" data-preview-file-type="any" data-allowed-file-extensions='["jpg","JPG", "jpeg","png","bmp","doc","docx","pdf"]' required="" accept="application/pdf,image/png, .jpeg, .jpg, .JPG, .bmp" >
					                        	</div>
				                  	 		</div>
					      				   	
			                        	</div>
			                        	<div id="div2dep" style="display:none;" >
			                          		<div class="item form-group">
				                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="numdepo">Número de Transferencia <span class="required">*</span>
				                        		</label>
				                        		<div class="col-md-6 col-sm-6 col-xs-12">
				                          			<input id="numtrans" class="form-control col-md-7 col-xs-12"  name="numtrans"  type="text" >
				                        		</div>
				                       		</div>
				      				   		<div class="item form-group">
				                          		<label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha de la Transferencia <span class="required">*</span>
				                          		</label>
				                          		<div class="col-md-2 col-sm-6 col-xs-12">
				                            		<input id="fechatrans" name="fechatrans" class="date-picker form-control col-md-7 col-xs-12"  type="text">
				                          		</div>
				                       		</div>
				                       		<div class="item form-group">
				                           		<label class="control-label col-md-3 col-sm-3 col-xs-12">Monto de la Transferencia <span class="required">*</span>
				                           		</label>
				                           		<div class="col-md-2 col-sm-6 col-xs-12">
				                            		<input id="montotrans" name="montotrans" class="form-control col-md-7 col-xs-12" data-validate-minmax="400,10000"  type="number">
				                           		</div>
				                        	</div>
				                        	<div class="item form-group" >
				                  		   		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="imgcheque">Imagen de la transferencia <span class="required">*</span>
					                        	</label>
				 								<div class="col-md-3 col-sm-6 col-xs-12">
					                        		<input id="imgtrans" name="imgtrans" type="file" class="file" data-preview-file-type="any" data-allowed-file-extensions='["jpg", "png","bmp","doc","docx","pdf"]'  accept="application/pdf,image/png, .jpeg, .jpg, .bmp" >
				                        		</div>
			                  	 			</div>
			                        	</div>
			                        	<div id="div3dep" style="display:none;" >
			                          		<div class="item form-group">
				                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="numdepo">Número de depósito <span class="required">*</span>
				                        		</label>
				                        		<div class="col-md-6 col-sm-6 col-xs-12">
				                          			<input id="numcheque" class="form-control col-md-7 col-xs-12"  name="numcheque"  type="text" >
				                        		</div>
				                       		</div>
				      				   		<div class="item form-group">
				                          		<label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha del depósito <span class="required">*</span>
				                          		</label>
				                          		<div class="col-md-2 col-sm-6 col-xs-12">
				                            		<input id="fechacheque" name="fechacheque" class="date-picker form-control col-md-7 col-xs-12"  type="text">
				                          		</div>
				                       		</div>
				                       		<div class="item form-group">
				                           		<label class="control-label col-md-3 col-sm-3 col-xs-12">Monto del depósito <span class="required">*</span>
				                           		</label>
				                           		<div class="col-md-2 col-sm-6 col-xs-12">
				                            		<input id="montocheque" name="montocheque" class="form-control col-md-7 col-xs-12" data-validate-minmax="400,10000"  type="number">
				                           		</div>
				                        	</div>
				                        	<div class="item form-group" >
				                  		   		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="imgcheque">Imagen de la transferencia o Cheque <span class="required">*</span>
					                        	</label>
				 								<div class="col-md-3 col-sm-6 col-xs-12">
					                        		<input id="imgcheque" name="imgcheque" type="file" class="file" data-preview-file-type="any" data-allowed-file-extensions='["jpg", "png","bmp","doc","docx","pdf"]'  accept="application/pdf,image/png, .jpeg, .jpg, .bmp" >
				                        		</div>
			                  	 			</div>
			                        	</div>
			                        	<div id="div4dep" style="display:none;" >
			                        		<div class="item form-group">
				                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="numdepo">Código de beca <span class="required">*</span>
				                        		</label>
				                        		<div class="col-md-6 col-sm-6 col-xs-12">
				                          			<input id="numbeca" class="form-control col-md-7 col-xs-12"  name="numbeca" type="text" data-toggle="tooltip" data-placement="right" title="Al ingresar el código de beca y hacer clic en VALIDAR, se le enviará un mensaje a su correo electrónico con el código de verificación el cual deberá ingresarlo en la casilla correspondiente.">
				                        		</div>
				                       		</div>
				                       		<div class="item form-group">
				                       			<label class="control-label col-md-3 col-sm-3 col-xs-12">Validar código de beca <span class="required">*</span>
					                        	</label>
					                        	<div class="col-md-6 col-sm-6 col-xs-12">
					                        		<button type="button" class="btn btn-info btn-xs"  >Validar</button>
					                        	</div>
				                       		</div>
				                       		<div id="codverificacion" style="display:none;">
				                       			<div class="item form-group">
					                       			<label class="control-label col-md-3 col-sm-3 col-xs-12">Código de verificación <span class="required">*</span>
						                        	</label>
						                        	<div class="col-md-2 col-sm-6 col-xs-12">
						                        		<input id="codver" name="codver" class="form-control col-md-7 col-xs-12" type="text">
						                        	</div>
				                       			</div>
					                       	</div>
			                        	</div>
			                        	<div id="divfact" style="display:;" >
					                      	<span class="section">Datos para la factura</span>
			                        		<div class="item form-group">
			                        			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Razón Social <span class="required">*</span>
			                        			</label>
			                        			<div class="col-md-6 col-sm-6 col-xs-12">
			                          				<input id="rsocial" class="form-control col-md-7 col-xs-12" data-validate-length-range="2"  name="rsocial" placeholder="Ingrese su razón social..." required="required" type="text">
			                          				<div class="help-block with-errors"></div>
			                        			</div>
			                      			</div>
			                         		<div class="item form-group">
												<label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">NIT / C.I. <span class="required">*</span></label>
												<div class="col-md-2 col-sm-6 col-xs-12">
													<input type="number" id="nitci" name="nitci" required="required" class="form-control col-md-7 col-xs-12">
													<div class="help-block with-errors"></div>
												</div>
											</div>
										</div>
										<span class="section">Términos y condiciones</span>
						                
					                    <p class="indent">
					                        a) La asistencia a las ponencias es obligatoria para recibir el Certificado de Participación. <br>
					                        b) Declaro que he revisado todos los datos insertados en el formulario, mismos que serán utilizados para la emisión del Certificado de Participación así como medio de contacto para la difusión de noticias.
					                        
					                        <br>
					                        
					                    </p>
					                    <div class="item form-group" data-toggle="validator">
					                        <div class="item form-group">
					                            <label for="terms">Estoy de acuerdo con los términos y condiciones.</label>
					                            <input type="checkbox" id="terms" data-error="Para completar la inscripción debe aceptar los términos y condiciones." required>  
					                            <div class="help-block with-errors"></div>
					                        </div>
					                    </div>
					         			<div class="ln_solid"></div>
					                      <div class="form-group">
					                        <div class="col-md-6 col-md-offset-3">
					                          <button type="reset"class="btn btn-primary">Cancelar</button>
					                          <input type="submit" class="btn btn-success" value="Registrar"  />
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
