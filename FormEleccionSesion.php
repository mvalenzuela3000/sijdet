<?php
 include 'conexion.php';
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
verifica_inscripcion($ci);
verificaregistrosesionparalela($ci);

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

    <title>Selección Sesiones Paralelas | Jornadas</title>

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
	                      <li><a href="<?php echo $ins;?>">Inscripción a Jornadas</a></li>
	                      <li><a href="<?php echo $selec;?>">Selección de Sesiones Paralelas</a></li>
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
		                <h3>Selección de Sesiones - Jornadas de Derecho Tributario</h3>
		              </div>
		            </div>
		            <div class="clearfix"></div>
		            <div class="row">
		            	<div class="col-md-12 col-sm-12 col-xs-12">
		            		<div class="x_panel">
		            			<div class="x_title">
				                	<h2>Selección Sesiones Paralelas</h2>
				                    <ul class="nav navbar-right panel_toolbox">
				                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
				                      </li>
				                      <li><a class="close-link"><i class="fa fa-close"></i></a>
				                      </li>
				                    </ul>
				                    <div class="clearfix"></div>
				              	</div>
				              	<div class="x_content">
				              		
				              		<span class="section">Por favor seleccione entre las Sesiones Paralelas a las que usted asistirá si alguna opción está deshabilitada es porque se llenó el cupo de la misma.</span>
							        <form class="form-horizontal form-label-left" enctype="multipart/form-data" id="myForm" role="form" action="control/seleccionSesiones.php" method="post">
							        	
							            <div class="table-responsive">
					                      <table class="table table-striped jambo_table bulk_action">
					                        <thead>
					                          <tr class="headings">
					                          
					                            <th class="column-title">Fecha</th>
					                            <th class="column-title">Sesión Paralela 1</th>
					                            <th class="column-title">Sesión Paralela 2</th>
					                            </th>
					                            <th class="bulk-actions" colspan="7">
					                              <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
					                            </th>
					                          </tr>
					                        </thead>
					                        <tbody>
						            	   <?php
						            	   					
						                        $query = "call pa_obtiene_sesiones_paralelas(year(now()))";
									                if (mysqli_multi_query($conexionj, $query)) {
								                      do {
								                          if ($result = mysqli_store_result($conexionj)) {
								                          		
								                               while ($row = mysqli_fetch_row($result)) {
																if($row[6]==0)
																{
																	 echo ' <tr class="even pointer">
                                            						<td class=" ">'.$row[3].'</td>';
																}
																		
																if($row[5]==1)
																{
																	if($row[6]==0){
																		echo'<td class=" ">
													                        		 <input type="radio"  name="'.$row[1].'" id="'.$row[0].'" value="'.$row[0].'" checked="" required />'.$row[4].'
										                          			</td>';
																	}
																	else {
																		if($row[7]==0)
																		{
																		echo'<td class=" ">
													                        		 <input type="radio"  name="'.$row[1].'" id="'.$row[0].'" value="'.$row[0].'" />'.$row[4].'
										                          			</td>';
																		}
																		else {
																			echo'<td class=" ">
													                        		 <input type="radio"  name="'.$row[1].'" id="'.$row[0].'" value="'.$row[0].'" checked="" required />'.$row[4].'
										                          			</td>';
																		}
																	}
																}
																else{
																	
																	echo'<td class=" ">
													                        		 NO HAY CUPOS
										                          			</td>';	
																}
								                         			
								                          		if($row[6]==1){
								                          			echo '</tr>'; 
								                          		}	
								                         		
								                            }
								                           mysqli_free_result($result);
								                          }
								                       } while (mysqli_next_result($conexionj));
								                    }
												  else
												  	echo mysqli_error();                   
						                 ?>
		                         			</tbody>
		                         			</table>
		
										</div>
										
										
					         			<div class="ln_solid"></div>
					                      <div class="form-group">
					                        <div class="col-md-6 col-md-offset-3">
					                        	<input type="hidden" value="<?php echo $ci;?>" name="number" id="number"/>
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
