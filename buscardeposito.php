<?php
include 'conexion.php';
$conexion = conexj();
$deposito = $_GET['term'];
$consulta = "select id_deposito FROM depositos_cargados WHERE id_deposito LIKE '%$deposito%' and gestion='".date("Y")."'";

$result = $conexion->query($consulta);

if($result->num_rows > 0){
	while($fila = $result->fetch_array()){
		$depositos[] = $fila['id_deposito'];		
	}
	echo json_encode($depositos);
}

mysqli_close($conexion);
?>