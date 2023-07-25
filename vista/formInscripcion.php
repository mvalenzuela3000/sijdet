<?php
	$valor=45;
	$texto='Marcelo Rules!!!!';
?>
<style>
<!--
#encabezado {padding:10px 0; border-top: 1px solid; border-bottom: 1px solid; width:100%; }
#encabezado .fila #col_1 {width: 15%}
#encabezado .fila #col_2 {text-align:center; width: 55%}
#encabezado .fila #col_3 {width: 15%}
#encabezado .fila #col_4 {width: 15%}
 
#encabezado .fila td img {width:50%}
#encabezado .fila #col_2 #span1{font-size: 15px;}
#encabezado .fila #col_2 #span2{font-size: 12px; color: #4d9;}
 
#footer {padding-top:5px 0; border-top: 1px solid; width:100%;}
#footer .fila td {text-align:center; width:100%;}
#footer .fila td span {font-size: 10px; color: #f5a;}
 
-->
</style>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="20mm">
    <page_header>
        <table id="encabezado">
            <tr class="fila" >
                <td id="col_1" >
                    <img src="../images/img_izq.png">
                </td>
                <td id="col_2">
                    <span id="span1">Aqu� pueden ir m�s span o divs seg�n requiera el dise�o</span>
                    <br>
                    <span id="span2">Este es otro span con otros estilos</span>
                </td>
                <td id="col_3">
                    <img  src="../images/img_der_1.png">
                </td>
                <td id="col_4">
                    <img src="../images/img_der_2.png">
                </td>
            </tr>
        </table>
    </page_header>
 			
    <page_footer>
        <table id="footer">
            <tr class="fila">
                <td>
                    <span>Este el footer y pueder ir con letra m�s peque�a por ejemplo poner una
                    direcci�n o algo as� :P</span>
                </td>
            </tr>
        </table>
    </page_footer>
    <table id="central">
        <tr class="fila">
            <td>
                Es es un texto fijo que puede ir directamente dentro de la vista.
                Este texto está dentro de una tabla con una fila y una columna que tendra un color de fondo con
                background color azul para identificarlo. El texto esta justificado
                Con HTML2PDF las posiciones X, Y ya no serán un problema, ya que usando la tabla anterior con
                width a 100% esta tabla de texto con texto fijo se pone inmediatamente debajo. También podemos usar
                un padding arriba-abajo para separar. Si es necesario 'mover' podemos usar margin.
                <br><br>
                Aquí hubo un salto de línea con con el tag br y podemos poner span como en este texto que dice hola ->
                <span style="color:#f00">HOLA</span> y es de color rojo. El siguiente tr td mostrará los datos de la
                BD, tendrá un background
                <br><br>
                Cuando veas el código de este hoja, te darás cuenta que son simplemente tablas con tablas anidadas.
                Puedes usar divs si lo prefieres también, para mí se me facilita más con tablas
            </td>
        </tr>
 
        <tr>
            <td >
                <table id="datos">
                    <tr class="fila">
                        <td style="width:30%">
                            Nombre:
                        </td>
                        <td style="width:70%">
                            <?php echo $valor. ' '. $texto . ' '.$valor;?>
                        </td>
                    </tr>
                    <tr class="fila">
                        <td style="width:30%">
                            Matricula:
                        </td>
                        <td style="width:70%">
                            <?php //echo $datos[0]["matricula"];?>
                        </td>
                    </tr>
                    <tr class="fila">
                        <td style="width:30%">
                            Correo:
                        </td>
                        <td style="width:70%">
                            <?php //echo $datos[0]["correo"];?>
                        </td>
                    </tr>
                    <tr class="fila">
                        <td style="width:30%">
                            Edad:
                        </td>
                        <td style="width:70%">
                            <?php //echo $datos[0]["edad"];?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <br><br><br><br>
                <br><br><br><br>
                <br><br><br><br>
                <br>
              
                saltos de línea con el tag br
                <br><br>
                Acá podemos usar saltos y saltos de líneas, tantos como
                requiera tu diseño
            </td>
        </tr>
    </table>
 
</page>