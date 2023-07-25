<?php
include_once 'includes/config.php';

$idOfi=$_POST["q"];


?>
						

<?php
$conexion = new mysqli('localhost','u_consulta','u_consulta_ait','bd_personal',3306);
$query = "call pa_obtiene_areas_xofi($idOfi)";
?>
<label class="control-label col-md-3 col-sm-3 col-xs-12">Seleccione el Área<span class="required">*</span>
</label>
<div class="col-md-6 col-sm-6 col-xs-12">
	<select id="area" name="area" class="form-control" required="required">
  <?php
  	 if (mysqli_multi_query($conexion, $query)) {
	      do {
	          if ($result = mysqli_store_result($conexion)) {
	              while ($row = mysqli_fetch_row($result)) {
						echo "<option value=".$row[0].">".$row[1]."</option>";
	              }
	              mysqli_free_result($result);
	          }
	  
	      } while (mysqli_next_result($conexion));
	  }
		else {
			$error= "Fallo la conexion: (" . $conexion->errno . ") " . $conexion->error;
			?>
			<script language="javascript">
			history.back(-1);
			alert("<?php echo $error; ?>");
			
			</script>
			<?php
		}
	  mysqli_close($conexion);
 
  ?>
 </select>
</div>
  
