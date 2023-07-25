<?php 
    include 'conexion.php';
	include_once 'includes/db_connect.php';
	include_once 'includes/functions.php';
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

<title>AIT | Quejas Recibidas</title>

<!-- Bootstrap -->
<link href="vendors/bootstrap/dist/css/bootstrap.min.css"
	rel="stylesheet">
<!-- Font Awesome -->
<link href="vendors/font-awesome/css/font-awesome.min.css"
	rel="stylesheet">
<!-- NProgress -->
<link href="vendors/nprogress/nprogress.css" rel="stylesheet">
<!-- iCheck -->
<link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
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
<!-- bootstrap-daterangepicker -->
<link href="vendors/bootstrap-daterangepicker/daterangepicker.css"
	rel="stylesheet">

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
						<a href="FormQuejasRegistradas.php" class="site_title"> <span>Quejas
								Registradas </span></a>
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
							<h3>Transparencia</h3>
							<?php 
                      		//echo submenu($_SESSION['usuario'],1,$mysqli);
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
							<h3>
								Panel de quejas y/o sugerencias <small>Aqu&iacute; usted podr&aacute; visualizar
									las quejas y/o sugerencias registradas, generar listados y formulario F-1509</small>
							</h3>
						</div>


					</div>

					<div class="clearfix"></div>

					<div class="row">


						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel">
								<div class="x_title">
									<h2>
										Quejas y/o sugerencias registradas <small>Listado de quejas y/o sugerencias registradas en la
											p&aacute;gina web</small>
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
												<th>No. Control</th>
												<th>Oficina</th>
												<th>Desc. Queja</th>
												<th>Servidor Público</th>
												<th>Nombre Completo</th>
												<th>Doc. Identidad</th>
												<th>Telef. / Celular</th>
												<th>E-Mail</th>
												<th>Direcci&oacute;n</th>
												<th>An&oacute;nimo</th>
												<th>Reserva?</th>
												<th>F. Registro</th>
												<th>Adjuntos</th>

											</tr>
										</thead>


										<tbody>
                      <?php 
                      function validanum($numero)
                      {
                          if($numero<10)
                          {
                              $valor="000".$numero;
                              return ($valor);
                          }
                          if($numero>=10 && $numero <100)
                          {
                              $valor="00".$numero;
                              return ($valor);
                          }
                          if($numero>=100 && $numero <1000)
                          {
                              $valor="0".$numero;
                              return ($valor);
                          }
                          if($numero>=1000)
                          {
                              return ($numero);
                          }
                      }
                      /* ultimo dia mes actual */
                      function _data_last_month_day() {
                          $month = date('m');
                          $year = date('Y');
                          $day = date("d", mktime(0,0,0, $month+1, 0, $year));
                      
                          return date('d/m/Y', mktime(0,0,0, $month, $day, $year));
                      };
                      
                      /** Primer dia mes actual **/
                      function _data_first_month_day() {
                          $month = date('m');
                          $year = date('Y');
                          return date('d/m/Y', mktime(0,0,0, $month, 1, $year));
                      }
                      $query = "CALL pa_obtiene_quejas()";
                      
                      if (mysqli_multi_query($conexion, $query)) {
                          do {
                              /* store first result set */
                              if ($result = mysqli_store_result($conexion)) {
                                  while ($row = mysqli_fetch_row($result)) {
                                  	$servidor='';
									  if($row[15]!=''){
									  	$servidor.='Nombre: '.$row[15];
									  }
									  if($row[16]!=''){
									  	$servidor.='<br>Cargo: '.$row[16];
									  }
									  if($row[17]!=''){
									  	$servidor.='<br>Descripcion: '.$row[17];
									  }
                                      $formulario='<a href="pdf/f_1509.php?1d='.base64_encode($row[0]).'&g35='.base64_encode($row[1]).'&qu3j4='.base64_encode($row[11]).'&pru='.base64_encode($row[12]).'&an0='.base64_encode($row[7]).'&n0m='.base64_encode($row[2]).'&c1='.base64_encode($row[3]).'&t3l='.base64_encode($row[4]).'&m41l='.base64_encode($row[5]).'&d1r='.base64_encode($row[6]).'&r35='.base64_encode($row[8]).'&0f1='.base64_encode($row[13]).'&5pr='.base64_encode($row[14]).'&n05='.base64_encode($row[15]).'&c45='.base64_encode($row[16]).'&1p5='.base64_encode($row[17]).'">F-1509</a>'; 
                                      echo "<tr>
                                            <td>".validanum($row[0])."/".$row[1]."</td>
                                            <td>".utf8_encode($row[13])."</td>
                                            <td>".$row[11]."</td>
                                            <td>".$servidor."</td>
                                            <td>".$row[2]."</td>
                                            <td>".$row[3]."</td>
                                            <td>".$row[4]."</td>
                                            <td>".$row[5]."</td>
                                            <td>".$row[6]."</td>
                                            <td>".$row[7]."</td>
                                            <td>".$row[8]."</td>
                                            <td>".$row[9]."</td>
                                            <td>".$formulario.'<br>'.$row[10]."</td>
                                       </tr> ";
                                  }
                                  mysqli_free_result($result);
                              }
                      
                          } while (mysqli_next_result($conexion));
                      }
                      
                      /* close connection */
                      mysqli_close($conexion);
                      
                      ?>
                   
                        
                      </tbody>
									</table>
								</div>
							</div>
						</div>


						<!-- form date pickers -->
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="x_panel" style="">
								<div class="x_title">
									<h2>
										Formulario F - 1511 <small> En &eacute;sta secci&oacute;n
											podr&aacute; generar su formulario F - 1511 mediante el rango
											de d&iacute;as que desee.</small>
									</h2>
									<ul class="nav navbar-right panel_toolbox">
										<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
										</li>

										<li><a class="close-link"><i class="fa fa-close"></i></a></li>
									</ul>
									<div class="clearfix"></div>
								</div>
								<div class="x_content">


                             
									<div class="well" style="overflow: auto">
										<div class="col-md-4">
											Seleccione la fecha inicial y la fecha final
											<form class="form-horizontal" method="POST" action="p.php">
												<fieldset>
													<div class="control-group">
														<div class="controls">
																
															<div class="input-prepend input-group controls">
																
																<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
																<input type="text" style="width: 200px"
																	name="reservation" id="reservation"
																	class="form-control"
																	value="<?php echo(_data_first_month_day()); ?> - <?php echo(_data_last_month_day());?>" />
																	
																<!-- <button class="btn btn-primary pull-right" type="submit" style="margin-right: 5px;"><i class="fa fa-download"></i> Generar Formulario F - 2105</button>-->
															</div>
															
															<div class="controls">
															<label for="message"><h4>Seleccione Oficina <small>(Por favor indique la oficina de la AIT).</small> </h4> </label>
   
										                     	<select id="arit" name="arit"	class="col-md-4 col-sm-12 col-xs-12 form-control" required>
												           			<option value="0">Todas</option>
												           			<option value="1">Autoridad General de Impugnación Tributaria</option>
												                    <option value="2">Autoridad Regional de Impugnación Tributaria Chuquisaca</option>
												                    <option value="3">Autoridad Regional de Impugnación Tributaria Cochabamba</option>
												                    <option value="4">Autoridad Regional de Impugnación Tributaria La Paz</option>
												                    <option value="5">Autoridad Regional de Impugnación Tributaria Santa Cruz</option>
										              			</select>
										              		</div>
															<div class="input-prepend input-group">
															<input class="btn btn-primary pull-right" style="margin-right: 5px;" type="submit"  value="Generar Formulario F-1511">
															</div>
														</div>
													</div>
												</fieldset>
                                                    
											</form>
											
										</div>


									</div>



								</div>
							</div>
						</div>
						<!-- form date pickers -->


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
	<!-- iCheck -->
	<script src="vendors/iCheck/icheck.min.js"></script>
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
	<script src="vendors/jszip/dist/jszip.min.js"></script>
	<script src="vendors/pdfmake/build/pdfmake.min.js"></script>
	<script src="vendors/pdfmake/build/vfs_fonts.js"></script>
	<!-- bootstrap-daterangepicker -->
	<script src="vendors/moment/min/moment.min.js"></script>
	<script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	<!-- Custom Theme Scripts -->
	<script src="build/js/custom.min.js"></script>
