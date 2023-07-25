<?php
include 'conexion.php';
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
include_once 'includes/db_connect.php';
include_once 'includes/config.php';

sec_session_start();
	 if (!isset($_SESSION['usuario'])) 
	 {
	 	header("Location: index.php");
        exit();
	 }
   $id=base64_decode($_GET['1d']);
$conex = mysqli_connect(HOST, USER, PASSWORD, DATABASEP);
$query="call pa_obtiene_areas('".$id."')";
if (mysqli_multi_query($conex, $query)) {
    do {
        /* store first result set */
        if ($result = mysqli_store_result($conex)) {
            while ($row = mysqli_fetch_row($result)) {
                $id_area=$row[0];
                $desc_area=$row[1];
                $desc_ofi=$row[2];
                $id_ofi=$row[4];
            }
            mysqli_free_result($result);
            }

    } while (mysqli_next_result($conex));
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

    <title>Modificacion de Datos Áreas</title>

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
                <h3>Modificación datos áreas</h3>
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Modificación <small>datos áreas</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <form class="form-horizontal form-label-left" novalidate action="control/actualizaArea.php" method="post">

                     
                      <span class="section">Informaci&oacute;n área</span>

                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion">Descripci&oacute;n <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="descripcion" class="form-control col-md-7 col-xs-12"  name="descripcion" required="required" type="text" value="<?php echo $desc_area;?>">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Oficina <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                           <select id="oficina" name="oficina" class="form-control" required>
                            <option value="<?php echo $id_ofi;?>"><?php echo $desc_ofi;?></option>
                            <?php
                           
                             $query = "select id,descripcion from oficinas";            
                                if (mysqli_multi_query($conexionp, $query)) {
                                    do {
                                        /* store first result set */
                                        if ($result = mysqli_store_result($conexionp)) {
                                            while ($row = mysqli_fetch_row($result)) {
                                                echo "<option value=".$row[0].">".$row[1]."</option>";
                                            }
                                            mysqli_free_result($result);
                                        }
                                
                                    } while (mysqli_next_result($conexionp));
                                }
                                else
                                echo mysqli_error();
                                
                                /* close connection */
                                mysqli_close($conexionp);
                            ?>
                          </select>
                        </div>
                      </div>
                      
                      <input type="hidden" name="id" value="<?php echo $id_area;?>"/>
                 
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