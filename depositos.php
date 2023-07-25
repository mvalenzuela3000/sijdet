<?php
	include 'conexion.php';
	$conexion = conexj();
	$deposito = $_POST['deposito'];
	$consulta = "select date_format(fecha_deposito,'%d/%m/%Y') as fecha, monto_deposito FROM depositos_cargados WHERE id_deposito = '$deposito' and gestion='".date("Y")."'";

	$result = $conexion->query($consulta);
	
	$respuesta = new stdClass();
	if($result->num_rows > 0){
		$fila = $result->fetch_array();
		$respuesta->fechadepo= $fila['fecha'];
		$respuesta->montodepo = $fila['monto_deposito'];		
	}
	else {
		$respuesta->fechadepo= '';
		$respuesta->montodepo = '';
		?>
				<script language="javascript">
					alert("Registro modificado satisfactoriamente.");
				
				</script>
			<?php
	}
	
	echo json_encode($respuesta);
	mysqli_close($conexion);
?>