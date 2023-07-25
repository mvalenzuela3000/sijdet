<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        
       <script src="js/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <link href="css/jqueryui.css" type="text/css" rel="stylesheet"/>
       
        <script>
	       	$(document).ready(function(){ 	
				$( "#numdepo" ).autocomplete({
      				source: "buscardeposito.php",
      				minLength: 2
    			});
    			
    			$("#numdepo").focusout(function(){
    				$.ajax({
    					url:'depositos.php',
    					type:'POST',
    					dataType:'json',
    					data:{ deposito:$('#numdepo').val()}
    				}).done(function(respuesta){
    					$("#fechadep").val(respuesta.fechadepo);
    					$("#montodepo").val(respuesta.montodepo);
    				});
    			});    			    		
			});
        </script>
                    
    </head>
    <body>
        
       	<form action='prueba.php' method="post">
       		<label for="matricula">Deposito:</label>
	    	<input type="text" id="numdepo" name="numdepo" value=""/>
		    <label for="nombre">Fecha:</label>
		    <input type="text" id="fechadep" name="fechadep" readonly="readonly" value=""/>
		    <label for="paterno">Monto:</label>
    		<input type="text" id="montodepo" name="montodepo" readonly="readonly" value=""/>
    		<input type="submit" value="Registrar"/>
		</form>
    </body>
</html>