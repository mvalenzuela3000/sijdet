<?php
date_default_timezone_set('America/La_Paz');
	include_once '../conexion.php';
	include_once '../includes/functions.php';
	sec_session_start();
	
	$tci=$_POST["id"];
	$tempci=explode('.',$tci);
	$id=trim($tempci[1]);
	$ci=base64_encode($id);

	$e=0;
	$usuario=$_SESSION['usuario']; 
	 //asd.3865975.asd.156

	if($ci!=null)
	{
		$e=0;
		$query="call pa_registra_refrigerios('".$id."','".$usuario."')";
		
		if (mysqli_multi_query($conexionj, $query)) {
	      do {
	          if ($result = mysqli_store_result($conexionj)) {
	              while ($row = mysqli_fetch_row($result)) {
						$e=$row[0];
	              }
	              mysqli_free_result($result);
	          }
	      } while (mysqli_next_result($conexionj));
		  if($e==1)
		  {
		  	$date = base64_encode(date("H:i:s"));
			$e=base64_encode(1);
			header("Location:../ControlRefrigerio.php?id=$ci&d=$date&e=$e");
		  }
		  elseif ($e==2)
		  {
			  $e=base64_encode(0);
				  $date=base64_encode("Error, el C.i. ya recibió su refrigerio.");
        		 header("Location:../ControlRefrigerio.php?id=$ci&d=$date&e=$e");
		  }
		  elseif ($e==0) {
			  $e=base64_encode(0);
				  $date=base64_encode("Error, el C.i. no está inscrito.");
        		 header("Location:../ControlRefrigerio.php?id=$ci&d=$date&e=$e");
		  }
          elseif ($e==3) {
            $e=base64_encode(0);
                $date=base64_encode("Error, el C.i. ya recibió sus dos refrigerios.");
               header("Location:../ControlRefrigerio.php?id=$ci&d=$date&e=$e");
            }
	  	}
		else {
			$e=base64_encode(0);
				  $date=base64_encode("Error, No se pudo ejecutar la consulta.");
        		 header("Location:../ControlRefrigerio.php?id=$ci&d=$date&e=$e");
		}
		
	}
	else
	{
         $e=base64_encode(0);
         $date=base64_encode(".");
          header("Location:../ControlRefrigerio.php?id=$ci&d=$date&e=$e");
	}
?>