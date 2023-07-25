<?php
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
include_once 'includes/db_connect.php';
//include_once 'conexion.php';
include_once 'includes/funj.php';
;
sec_session_start();
	 if (!isset($_SESSION['usuario'])) 
	 {
	 	header("Location: index.php");
        exit();
	 }
	 
	 $val=verifica_gestion_activa(date("Y"));
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
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>AIT | Registro Horarios de Asistencia</title>

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
              <a href="FormRegHorario.php" class="site_title"> <span>Horarios de Asistencia</span></a>
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
                <h3>Registro de Horarios de Asistencia Jornadas Tributarias</h3>
              </div>

            
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Registro<small>Horarios de asistencia</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <form class="form-horizontal form-label-left" novalidate action="control/registra_horarios_ingreso.php" method="post" name="registra_fechas">

                     
                     
					<div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Seleccione la fecha: <span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                           <input id="fecha" name="fecha" class="date-picker form-control col-md-7 col-xs-12"  type="text">
                        </div>
                      </div>
                       <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Turno: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            Mañana: <input type="radio" class="flat" name="turno" id="manana" value="M" checked="" required="" /> Tarde:
                        	<input type="radio" class="flat" name="turno" id="tarde" value="T" />
                          </div>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Horarios:  <span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                           HH: <input type="number" name="hora" id="hora" class="form-control" value="08" min="07" max="18" required=""/>
                           min:<input type="number" name="minuto" id="minuto" class="form-control" value="00" min="00" max="59" required=""/>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo: <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            Entrada: <input type="radio" class="flat" name="tipo" id="entrada" value="E" checked="" required="" /> Salida:
                        	<input type="radio" class="flat" name="tipo" id="salida" value="S" />
                          </div>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="monto">Tolerancia en el ingreso (min) <span class="required">*</span>
                        </label>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                          <input id="tolerancia" class="form-control col-md-7 col-xs-12"  name="tolerancia" placeholder="ingrese la tolerancia en el ingreso en minutos" required="required" type="number" value="0">
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
                  </div> <!--x-content-->
                  
                  
                </div> <!--x_panel-->
              </div> <!-- class="col-md-12 col-sm-12 col-xs-12" -->
              
              <!--tablas-->
              
                   <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Rangos de fechas registradas <small>Jornadas de Derecho Tributario</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                 
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                          
                            <th class="column-title">Gestión </th>
                            <th class="column-title">Fecha </th>
                            <th class="column-title">Hora </th>
                            <th class="column-title">Turno </th>
                            <th class="column-title">Tipo </th>
                            <th class="column-title">Tolerancia (min) </th>
                            <th class="column-title no-link last"><span class="nobr">Acción</span>
                            </th>
                            <th class="bulk-actions" colspan="7">
                              <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>
                          </tr>
                        </thead>

                        <tbody>
        	
                        	<?php
                        	$conexionj=conexj();
                        	$query = "CALL pa_obtiene_horarios()";
                      
                      if (mysqli_multi_query($conexionj, $query)) {
                          do {
                              /* store first result set */
                              if ($result = mysqli_store_result($conexionj)) {
                                  while ($row = mysqli_fetch_row($result)) {
                                      $eliminar='<a class="btn btn-danger btn-xs" href="control/eliminaHorario.php?1d='.base64_encode($row[0]).'" onclick="return confirmar();">Eliminar</a>'; 
                                  
									 // $eliminar='<button type="button" class="btn btn-danger btn-xs" onclick="return confirmar("¿Está seguro que desea eliminar el registro?")">Eliminar</button>';
                                      echo " <tr class=\"even pointer\">
                                            <td class=\" \">".$row[1]."</td>
                                            <td class=\" \">".$row[2]."</td>
                                            <td class=\" \">".$row[3]."</td>
                                            <td class=\" \">".$row[4]."</td>
                                            <td class=\" \">".$row[6]."</td>
                                           <td class=\" \">".$row[5]."</td>
                                            <td class=\" last\">".$eliminar."</td>
                                       </tr> ";
                                  }
                                  mysqli_free_result($result);
                              }
                      
                          } while (mysqli_next_result($conexionj));
                      }
                      
                      /* close connection */
                      mysqli_close($conexionj);
                      ?>
       
                       
                    
                         
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              
              
              <!--fin tablas-->
              
              
              
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
        $('#fecha').daterangepicker({
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