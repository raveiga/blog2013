<?php

if (!empty($_GET['ck']))
{
	// Consulta de actualización.
	$sql = sprintf("update users set checking='OK' where checking='%s'", $_GET['ck']);
	mysql_query($sql, $conexion) or die(mysql_error());

	if (mysql_affected_rows() != 0) // Si hubo filas afectadas.
	{
		echo "Enhorabuena!!<br/>Su e-mail ha sido validado correctamente.<br/><br/>Ya puede acceder con su nick y contraseña en el Blog.";
	}
	else
		echo "ERROR: El código de validación es incorrecto, o su e-mail ya fue validado anteriormente.";
}
else
	echo "ERROR: El código de validación es incorrecto, o su e-mail ya fue validado anteriormente.";
?>