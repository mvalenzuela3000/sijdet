<?php 
    include_once '../includes/functions.php';
    include_once '../conexion.php';
    sec_session_start();
    if(isset($_POST["abrev"]) && isset($_POST["descripcion"]))
    {
        $query="call pa_registra_oficina('".$_POST["descripcion"]."','".$_POST["abrev"]."','".$_SESSION['usuario']."')";
        if (mysqli_multi_query($conexionp, $query)) {
            ?>
				<script language="javascript">
                    alert("Registrado exitosamente.");
                    location.href = "../FormRegOficina.php";
                    </script>
			<?php
        }
        else {
            ?>
            <script language="javascript">
                alert("Error al registrar, favor contactese con el administrador.");
                location.href = "../FormRegOficina.php";
            </script>
            <?php
        }
    }
    else{
        ?>
        <script language="javascript">
            alert("No se introdujeron todos los datos.");
            location.href = "../FormRegOficina.php";
        </script>
        <?php
    }
?>