<?php
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
include_once 'includes/db_connect.php';
include_once 'includes/funj.php';
//include_once 'conexion.php';
sec_session_start();
	 if (!isset($_SESSION['usuario'],$_SESSION['cargo'])) 
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

    <title>AIT | Registro Becas</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
     <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
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
    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/favicon.ico">
    <script language="JavaScript">
		function confirmar () {
  			return confirm("Está seguro que eliminará el registro?");
		} 
	</script>
<style>
        input {text-transform: uppercase;}
    </style> 
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
              <a href="FormBecas.php" class="site_title"> <span>Registro de Becas</span></a>
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
                <h3>Registro Becas - Institución</h3>
              </div>

            
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Registro de Becas<small>Jornadas Bolivianas de Derecho Tributario</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
					<div class="x_content" data-toggle="validator">
					<span class="section">Registro de Becas por Institución</span>
						<form id="demo-form2" data-toggle="validator" class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" action="control/registraBecaInstitucion.php">
							<?php
					        	$conexionj=conexj();
					            //$query = "select ((select n_becas from ges_jornadas where gestion=year(now()))-(select sum(cupos) from beca_institucion where gestion=year(now()))) as resto";
					            $query="select ((select n_becas from ges_jornadas where gestion=year(now()))-(select  ifnull((select sum(cupos) from beca_institucion where gestion=year(now())),0)))";
							    $result = $conexionj->query($query);
							    $fila = $result->fetch_array();
								$cuposdisponibles=$fila[0];
							?>
							
							<div class="form-group">
		                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cbeca">Cupos disponibles para Becas<span class="required">*</span>
		                        </label>
		                        <div class="col-md-3 col-sm-6 col-xs-12">
		                          <input type="number" id="cupobeca" name="cupobeca" readonly="" class="form-control col-md-7 col-xs-12" value="<?php echo $cuposdisponibles;?>" >
		                        </div>
	                        </div>
							
							<div class="item form-group" id="inst">
	                    		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="institucion">Seleccione la institución <span class="required">*</span>
	                    		</label>
	                    		<div class="col-md-3 col-sm-6 col-xs-12">
	                      			<select id="institucion" name="institucion" class="form-control" required="required">
	                        			<option value="">Seleccione..</option>
					                      <?php
					                      		$conexionj=conexj();
					        	              $query = "select id_inst,nombre_inst from institucion where id_inst not in(select id_institucion from beca_institucion where gestion=year(now()))";
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
	                        <div class="item form-group" >
	                  				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="notaait">Nota de la AIT <span class="required">*</span>
		                       		</label>
	 								<div class="col-md-3 col-sm-6 col-xs-12">
		                       			<input id="notaait" name="notaait" type="file" class="file" data-preview-file-type="any" data-allowed-file-extensions='["pdf"]' accept="application/pdf" required="" >
		                       		</div>
	                  	 	</div>
	                  	 	<div class="item form-group" >
	                  				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="notaresp">Nota de Respuesta <span class="required">*</span>
		                       		</label>
	 								<div class="col-md-3 col-sm-6 col-xs-12">
		                       			<input id="notaresp" name="notaresp" type="file" class="file" data-preview-file-type="any" data-allowed-file-extensions='["pdf"]' accept="application/pdf">
		                       		</div>
	                  	 	</div>
	                  	 	<?php
	                  	 		
	                  	 	
	                  	 	?>
	                        <div class="form-group">
		                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cbeca">Cupo de becas a asignar<span class="required">*</span>
		                        </label>
		                        <div class="col-md-3 col-sm-6 col-xs-12">
		                          <input type="number" id="cbeca" name="cbeca" required="required" class="form-control col-md-7 col-xs-12" placeholder="Cantidad de cupos a asignar" min="1" max="<?php echo $cuposdisponibles;?>">
		                        </div>
	                        </div>
	                        <input type="hidden" name="cuposdisponibles" value="<?php echo $cuposdisponibles;?>">
	                        <div class="ln_solid"></div>
		                      <div class="form-group">
		                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
		                          <button type="reset"class="btn btn-primary">Cancelar</button>
		                          <input type="submit" class="btn btn-success" value="Registrar"/>
		                        </div>
		                      </div>
						</form>
				
                  </div>

                </div> <!--x_panel-->
              </div> <!-- class="col-md-12 col-sm-12 col-xs-12" -->
              
              <!--tablas-->
              
                   <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Registros<small> Becas a instituciones</small></h2>
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
                            <th class="column-title">Institución </th>
                            
                            <th class="column-title">Cantidad de Cupos </th>
                            <th class="column-title">Nota de la AIT </th>
                            <th class="column-title">Nota Respuesta de la Institución </th>
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
                        	$query = "CALL pa_obtiene_becas_institucion()";
                      
                      if (mysqli_multi_query($conexionj, $query)) {
                          do {
                              /* store first result set */
                              if ($result = mysqli_store_result($conexionj)) {
                                  while ($row = mysqli_fetch_row($result)) {
                                      echo " <tr class=\"even pointer\">
                                            <td class=\" \">".$row[0]."</td>
                                            <td class=\" \">".$row[2]."</td>
                                            <td class=\" \">".$row[3]."</td>
                                            <td class=\" \">".$row[4]."</td>
                                            <td class=\" \">".$row[5]."</td>
                                            ";
                                            
									echo "<td class=\" last\"><a class=\"btn btn-success btn-xs\" href=\"regbecainst.php?g3s='".base64_encode($row[0])."'&1n5='".base64_encode($row[1])."'&1n5n='".base64_encode($row[2])."'&cup='".base64_encode($row[3])."'\" onClick=\"window.open(this.href, this.target,'top=50,left=50,width=800,height=700,'); return false;\" > Editar</a>
										
										<a class=\"btn btn-danger btn-xs\" href=\"control/eliminaBecaInst.php?g3s='".base64_encode($row[0])."'&1n5='".base64_encode($row[1])."'\" onclick=\"return confirmar();\">Eliminar</a>
									</td>";
                                      echo"</tr> ";
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
      
          </div>    <!--""-->
        </div> <!--rightcol role main-->
       </div> <!-- /page content -->

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
   <!-- Include jQuery Validator plugin -->
    <script src="js/validator.min.js"></script>
    <!-- Datatables -->
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
    <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons-2").length) {
            $("#datatable-buttons-2").DataTable({
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
	<!-- /Datatables -->
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