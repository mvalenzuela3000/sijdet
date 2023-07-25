<?php
	include '../conexion.php';
	include_once '../includes/functions.php';
	sec_session_start();
	$nombre=strtoupper(trim($_POST["nombre"]));
	$apPaterno=strtoupper(trim($_POST["apPaterno"]));
	$apMaterno=strtoupper(trim($_POST["apMaterno"]));
    $cargo=$_POST["cargo"];
    $region=$_POST["dpto"];
    $email=$_POST["email"];
    $interno=$_POST["interno"];
	$ci=str_replace(' ','',strtoupper(trim($_POST["ci"])));
    if($nombre=='' || $ci=='')
    {
        ?>
        <script language="javascript">
            history.back(-1);
            alert("Por favor revise nodejar ni el ci ni el nombre vacios.");
        </script>
        <?php
        exit ;
    }
	$dpto=$_POST["dpto"];
    if($_FILES["foto"]["name"]!=""){
        $destination_path = "../images";
        $ruta="images/".$ci;
        $resadmnom=$_FILES["foto"]["name"];
        $ds_inf=basename($_FILES['foto']['name']);
        $ds1_inf=$_FILES['foto']['tmp_name'];
        $ext_inf=extension1($ds_inf);
        $ruta.='.'.$ext_inf;
        $target_path2=$destination_path."/".$ci.".".$ext_inf;
        
        if($resadmnom !="")
        {
            if(move_uploaded_file($_FILES['foto']['tmp_name'], $target_path2))
            {
            
            }
            else
            {
                ?>
                <script language="javascript">
                    history.back(-1);
                    alert("Por favor revise que el tamaño de la fotografia sea inferior a 2 MB.");
                </script>
                <?php
                exit ;
            }
        }
    }
    else{
        $ruta="images/user.png";
    }
	
	function extension1($filename)
	{
		$ext1= substr(strrchr($filename, '.'), 1);
		return $ext1;
	}

	$query="call pa_registra_persona('".$ci."','".$nombre."','".$apPaterno."','".$apMaterno."','".$cargo."','".$region."','".$email."','".$interno."','".$_SESSION['usuario']."','".$ruta."')";
	//echo $query;
	if($resultado=$conexionp->query($query))
			{
		?>
		<script language="javascript">
            alert("Registrado exitosamente.");
            location.href = "../FormRegPersonal.php";        
            </script>
	<?php
	}
	else
		{
			?>
		<script language="javascript">
            alert("Error al registrar a la persona, favor contactese con el administrador.");
            location.href = "../FormRegPersonal.php";
        </script>
		<?php
		}
	mysqli_close($conexionj);
?>