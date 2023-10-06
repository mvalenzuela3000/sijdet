<?php
	//include_once '../conexion.php';
	include_once '../includes/config.php';
    include_once '../includes/funj.php';
    $cn = mysqli_connect(HOST, USER, PASSWORD, DATABASEJ);
	function obtiene_desc_jornadas($gestion,$cn)
	{
		$query="select descripcion from ges_jornadas where gestion=$gestion";
		$resultado= $cn->query($query);
		if($fila2 = $resultado->fetch_array())
		{
			$valor=$fila2[0];
		}
		return $valor;
	}
	function formato_fecha($fecha)
	{
		$tfini=explode('/',$fecha);
		$tempfini=$tfini[2].'-'.$tfini[1].'-'.$tfini[0];
		return $tempfini;
	}
	function extension1($filename)
	{
		$ext1= substr(strrchr($filename, '.'), 1);
		return $ext1;
	}
	function normaliza ($cadena){
		$originales = 'Ã€Ã�Ã‚ÃƒÃ„Ã…Ã†Ã‡ÃˆÃ‰ÃŠÃ‹ÃŒÃ�ÃŽÃ�Ã�Ã‘Ã’Ã“Ã”Ã•Ã–Ã˜Ã™ÃšÃ›ÃœÃ�Ãž
		ÃŸÃ Ã¡Ã¢Ã£Ã¤Ã¥Ã¦Ã§Ã¨Ã©ÃªÃ«Ã¬Ã­Ã®Ã¯Ã°Ã±Ã²Ã³Ã´ÃµÃ¶Ã¸Ã¹ÃºÃ»Ã½Ã½Ã¾Ã¿Å”Å•';
		$modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
		bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
		$cadena = utf8_decode($cadena);
		$cadena = strtr($cadena, utf8_decode($originales), $modificadas);
		$cadena = strtolower($cadena);
		$cadena=preg_replace('[\s+]','',$cadena);
		return utf8_encode($cadena);
	}
	
	$descjornadas=obtiene_desc_jornadas(date("Y"),$cn);
	$nombres=trim(strtoupper($_POST["name"]));
	$apellidos=trim(strtoupper($_POST["apellido"]));
	$ci=$_POST["number"];
	$extension=$_POST["extension"];
	$correo=trim(strtoupper($_POST["email"]));
	$pais=1;
	$fono=0;
	$otraprof='';
	$prof=0;
	$contadorregistrados=0;
    $contador=0;
	
	 /* conexion*/
    $query1="select count(*) from registrados where ci='".$ci."'";
    $resultado1 = $cn->query($query1);
    $row1 = mysqli_fetch_row($resultado1);
    $contadorregi=$row1[0];
    if($contadorregi>0){//si ya está registrado
        //verifico si ya está inscrito
        $query1="select count(*) from inscritos where ci='".$ci."' and gestion=year(now())";
        $resultado1 = $cn->query($query1);
        $row1 = mysqli_fetch_row($resultado1);
        $contadorinscri=$row1[0];
        if($contadorinscri>0){//si ya esta inscrito en la jornada
            ?>
            <script language="javascript">
                alert("La persona ya se encuentra inscrita.");
                history.back(-1);
            </script>
            <?php
            exit ;
        }
        else{//registro la inscripción
            $valor=$ci.date("Y");	
            $cod= substr(hash_hmac("sha512", $valor, VALORENC), 1,20);
            $c="INSERT INTO inscritos (ci,f_inscripcion,gestion,ip,estado,id_pago,id_tipo_inscrito,ruta_comprobante,cod_inscripcion,observaciones,correlativo)
                 VALUES ('".$ci."',now(),'".date("Y")."','".$_SERVER['REMOTE_ADDR']."',1,'123123123',1,'','".$cod."','','".obtiene_siguiente_correlativo_inscripcion()."')";
            if($resultado = $cn->query($c))
            {	
                $contador++;
            }else{
                ?>
                <script language="javascript">
                    alert("No se pudo inscribir a la persona, contáctese con sistemas.");
                    history.back(-1);
                </script>
                <?php
                exit ;
            }
        }
    }else{//si no esta registrado primero registro y luego inscribo

        $nombrecompleto=$nombres.' '.$apellidos;
        $cr="INSERT INTO registrados (nombres, apellidos, ci, extension, email, dpto, profesion, otraprofesion, estado, ruta_matricula,f_update,ip_registro, fono, password, nit, razonsocial, institucion, otrainstitucion, id_pais)                           
            VALUES ('".$nombres."','".$apellidos."','".$ci."',$extension,'".$correo."',$extension,0,'',1,'',now(),'".$_SERVER['REMOTE_ADDR']."',0,'1e272ed5a01ad2bb6a396f269428e307','".$ci."','".$nombrecompleto."',0,'EGPP',1)";
        if($resultado = $cn->query($cr))//si se ha insetado el nuevo registro
        {	
            $contadorregistrados++;
            //ahora registramos la inscripción
            $valor=$ci.date("Y");	
            $cod= substr(hash_hmac("sha512", $valor, VALORENC), 1,20);
            $c="INSERT INTO inscritos (ci,f_inscripcion,gestion,ip,estado,id_pago,id_tipo_inscrito,ruta_comprobante,cod_inscripcion,observaciones,correlativo)
                VALUES ('".$ci."',now(),'".date("Y")."','".$_SERVER['REMOTE_ADDR']."',1,'123123123',1,'','".$cod."','','".obtiene_siguiente_correlativo_inscripcion()."')";
            if($resultado = $cn->query($c))
            {	
                $contador++;
            }else{
                ?>
                <script language="javascript">
                    alert("No se pudo inscribir a la persona, contáctese con sistemas.");
                    history.back(-1);
                </script>
                <?php
                exit ;
            }
        }else{
            ?>
                <script language="javascript">
                    alert("No se pudo registrar a la persona, contáctese con sistemas.");
                    history.back(-1);
                </script>
                <?php
                exit ;
        }
    }
    ?>
    <script language="javascript">
        alert("Registro exitoso.");
        location.href = "../FormInscripcionEGPP.php"; 
    </script>
    <?php
?>
