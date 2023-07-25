<?php
function conectar()
{
	mysql_connect("localhost", "u_consulta", "u_consulta_ait");
	mysql_select_db("bd_usuario");
}

function desconectar()
{
	mysql_close();
}
?>