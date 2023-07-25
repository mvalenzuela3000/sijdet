<?php

include_once 'psl-config.php';

function registra_asistencia($ci,$conex)
{
	$query="call pa_registra_asistencia($ci)";

	if($resultado = $conex->query($query))
	{
		return 1;
	}
	else
	{
		return 0;
	}
}
function verifica_fecha($fini,$ffin)
{
	$tfini=explode('/',$fini);
	$tempfini=$tfini[2].'-'.$tfini[1].'-'.$tfini[0];
	$tffin=explode('/',$ffin);
	$tempffin=$tffin[2].'-'.$tffin[1].'-'.$tffin[0];
	if($tempffin>$tempfini)
	{ return 1;}
	else {
		return 0;}
}
function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name 
    $secure = SECURE;

    // This stops JavaScript being able to access the session id.
    $httponly = true;

    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=No se puede iniciar una sesion segura (ini_set)");
        exit();
    }

    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

    // Sets the session name to the one set above.
    session_name($session_name);

    session_start();            // Start the PHP session 
    session_regenerate_id();    // regenerated the session, delete the old one. 
}
function pag_inicio($id_user,$mysqli)
{
	

    if ($stmt = $mysqli->prepare("select m.ruta from menu m,menu_usuario u where m.id_menu=u.id_menu  and m.id_padre>0 and u.id_user= ? order by m.area, m.id_padre limit 1")) {
        $stmt->bind_param('s', $id_user);

        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();
		$stmt->bind_result($ruta);
        $stmt->fetch();
        // If there have been more than 5 failed logins 
        if ($stmt->num_rows ==1) {
            return $ruta;
        } else {
        	$inicio='index.php';
            return $inicio;
        }
    } else {
        // Could not create a prepared statement
        header("Location: ../error.php?err=Database error: cannot prepare statement");
        exit();
    }
}

function crea_menu($id_user,$mysqli)
{

    $menu='<ul class="nav side-menu">';
    $query = "CALL pa_menu_padres('".$id_user."')";
                      
  if (mysqli_multi_query($mysqli, $query)) {
      do {
          if ($result = mysqli_store_result($mysqli)) {
              while ($row = mysqli_fetch_row($result)) {
                  $menu.='<li><a><i class="'.$row[1].'"></i>'.$row[2].'<span class="fa fa-chevron-down"></span></a>';
					$menu.=submenu($id_user,$row[0]);		
              }
              mysqli_free_result($result);
          }
		$menu.='</li>';
      } while (mysqli_next_result($mysqli));
  }
  	$menu.='<li><a data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-key"></i>Cambio Password</a></li>';
  	$menu.='<li><a href="logout.php"><i class="fa fa-sign-out"></i>Salir</a></li>';
	
	$menu.='</ul>';
	return $menu;	                      
}

function submenu($id_user,$id_padre)
{
	$menu2='';
	$mysqli2 = new mysqli(HOSTU, USERU, PASSWORDU, DATABASEU);
	if (mysqli_connect_errno()) {
    printf("Falló la conexión: %s\n", mysqli_connect_error());
    exit();
	}
	$query="select s.ruta,s.titulo from menu s,menu_usuario us where us.id_user='".$id_user."' and s.id_padre=".$id_padre." and s.id_menu=us.id_menu order by s.id_menu";
	$menu2.='<ul class="nav child_menu">';
	if($resultado=$mysqli2->query($query))
	{
		
		while ($fila = $resultado->fetch_row()){
		 $menu2.='<li><a href="'.$fila[0].'">'.$fila[1].'</a></li>';
		}
		$resultado->close();
	}
	
	$menu2.='</ul>';
	$mysqli2->close();
	
	return $menu2;
}


function login($id_user, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT u.id_user,u.nombres,u.apellidos,u.ci_user, u.password, u.salt ,c.descripcion,d.descripcion
				  FROM usuario u, cargo c , dependencia d
                                  WHERE id_user = ? and u.id_cargo=c.id_cargo and u.id_depen=d.id_depen and activo=1 LIMIT 1")) {
        $stmt->bind_param('s', $id_user);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($id_usuario, $nombres,$apellidos,$ci_user, $db_password, $salt,$cargo,$dependencia);
        $stmt->fetch();

        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
            if (checkbrute($id_usuario, $mysqli) == true) {
                // Account is locked 
                // Send an email to user saying their account is locked 
                return false;
            } else {
                // Check if the password in the database matches 
                // the password the user submitted.
                if ($db_password == $password) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];

                    // XSS protection as we might print this value
                    //$id_usuario = preg_replace("/[^0-9]+/", "", $id_user);
                    $_SESSION['usuario'] = $id_usuario;

                    // XSS protection as we might print this value
                    $nombres = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $nombres);
					$apellidos = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $apellidos);
					$username=$nombres." ".$apellidos;
                    $_SESSION['username'] = $username;
					$cargo=preg_replace("/[^a-zA-Z0-9_\-]+/", "", $cargo);
					$_SESSION['cargo']=$cargo;
					$dependencia=preg_replace("/[^a-zA-Z0-9_\-]+/", "", $dependencia);
					$_SESSION['dependencia']=$dependencia;
                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);

                    // Login successful. 
                    return true;
                } else {
                    // Password is not correct 
                    // We record this attempt in the database 
                    $now = time();
                    if (!$mysqli->query("INSERT INTO login_attempts(id_user, time) 
                                    VALUES ('$id_user', '$now')")) {
                        header("Location: ../error.php?err=Database error: login_attempts");
                        exit();
                    }

                    return false;
                }
            }
        } else {
            // No user exists. 
            return false;
        }
    } else {
        // Could not create a prepared statement
        header("Location: ../error.php?err=Database error: cannot prepare statement");
        exit();
    }
}

function checkbrute($id_user, $mysqli) {
    // Get timestamp of current time 
    $now = time();

    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);

    if ($stmt = $mysqli->prepare("SELECT time 
                                  FROM login_attempts 
                                  WHERE id_user = ? AND time > '$valid_attempts'")) {
        $stmt->bind_param('s', $id_user);

        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();

        // If there have been more than 5 failed logins 
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    } else {
        // Could not create a prepared statement
        header("Location: ../error.php?err=Database error: cannot prepare statement");
        exit();
    }
}

function login_check($mysqli) {
    // Check if all session variables are set 
    if (isset($_SESSION['usuario'], $_SESSION['username'],$_SESSION['login_string'])) {
        $id_user = $_SESSION['usuario'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $mysqli->prepare("SELECT password 
				      FROM usuario 
				      WHERE id_user = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('s', $id_user);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);

                if ($login_check == $login_string) {
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Could not prepare statement
            header("Location: ../error.php?err=Database error: cannot prepare statement");
            exit();
        }
    } else {
        // Not logged in 
        return false;
    }
}

function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
    
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
    
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
    
    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);
    
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}
