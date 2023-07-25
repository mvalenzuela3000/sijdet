<?php
    $idcargo=$_POST["id"];
    $persona=$_POST["persona"];
    include_once '../includes/functions.php';
    include_once '../conexion.php';
    sec_session_start();
    if(isset($_POST["id"]) && isset($_POST["persona"]))
    {
        $query="update personas set idCargo=$idcargo where ci=$persona";

        if (mysqli_multi_query($conexionp, $query)) {
            ?>
            <script language="javascript">
                window.opener.document.location.reload();
                self.close();
            </script>
            <?php
        }
        else {
            $error= "Fallo la insercion de datos: (" . $conexionp->errno . ") " . $conexionp->error;
            ?>
            <script language="javascript">
                history.back(-1);
                alert("<?php echo $error; ?>");
            </script>
            <?php
        }
    }
    else{
        ?>
            <script language="javascript">
                history.back(-1);
                alert("No se introdujeron todos los datos");
            </script>
            <?php
    }
?>