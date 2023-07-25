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
	$gestion=base64_decode($_GET["g3s"]);
	$descripcion=base64_decode($_GET["d3s"]);
	$cb=base64_decode($_GET["cb"]);
	$cdp=base64_decode($_GET["cdp"]);
	$cde=base64_decode($_GET["cde"]);
	$ct=base64_decode($_GET["ct"]);
	$cdt=base64_decode($_GET["cdt"]);
	$cbait=base64_decode($_GET["cbait"]);
	$cbt=base64_decode($_GET["cbt"]);
	$mail=base64_decode($_GET["m41l"]);
	$cexpyaut=base64_decode($_GET["c3y4"]);
	
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Modificación - Datos Inicio Jornada</title>

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
                <h3>Modificaci&oacute;n Datos B&aacute;sicos jornadas</h3>
              </div>
            
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                
                 <div class="x_content" data-toggle="validator">
							<span class="section">Parámetros iniciales.</span>
								<form id="demo-form2" data-toggle="validator" class="form-horizontal form-label-left" enctype="multipart/form-data" action="control/actualizaParInicial.php" method="post">
									<div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">Descripción <span class="required">*</span>
				                        </label>
				                        <div class="col-md-6 col-sm-6 col-xs-12">
				                          <input type="text" id="nombre" name="nombre" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $descripcion;?>">
				                        </div>
			                        </div>
			                        <div class="item form-group" id="resadm" >
			                  				<label class="control-label col-md-3 col-sm-3 col-xs-12" for="imgres">Resolución Administrativa <span class="required">*</span>
				                       		</label>
			 								<div class="col-md-3 col-sm-6 col-xs-12">
				                       			<input id="imgres" name="imgres" type="file" class="file" data-preview-file-type="any" data-allowed-file-extensions='["pdf"]' accept="application/pdf" >
				                       		</div>
			                  	 	</div>
			                        <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="inscritos">Cupos Profesionales<span class="required">*</span>
				                        </label>
				                        <div class="col-md-6 col-sm-6 col-xs-12">
				                          <input type="number" id="inscritos" name="inscritos" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $cdp;?>" onkeyup="sumar();">
				                        </div>
			                        </div>
			                        <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="inscritos">Cupos Estudiantes<span class="required">*</span>
				                        </label>
				                        <div class="col-md-6 col-sm-6 col-xs-12">
				                          <input type="number" id="inscritose" name="inscritose" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $cde;?>" onkeyup="sumar();">
				                        </div>
			                        </div>
			                        <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="total">Total de Cupos con depósitos<span class="required">*</span>
				                        </label>
				                        <div class="col-md-3 col-sm-6 col-xs-12">
				                          <input type="number" id="totald" name="totald" readonly="" class="form-control col-md-7 col-xs-12" value="<?php echo $cdt;?>">
				                        </div>
			                        </div>
			                        <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="becados">Cupos Becados<span class="required">*</span>
				                        </label>
				                        <div class="col-md-6 col-sm-6 col-xs-12">
				                          <input type="number" id="becados" name="becados" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $cb;?>" onkeyup="sumar();">
				                        </div>
			                        </div>
			                        <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="becadosait">Cupos Funcionarios AIT<span class="required">*</span>
				                        </label>
				                        <div class="col-md-3 col-sm-6 col-xs-12">
				                          <input type="number" id="becadosait" name="becadosait" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $cbait;?>" onkeyup="sumar();" >
				                        </div>
			                        </div>
			                        <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="total">Total de Cupos Becas<span class="required">*</span>
				                        </label>
				                        <div class="col-md-3 col-sm-6 col-xs-12">
				                          <input type="number" id="totalb" name="totalb" readonly="" value="<?php echo $cbt;?>" class="form-control col-md-7 col-xs-12">
				                        </div>
			                        </div>
			                         <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expositoresyaut">Cupos Expositores y Autoridades<span class="required">*</span>
				                        </label>
				                        <div class="col-md-3 col-sm-6 col-xs-12">
				                          <input type="number" id="becadosexpyaut" name="becadosexpyaut" required="required" value="<?php echo $cexpyaut;?>" class="form-control col-md-7 col-xs-12" onkeyup="sumar();" >
				                        </div>
			                        </div>
			                        <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="total">Total de Cupos<span class="required">*</span>
				                        </label>
				                        <div class="col-md-6 col-sm-6 col-xs-12">
				                          <input type="number" id="total" name="total" readonly="" class="form-control col-md-7 col-xs-12" value="<?php echo $ct;?>" >
				                        </div>
			                        </div>
			                        <div class="item form-group">
		                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span>
		                        		</label>
		                        		<div class="col-md-6 col-sm-6 col-xs-12">
		                          			<input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12" data-toggle="tooltip" data-placement="right" value="<?php echo $mail;?>" title="El correo electrónico se guarda con mayúsculas, no intente ingresar minúsculas">
		                          			<div class="help-block with-errors"></div>
		                        		</div>
		                      		</div>
			                        <div class="ln_solid"></div>
				                      <div class="form-group">
				                      	<input type="hidden" name="gestion" value="<?php echo $gestion;?>" />
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
            Autoridad de Impugnaci&oacute;n Tributaria <a href="https://www.ait.gob.bo">A.I.T.</a>
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