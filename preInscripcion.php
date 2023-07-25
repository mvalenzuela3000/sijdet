<?php
     include 'conexion.php';
	include_once 'includes/db_connect.php';
	include_once 'includes/functions.php';
sec_session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Jornadas Bolivianas de Derecho Tributario</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">
    <!-- Custom styling plus plugins -->
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
											echo htmlentities($_SESSION['username']);} 
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
                	<h3>Inscripciones - Jornadas de Derecho Tributario</h3>
              	</div>
            </div>
            <div class="clearfix"></div>
            
            <div class="bs-docs-section">
                      <h1 id="glyphicons" class="page-header">Bienvenido, por favor elija alguna de las siguientes opciones.</h1>

                      <h2 id="glyphicons-glyphs">Por favor, indique si ya participó anteriormente en las Jornadas Tributarias</h2>
                      <br><br><br><br><br>
                      <div class="bs-glyphicons">
                        <ul class="bs-glyphicons-list">
						
                          <li>
                            <span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span>
                            <span class="glyphicon-class"><h2>Sí, ya participé en las Jornadas</h2></span>
                          </li>
					
                          <li>
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            <span class="glyphicon-class"><h2>No, es la primera vez que partipo en las Jornadas Tributarias</h2></span>
                          </li>
						
                        </ul>
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

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
  </body>
</html>