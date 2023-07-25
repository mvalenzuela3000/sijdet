<?php
	include_once '../includes/functions.php';
    include_once '../conexion.php';
    $id=base64_decode($_GET["1d"]);
	$opt=base64_decode($_GET["0pt"]);

	if (isset($opt) && isset ($id))
	{
        $tabla='personas';
        if ($opt==1 ||$opt==3){
            $query="update $tabla set idCargo=null where ci=$id";
        }else{
            $query="delete from $tabla where ci=$id";
        }

		
		if($resultado = $conexionp->query($query))
		{
			if($opt==3){
				?>
				<script language="javascript">
					alert("Realizado satisfactoriamente.");
					location.href = "../FormAsignaCargo.php"; 
				</script>
				<?php
			}else{
				?>
				<script language="javascript">
					alert("Realizado satisfactoriamente.");
					location.href = "../FormRegPersonal.php"; 
				</script>
			<?php
			}
			
		}
		else
		{
			$error= "Fallo la actualizacion de datos: (" . $conexionp->errno . ") " . $conexionp->error;
			?>
			<script language="javascript">
			history.back(-1);
			alert("<?php echo $error; ?>");
			
			</script>
			<?php
		}
	}
	else {
		
	}
?>