<?php

//echo $_POST['id_userp']."- ".$_POST['ci_userp']."- ".$_POST['passwordp']."- ".$_POST['password2p']."- ".$_POST['p'];
  include_once 'db_connect.php';
include_once 'psl-config.php';
include '../conexion.php';
$error_msg = "";
$mysqli=conexj();
if (isset($_POST['ci_userp'], $_POST['passwordp'])) {
    // Sanitize and validate the data passed in

   $ci_user=$_POST['ci_userp'];
   
   $password = $_POST['passwordp'];

   
    $prep_stmt = "SELECT ci FROM registrados WHERE ci = ? LIMIT 1";
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


        // Create salted password 
        $password = md5($password);

        // Insert the new user into the database 
        if ($insert_stmt = $mysqli->prepare("update registrados set password=? where ci= ?")) 
        {
            $insert_stmt->bind_param('ss', $password,$ci_user);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Fallo en registro: UPDATE');
                exit();
            }
			else {
				?>
            <script language="javascript">
                    alert("Password registrado exitosamente.");
                    location.href = "../formIngreso.php";
                    
                    </script>
        	<?php
				}
        
         }
		
        exit();
        
 				
			}
			
		}
        
?>