<?php
	define("SECURE", FALSE);
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
	function login($id_user, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT u.nombres,u.apellidos,u.ci, u.password
				  FROM registrados u WHERE ci= ? LIMIT 1")) {
        $stmt->bind_param('s', $id_user);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($nombres,$apellidos,$ci_user, $db_password);
        $stmt->fetch();

        // hash the password with the unique salt.
        $password = md5($password);
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
                    $_SESSION['usuario'] = $ci_user;

                    // XSS protection as we might print this value
                    $nombres = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $nombres);
					$apellidos = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $apellidos);
					$username=$nombres." ".$apellidos;
                    $_SESSION['username'] = $username;

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
    if (isset($_SESSION['usuario'], $_SESSION['username'])) {
        $id_user = $_SESSION['usuario'];

        $username = $_SESSION['username'];
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $mysqli->prepare("SELECT password 
				      FROM registrados
				      WHERE ci = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('s', $id_user);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                    return true;
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
function obtiene_datos_registrado($ci,$mysqli)
{
	 if ($stmt = $mysqli->prepare("SELECT u.nombres,u.apellidos,u.ci, u.extension,d.ext_dep,u.email,u.dpto,d.nombre_dep,u.profesion,p.nombre_prof,u.otraprofesion, u.fono
				  FROM registrados u left join departamentos d on u.dpto=d.id_dep left join profesiones p on u.profesion=p.id_prof WHERE ci= ? LIMIT 1")) {
        $stmt->bind_param('s', $ci);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();

        $stmt->bind_result($nombres,$apellidos,$ci, $extension,$depextension,$mail,$dpto,$nombredpto,$profesion,$nombreprofesion,$otraprofesion,$fono);
        $stmt->fetch();
		$cadena=$nombres.'|'.$apellidos.'|'.$ci.'|'.$extension.'|'.$depextension.'|'.$mail.'|'.$dpto.'|'.$nombredpto.'|'.$profesion.'|'.$nombreprofesion.'|'.$otraprofesion.'|'.$fono;
		return $cadena;   
    } else {
        return '';
    }
}
?>