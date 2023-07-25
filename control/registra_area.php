<?php 
    include_once '../includes/functions.php';
    include_once '../conexion.php';
    sec_session_start();
    if(isset($_POST["oficina"]) && isset($_POST["descripcion"]))
    {
        $query="call pa_registra_area('".$_POST["descripcion"]."','".$_SESSION['usuario']."','".$_POST["oficina"]."')";

        if (mysqli_multi_query($conexionp, $query)) {
            ?>
				<script language="javascript">
                    alert("Registrado exitosamente.");
                    location.href = "../FormRegArea.php";
                    </script>
			<?php
        }
        else {
            ?>
            <script language="javascript">
                alert("Error al registrar, favor contactese con el administrador.");
                location.href = "../FormRegArea.php";
            </script>
            <?php
        }
    }
    else{
        ?>
        <script language="javascript">
            alert("No se introdujeron todos los datos.");
            location.href = "../FormRegArea.php";
        </script>
        <?php
    }
?>