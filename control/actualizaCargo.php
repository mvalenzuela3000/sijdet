<?php 
    include_once '../includes/functions.php';
    include_once '../conexion.php';
    sec_session_start();
    if(isset($_POST["checkbox1"]))
    {
        if(isset($_POST["area"]) && isset($_POST["descripcion"]) && isset($_POST["id"])  && isset($_POST["item"]))
        {
            $query="call pa_actualiza_cargo('".$_POST["id"]."','".$_POST["descripcion"]."','".$_POST["item"]."','".$_POST["area"]."','".$_SESSION['usuario']."')";
            if($resultado = $conexionp->query($query))
            {
            ?>
                <script language="javascript">
                    window.opener.document.location.reload();
                    self.close();
                </script>
            <?php
            }
            else
            {
            $error= "Fallo la insercion de datos: (" . $conexionp->errno . ") " . $conexionp->error;
            ?>
            <script language="javascript">
                history.back(-1);
                alert("<?php echo $error; ?>");
            </script>
            <?php
            }
            
            mysqli_close($conexionp);
        }
        else{
            ?>
            <script language="javascript">
                history.back(-1);
                alert("No se introdujeron todos los datos");
            </script>
            <?php
        }
    }
    else{
        if(isset($_POST["descripcion"]) && isset($_POST["id"])  && isset($_POST["item"]))
        {
            $query="call pa_actualiza_cargo('".$_POST["id"]."','".$_POST["descripcion"]."','".$_POST["item"]."',0,'".$_SESSION['usuario']."')";
            if($resultado = $conexionp->query($query))
            {
            ?>
                <script language="javascript">
                    window.opener.document.location.reload();
                    self.close();
                </script>
            <?php
            }
            else
            {
            $error= "Fallo la insercion de datos: (" . $conexionp->errno . ") " . $conexionp->error;
            ?>
            <script language="javascript">
                history.back(-1);
                alert("<?php echo $error; ?>");
            </script>
            <?php
            }
            
            mysqli_close($conexionp);
        }
        else{
            ?>
            <script language="javascript">
                history.back(-1);
                alert("No se introdujeron todos los datos");
            </script>
            <?php
        }
    }
    
?>