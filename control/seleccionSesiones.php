<?php
	//include '../includes/funj.php';
	include '../conexion.php';
	include_once '../includes/functions.php';
	 require_once '../includes/codigo.php';
	require 'class.phpmailer.php';
	require 'class.smtp.php';
	
	sec_session_start();
	$ci=$_POST['number'];

	function formato_fecha($fecha)
	{
		$tfini=explode('/',$fecha);
		$tempfini=$tfini[2].'-'.$tfini[1].'-'.$tfini[0];
		return $tempfini;
	}
	
	function obtiene_codsesion()
	{
		$conexionj=conexj();
		$query="select distinct(cod_sesion) from sesiones_paralelas where gestion=year(now())";
		$valores=array();
		 if (mysqli_multi_query($conexionj, $query)) {
	          do {
	              if ($result = mysqli_store_result($conexionj)) {
	                  while ($row = mysqli_fetch_row($result)) {
	                  		$valores[]=$row[0];     
	                  }
	                  mysqli_free_result($result);
	              }
	      
	          } while (mysqli_next_result($conexionj));
	      }
		else {
			?>
				<script>
					alert("El registro no fue encontrado por favor revise su enlace o conexión con internet.")
				</script>
			<?php
		}
		return $valores;
	}
	$valores=obtiene_codsesion();
	$conexionj=conexj();
	$cont=0;
	for($i=0;$i<count($valores);$i++)
	{
		$indice=$valores[$i];
		$val=$_POST[$indice];
		$query="call pa_inserta_sesiones_inscrito('".$ci."',$val)";
		if($resultado = $conexionj->query($query))
		{
			$cont++;
		}
		else
		{
				$error= "Fallo la insercion de datos: (" . $conexionj->errno . ") " . $conexionj->error;
			?>
			<script language="javascript">
			history.back(-1);
			alert("<?php echo $error; ?>
				");
			</script>
			<?php
		}

	}
	?>
	<script language="javascript">

		alert("Se registraron correctamente "+"<?php echo $cont; ?>"+" registros.");
		location.href = "../FormDatosBasicos.php?c0d="+"<?php echo base64_encode($ci);?>"; 
	</script>
	<?php

?>