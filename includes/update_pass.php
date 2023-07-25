<?php

include 'functions.php';

  include_once 'db_connect.php';
include_once 'psl-config.php';
sec_session_start();
$error_msg = "";

if (isset($_POST['passworda'], $_POST['passwordn'])) {
    // Sanitize and validate the data passed in
   $passworda=$_POST['passworda'];
   $passwordn=$_POST['passwordn'];
   
   $passworda = hash('sha512', $_POST['passworda']);;
    if (strlen($passworda) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Configuración invalida de password.</p>';
    }
	$passwordn = hash('sha512', $_POST['passwordn']);;
    if (strlen($passwordn) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Configuración invalida de password.</p>';
    }
   
    $prep_stmt = "SELECT password,salt FROM usuario WHERE id_user = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
    
    if ($stmt) {
        $stmt->bind_param('s', $_SESSION['usuario']);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($passcompara,$saltpassant);
        $stmt->fetch();
		$passworda=hash('sha512', $passworda.$saltpassant);
       if ($passcompara!=$passworda) {
            // A user with this email address already exists
            $error_msg .= '<p class="error">El dato de password actual no es correcto.</p>';
			?>
					<script language="javascript">
                    alert("El dato de password actual no es correcto.");
                   history.back(-1);
                    
                    </script>
			<?php
        }
		
    } else {
        $error_msg .= '<p class="error">Error en la base de datos</p>';
    }
    
    // TODO: 
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.

    if (empty($error_msg)) {
       // Create a random salt
        $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));

        // Create salted password 
        
        $passwordn = hash('sha512', $passwordn . $random_salt);

        // Insert the new user into the database 
        if ($insert_stmt = $mysqli->prepare("update usuario set password=?,salt= ? where id_user= ? ")) 
        {
            $insert_stmt->bind_param('sss', $passwordn,$random_salt,$_SESSION['usuario']);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Fallo en registro: UPDATE');
                exit();
            }
			else {
				?>
            <script language="javascript">
                    alert("Password modificado exitosamente.");
                    location.href = "../index.php";
                    
                    </script>
        	<?php
				}
        
         }
		
        exit();
        
 				
			}
			
		}
        
?>