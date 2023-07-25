<?php 
    include 'conexion.php';
	include_once 'includes/db_connect.php';
	include_once 'includes/functions.php';
	include_once 'includes/config.php';
	sec_session_start();
	 if (!isset($_SESSION['usuario'],$_SESSION["cargo"])) 
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

    <title>AIT | Dashboard</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
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
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="dashboard.php" class="site_title"><span>Dashboard</span></a>
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
					<h3>DASHBOARD</h3>
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
                <h3>DASHBOARD <small>Información resumida de la gestión</small></h3>
              </div>
            </div>
				
			<div class="clearfix"></div>
            
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>
							Relación de cupos 
						</h2>
						<ul class="nav navbar-right panel_toolbox">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							</li>

							<li><a class="close-link"><i class="fa fa-close"></i></a></li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table class="table table-bordered">

							<tbody>
					          <?php 
								$conj=conexj();
							  $anio=date("Y");
							 // $anio=date("Y");;
							 $query3 = "CALL pa_obtiene_cuadro_resumen($anio)";
							$res3=$conj->query($query3);
							$fila2 = $res3->fetch_array();
					          $sumainscritos=$fila2[3]+$fila2[11]+$fila2[19]+$fila2[25]+$fila2[31]+$fila2[5]+$fila2[13];
					          $sumatotal=$fila2[1]+$fila2[9]+$fila2[17]+$fila2[23]+$fila2[29];
					          ?>
					          <tr><td><?php echo $fila2[0];?></td><td><?php echo $fila2[1];?></td><td><?php echo $fila2[2];?></td><td><?php echo $fila2[3];?></td><td><?php echo $fila2[4];?></td><td><?php echo $fila2[5];?></td><td><?php echo $fila2[6];?></td><td><?php echo $fila2[7];?></td></tr>
					          <tr><td><?php echo $fila2[8];?></td><td><?php echo $fila2[9];?></td><td><?php echo $fila2[10];?></td><td><?php echo $fila2[11];?></td><td><?php echo $fila2[12];?></td><td><?php echo $fila2[13];?></td><td><?php echo $fila2[14];?></td><td><?php echo $fila2[15];?></td></tr>
					          <tr><td><?php echo $fila2[16];?></td><td><?php echo $fila2[17];?></td><td><?php echo $fila2[18];?></td><td><?php echo $fila2[19];?></td><td></td><td></td><td><?php echo $fila2[20];?></td><td><?php echo $fila2[21];?></td></tr>
					          <tr><td><?php echo $fila2[22];?></td><td><?php echo $fila2[23];?></td><td><?php echo $fila2[24];?></td><td><?php echo $fila2[25];?></td><td></td><td></td><td><?php echo $fila2[26];?></td><td><?php echo $fila2[27];?></td></tr>
					          <tr><td><?php echo $fila2[28];?></td><td><?php echo $fila2[29];?></td><td><?php echo $fila2[30];?></td><td><?php echo $fila2[31];?></td><td></td><td></td><td><?php echo $fila2[32];?></td><td><?php echo $fila2[33];?></td></tr>
					          <tr><td><strong>TOTAL</strong></td><td><strong><?php echo ($fila2[1]+$fila2[9]+$fila2[17]+$fila2[23]+$fila2[29])?></strong></td><td><strong>TOTAL</strong></td><td><strong><?php echo ($fila2[3]+$fila2[11]+$fila2[19]+$fila2[25]+$fila2[31])?></strong></td><td><strong>TOTAL</strong></td><td><STRONG><?php echo ($fila2[5]+$fila2[13])?></STRONG></td><td><strong>TOTAL</strong></td><td><strong><?php echo ($fila2[7]+$fila2[15]+$fila2[21]+$fila2[27]+$fila2[33]);?></strong></td></tr>
					         </tbody> 
						</table>
						
						<br>
						
					</div>
				</div>
			</div>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel fixed_height_320">
                  <div class="x_title">
                    <h2>Avance <small>Inscripciones</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
 
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="dashboard-widget-content">
                      <ul class="quick-list">
                        <li><i class="fa fa-bars"></i><a href="genera_reporte_inscritos_d.php?1n5=<?php echo base64_encode(0);?>&g3s=<?php $anio=date("Y"); echo base64_encode($anio);?>">Total Inscritos</a></li>
                        <li><i class="fa fa-bars"></i><a href="genera_reporte_inscritos_d.php?1n5=<?php echo base64_encode(1);?>&g3s=<?php $anio=date("Y"); echo base64_encode($anio);?>">Inscritos</a></li>
                        <li><i class="fa fa-bars"></i><a href="genera_reporte_inscritos_d.php?1n5=<?php echo base64_encode(2);?>&g3s=<?php $anio=date("Y"); echo base64_encode($anio);?>">Becados</a></li>
                        <li><i class="fa fa-bars"></i><a href="genera_reporte_inscritos_d.php?1n5=<?php echo base64_encode(3);?>&g3s=<?php $anio=date("Y"); echo base64_encode($anio);?>">Funcionarios AIT</a></li>
                        <li><i class="fa fa-bars"></i><a href="genera_reporte_inscritos_d.php?1n5=<?php echo base64_encode(4);?>&g3s=<?php $anio=date("Y"); echo base64_encode($anio);?>">Expositores</a></li>
                        <li><i class="fa fa-bars"></i><a href="genera_reporte_inscritos_d.php?1n5=<?php echo base64_encode(5);?>&g3s=<?php $anio=date("Y"); echo base64_encode($anio);?>">Ctas. X Cobrar</a></li>
                        <li><i class="fa fa-file-pdf-o"></i><a href="genera_reporte_depositos_d.php?cr5=<?php echo base64_encode(1);?>&g3s=<?php $anio=date("Y"); echo base64_encode($anio);?>">Depositos utilizados</a> </li>
                        <li><i class="fa fa-file-pdf-o"></i><a href="genera_reporte_depositos_d.php?cr5=<?php echo base64_encode(2);?>&g3s=<?php $anio=date("Y"); echo base64_encode($anio);?>">Depositos sin utilizar</a> </li>
                        
                      </ul>

                      <div class="sidebar-widget">
                        <h4>Cupos Jornadas</h4>
                        <canvas width="150" height="80" id="foo2" class="" style="width: 160px; height: 100px;"></canvas>
                        <div class="goal-wrapper">
                          <span id="gauge-text2" class="gauge-value pull-left">Cupos ocupados:<?php echo $sumainscritos?></span>
                          <span id="goal-text2" class="goal-value pull-right">Total cupos: <?php echo $sumatotal?></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>
							Relación de asistencia a las Jornadas Tributarias
						</h2>
						<ul class="nav navbar-right panel_toolbox">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							</li>

							<li><a class="close-link"><i class="fa fa-close"></i></a></li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table id="datatable-buttons"
							class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Asistentes a las Jornadas de Derecho Tributario</th>
									<th>APROBADOS</th>
									<th>ACREDITADOS</th>
									<th>ASISTENTES</th>
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
							  $anio=date("Y");
					          $query = "CALL pa_inscritosvsacrevsasist($anio)";
					          $i=0;
							  $sapr=0;
							  $sacre=0;
							  $sasis=0;
					          if (mysqli_multi_query($conexionj, $query)) {
					              do {
					                  /* store first result set */
					                  if ($result = mysqli_store_result($conexionj)) {
					                      while ($row = mysqli_fetch_row($result)) {
											$arrayasistentes[$i][0]=$row[2];
											$arrayasistentes[$i][1]=$row[3];
											$arrayasistentes[$i][2]=$row[4];
											$sapr+=$row[2];
											$sacre+=$row[3];
											$sasis+=$row[4];
											echo "<tr>
					                                <td>".$row[1]."</td>
					                                <td>".$row[2]."</td>
					                                <td>".$row[3]."</td>
													<td>".$row[4]."</td>
					                           </tr> ";
											$i++;   
					                      }
					                      mysqli_free_result($result);
					                  }
					          		
					              } while (mysqli_next_result($conexionj));
					          }
					          mysqli_close($conexionj);
					          
					          ?>
					          <tr><td><strong>TOTAL</strong></td><td><strong><?php echo $sapr;?></strong></td><td><strong><?php echo $sacre;?></strong></td><td><strong><?php echo $sasis;?></strong></td></tr>
					          </tbody>
						</table>
						
						<br>
						
					</div>
				</div>
			</div>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Relación de asistencia <small> Jornadas Bolivianas de Derecho Tributario</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <canvas id="mybarChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2>
							Relación de Inscritos por meses
						</h2>
						<ul class="nav navbar-right panel_toolbox">
							<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
							</li>

							<li><a class="close-link"><i class="fa fa-close"></i></a></li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<table id="datatable-buttons2"
							class="table table-striped table-bordered">
							<thead>
								<tr>
									<th></th>
									<th>A MAYO</th>
									<th>A JUNIO</th>
									<th>A JULIO</th>
									<th>A AGOSTO</th>
								</tr>
							</thead>
							<tbody>
					          <?php 
								$conj=conexj();
							  $anio=date("Y");
					          $query2 = "CALL pa_inscritosxmeses($anio)";
					          $i=0;
							  $sjul=0;
							  $sago=0;
							  $ssep=0;
							  $soct=0;
					          if (mysqli_multi_query($conj, $query2)) {
					              do {
					                  /* store first result set */
					                  if ($result = mysqli_store_result($conj)) {
					                      while ($row = mysqli_fetch_row($result)) {
											$arrayinscritos[$i][0]=$row[1];
											$arrayinscritos[$i][1]=$row[2];
											$arrayinscritos[$i][2]=$row[3];
											$arrayinscritos[$i][3]=$row[4];
											$sjul+=$row[1];
											$sago+=$row[2];
											$ssep+=$row[3];
											$soct+=$row[4];
											echo "<tr>
					                                <td>".$row[0]."</td>
					                                <td>".$row[1]."</td>
					                                <td>".$row[2]."</td>
													<td>".$row[3]."</td>
													<td>".$row[4]."</td>
					                           </tr> ";
											$i++;   
					                      }
					                      mysqli_free_result($result);
					                  }
					          		
					              } while (mysqli_next_result($conj));
					          }
					          mysqli_close($conj);
					          
					          ?>
					          <tr><td><strong>TOTAL</strong></td><td><strong><?php echo $sjul;?></strong></td><td><strong><?php echo $sago;?></strong></td><td><strong><?php echo $ssep;?></strong></td><td><strong><?php echo $soct;?></strong></td></tr>
					          </tbody>
						</table>
						
						<br>
						
					</div>
				</div>
			</div>

              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Relación de inscritos <small>Jornadas Bolivianas de Derecho Tributario</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <canvas id="mybarChart2"></canvas>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="clearfix"></div>
            
          </div>
        </div>
        <!-- /page content -->

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
    <!-- Chart.js -->
    <script src="vendors/Chart.js/dist/Chart.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
      <!-- gauge.js -->
    <script src="vendors/gauge.js/dist/gauge.min.js"></script>
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
          if ($("#datatable-buttons2").length) {
            $("#datatable-buttons2").DataTable({
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

    <!-- Chart.js -->
    <script>
      Chart.defaults.global.legend = {
        enabled: false
      };

      

      // Bar chart
      var ctx = document.getElementById("mybarChart");
      var mybarChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ["Expositores", "Personal AIT", "Becados", "Asistentes externos"],
          datasets: [
          	
          	{
            label: '# aprobados',
            backgroundColor: "#26B99A",
            data: [
	            <?php 
	            	echo $arrayasistentes[3][0];
	            ?>,
	            <?php 
	            	echo $arrayasistentes[2][0];
	            ?>,
	            <?php 
	            	echo $arrayasistentes[1][0];
	            ?>,
	            <?php 
	            	echo $arrayasistentes[0][0];
	            ?>
            	]
          }, {
            label: '# acreditados',
            backgroundColor: "#03576A",
            data: [
            	<?php 
            	echo $arrayasistentes[3][1];
	            ?>,
	            <?php 
	            	echo $arrayasistentes[2][1];
	            ?>,
	            <?php 
	            	echo $arrayasistentes[1][1];
	            ?>,
	            <?php 
	            	echo $arrayasistentes[0][1];
	            ?>
            	]          
          }, {
          	label: '# asistentes',
            backgroundColor: "#04A66A",
            data: [
	            <?php 
	            	echo $arrayasistentes[3][2];
	            ?>,
	            <?php 
	            	echo $arrayasistentes[2][2];
	            ?>,
	            <?php 
	            	echo $arrayasistentes[1][2];
	            ?>,
	            <?php 
	            	echo $arrayasistentes[0][2];
	            ?>
            	] 
          }
          ]
        },

        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });
      
      // Bar chart 2
      var ctx2 = document.getElementById("mybarChart2");
      var mybarChart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
          labels: ["A MAYO", "A JUNIO", "A JULIO", "A AGOSTO"],
          datasets: [
          	
          	{
            label: '# profesionales',
            backgroundColor: "#26B99A",
            data: [
	            <?php 
	            	echo $arrayinscritos[0][0];
	            ?>,
	            <?php 
	            	echo $arrayinscritos[0][1];
	            ?>,
	            <?php 
	            	echo $arrayinscritos[0][2];
	            ?>,
	            <?php 
	            	echo $arrayinscritos[0][3];
	            ?>
            	]
          }, {
            label: '# estudiantes',
            backgroundColor: "#03576A",
            data: [
            	<?php 
	            	echo $arrayinscritos[1][0];
	            ?>,
	            <?php 
	            	echo $arrayinscritos[1][1];
	            ?>,
	            <?php 
	            	echo $arrayinscritos[1][2];
	            ?>,
	            <?php 
	            	echo $arrayinscritos[1][3];
	            ?>
            	]         
          }, {
          	label: '# becados',
            backgroundColor: "#24ADCA",
            data: [
	            <?php 
	            	echo $arrayinscritos[2][0];
	            ?>,
	            <?php 
	            	echo $arrayinscritos[2][1];
	            ?>,
	            <?php 
	            	echo $arrayinscritos[2][2];
	            ?>,
	            <?php 
	            	echo $arrayinscritos[2][3];
	            ?>
            	] 
          }, {
          	label: '# servidores AIT',
            backgroundColor: "#04CC5A",
            data: [
	            <?php 
	            	echo $arrayinscritos[3][0];
	            ?>,
	            <?php 
	            	echo $arrayinscritos[3][1];
	            ?>,
	            <?php 
	            	echo $arrayinscritos[3][2];
	            ?>,
	            <?php 
	            	echo $arrayinscritos[3][3];
	            ?>
            	]
          }, {
          	label: '# Expositores',
            backgroundColor: "#B4AB6B",
            data: [
	            <?php 
	            	echo $arrayinscritos[4][0];
	            ?>,
	            <?php 
	            	echo $arrayinscritos[4][1];
	            ?>,
	            <?php 
	            	echo $arrayinscritos[4][2];
	            ?>,
	            <?php 
	            	echo $arrayinscritos[4][3];
	            ?>
            	]
          }
          ]
        },

        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });
      
     

      </script>
       <!-- gauge.js -->
    <script>
      var opts = {
        lines: 12,
        angle: 0,
        lineWidth: 0.4,
        pointer: {
          length: 0.75,
          strokeWidth: 0.042,
          color: '#1D212A'
        },
        limitMax: 'false',
        colorStart: '#1ABC9C',
        colorStop: '#1ABC9C',
        strokeColor: '#F0F3F3',
        generateGradient: true
      };
   
      var target = document.getElementById('foo2'),
          gauge = new Gauge(target).setOptions(opts);

      gauge.maxValue = <?php echo $sumatotal;?>;
      gauge.animationSpeed = 32;
      gauge.set(<?php echo $sumainscritos;?>);
      gauge.setTextField(document.getElementById("gauge-text2"));
    </script>
    <!-- /gauge.js -->
    <!-- /Chart.js -->
  </body>
</html>
