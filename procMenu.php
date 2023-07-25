<?php
include_once 'includes/config.php';

$menu=$_POST["m"];
$usuario=$_POST["u"];
//$res=sqlsrv_query($con,"select * from subadmin where id_adm=".$q."");

?>


<table class="table table-striped jambo_table bulk_action">
    <thead>
      <tr class="headings" >

        <th class="column-title">Título del menú </th>
      
      </tr>
    </thead>

    <tbody>

    	<?php
    	$conexion = new mysqli('localhost','u_consulta','u_consulta_ait','bd_usuario',3306);
    	$query = "CALL pa_obtiene_menuxusuario('".$menu."','".$usuario."')";
 		     
        
 		if (mysqli_multi_query($conexion, $query)) {
	      do {
	          if ($result = mysqli_store_result($conexion)) {
	              while ($row = mysqli_fetch_row($result)) {
						if($row[2]>0){
	         				echo "<tr  class=\"a-center col-md-12 col-sm-12 col-xs-12\"><td><input name='checkbox1[]' type='checkbox' id='checkbox1[]' value='".$row[0]."' checked=\"checked\"></td>
	                                            <td>".$row[1]."</td><tr>";  
						}
						else {
	         				echo "<tr  class=\"a-center col-md-12 col-sm-12 col-xs-12\"><td><input name='checkbox1[]' type='checkbox' id='checkbox1[]' value='".$row[0]."'></td>
	                                            <td>".$row[1]."</td><tr>";
						}
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
			alert("<?php echo $error; ?>
				");
			
			</script>
			<?php
		}
	  mysqli_close($conexion);
	 /* echo "<tr><td>".$menu."</td></tr>";
	  echo "<tr><td>".$usuario."</td></tr>";
	   echo "<tr><td>".$query."</td></tr>";*/
	  ?>
   
                   
                
                     
       </tbody>
  </table>
  