<!-- validator -->
    <script src="vendors/validator/validator.js"></script>
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
	<!-- /Datatables -->
	<!-- bootstrap-daterangepicker -->
	<script>
      $(document).ready(function() {
        var cb = function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
          $('#reportrange_right span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        };

        var optionSet1 = {
          startDate: moment().subtract(29, 'days'),
          endDate: moment(),
          minDate: '01/01/2012',
          maxDate: '12/31/2020',
          dateLimit: {
            days: 60
          },
          showDropdowns: true,
          showWeekNumbers: true,
          timePicker: false,
          timePickerIncrement: 1,
          timePicker12Hour: true,
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          opens: 'right',
          buttonClasses: ['btn btn-default'],
          applyClass: 'btn-small btn-primary',
          cancelClass: 'btn-small',
          format: 'MM/DD/YYYY',
          separator: ' to ',
          locale: {
            applyLabel: 'Aceptar',
            cancelLabel: 'Limpiar',
            fromLabel: 'Desde',
            toLabel: 'Hasta',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
          }
        };

        $('#reportrange_right span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

        $('#reportrange_right').daterangepicker(optionSet1, cb);

        $('#reportrange_right').on('show.daterangepicker', function() {
          console.log("show event fired");
        });
        $('#reportrange_right').on('hide.daterangepicker', function() {
          console.log("hide event fired");
        });
        $('#reportrange_right').on('apply.daterangepicker', function(ev, picker) {
          console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
        });
        $('#reportrange_right').on('cancel.daterangepicker', function(ev, picker) {
          console.log("cancel event fired");
        });

        $('#options1').click(function() {
          $('#reportrange_right').data('daterangepicker').setOptions(optionSet1, cb);
        });

        $('#options2').click(function() {
          $('#reportrange_right').data('daterangepicker').setOptions(optionSet2, cb);
        });

        $('#destroy').click(function() {
          $('#reportrange_right').data('daterangepicker').remove();
        });

      });
    </script>

	<script>
      $(document).ready(function() {
        var cb = function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        };

        var optionSet1 = {
          startDate: moment().subtract(29, 'days'),
          endDate: moment(),
          minDate: '01/01/2012',
          maxDate: '12/31/2020',
          dateLimit: {
            days: 60
          },
          showDropdowns: true,
          showWeekNumbers: true,
          timePicker: false,
          timePickerIncrement: 1,
          timePicker12Hour: true,
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          opens: 'left',
          buttonClasses: ['btn btn-default'],
          applyClass: 'btn-small btn-primary',
          cancelClass: 'btn-small',
          format: 'MM/DD/YYYY',
          separator: ' to ',
          locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
          }
        };
        $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        $('#reportrange').daterangepicker(optionSet1, cb);
        $('#reportrange').on('show.daterangepicker', function() {
          console.log("show event fired");
        });
        $('#reportrange').on('hide.daterangepicker', function() {
          console.log("hide event fired");
        });
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
          console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
        });
        $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
          console.log("cancel event fired");
        });
        $('#options1').click(function() {
          $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
        });
        $('#options2').click(function() {
          $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
        });
        $('#destroy').click(function() {
          $('#reportrange').data('daterangepicker').remove();
        });
      });
    </script>

	<script>
      $(document).ready(function() {
        $('#single_cal1').daterangepicker({
          singleDatePicker: true,
          singleClasses: "picker_1"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
        $('#single_cal2').daterangepicker({
          singleDatePicker: true,
          singleClasses: "picker_2"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
        $('#single_cal3').daterangepicker({
          singleDatePicker: true,
          singleClasses: "picker_3"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
        $('#single_cal4').daterangepicker({
          singleDatePicker: true,
          singleClasses: "picker_4"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>

	<script>
      $(document).ready(function() {
        $('#reservation').daterangepicker(null, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });

        $('#reservation-time').daterangepicker({
          timePicker: true,
          timePickerIncrement: 30,
          locale: {
            format: 'MM/DD/YYYY h:mm A'
          }
        });
      });
    </script>
	<!-- /bootstrap-daterangepicker -->
</body>
</html>