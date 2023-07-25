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
	
	$nominst=base64_decode($_GET["1n5n"]);
	
	
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Complementación Datos Cuentas X Cobrar</title>

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
 <script>
     	
		function habilitaradio(value)
		{
			if(value=="0")
			{
				// habilitamos
				$('#numdepo').prop("required", true);
				$('#file-1').prop("required", true);

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
				$("#div2dep").hide();
			    $("#div3dep").hide();

			}else if(value=="1"){
				// deshabilitamos
				$('#numtrans').prop("required", true);
				$('#imgtrans').prop("required", true);
				$('#fechatrans').prop("required", true);
				$('#montotrans').prop("required",true);

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
			    $("#div3dep").hide();

			}else if(value=="2"){
				// deshabilitamos
				$('#numcheque').prop("required", true);
				$('#imgcheque').prop("required", true);
				$('#fechacheque').prop("required", true);
				$('#montocheque').prop("required",true);

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
                <h3>Complementación Datos Cuentas X Cobrar</h3>
              </div>
            
            </div>
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                
                 <div class="x_content" data-toggle="validator">
							
								<form id="demo-form2" data-toggle="validator" class="form-horizontal form-label-left" enctype="multipart/form-data" action="control/actualizaDatosCXC.php" method="post">
									
									<span class="section">Datos del Depósito, Transferencia o Cheque, por favor seleccione el modo de pago</span>
						            <div class="form-group">
				                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cbeca">Institución<span class="required">*</span>
				                        </label>
				                        <div class="col-md-3 col-sm-6 col-xs-12">
				                          <input type="text" id="nominst" name="nominst" readonly="" class="form-control col-md-7 col-xs-12" value="<?php echo $nominst;?>" >
				                        </div>
			                        </div>
	                         		<div class="item form-group">
	                         			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="tipodep">Forma de Pago<span class="required">*</span>
				                        </label>
	                            		<div class="col-md-4 col-sm-6 col-xs-12">	
				                        		<input type="radio" name="tipodep" id="deposito" value="0" checked="" onchange="habilitaradio(this.value);" required /> Depósito Bancario <br>
				                        		<input type="radio" name="tipodep" id="transf" onchange="habilitaradio(this.value);" value="1" /> Transferencia Bancaria <br>
				                        		<input type="radio" name="tipodep" id="cheque" onchange="habilitaradio(this.value);" value="2" /> Cheque
				                        </div>	
	                         		</div>
	                         		<div id="div1dep" style="display:;">
				                          	<div class="item form-group">
					                        	<label class="control-label col-md-3 col-sm-3 col-xs-12" for="numdepo">Número de Depósito <span class="required">*</span>
					                        	</label>
					                        	<div class="col-md-6 col-sm-6 col-xs-12">
					                          		<!--<input id="numdepo" class="form-control col-md-7 col-xs-12"  name="numdepo" required="" type="number" >-->
					                          		<select id="numdepo" name="numdepo" class="form-control" required="required">
			                            			<option value="">Seleccione..</option>
								                       <?php
								                       	$conexionj=conexj();
								                         $query = "select distinct p.id_pago from pagos p where gestion=year(now()) and p.id_pago not in(select id_pago from inscritos where gestion=year(now()))";
								        	           	 if (mysqli_multi_query($conexionj, $query)) {
														 	do {
														    	if ($result = mysqli_store_result($conexionj)) {
														        	while ($row = mysqli_fetch_row($result)) {
																		echo "<option value=".$row[0].">".$row[0]."</option>";
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
					                        <!--<div class="form-group" >
					                  			<label class="control-label col-md-3 col-sm-3 col-xs-12" for="file-1">Comprobante de Depósito (imagen, escaneado) <span class="required">*</span>
						                    	</label>
					 							<div class="col-md-3 col-sm-6 col-xs-12">
						                    		<input id="file-1" name="file-1" type="file" class="file" data-preview-file-type="any" data-allowed-file-extensions='["jpg","JPG", "jpeg","png","bmp","doc","docx","pdf"]' required="" accept="application/pdf,image/png, .jpeg, .jpg, .JPG, .bmp" >
					                        	</div>
				                  	 		</div>-->
					      				   	
			                        	</div>
			                        	<div id="div2dep" style="display:none;" >
			                          		<div class="item form-group">
				                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="numdepo">Número de Transferencia <span class="required">*</span>
				                        		</label>
				                        		<div class="col-md-6 col-sm-6 col-xs-12">
				                          			<input id="numtrans" class="form-control col-md-7 col-xs-12"  name="numtrans"  type="text" >
				                        		</div>
				                       		</div>
				      				   		<div class="item form-group">
				                          		<label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha de la Transferencia <span class="required">*</span>
				                          		</label>
				                          		<div class="col-md-2 col-sm-6 col-xs-12">
				                            		<input id="fechatrans" name="fechatrans" class="date-picker form-control col-md-7 col-xs-12"  type="text">
				                          		</div>
				                       		</div>
				                       		<div class="item form-group">
				                           		<label class="control-label col-md-3 col-sm-3 col-xs-12">Monto de la Transferencia <span class="required">*</span>
				                           		</label>
				                           		<div class="col-md-2 col-sm-6 col-xs-12">
				                            		<input id="montotrans" name="montotrans" class="form-control col-md-7 col-xs-12" data-validate-minmax="400,10000"  type="number">
				                           		</div>
				                        	</div>
				                        	<!--<div class="item form-group" >
				                  		   		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="imgcheque">Imagen de la transferencia <span class="required">*</span>
					                        	</label>
				 								<div class="col-md-3 col-sm-6 col-xs-12">
					                        		<input id="imgtrans" name="imgtrans" type="file" class="file" data-preview-file-type="any" data-allowed-file-extensions='["jpg", "png","bmp","doc","docx","pdf"]'  accept="application/pdf,image/png, .jpeg, .jpg, .bmp" >
				                        		</div>
			                  	 			</div>-->
			                        	</div>
			                        	<div id="div3dep" style="display:none;" >
			                          		<div class="item form-group">
				                        		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="numdepo">Número de Cheque <span class="required">*</span>
				                        		</label>
				                        		<div class="col-md-6 col-sm-6 col-xs-12">
				                          			<input id="numcheque" class="form-control col-md-7 col-xs-12"  name="numcheque"  type="text" >
				                        		</div>
				                       		</div>
				      				   		<div class="item form-group">
				                          		<label class="control-label col-md-3 col-sm-3 col-xs-12">Fecha del Cheque <span class="required">*</span>
				                          		</label>
				                          		<div class="col-md-2 col-sm-6 col-xs-12">
				                            		<input id="fechacheque" name="fechacheque" class="date-picker form-control col-md-7 col-xs-12"  type="text">
				                          		</div>
				                       		</div>
				                       		<div class="item form-group">
				                           		<label class="control-label col-md-3 col-sm-3 col-xs-12">Monto del Cheque <span class="required">*</span>
				                           		</label>
				                           		<div class="col-md-2 col-sm-6 col-xs-12">
				                            		<input id="montocheque" name="montocheque" class="form-control col-md-7 col-xs-12" data-validate-minmax="400,10000"  type="number">
				                           		</div>
				                        	</div>
				                        	<!--<div class="item form-group" >
				                  		   		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="imgcheque">Imagen de la transferencia o Cheque <span class="required">*</span>
					                        	</label>
				 								<div class="col-md-3 col-sm-6 col-xs-12">
					                        		<input id="imgcheque" name="imgcheque" type="file" class="file" data-preview-file-type="any" data-allowed-file-extensions='["jpg", "png","bmp","doc","docx","pdf"]'  accept="application/pdf,image/png, .jpeg, .jpg, .bmp" >
				                        		</div>
			                  	 			</div>-->
			                        	</div>
									
			                        
			                        
							
			                       
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
  </body>
</html>