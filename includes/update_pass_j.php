<?php

include '../conexion.php';
include 'functions.php';
sec_session_start();
$error_msg = "";
$mysqli=conexj();
if (isset($_POST['passworda'], $_POST['passwordn'])) {
    // Sanitize and validate the data passed in
   $passworda=$_POST['passworda'];
   $passwordn=$_POST['passwordn'];
   
  
    $prep_stmt = "SELECT password FROM registrados WHERE ci = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
    
    if ($stmt) {
        $stmt->bind_param('s', $_SESSION['usuario']);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($passcompara);
        $stmt->fetch();
       if ($passcompara!=md5($passworda)) {
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
        
        //$passwordn = md5($passwordn);

        // Insert the new user into the database 
        if ($insert_stmt = $mysqli->prepare("update registrados set password=MD5('".$passwordn."') where ci= ? ")) 
        {
            $insert_stmt->bind_param('s', $_SESSION['usuario']);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Fallo en registro: UPDATE');
                exit();
            }
			else {
				?>
            <script language="javascript">
                    alert("Password modificado exitosamente.");
                    location.href = "../formIngreso.php";
                    
                    </script>
        	<?php
				}
        
         }
		
        exit();
        
 				
			}
			
		}
        
?>