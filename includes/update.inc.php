<?php

//echo $_POST['id_userp']."- ".$_POST['ci_userp']."- ".$_POST['passwordp']."- ".$_POST['password2p']."- ".$_POST['p'];
  include_once 'db_connect.php';
include_once 'psl-config.php';

$error_msg = "";

if (isset($_POST['id_userp'],$_POST['ci_userp'], $_POST['passwordp'])) {
    // Sanitize and validate the data passed in
   $id_user=$_POST['id_userp'];
   $ci_user=$_POST['ci_userp'];
   
   $password = hash('sha512', $_POST['passwordp']);;
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Configuración invalida de password.</p>';
    }
   
    $prep_stmt = "SELECT id_user FROM usuario WHERE ci_user = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
    
    if ($stmt) {
        $stmt->bind_param('s', $ci_user);
        $stmt->execute();
        $stmt->store_result();
        /*$stmt->bind_result($ruta);
        $stmt->fetch();*/
       if ($stmt->num_rows == 0) {
            // A user with this email address already exists
            $error_msg .= '<p class="error">Un usuario con este CI no se encuentra registrado.</p>';
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
        $password = hash('sha512', $password . $random_salt);

        // Insert the new user into the database 
        if ($insert_stmt = $mysqli->prepare("update usuario set password=?,salt= ? where id_user= ? and ci_user= ?")) 
        {
            $insert_stmt->bind_param('ssss', $password,$random_salt,$id_user,$ci_user);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Fallo en registro: UPDATE');
                exit();
            }
			else {
				?>
            <script language="javascript">
                    alert("Password registrado exitosamente.");
                    location.href = "../index.php";
                    
                    </script>
        	<?php
				}
        
         }
		
        exit();
        
 				
			}
			
		}
        
?>