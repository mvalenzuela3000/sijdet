<?php
include_once 'conexion.php';
include_once 'includes/funcionesj.php';
$mysqli=conexj();
sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
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

    <title>AIT | Login</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="css/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="css/custom.min.css" rel="stylesheet">
     <script type="text/JavaScript" src="js/sha512.js"></script> 
     <script type="text/JavaScript" src="js/forms.js"></script> 
        
    <link rel="shortcut icon" href="images/favicon.ico">
  </head>

  <body class="login">
  	 <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error en los datos!</p>';
        }
        ?> 
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
          	<img src="images/logoXjornadas.png" /><br />
            <form action="includes/process_loginj.php" method="post" name="login_form">
            	
              <h1>Inicio de Sesión</h1>
              <div>
                <input type="text" class="form-control" placeholder="Número de C.I." name="id_user" required="" data-toggle="tooltip" data-placement="right" title="Ingrese el número de su C.I." autofocus/>
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" name="password" data-toggle="tooltip" data-placement="right" title="(Si no cambió su password, inicial de su nombre, inicial de su apellido y su CI. Ej. MV6125478)" required="" />
              </div>
              <div>
               
               <input type="submit" class="btn btn-default submit"
                   value="Ingresar" 
                   /> 
              </div>

              <div class="clearfix"></div>

              <div class="separator">
              	<a href="#signup" class="to_register"> Olvidaste tu password? </a>
	
                <div class="clearfix"></div>
                <br />

                <div>
                  <h2> Autoridad de Impugnación Tributaria</h2>
                  <p>©<?php echo(date("Y"));?> Todos los derechos reservados.</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
          	<img src="images/logoXjornadas.png" /><br />
            <form  action="includes/update.incj.php" method="post" name="update_form" novalidate >
            	
              <h1>Reestablecer password</h1>

              <div class="item form-group">
                <input type="number" class="form-control" placeholder="C.I." name="ci_userp" required="" />
                <br />
              </div>
              <div class="item form-group">
                <input type="password" class="form-control" placeholder="Nuevo Password" name="passwordp" id="passwordp" required="" />
              </div>
              <div class="item form-group">
                <input type="password" class="form-control" placeholder="Repita Nuevo Password" name="password2p" id="password2p" data-validate-linked="passwordp" required="" />
              </div>
              <div class="item form-group">
               <input type="submit" class="btn btn-default submit" value="Cambiar Password" id="btncambiar"/> 
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Ya eres usuario ?
                  <a href="#signin" class="to_register"> Ingresar </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h2> Autoridad de Impugnación Tributaria</h2>
                  <p>© <?php echo(date("Y"));?> Todos los derechos reservados.</p>
                </div>
              </div>
            </form>
          </section>
        </div>
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
