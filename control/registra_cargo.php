<?php 
    include_once '../includes/functions.php';
    include_once '../conexion.php';
    sec_session_start();
    if(isset($_POST["area"]) && isset($_POST["descripcion"]) && isset($_POST["item"]))
    {
        $query="call pa_registra_cargo('".$_POST["descripcion"]."','".$_POST["item"]."','".$_SESSION['usuario']."','".$_POST["area"]."')";

        if (mysqli_multi_query($conexionp, $query)) {
            ?>
				<script language="javascript">
                    alert("Registrado exitosamente.");
                    location.href = "../FormRegCargo.php";
                    </script>
			<?php
        }
        else {
            ?>
            <script language="javascript">
                alert("Error al registrar, no se puede registrar dos veces el mismo número de item.");
                location.href = "../FormRegCargo.php";
            </script>
            <?php
        }
    }
    else{
        ?>
        <script language="javascript">
            alert("No se introdujeron todos los datos.");
            location.href = "../FormRegCargo.php";
        </script>
        <?php
    }
?>