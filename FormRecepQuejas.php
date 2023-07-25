<?php
 include 'conexion.php';
	include_once 'includes/db_connect.php';
	include_once 'includes/functions.php';
sec_session_start();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> AIT | Formulario de Quejas</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
 
    <!-- Select2 -->
    <link href="vendors/select2/dist/css/select2.min.css" rel="stylesheet">

    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
     <!-- Bootstrap_file_input -->
    <link href="css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
    <script src="js/jquery.min.js"></script>
    <script src="js/fileinput.min.js" type="text/javascript"></script>

    <link href="themes/explorer/theme.css" media="all" rel="stylesheet" type="text/css"/>
   
    <script src="js/plugins/sortable.js" type="text/javascript"></script>

    <script src="themes/explorer/theme.js" type="text/javascript"></script>
   <script src="js/bootstrap.min.js" type="text/javascript"></script>
   <script>
	function habilitar(value) {
		if (value == "1") {
			// habilitamos
			 divC = document.getElementById("divnombre");
		           divC.style.display = "";
			document.getElementById("fullname").disabled = false;
			document.getElementById("ci").disabled = false;
			document.getElementById("tel").disabled = false;
			document.getElementById("email").disabled = false;
			document.getElementById("direccion").disabled = false;
			document.getElementById("reserva").disabled = false;
		} else if (value == "2") {
			// deshabilitamos
			divC = document.getElementById("divnombre");
		           divC.style.display="none";
			document.getElementById("fullname").disabled = true;
			document.getElementById("ci").disabled = true;
			document.getElementById("tel").disabled = true;
			document.getElementById("email").disabled = true;
			document.getElementById("direccion").disabled = true;
			document.getElementById("reserva1").disabled = true;
		}
	}


	function habilitaprueba1(value)
		{
			if(value.length>"0")
			{
				// habilitamos
				$('#file-1').prop("required", true);
			}else{
				$('#file-1').prop("required", false);
				divC = document.getElementById("sinpruebas");
		        divC.style.display = "none";
			}
		}
	function habilitaprueba2(value)
		{
			if(value.length>"0")
			{
				// habilitamos
				$('#file-2').prop("required", true);
			}else{
				$('#file-2').prop("required", false);
				divC = document.getElementById("sinpruebas");
		        divC.style.display = "none";
			}
		}	
	function habilitaprueba3(value)
		{
			if(value.length>"0")
			{
				// habilitamos
				$('#file-3').prop("required", true);
			}else{
				$('#file-3').prop("required", false);
				divC = document.getElementById("sinpruebas");
		        divC.style.display = "none";
			}
		}
	</script>

     

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
              <a href="FormRecepQuejas.php" class="site_title"> <span>Formulario de quejas</span></a> 
             
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
										else echo 'Invitado';
											$usuario='';
										?></h2>
						</div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                
               <?php
						if(isset($_SESSION['usuario'])) 
                			{	
		                    
                      		echo crea_menu($_SESSION['usuario'],$mysqli);
							}
						else {
							echo '<ul class="nav side-menu">
                  
                  <li><a><i class="fa fa-edit"></i> Formularios <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="FormRecepQuejas.php">Formulario de quejas</a></li>
                
                    </ul>
                  </li>
                  
                </ul>';
						}
							?>
                
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
                <h3>FORMULARIO DE RECEPCIÓN DE QUEJAS Y/O SUGERENCIAS Nro. <?php
				$query = "CALL pa_obtener_id()";

				if (mysqli_multi_query($conexion, $query)) {
					do {
						/* store first result set */
						if ($result = mysqli_store_result($conexion)) {
							while ($row = mysqli_fetch_row($result)) {
								if($row[0]<10){
									$cifra='000'.$row[0];
								}elseif($row[0]>=10 && $row[0]<100){
									$cifra='00'.$row[0];
								}elseif($row[0]>100 && $row[0]<1000){
									$cifra='0'.$row[0];
								}else{
									$cifra=$row[0];
								}
								
								echo "<strong>" . $cifra . "/" . date("Y") . "</strong>";
							}
							mysqli_free_result($result);
						}

					} while (mysqli_next_result($conexion));
				}

				/* close connection */
				mysqli_close($conexion);
                ?></h3>
              </div>

            </div>
            <div class="clearfix"></div>
           

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
            	<label for="message"><h4><small> Agradecemos a usted su cooperación para fortalecer la mejora continua en los servicios que le brinda la Autoridad de Impugnación Tributaria (AIT), por lo que es importante  conocer sus quejas y/o sugerencias sobre el servicio que reciben en esta institución.  En caso que usted haya advertido, la existencia de mala calidad en alguna de las actividades misionales y/o de apoyo que se relacionan directamente con el servicio que presta la institución en cualquiera de sus dependencias o problemas y/o deficiencias en los espacios físicos y condiciones de trabajo, para el desarrollo de los trámites de los/as recurrentes, agradeceremos llene y presente éste formulario. </small> </h4> </label>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>DATOS DE LA QUEJA O SUGERENCIA</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <!-- start form for validation -->
                    <form action="control/registraQueja.php" method="POST" enctype="multipart/form-data" data-parsley-validate >
                    
                     <label for="message"><h4>LUGAR DEL HECHO. <small>(Por favor indique la oficina de la AIT donde se registro el hecho).</small> </h4> </label>
   
                     	<select id="oficina" name="oficina"	class="col-md-4 col-sm-12 col-xs-12 form-control" required>
		           			<option value="1">Autoridad General de Impugnación Tributaria</option>
		                    <option value="2">Autoridad Regional de Impugnación Tributaria Chuquisaca</option>
		                    <option value="3">Oficina Departamental Potosí</option>
		                    <option value="4">Autoridad Regional de Impugnación Tributaria Cochabamba</option>
		                    <option value="5">Oficina Departamental Tarija</option>
		                    <option value="6">Autoridad Regional de Impugnación Tributaria La Paz</option>
		                    <option value="7">Oficina Departamental Oruro</option>
		                    <option value="8">Autoridad Regional de Impugnación Tributaria Santa Cruz</option>
		                    <option value="9">Oficina Departamental Beni</option>
		                    <option value="10">Oficina Departamental Pando</option>
              			</select>
					
              
                     <label for="message"><h4>DESCRIBE TU QUEJA O SUGERENCIA. <small>(Por favor realizar una explicación breve y concreta de los hechos que dan lugar a su queja o sugerencia. Para ello tomar en cuenta los siguientes preguntas guía para exponer los hechos: ¿Qué ocurrió?, ¿Cuándo ocurrió?, ¿Cómo ocurrió?, ¿Dónde ocurrió?, ¿Quién lo hizo? (20 caracteres mínimo, 1000 máximo)).</small> </h4> </label>
                     <textarea id="queja" required class="form-control" name="queja" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="1000" data-parsley-minlength-message="La descripción de la queja no puede tener menos de 20 caracteres"
                     data-parsley-validation-threshold="10"></textarea>
                     <label for="message"><h4>PRUEBAS DE LA QUEJA. <small>(Sólo en caso de presentar una queja, por favor indicar las pruebas que presenta para respaldo (Puede subir hasta 3 archivos entre imágenes, documentos, audio.)</small> </h4> </label>
                  		</br>
                  	 <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                  		 <label for="fullname"><h4>Descripción Prueba 1:</h4></label>
                    	  <input type="text" id="prueba1des" class="form-control" name="prueba1des" placeholder="Describir aqui..." onchange="habilitaprueba1(this.value);"  />
 
                  		  <input id="file-1" name="file-1" type="file" class="file" multiple=true data-preview-file-type="any" data-allowed-file-extensions='["jpg", "png","bmp","gif","mp4","mp3","avi","3gp","doc","docx","xls","xlsx","txt","ppt","pptx","pdf"]' accept="application/pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .mp4, .mp3, .avi, image/png, .jpeg, .jpg, .bmp">
     
                  	 </div>	
                  	<div class="col-md-4 col-sm-12 col-xs-12 form-group">
                  		<label for="fullname"><h4>Descripción Prueba 2:</h4></label>
                      <input type="text" id="prueba2des" class="form-control" name="prueba2des" placeholder="Describir aqui..." onchange="habilitaprueba2(this.value);" />
                       <input id="file-2" name="file-2"type="file" class="file" multiple=true data-preview-file-type="any" data-allowed-file-extensions='["jpg", "png","bmp","gif","mp4","mp3","avi","3gp","doc","docx","xls","xlsx","txt","ppt","pptx","pdf"]' accept="application/pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .mp4, .mp3, .avi, image/png, .jpeg, .jpg, .bmp">
                  	</div>
                    
                  	<div class="col-md-4 col-sm-12 col-xs-12 form-group">
                  	 	<label for="fullname"><h4>Descripción Prueba 3:</h4></label>
                      <input type="text" id="prueba3des" class="form-control" name="prueba3des" placeholder="Describir aqui..." onchange="habilitaprueba3(this.value);"  />
                       <input id="file-3" name="file-3"type="file" class="file" multiple=true data-preview-file-type="any" data-allowed-file-extensions='["jpg", "png","bmp","gif","mp4","mp3","avi","3gp","doc","docx","xls","xlsx","txt","ppt","pptx","pdf"]' accept="application/pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .mp4, .mp3, .avi, image/png, .jpeg, .jpg, .bmp">
                  	</div>	
                   	<div id="sinpruebas" style="display:;">
					<div class="col-md-6 col-sm-12 col-xs-12 form-group"  >
                  	 	<label for="fullname"><h4>En caso de no adjuntar pruebas, indicar dónde podemos encontrarlas: </h4></label>
                      <textarea id="noadjuntos" class="form-control" name="noadjuntos" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="1000" data-parsley-minlength-message="La descripción no puede tener menos de 20 caracteres"
                     data-parsley-validation-threshold="10"></textarea>
                       
                  	</div>
                  	</div>
                  	<label for="message"><h4>IDENTIFICACIÓN DEL/LA SERVIDOR/A PÚBLICO. <small>(Sólo en caso de presentar una queja, por favor indique rasgos que permitan la individualización de la persona vinculada al hecho).</small> </h4> </label>
                  	<div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  		<label for="fullname"><h4>Nombre:</h4></label>
                      <input type="text" id="nombreservidor" class="form-control" name="nombreservidor" placeholder="Ingrese nombre del/la servidor/a público" />
                  	</div>
                    <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                  		<label for="fullname"><h4>Cargo:</h4></label>
                      <input type="text" id="cargoservidor" class="form-control" name="cargoservidor" placeholder="Ingrese cargo del/la servidor/a público" />
                  	</div> 
                
                  	<br>
                  	<div class="col-md-12 col-sm-12 col-xs-12 form-group">
                  		<label for="fullname"><h4>Si no conoce el nombre del/la servidor/a público/a, indique detalles que permitan la individualización de la persona:</h4></label>
                      <textarea id="indpersona" class="form-control" name="indpersona" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="1000" data-parsley-minlength-message="La descripción de la persona no puede tener menos de 20 caracteres"
                     data-parsley-validation-threshold="10"></textarea>
                  	</div> 
                 
                 </BR>
                 <div class="col-md-12 col-sm-12 col-xs-12">
              		  <div class="x_title">
                  	  <h2>DATOS DEL/LA RECLAMANTE</h2>
                   
                	    <div class="clearfix"></div>
               		   </div>
                 </div>
                 <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                    <label>Desea presentar la queja de forma anónima?</label>
                      <p>
                        No
                        <input type="radio" value="1" name="anonimo"  onchange="habilitar(this.value);" checked="" /> Si
                        <input type="radio"  value="2" name="anonimo"  onchange="habilitar(this.value);"  />
                      </p>
                      <div id="divnombre"  style="display:;">
                      	<label for="fullname"><h4>Nombre * :</h4></label>
	                       <!-- <input type="text" class="form-control"  data-parsley-pattern="^[a-zA-Z ]+$" name="fullname" id="fullname" data-parsley-trigger="keyup" />-->
	                      <input type="text" class="form-control"  data-parsley-pattern="^[a-zA-Z &ntilde;&Ntilde;&aacute;&eacute;&iacute;&oacute;&uacute;&Aacute;&Eacute;&Iacute;&Oacute;&Uacute;]+$" name="fullname" id="fullname" data-parsley-trigger="keyup" title="Ingrese nombre completo"/>
	                      
	                         <label for="fullname"><h4>Documento de identidad * :</h4></label>
	                      <input type="text" class="form-control"  data-parsley-type="number" maxlength="10" id="ci" name="ci" data-parsley-trigger="keyup"/>
	               
	                      <label for="fullname"><h4>Teléfono/Celular * :</h4></label>
	                      <input type="text" class="form-control"  data-parsley-type="number" maxlength="10" id="tel" data-parsley-trigger="keyup" name="tel"  />
	
	                      <label for="email"><h4>Correo electrónico * :</h4></label>
	                      <input type="email" id="email" class="form-control" name="email" data-parsley-trigger="change"  />
							<label for="fullname"><h4>Dirección * :</h4></label>
	                      <input type="text" id="direccion" class="form-control" name="direccion" />
                      </div>
                      
         			<label><h4>Mantener en reserva su identidad?</h4></label>
                      <p>
                        No
                        <input type="radio" value="1" name="reserva" id="reserva"  checked="" /> 
                        Si
                        <input type="radio"  value="2" name="reserva" id="reserva1"   />
                      </p>

				
                         

                          <br/>
                          <!-- <span class="btn btn-primary" type="submit">Registrar queja</span> -->
                          <input class="btn btn-primary" type="submit" value="Registrar queja">

                    </form>
                    <!-- end form for validations -->

                  </div>
                </div>
              </div>
            </div>         
          </div>
        </div>
        <!-- /page content -->

        
      </div>
    </div>
    
    <!-- Small modal -->

                <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2">Cambio de Password</h4>
                        </div>
                        <form class="form-horizontal form-label-left" novalidate method="post" name="cambia_pass_form" action="includes/update_pass.php">
                        <div class="modal-body">
                          <div class="item form-group">
	                        <label for="password" class="control-label col-md-6">Password actual</label>
	                        <div class="col-md-6">
	                          <input id="passworda" type="password" name="passworda" class="form-control col-md-3" required>
	                        </div>
	                      </div>	
                          <div class="item form-group">
	                        <label for="password" class="control-label col-md-6">Nuevo Password</label>
	                        <div class="col-md-6">
	                          <input id="passwordn" type="password" name="passwordn" class="form-control col-md-3" required>
	                        </div>
	                      </div>
	                      <div class="item form-group">
	                        <label for="password2" class="control-label col-md-6">Repita Nuevo Password</label>
	                        <div class="col-md-6">
	                          <input id="password2n" type="password" name="password2n" data-validate-linked="passwordn" class="form-control col-md-7 col-xs-12" required>
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
    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
  
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
   
    <!-- Switchery -->
    <script src="vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
   
     <!-- validator -->
    <script src="vendors/validator/validator.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
    
    
    <script>
		$("#file-3").fileinput({
			showCaption : false,
			browseClass : "btn btn-primary btn-lg",
			fileType : "any"
		});
	</script>

 <!-- validator -->
    <script>
      // initialize the validator function
      validator.message.date = 'not a real date';

      // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
      $('form')
        .on('blur', 'input[required], input.optional, select.required', validator.checkField)
        .on('change', 'select.required', validator.checkField)
        .on('keypress', 'input[required][pattern]', validator.keypress);

      $('.multi.required').on('keyup blur', 'input', function() {
        validator.checkField.apply($(this).siblings().last()[0]);
      });

      $('form').submit(function(e) {
        e.preventDefault();
        var submit = true;

        // evaluate the form using generic validaing
        if (!validator.checkAll($(this))) {
          submit = false;
        }

        if (submit)
          this.submit();

        return false;
      });
    </script>
    <!-- /validator -->
  </body>
</html>