<?php
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
include_once 'includes/db_connect.php';
include_once 'includes/funj.php';
sec_session_start();
	 if (!isset($_SESSION['usuario'],$_SESSION['cargo'])) 
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

    <title>AIT | Inicio de Jornadas</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
     <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
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
  			return confirm("Está seguro que cerrará la gestión?");
		} 
		function confirmar2 () {
  			return confirm("Está seguro que reiniciará la gestión?");
		} 
		function sumar()
    {
        var valor1=verificar("inscritos");
        var valor2=verificar("becados");
		var valor3=verificar("inscritose");
		var valor4=verificar("becadosait");
		var valor5=verificar("becadosexpyaut");
        // realizamos la suma de los valores y los ponemos en la casilla del
        // formulario que contiene el total
        document.getElementById("totald").value=parseInt(valor1) + parseInt(valor3);
        document.getElementById("totalb").value=parseInt(valor2) + parseInt(valor4)+ parseInt(valor5);
        document.getElementById("total").value=parseInt(valor1) + parseInt(valor2) + parseInt(valor3) + parseInt(valor4)+ parseInt(valor5);
    }
     function verificar(id)
    {
        var obj=document.getElementById(id);
        if(obj.value=="")
            value="0";
        else
            value=obj.value;
 		return value;
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
              <a href="FormInicio.php" class="site_title"> <span>Inicio de Jornadas</span></a>
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
                <h3>Parámetros de Inicio</h3>
              </div>

            
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Registro de Inicio<small>Jornadas Bolivianas de Derecho Tributario</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                 <?php
                 	$valor=verifica_gestion_activa(date("Y"));
					
					if($valor==0)
					{
						echo'
							<div class="x_content" data-toggle="validator">
							<span class="section">Parámetros iniciales.</span>
								<form id="demo-form2" data-toggle="validator" class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" action="control/insertaGestion.php">
									<div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Descripción <span class="required">*</span>
				                        </label>
				                        <div class="col-md-6 col-sm-6 col-xs-12">
				                          <input type="text" id="nombre" name="nombre" required="required" class="form-control col-md-7 col-xs-12" placeholder="Ingrese el nombre del evento Ej. X Jornadas Bolivianas de ....">
				                        </div>
			                        </div>
			                        <div class="item form-group" id="resadm" >
			                  				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="imgres">Resolución Administrativa <span class="required">*</span>
				                       		</label>
			 								<div class="col-md-3 col-sm-6 col-xs-12">
				                       			<input id="imgres" name="imgres" type="file" class="file" data-preview-file-type="any" data-allowed-file-extensions=\'["pdf"]\' accept="application/pdf" required="" >
				                       		</div>
			                  	 	</div>
			                        <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="inscritos">Cupos para Profesionales<span class="required">*</span>
				                        </label>
				                        <div class="col-md-3 col-sm-6 col-xs-12">
				                          <input type="number" id="inscritos" name="inscritos" required="required" class="form-control col-md-7 col-xs-12" placeholder="Cantidad de cupos para profesionales" onkeyup="sumar();">
				                        </div>
			                        </div>
			                        <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="inscritose">Cupos para Estudiantes<span class="required">*</span>
				                        </label>
				                        <div class="col-md-3 col-sm-6 col-xs-12">
				                          <input type="number" id="inscritose" name="inscritose" required="required" class="form-control col-md-7 col-xs-12" placeholder="Cantidad de cupos para estudiantes" onkeyup="sumar();">
				                        </div>
			                        </div>
			                        <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="total">Total de Cupos con depósitos<span class="required">*</span>
				                        </label>
				                        <div class="col-md-3 col-sm-6 col-xs-12">
				                          <input type="number" id="totald" name="totald" readonly="" class="form-control col-md-7 col-xs-12">
				                        </div>
			                        </div>
			                        <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="becados">Cupos Becados<span class="required">*</span>
				                        </label>
				                        <div class="col-md-3 col-sm-6 col-xs-12">
				                          <input type="number" id="becados" name="becados" required="required" class="form-control col-md-7 col-xs-12" placeholder="Cantidad de cupos para becas" onkeyup="sumar();" >
				                        </div>
			                        </div>
			                        <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="becados">Cupos Funcionarios AIT<span class="required">*</span>
				                        </label>
				                        <div class="col-md-3 col-sm-6 col-xs-12">
				                          <input type="number" id="becadosait" name="becadosait" required="required" class="form-control col-md-7 col-xs-12" placeholder="Cantidad de cupos funcionarios AIT" onkeyup="sumar();" >
				                        </div>
			                        </div>
			                       
			                        <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="total">Total de Cupos Becas<span class="required">*</span>
				                        </label>
				                        <div class="col-md-3 col-sm-6 col-xs-12">
				                          <input type="number" id="totalb" name="totalb" readonly="" class="form-control col-md-7 col-xs-12">
				                        </div>
			                        </div>
			                         <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expositoresyaut">Cupos Expositores y Autoridades<span class="required">*</span>
				                        </label>
				                        <div class="col-md-3 col-sm-6 col-xs-12">
				                          <input type="number" id="becadosexpyaut" name="becadosexpyaut" required="required" class="form-control col-md-7 col-xs-12" placeholder="Cantidad de cupos Expositores y Autoridades" onkeyup="sumar();" >
				                        </div>
			                        </div>
			                        <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="total">Total de Cupos<span class="required">*</span>
				                        </label>
				                        <div class="col-md-3 col-sm-6 col-xs-12">
				                          <input type="number" id="total" name="total" readonly="" class="form-control col-md-7 col-xs-12">
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
			                        <div class="ln_solid"></div>
				                      <div class="form-group">
				                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
				                          <button type="reset"class="btn btn-primary">Cancelar</button>
				                          <input type="submit" class="btn btn-success" value="Registrar"/>
				                        </div>
				                      </div>
								</form>
						
		                  </div>
						';
					}
					elseif($valor==1) {
						echo'
						<div class="x_content" data-toggle="validator">
						<span class="section">Cerrar Gestión</span>
						<div class="form-group">
				                        <a class="btn btn-app" href="control/cierrages.php?g3s='.base64_encode(date("Y")).'" onclick="return confirmar();">
                      						<i class="fa fa-edit"></i> Cerrar gestión
                   						 </a>
			                        </div>
			            </div>'    ;
					}
					elseif ($valor==2) {
						echo'
						<div class="x_content" data-toggle="validator">
						<span class="section">Reiniciar Gestión</span>
						<div class="form-group">
				                        <a class="btn btn-app" href="control/abreges.php?g3s='.base64_encode(date("Y")).'" onclick="return confirmar2();">
                      						<i class="fa fa-play"></i> Reiniciar gestión
                   						 </a>
			                        </div>
			            </div>'    ;
					}
	
                 ?>
				  
				 
                </div> <!--x_panel-->
              </div> <!-- class="col-md-12 col-sm-12 col-xs-12" -->
              
              <!--tablas-->
              
                   <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Registros<small> Jornadas de Derecho Tributario</small></h2>
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
                            <th class="column-title">Descripción </th>
                            
                            <th class="column-title">Cantidad Cupos Profesionales </th>
                            <th class="column-title">Cantidad Cupos Estudiantes </th>
                            <th class="column-title">Cantidad Cupos Becas </th>
                            <th class="column-title">Cantidad Cupos Funcionarios AIT </th>
                            <th class="column-title">Cantidad Expositores y Autoridades </th>
                            <th class="column-title">Cantidad Cupos Totales </th>
                            <th class="column-title">Resolución </th>
                            <th class="column-title">Correo de contacto GAF </th>
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
                        	$query = "CALL pa_obtiene_jornadas_registradas()";
                      
                      if (mysqli_multi_query($conexionj, $query)) {
                          do {
                              /* store first result set */
                              if ($result = mysqli_store_result($conexionj)) {
                                  while ($row = mysqli_fetch_row($result)) {
                                    
                                      echo " <tr class=\"even pointer\">
                                            <td class=\" \">".$row[0]."</td>
                                            <td class=\" \">".$row[1]."</td>
                                            <td class=\" \">".$row[6]."</td>
                                            <td class=\" \">".$row[7]."</td>
                                            <td class=\" \">".$row[2]."</td>
                                            <td class=\" \">".$row[8]."</td>
                                            <td class=\" \">".$row[12]."</td>
                                            <td class=\" \">".$row[4]."</td>
                                            <td class=\" \">".$row[9]."</td>
                                            <td class=\" \">".$row[11]."</td>
                                            ";
                                            if($row[5]==1)
											{
												echo "<td class=\" last\"><a class=\"btn btn-success btn-xs\" href=\"regini.php?g3s='".base64_encode($row[0])."'&d3s='".base64_encode($row[1])."'&cdp='".base64_encode($row[6])."'&cde='".base64_encode($row[7])."'&cdt='".base64_encode($row[3])."'&cb='".base64_encode($row[2])."'&cbait='".base64_encode($row[8])."'&cbt='".base64_encode($row[10])."'&ct='".base64_encode($row[4])."'&m41l='".base64_encode($row[11])."'&c3y4='".base64_encode($row[12])."'\" onClick=\"window.open(this.href, this.target,'top=50,left=50,width=800,height=700,'); return false;\" > Editar</a></td>";
											}
											else
												{
													echo "<td class=\" \"></td>";
												}
                                            
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