<?php 
    include '../conexion.php';
    
    
    $queja=$_POST["queja"];
    
    $prueba1des="";
    $prueba2des="";
    $prueba3des="";

    $file1nom="";
    $file2nom="";
    $file3nom="";
    $file1tam=0;
    $file2tam=0;
    $file3tam=0;
   
         
     $prueba1des=$_POST["prueba1des"];
	 if($prueba1des<>''){
	 	$file1nom=$_FILES["file-1"]["name"];
     	$file1tam=$_FILES["file-1"]["size"];
	 }
	 else
	 {
	 	$file1nom='';
     	$file1tam=0;
	 }
     $prueba2des=$_POST["prueba2des"];
	 if($prueba2des<>''){
	 	$file2nom=$_FILES["file-2"]["name"];
     	$file2tam=$_FILES["file-2"]["size"];
	 }
	 else
	 {
	 	$file2nom='';
     	$file2tam=0;
	 }
 	$prueba3des=$_POST["prueba3des"];
	 if($prueba3des<>''){
	 	$file3nom=$_FILES["file-3"]["name"];
     	$file3tam=$_FILES["file-3"]["size"];
	 }
	 else
	 {
	 	$file3nom='';
     	$file3tam=0;
	 }

    
     if(valida_tamano($file1tam,$file2tam,$file3tam)!=1)
     {
         ?>
                     <script language="javascript">
                     history.back(-1);
                     alert("El tama\u00F1o de los archivos no debe exceder en conjunto a 10 MB");
                     </script>
                 <?php 
     	exit;
	 }
 
    
    $anonimo=$_POST["anonimo"];
    $oficina=$_POST["oficina"];
	$noadjuntos=$_POST["noadjuntos"];
	$nombreservidor=$_POST["nombreservidor"];
	$cargoservidor=$_POST["cargoservidor"];
	$indpersona=$_POST["indpersona"];
	

    
    
    if($anonimo==1)
    {
        if(empty($_POST["fullname"]) || empty($_POST["ci"]) || empty($_POST["tel"]) || empty($_POST["email"]) || empty($_POST["direccion"]))
        {?>
            <script language="javascript">
                         history.back(-1);
                         alert("Los campos de Nombres, Documento de identidad, Telefono/celular, Correo electronico o Direccion no pueden estar vacios, por favor verifique");
            </script>
        <?php 
        exit;
        }
        else
        {
            $fullname=$_POST["fullname"];
            $ci=$_POST["ci"];
            $tel=$_POST["tel"];
            $email=$_POST["email"];
            $direccion=$_POST["direccion"];
            $reserva=$_POST["reserva"];
        }
    }
    else
    {
        $fullname="";
        $ci=null;
        $tel=null;
        $email="";
        $direccion="";
        $reserva=2;
    }
  
    $query = "CALL pa_obtener_id()";
    
    if (mysqli_multi_query($conexion, $query)) {
        do {
         
            if ($result = mysqli_store_result($conexion)) {
                while ($row = mysqli_fetch_row($result)) {
                    $id=$row[0];
                }
                mysqli_free_result($result);
            }
    
        } while (mysqli_next_result($conexion));
    }
    
    if($file1nom<>"" || $file2nom<>"" || $file3nom <>"")
    {
        $anio=explode('/',date('d/m/Y'));
        $destination_path = "/var/www/html/transparencia/documentos";
        //$destination_path = "../documentos";
        $ruta=$destination_path.'/'.$anio[2];
        $ruta.="_".$id;

        if($file1nom<>"")
        {
            $target_path=$ruta.'_'.$file1nom;
            $ds_inf=basename($_FILES['file-1']['name']);
            $ds1_inf=$_FILES['file-1']['tmp_name'];
            $ext_inf=extension1($ds_inf);
           // $target_path.=".".$ext_inf;
            
            if(move_uploaded_file($_FILES['file-1']['tmp_name'], normaliza($target_path)))
            {
    
                    ?>
            		<script language="javascript">
            			alert("Prueba 1 cargada exitosamente.");
            			//history.back(-1);
            		</script>
            				<?php
            }
            else
            {
               
            		?>
            		<script language="javascript">
            		history.back(-1);
        			 alert("Surgio un error intentelo de nuevo por favor.");
          				
        			</script>
        						<?php
        			exit;
            }
                
          }
          if($file2nom<>"")
          {
              $target_path=$ruta.'_'.$file2nom;
              $ds_inf=basename($_FILES['file-2']['name']);
              $ds1_inf=$_FILES['file-2']['tmp_name'];
              $ext_inf=extension1($ds_inf);
              // $target_path.=".".$ext_inf;
          
              if(move_uploaded_file($_FILES['file-2']['tmp_name'], normaliza($target_path)))
              {
               
                  ?>
              		<script language="javascript">
              			alert("Prueba 2 cargada exitosamente.");
              			//history.back(-1);
              		</script>
              				<?php
              }
               else
               {
					?>
					<script language="javascript">
					history.back(-1);
					alert("Surgio un error intentelo de nuevo por favor.");
						
					</script>
					<?php
					exit;
               }
                          
          }
          if($file3nom<>"")
          {
              $target_path=$ruta.'_'.$file3nom;
              $ds_inf=basename($_FILES['file-3']['name']);
              $ds1_inf=$_FILES['file-3']['tmp_name'];
              $ext_inf=extension1($ds_inf);
              // $target_path.=".".$ext_inf;
          
              if(move_uploaded_file($_FILES['file-3']['tmp_name'], normaliza($target_path)))
              {
                
                  ?>
                   		<script language="javascript">
                   			alert("Prueba 3 cargada exitosamente.");
                    			//history.back(-1);
                    	</script>
                  <?php
              }
              else
              {
        			?>
					<script language="javascript">
					history.back(-1);
						alert("Surgio un error intentelo de nuevo por favor.".);
						
					</script>
					<?php
					exit;
              }
                                    
          }
            			
     }
    
    
    $query="call pa_inserta_queja('".$queja."','".$anonimo."','".$fullname."','".$ci."','".$tel."','".$email."','".$direccion."','".$reserva."','".$prueba1des."','".normaliza($file1nom)."','".$file1tam."','".$prueba2des."','".normaliza($file2nom)."','".$file2tam."','".$prueba3des."','".normaliza($file3nom)."','".$file3tam."','".$oficina."','".$noadjuntos."','".$nombreservidor."','".$cargoservidor."','".$indpersona."')";
    if($resultado = $conexion->query($query))
    {
        
        
        $gestion=date('Y');
        $link="http://www.ait.gob.bo/transparencia/FormQuejaBuzon.php?1d=".base64_encode($id)."&g35=".base64_encode($gestion).""; //para desarrolllo 
        $subject = "Correo desde Página de quejas ";
        $body = "<b>Ha llegado una nueva queja desde la P&aacute;gina WEB</b><br><br>".
            "<br><br>ID: <strong>$id</strong><br>".
            "<br><br>Gesti&oacute;n: <strong>$gestion</strong><br>".
            "<br><br>Link: <strong>$link</strong><br><br>";
            	
        
            require 'class.phpmailer.php';
            require 'class.smtp.php';
            	
	try {
	    require_once '../includes/codigo.php';
	
			
			//Crear una instancia de PHPMailer
			$mail = new PHPMailer();
			//Definir que vamos a usar SMTP
			$mail->IsSMTP();
			//Esto es para activar el modo depuración. En entorno de pruebas lo mejor es 2, en producción siempre 0
			// 0 = off (producción)
			// 1 = client messages
			// 2 = client and server messages
			$mail->SMTPDebug  = 0;
			//Ahora definimos gmail como servidor que aloja nuestro SMTP
			$mail->Host       = 'mail.ait.gob.bo';
			//Tenemos que usar gmail autenticados, así que esto a TRUE
			$mail->SMTPAuth   = true;
			//Definimos la cuenta que vamos a usar. Dirección completa de la misma
			$mail->Username   = USERMAIL;
			//Introducimos nuestra contraseña de gmail
			$mail->Password   = PASSMAIL;
			
			//Definmos la seguridad como TLS
			$mail->SMTPSecure = 'tls';
			//El puerto será el 587 ya que usamos encriptación TLS
			$mail->Port       = 587;
		
			//Definimos el remitente (dirección y, opcionalmente, nombre)
			$mail->setFrom(USERMAIL,'TRANSPARENCIA AIT');
			
			if($email!="")
			{
			    //Esta línea es por si queréis enviar copia a alguien (dirección y, opcionalmente, nombre)
			 
			    $mail->addAddress($email, 'Registro Queja');
			}
			
			//Y, ahora sí, definimos el destinatario (dirección y, opcionalmente, nombre)
			$mail->addAddress('transparencia@ait.gob.bo', 'Transparencia');
			//Definimos el tema del email
			$mail->Subject =$subject;
			//Para enviar un correo formateado en HTML lo cargamos con la siguiente función. Si no, puedes meterle directamente una cadena de texto.
			//$mail->MsgHTML(file_get_contents('correomaquetado.html'), dirname(ruta_al_archivo));
			$mail->MsgHTML($body);
            $mail->IsHTML(true); // Enviar como HTML
			//Y por si nos bloquean el contenido HTML (algunos correos lo hacen por seguridad) una versión alternativa en texto plano (también será válida para lectores de pantalla)
			$mail->AltBody = 'Queja registrada correctamente';
			$mail->Send();//Enviar
            
        } catch (phpmailerException $e) {
        echo $e->errorMessage();//Mensaje de error si se produciera.
        }
        	  
        
        
        ?>
                    <script language="javascript">
                    alert("Queja registrada exitosamente.");
                    location.href = "../FormRecepQuejas.php";
                    
                    </script>
                <?php
                
                
    }
    else
    {
        echo "FallÃ³ la inserciÃ³n de datos: (" . $conexion->errno . ") " . $conexion->error;
    }
     
                    
    mysqli_close($conexion);
        
    function extension1($filename)
    {
        $ext1= substr(strrchr($filename, '.'), 1);
        return $ext1;
    }   
        
    function valida_tamano($p1=0,$p2=0,$p3=0)
    {
        if($p1+$p2+$p3<=10000000)
            return true;
        else 
            return false;
    }
        
 
    function normaliza ($cadena){
        $originales = 'Ã€Ã�Ã‚ÃƒÃ„Ã…Ã†Ã‡ÃˆÃ‰ÃŠÃ‹ÃŒÃ�ÃŽÃ�Ã�Ã‘Ã’Ã“Ã”Ã•Ã–Ã˜Ã™ÃšÃ›ÃœÃ�Ãž
ÃŸÃ Ã¡Ã¢Ã£Ã¤Ã¥Ã¦Ã§Ã¨Ã©ÃªÃ«Ã¬Ã­Ã®Ã¯Ã°Ã±Ã²Ã³Ã´ÃµÃ¶Ã¸Ã¹ÃºÃ»Ã½Ã½Ã¾Ã¿Å”Å•';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuy
bsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        $cadena = strtolower($cadena);
        return utf8_encode($cadena);
    }

  
  
?>