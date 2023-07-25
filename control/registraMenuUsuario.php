<?php
	include '../conexion.php';
	include_once '../includes/functions.php';
	include_once '../includes/db_connect.php';
	sec_session_start();
	
	function formato_fecha($fecha)
	{
		$tfini=explode('/',$fecha);
		$tempfini=$tfini[2].'-'.$tfini[1].'-'.$tfini[0];
		return $tempfini;
	}
	if (isset($_POST["checkbox1"]))
	{
		$menu_padre=$_POST["menu"];
		$usuario=$_POST["usuario"];
		$registro=$_POST["checkbox1"];
		$cantregistros=count($registro);
//		$mysqli=conexu();
		$menuerrores='';
		$query="call pa_elimina_menuxusuario_padre('".$menu_padre."','".$usuario."')";
		//echo $query."<br>";
		if($resultado = $mysqli->query($query))
		{
			$query2="call pa_inserta_menu_usuario('".$menu_padre."','".$usuario."')";
			if($resultado2 = $mysqli->query($query2))
			{
				for ($i=0;$i<count($registro);$i++)
				{
					$query3="call pa_inserta_menu_usuario('".$registro[$i]."','".$usuario."')";	
					$cont=0;
					if($resultado3 = $mysqli->query($query3))
					{
						$cont++;
					}
					else {
						$menuerrores.='Error en la inserción del submenú con ID: '.$registro[$i].'<br>';
					}
						//echo $menu_padre." - ".$usuario;	
				}
			}
			else
			{
				$error= "Fallo la inserción del menú padres: (" . $mysqli->errno . ") " . $mysqli->error;
				?>
				<script language="javascript">
				history.back(-1);
				alert("<?php echo $error; ?>
					");
				</script>
				<?php
			}
		}	
			
		else
		{
			$error= "Fallo la eliminación de datos: (" . $mysqli->errno . ") " . $mysqli->error;
			?>
			<script language="javascript">
			history.back(-1);
			alert("<?php echo $error; ?>
				");
			</script>
			<?php
		}
		if($menuerrores==''){
			?>
			<script language="javascript">
			alert("Registros ingresados correctamente");
			location.href = "../FormMenuUsuario.php"; 
			</script>
			<?php
		}
		else {
			?>
			<script language="javascript">
			history.back(-1);
			alert("<?php echo $menuerrores;?>");
		
			</script>
			<?php
		}
		
	}
	else{
		$menu_padre=$_POST["menu"];
		$usuario=$_POST["usuario"];
	//	$mysqli=conexu();
		$query="call pa_elimina_menuxusuario_padre('".$menu_padre."','".$usuario."')";
		//echo $query."<br>";
		if($resultado = $mysqli->query($query))
		{
			?>
			<script language="javascript">
			alert("Registros actualizados correctamente");
			location.href = "../FormMenuUsuario.php"; 
			</script>
			<?php
		}
		else {
			$error= "Fallo la eliminación de datos: (" . $mysqli->errno . ") " . $mysqli->error;
			?>
			<script language="javascript">
			history.back(-1);
			alert("<?php echo $error; ?>
				");
			</script>
			<?php
			exit;
		}
	}
	
	
?>