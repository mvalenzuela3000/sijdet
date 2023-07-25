<?php
	include 'conexion.php';
	$conexion = conexj();
	$pais = $_POST['pais'];
	$consulta = "select terminos FROM tipo_inscrito WHERE id_tipo_inscrito = '$pais' ";

	$result = $conexion->query($consulta);
	
	$respuesta = new stdClass();
	if($result->num_rows > 0){
		$fila = $result->fetch_array();
		$respuesta->terminos= str_replace("<br />", "\n", $fila['terminos']);		

	}
	else {
		$respuesta->terminos= '';
		?>
				<script language="javascript">
					alert("Registro modificado satisfactoriamente.");
				
				</script>
			<?php
	}
	
	echo json_encode($respuesta);
	mysqli_close($conexion);
?>