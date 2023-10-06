<?php
 include 'includes/funj.php';
	include_once 'includes/db_connect.php';
	include_once 'includes/functions.php';
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

    <title>Inscripciones | Jornadas</title>

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
					//$('#imgmatricula').prop("required", true);
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
				//$('#file-1').prop("required", true);
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
				//$('#imgtrans').prop("required", true);
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
				//$('#imgcheque').prop("required", true);
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
	              <a href="https://jornadas.ait.gob.bo" class="site_title"><span>Jornadas - AIT</span></a>
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
							        <form class="form-horizontal form-label-left" enctype="multipart/form-data" id="myForm" role="form" data-toggle="validator" action="control/registra_inscripcionegpp.php" method="post">
			            	    		<div class="item form-group">
			                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nombre(s) <span class="required">*</span>
			                        		</label>
			                        		<div class="col-md-6 col-sm-6 col-xs-12">
			                          			<input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="2"  name="name" placeholder="Ingrese su(s) nombre(s)..." required="required" type="text" autofocus>
			                          			<div class="help-block with-errors"></div>
			                        		</div>
			                      		</div>
			                      		<div class="item form-group">
			                       			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="apellido">Apellido(s) <span class="required">*</span>
			                        		</label>
			                        		<div class="col-md-6 col-sm-6 col-xs-12">
			                          			<input id="apellido" class="form-control col-md-7 col-xs-12" data-validate-length-range="2" name="apellido" placeholder="Ingrese su(s) apellido(s)..." required="required" type="text">
			                          			<div class="help-block with-errors"></div>
			                        		</div>
			                      		</div>
			                      		<div class="item form-group">
			                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">C.I. <span class="required">*</span></label>
			                        		<div class="col-md-2 col-sm-6 col-xs-12">
			                          			<input type="text" id="number" name="number" required="required"  class="form-control col-md-7 col-xs-12">
			                          			<div class="help-block with-errors"></div>
			                        		</div>
			                        		<label  class="control-label col-md-1 col-sm-3 col-xs-12" for="extension">Extensión <span class="required">*</span></label>
			                        		<div class="col-md-1 col-sm-6 col-xs-12">
			                          			<select id="extension" name="extension" class="form-control" required="required" >
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
			                          			<input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12">
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
