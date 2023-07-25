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
    $inst=base64_decode($_GET["1n5"]);
	$ges=base64_decode($_GET["g3s"]);
	$cupos=base64_decode($_GET["cup"]);
	$nominst=base64_decode($_GET["1n5n"]);
	//echo $int." - ".$ges." - ".$cupos." - ".$nominst;
	
	
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Modificación - Datos Becas</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

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


		<script language="JavaScript">
function confirmar ( mensaje ) {
  return confirm( mensaje );
} 
</script>
<script>
	function cerrarse(){
		window.close()
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

         

            <br />



           
          </div>
        </div>

 
    

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Modificaci&oacute;n Datos Becas - Instituci&oacute;n</h3>
              </div>
            
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                
                 <div class="x_content" data-toggle="validator">
							<span class="section">Parámetros de beca.</span>
								<form id="demo-form2" data-toggle="validator" class="form-horizontal form-label-left" enctype="multipart/form-data" action="control/actualizaBecasInst.php" method="post">
									<?php
							        	$conexionj=conexj();
							            $query = "select ((select n_becas from ges_jornadas where gestion='".date("Y")."')-(select sum(cupos) from beca_institucion where gestion='".date("Y")."')) as resto";
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
			                        <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cbeca">Institución<span class="required">*</span>
				                        </label>
				                        <div class="col-md-3 col-sm-6 col-xs-12">
				                          <input type="text" id="nominst" name="nominst" readonly="" class="form-control col-md-7 col-xs-12" value="<?php echo $nominst;?>" >
				                        </div>
			                        </div>
			                        <div class="item form-group" >
		                  				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="notaait">Nota de la AIT <span class="required">*</span>
			                       		</label>
		 								<div class="col-md-3 col-sm-6 col-xs-12">
			                       			<input id="notaait" name="notaait" type="file" class="file" data-preview-file-type="any" data-allowed-file-extensions='["pdf"]' accept="application/pdf"  >
			                       		</div>
			                  	 	</div>
			                  	 	<div class="item form-group" >
			                  				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="notaresp">Nota de Respuesta <span class="required">*</span>
				                       		</label>
			 								<div class="col-md-3 col-sm-6 col-xs-12">
				                       			<input id="notaresp" name="notaresp" type="file" class="file" data-preview-file-type="any" data-allowed-file-extensions='["pdf"]' accept="application/pdf"  >
				                       		</div>
			                  	 	</div>
									<?php
										if($cuposdisponibles==0)
										{
											echo'
											 <div class="form-group">
						                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cbeca">Cupo de becas a asignar<span class="required">*</span>
						                        </label>
						                        <div class="col-md-3 col-sm-6 col-xs-12">
						                          <input type="number" id="cbeca" name="cbeca" required="required" class="form-control col-md-7 col-xs-12" value="'.$cupos.'" placeholder="Cantidad de cupos a asignar" min="1" max="'.$cupos.'">
						                        </div>
					                        </div>
											';
										}
										else {
											echo'
											<div class="form-group">
						                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cbeca">Cupo de becas a asignar<span class="required">*</span>
						                        </label>
						                        <div class="col-md-3 col-sm-6 col-xs-12">
						                          <input type="number" id="cbeca" name="cbeca" required="required" class="form-control col-md-7 col-xs-12" value="'.$cupos.'" placeholder="Cantidad de cupos a asignar" min="1" max="'.$cuposdisponibles.'">
						                        </div>
					                        </div>
											';
										}
									?>
			                       
			                        <div class="ln_solid"></div>
				                      <div class="form-group">
				                      	<input type="hidden" name="gestion" value="<?php echo $ges;?>" />
				                      	<input type="hidden" name="institucion" value="<?php echo $inst;?>" />
				                      	<input type="hidden" name="institucionnom" value="<?php echo $nominst;?>" />
				                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
				                          <input type="reset" value="Cancelar" class="btn btn-primary" onclick="cerrarse()">
				                          <input type="submit" class="btn btn-success" value="Actualizar"/>
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
            Autoridad de Impugnaci�n Tributaria <a href="https://www.ait.gob.bo">A.I.T.</a>
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

    <script>
		$("#imgres").fileinput({
			showCaption : false,
			browseClass : "btn btn-primary btn-lg",
			fileType : "any"
		});
	</script>
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
        $('#fechafac').daterangepicker({
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