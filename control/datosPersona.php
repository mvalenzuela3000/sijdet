<?php
    
    function datos($id){
        include '../conexion.php';
        $id=base64_decode($id);
        $query="call pa_obtiene_personas('".$id."')";
        if (mysqli_multi_query($conexionp, $query)) {
            do {
                /* store first result set */
                if ($result = mysqli_store_result($conexionp)) {
                    while ($row = mysqli_fetch_row($result)) {
                        $data=array(0=>$row[0],1=>$row[1],2=>$row[2],3=>$row[3],4=>$row[4],5=>$row[5],6=>$row[6],7=>$row[7],8=>$row[8],9=>$row[9],10=>$row[10],11=>$row[11],12=>$row[12]);
                    }
                        mysqli_free_result($result);
                    }
        
            } while (mysqli_next_result($conexionp));
        }
        else{
            $data='';
        } 
        return $data;
    }
    
?>
