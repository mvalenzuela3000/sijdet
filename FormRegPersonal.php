<?php
include 'conexion.php';
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
include_once 'includes/db_connect.php';
include_once 'includes/psl-config.php';

sec_session_start();
	 if (!isset($_SESSION['usuario'])) 
	 {
	 	header("Location: index.php");
        exit();
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

    <title>AIT | Registro de Personal</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
     <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/favicon.ico">
    <!-- Bootstrap_file_input -->
    <link href="css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
    <script src="js/jquery.min.js"></script>
    <script src="js/fileinput.min.js" type="text/javascript"></script>
    <!-- Datatables -->
<link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css"
	rel="stylesheet">
<link
	href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css"
	rel="stylesheet">
<link
	href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css"
	rel="stylesheet">
<link
	href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"
	rel="stylesheet">
<link
	href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css"
	rel="stylesheet">
	<script language="JavaScript">
		function confirmar () {
  			return confirm("Está seguro que realizará la acción?");
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
              <a href="FormRegUser.php" class="site_title"> <span>Registro de Personal</span></a>
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
                <h3>Registro de Personal</h3>
              </div>

            
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Registro<small>personal</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form id="demo-form2" data-toggle="validator" class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" action="control/registra_persona.php">
                     
                      <span class="section">Informaci&oacute;n personal</span>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Nombre(s) <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="nombre" class="form-control col-md-7 col-xs-12"  name="nombre" placeholder="ingrese lo(s) nombre(s)" required="required" type="text">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="apPaterno">Apellido Paterno <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="apPaterno" class="form-control col-md-7 col-xs-12" data-validate-length-range="2"  name="apPaterno" placeholder="ingrese apellido paterno" required="required" type="text">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="apMaterno">Apellido Materno <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="apMaterno" class="form-control col-md-7 col-xs-12" data-validate-length-range="2"  name="apMaterno" placeholder="ingrese apellido materno" required="required" type="text">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ci">C.I. <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="ci" name="ci" required="required" class="form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Departamento <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <select id="dpto" name="dpto" class="form-control" required>
                            <?php
                             $query = "select id_dep,ext_dep from departamentos";                     
                                if (mysqli_multi_query($conexionj, $query)) {
                                    do {
                                        /* store first result set */
                                        if ($result = mysqli_store_result($conexionj)) {
                                            while ($row = mysqli_fetch_row($result)) {
                                                echo $row[0]." ".$row[1];
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Cargo <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <select id="cargo" name="cargo" class="form-control" required>
                            <option value="">Seleccione..</option>
                            <?php
                           
                             $query = "select c.id,concat(o.descripcion,' - ',c.descripcion,' - Item:',c.item) from cargos c join areas a on c.idArea=a.id join oficinas o on a.idOficina=o.id where c.id not in (select idCargo from personas where idCargo is not null)";                      
                                if (mysqli_multi_query($conexionp, $query)) {
                                    do {
                                        /* store first result set */
                                        if ($result = mysqli_store_result($conexionp)) {
                                            while ($row = mysqli_fetch_row($result)) {
                                                echo $row[0]." ".$row[1];
                                                echo "<option value=".$row[0].">".$row[1]."</option>";
                                            }
                                            mysqli_free_result($result);
                                        }
                                
                                    } while (mysqli_next_result($conexionp));
                                }
                                else
                                echo mysqli_error();
							                     
                            ?>
                 
                          </select>
                        </div>
                      </div>
                      <div class="item form-group" id="resadm" >
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="foto">Fotografía
                            </label>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <input id="foto" name="foto" type="file" class="file" data-preview-file-type="any" accept="image/*"  >
                            </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="email" id="email" name="email" class="form-control col-md-7 col-xs-12">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Nro. de Interno
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" id="interno" name="interno" class="form-control col-md-7 col-xs-12">
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
              </div> <!--final formulario-->
              
               <!--tablas-->
              
                <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>
										Personas <small>Listado de personas</small>
									</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
										</li>

										<li><a class="close-link"><i class="fa fa-close"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">
									<p class="text-muted font-13 m-b-30">Puede buscar por cualquier
										criterio de las columnas ingresando el mismo en el cuadro
										Buscar y, a partir de ello generar listados con los botones
										ubicados en la parte superior de la tabla.</p>
									<table id="datatable-buttons"
										class="table table-striped table-bordered">
										<thead>
											<tr>
												<th>Apellido Paterno</th>
                                                <th>Apellido Materno</th>
                                                <th>Nombre(s)</th>
												<th>C.I.</th>
												<th>Cargo</th>												
												<th>Email</th>
												<th>Interno</th>
                                                <th>Foto</th>
												<th>Acciones</th>	
											</tr>
										</thead>


										<tbody>
                      <?php 
               
                    $conex = mysqli_connect(HOST, USER, PASSWORD, DATABASEP);
                      $query = "CALL pa_obtiene_personas(0)";
                      
                      if (mysqli_multi_query($conex, $query)) {
                          do {
                              /* store first result set */
                              if ($result = mysqli_store_result($conex)) {
                                  while ($row = mysqli_fetch_row($result)) {
									
									echo "<tr>
                                            <td>".$row[2]."</td>
                                            <td>".$row[3]."</td>
                                            <td>".$row[1]."</td>
                                            <td>".$row[0]."</td>
                                            <td>".$row[10]."</td>
                                           <td>".$row[4]."</td>
                                           <td>".$row[5]."</td>
                                           <td>";
                                            echo "<img src=\"$row[6]\" alt=\"foto\" class=\"img-circle profile_img\">";
                                            echo "</td>

                                            <td><a class=\"btn btn-success btn-xs\" href=\"editPersona.php?1d='".base64_encode($row[0])."'\" onClick=\"window.open(this.href, this.target,'top=50,left=50,width=600,height=650,'); return false;\" > Editar</a>
										                            <a class=\"btn btn-warning btn-xs\" href=\"control/accionPersona.php?0pt='".base64_encode('1')."'&1d='".base64_encode($row[0])."'\" onclick=\"return confirmar();\"> Desvincular</a>
											                          <a class=\"btn btn-danger btn-xs\" href=\"control/accionPersona.php?0pt='".base64_encode('2')."'&1d='".base64_encode($row[0])."'\" onclick=\"return confirmar();\"> Eliminar</a> 	
                                            </td>
                                            
                                       </tr> ";
                                  }
                                  mysqli_free_result($result);
                              }
                      
                          } while (mysqli_next_result($conex));
                      }
                      
                      /* close connection */
                      mysqli_close($conex);
                      
                      ?>
                   
                        
                      </tbody>
									</table>
								</div>
							</div>
						</div>
              
              
              <!--fin tablas-->
              
              
            </div>
          </div>
        </div>
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
<!-- Datatables -->
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script
		src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script
		src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
	<script src="js/buttons.flash.min.js"></script>
	<script src="js/buttons.html5.min.js"></script>
	<script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script
		src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
	<script
		src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
	<script
		src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script
		src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
	<script
		src="vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
     <!-- bootstrap-wysiwyg -->
    <script src="vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="vendors/google-code-prettify/src/prettify.js"></script>
     <!-- bootstrap-daterangepicker -->
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script>
		$("#file-1").fileinput({
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
    
    <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();

        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        var $datatable = $('#datatable-checkbox');

        $datatable.dataTable({
          'order': [[ 1, 'asc' ]],
          'columnDefs': [
            { orderable: false, targets: [0] }
          ]
        });
        $datatable.on('draw.dt', function() {
          $('input').iCheck({
            checkboxClass: 'icheckbox_flat-green'
          });
        });

        TableManageButtons.init();
      });
    </script>
  </body>
</html>