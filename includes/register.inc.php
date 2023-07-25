<?php

include_once 'db_connect.php';
include_once 'psl-config.php';

$error_msg = "";

if (isset($_POST['name'],$_POST['apellido'], $_POST['ci'], $_POST['cargo'],$_POST['depen'], $_POST['password'])) {
    // Sanitize and validate the data passed in
   $name=$_POST['name'];
   $apellido=$_POST['apellido'];
   $ci=$_POST['ci'];
   $cargo=$_POST['cargo'];
   $depen=$_POST['depen'];
   $password=hash('sha512', $_POST['password']);
  // echo $name."-".$apellido."-".$ci="-".$cargo."-".$depen."-".$password."-".$_POST['password'];
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Configuraciòn invalida de password.</p>';
    }
   $tname=strtolower(substr($name, 0,1));
   $tempape=explode(' ', $apellido);

	$tape=strtolower($tempape[0]);

   $id_user=$tname.$tape;
    $prep_stmt = "SELECT ci_user FROM usuario WHERE ci_user = ? or id_user= ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
    
    if ($stmt) {
        $stmt->bind_param('ss', $ci,$id_user);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            $error_msg .= '<p class="error">Un usuario con este ci o con el id ya se encuentra registrado.</p>';
			?>
					<script language="javascript">
                    alert("Un usuario con este CI o con el ID ya se encuentra registrado..");
                   history.back(-1);
                    
                    </script>
			<?php
        }
    } else {
        $error_msg .= '<p class="error">Error en la base de datos</p>';
		?>
					<script language="javascript">
                    alert("No se puede contactar con la base de datos.");
                    location.href = "FormRegUser.php";
                    
                    </script>
			<?php
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
	$val=1;
        // Insert the new user into the database 
        if ($insert_stmt = $mysqli->prepare("INSERT INTO usuario (id_user, ci_user, nombres, apellidos,activo,password,id_cargo,id_depen,salt) VALUES (?, ?, ?, ?,?,?,?,?,?)")) {
            $insert_stmt->bind_param('sssssssss', $id_user, $ci, $name,$apellido,$val, $password,$cargo,$depen,$random_salt);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Fallo en registro: INSERT');
                exit();
            }
			?>
            <script language="javascript">
                    alert("Usuario registrado exitosamente.");
                    location.href = "FormRegUser.php";
                    
                    </script>
        <?php
        }
         }
		
        exit();
    }
