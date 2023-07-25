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
   $id=base64_decode($_GET['1d']);

$query="call pa_datos_usuario('".$id."')";
if (mysqli_multi_query($mysqli, $query)) {
	                          do {
	                              /* store first result set */
	                              if ($result = mysqli_store_result($mysqli)) {
	                                  while ($row = mysqli_fetch_row($result)) {
	                                      $id_user=$row[0];
										  $ci_user=$row[1];
										  $nom_user=$row[2];
										  $ape_user=$row[3];
										  $id_cargo=$row[4];
										  $nom_cargo=$row[5];
										  $id_depen=$row[6];
										  $nom_depen=$row[7];
	                                  }
	                                  mysqli_free_result($result);
		                              }
	                      
	                          } while (mysqli_next_result($mysqli));
	                      }
						  else
						  	echo mysqli_error();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Modificacion de Datos Usuarios de Sistema</title>

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
function confirmar ( mensaje ) {
  return confirm( mensaje );
} 
</script>
<script>
	function cerrarse(){
		window.close()
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
       

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Modificación datos de Usuario</h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Modificación <small>datos de usuarios</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <form class="form-horizontal form-label-left" novalidate action="control/actualizaUsuario.php" method="post">

                     
                      <span class="section">Informaci&oacute;n personal</span>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nombre(s) <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="name" class="form-control col-md-7 col-xs-12"  name="name" placeholder="ingrese lo(s) nombre(s)" required="required" type="text" value="<?php echo $nom_user;?>">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="apellido">Apellido(s) <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="apellido" class="form-control col-md-7 col-xs-12" data-validate-length-range="2"  name="apellido" placeholder="ingrese lo(s) apellido(s)" required="required" type="text" value="<?php echo $ape_user;?>">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">C.I. <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" id="ci" name="ci" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $ci_user;?>">
                        </div>
                      </div>
                  
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Cargo <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <select id="cargo" name="cargo" class="form-control" required>
                            <option value="<?php echo $id_cargo;?>"><?php echo $nom_cargo;?></option>
                            <?php
                           
                             $query = "select id_cargo,descripcion from cargo";
                           
							                      
							                      if (mysqli_multi_query($mysqli, $query)) {
							                          do {
							                              /* store first result set */
							                              if ($result = mysqli_store_result($mysqli)) {
							                                  while ($row = mysqli_fetch_row($result)) {
							                                      echo $row[0]." ".$row[1];
																  echo "<option value=".$row[0].">".$row[1]."</option>";
							                                  }
							                                  mysqli_free_result($result);
							                              }
							                      
							                          } while (mysqli_next_result($mysqli));
							                      }
												  else
												  	echo mysqli_error();
							                      
							                      /* close connection */
							                     
                            ?>
                 
                          </select>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Dependencia <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <select id="depen" name="depen" class="form-control" required>
                            <option value="<?php echo $id_depen;?>"><?php echo $nom_depen;?></option>
                            <?php
                           
                             $query = "select id_depen,descripcion from dependencia";
                           
							                      
							                      if (mysqli_multi_query($mysqli, $query)) {
							                          do {
							                              /* store first result set */
							                              if ($result = mysqli_store_result($mysqli)) {
							                                  while ($row = mysqli_fetch_row($result)) {
							                                      echo $row[0]." ".$row[1];
																  echo "<option value=".$row[0].">".$row[1]."</option>";
							                                  }
							                                  mysqli_free_result($result);
							                              }
							                      
							                          } while (mysqli_next_result($mysqli));
							                      }
												  else
												  	echo mysqli_error();
							                      
							                      /* close connection */
							                      mysqli_close($mysqli);
                            ?>
                          </select>
                        </div>
                      </div>
                      <input type="hidden" name="id" value="<?php echo $id_user;?>"/>
                 
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                           <input type="submit" class="btn btn-success" value="Guardar"  />
						  <input type="reset" value="Cancelar" class="btn btn-primary" onclick="cerrarse()">
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div> <!--final formulario-->
                      
            </div>
          </div>
        </div>
        <!-- /page content -->

 
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
    
   
  </body>
</html>