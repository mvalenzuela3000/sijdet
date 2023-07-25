<?php
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
include_once 'includes/db_connect.php';
//include_once 'conexion.php';
include 'includes/funj.php';

sec_session_start();
	 if (!isset($_SESSION['usuario'])) 
	 {
	 	header("Location: index.php");
        exit();
	 }
	 
	 //$val=verifica_gestion_activa(date("Y"));
	 $val=verifica_gestion_activa(2019);
	 if($val==0){
	 	?>
	 		<script>
	 			alert("La gestión correspondiente a la Jornada no ha sido iniciada o ha sido cerrada, por favor verifique.");
            	location.href = "FormInicio.php";
	 		</script>
	 	<?php
	 	exit;
	 }
	 elseif ($val==2) {
		 ?>
	 		<script>
	 			alert("La gestión correspondiente a la Jornada o ha sido cerrada, por favor verifique.");
            	location.href = "FormInicio.php";
	 		</script>
	 	<?php
	 	exit;
	 }
	 //$gestion=date("Y");
	 $gestion=2019;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>AIT | Reportes asistencia</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
     <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/favicon.ico">
    <script language="JavaScript">
		function confirmar () {
  			return confirm("Está seguro que eliminará el registro?");
		} 
	</script>
	<script>
     	
		function habilitaradio(value)
		{
			if(value=="0")
			{
				// habilitamos
				$('#inscritos').prop("required", true);

				$('#institucion').removeAttr("required");
				$('#ofiait').removeAttr("required");


				$("#div1dep").show();
				
				$("#div2dep").hide();
				$("#div3dep").hide();

			}else if(value=="1"){
				// deshabilitamos
				$('#institucion').prop("required", true);

				$('#inscritos').removeAttr("required");
				$('#ofiait').removeAttr("required");


				$("#div1dep").hide();
			    $("#div2dep").show();
			    $("#div3dep").hide();

			}else if(value=="2"){
				// deshabilitamos
				$('#ofiait').prop("required", true);

				$('#institucion').removeAttr("required");
				$('#inscritos').removeAttr("required");
				
				$("#div1dep").hide();
			    $("#div2dep").hide();
			    $("#div3dep").show();


			}
		}
	</script>
  </head>

  <body class="nav-md">
  	<?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="FormRepAsistencias.php" class="site_title"> <span>Reportes de asistencias</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="images/user.png" alt="..."
								class="img-circle profile_img">
              </div>
              <div class="profile_info">
               <span>Bienvenido(a)</span>
							<h2><?php if (isset($_SESSION['username']))
										{
											$usuario=$_SESSION['usuario'];
											echo htmlentities($_SESSION['username']);} 
										else echo 'Invitado';
											$usuario='';; 
										?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
					<div id="sidebar-menu"
						class="main_menu_side hidden-print main_menu">
						<div class="menu_section">
							<h3>Sistema</h3>
							<?php 
                      			echo crea_menu($_SESSION['usuario'],$mysqli);
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
                <h3>Reporte de Asistencia a Jornadas</h3>
              </div>

            
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Reportes<small>Por persona o institución </small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <form class="form-horizontal form-label-left" novalidate action="genera_reporte_asistencia.php" method="post" name="registra_fechas">

					  <div class="item form-group">
                        <label class="control-label col-md-2 col-sm-3 col-xs-12">Desde: <span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                           <input id="fechaini" name="fechaini" class="date-picker form-control col-md-7 col-xs-12"  type="text" required="required">
                        </div>
                        <label class="control-label col-md-2 col-sm-3 col-xs-12">Hasta: <span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                           <input id="fechafin" name="fechafin" class="date-picker form-control col-md-7 col-xs-12"  type="text" required="required">
                        </div>
                      </div>
                      <div class="item form-group">
                      	<label class="control-label col-md-3 col-sm-3 col-xs-12">Seleccione el criterio <span class="required">*</span>
                        </label>
                 			<div class="col-md-2 col-sm-6 col-xs-12">
                    			<label> 
	                        		Por Persona: <input type="radio"  name="criterio" id="persona" value="0" checked="" onchange="habilitaradio(this.value);"/>
                  				</label>
                  			</div>
                  			<div class="col-md-2 col-sm-6 col-xs-12">
                    			<label> 
	                        		Por Institución: <input type="radio"  name="criterio" id="institucion"  value="1" onchange="habilitaradio(this.value);"/>
	                        	</label>
                  			</div>
                  			<div class="col-md-2 col-sm-6 col-xs-12">
                    			<label> 
	                        		Funcionarios AIT: <input type="radio"  name="criterio" id="ait"  value="2" onchange="habilitaradio(this.value);"/>
	                        	</label>
                  			</div>
                 		</div>	
                      <div id="div1dep" style="display:;">
                          	<div class="item form-group" >
                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="pais">Seleccione nombre <span class="required">*</span>
                        		</label>
                        		<div class="col-md-3 col-sm-6 col-xs-12">
                          			<select id="nombre" name="nombre" class="form-control" required="required" >
                            			<option value="">Seleccione..</option>
					                      <?php
					                      $conexionj=conexj();
					        	              $query = "call pa_obtiene_lista_inscritos($gestion)";
								              if (mysqli_multi_query($conexionj, $query)) {
											 	do {
											    	if ($result = mysqli_store_result($conexionj)) {
											        	while ($row = mysqli_fetch_row($result)) {
															echo "<option value=".$row[14].">".$row[0]."-".$row[1]."</option>";
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
                    	</div>
                    	<div id="div2dep" style="display:none;" >
                      		<div class="item form-group" >
                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="pais">Seleccione Institución <span class="required">*</span>
                        		</label>
                        		<div class="col-md-3 col-sm-6 col-xs-12">
                          			<select id="institucion" name="institucion" class="form-control" >
                            			<option value="">Seleccione..</option>
					                      <?php
					                      $conexionj=conexj();
					        	              $query = "call pa_obtiene_institucion()";
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
                    	</div>
                    	<div id="div3dep" style="display:none;" >
                      		<div class="item form-group" >
                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="pais">Seleccione Oficina <span class="required">*</span>
                        		</label>
                        		<div class="col-md-3 col-sm-6 col-xs-12">
                          			<select id="ofiait" name="ofiait" class="form-control" >
                            			<option value="">Seleccione..</option>
										<option value="AGIT">AGIT</option>
										<option value="ARITLPZ">ARITLPZ</option>
										<option value="ARITSCZ">ARITSCZ</option>
										<option value="ARITCBA">ARITCBA</option>
										<option value="ARITCHQ">ARITCHQ</option>
                          			</select>
                        		</div>
                      		</div>
                    	</div>
                 
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <button type="reset"class="btn btn-primary">Cancelar</button>
                          <input type="submit" class="btn btn-success" value="Generar"  />
                        </div>
                      </div>
                    </form>
                  </div> <!--x-content-->
                  
                  
                </div> <!--x_panel-->
              </div> <!-- class="col-md-12 col-sm-12 col-xs-12" -->
              
             
              
              
              
            </div>  <!--row-->
          </div>    <!--""-->
        </div> <!--rightcol role main-->
        <!-- /page content -->

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
					Autoridad de Impugnaci&oacute;n Tributaria <a
						href="https://www.ait.gob.bo">A.I.T.</a>
				</div>
				<div class="clearfix"></div>
			</footer>
			<!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- validator -->
    <script src="vendors/validator/validator.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
     <!-- bootstrap-daterangepicker -->
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

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
     <!-- bootstrap-daterangepicker -->
    <script>
      $(document).ready(function() {
        $('#fechaini').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>
    <script>
      $(document).ready(function() {
        $('#fechafin').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>
    <!-- /bootstrap-daterangepicker -->
  </body>
</html>