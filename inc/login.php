<?php
// Comprobamos que estamos recibiendo un nickname.

if (!empty($_POST['nickname']))
{
	// Consulta para obtener los datos del usuarios
	$sql = sprintf("select * from users where nickname = '%s'", mysql_real_escape_string($_POST['nickname']));
	$recordset = mysql_query($sql, $conexion) or die(mysql_error());

	// Comprobamos si está validado el correo.
	if (mysql_num_rows($recordset) != 0)
	{
		$fila = mysql_fetch_assoc($recordset);
		if ($fila['checking'] == 'OK')
		{
			// Comprobamos que la contraseña es correcta, usando Crypt.
			if (crypt($_POST['password'], $fila['password']) == $fila['password'])
			{
				// Creamos variable de sesión. Las sesiones ya fueron inicializadas en el controlador.
				$_SESSION['nickname'] = $_POST['nickname'];

				// Redireccionamos a la página index.html
				header("location: index.html");
				
				// Si no funciona este método usar JavaScript.
				//echo "<script>document.location='index.html';</script>";
			} else
			{
				echo "ERROR: Sus datos de acceso son incorrectos.";
			}
		}
		else
			echo "Atención su e-mail no ha sido validado todavía.<br/><br/>Consulte su buzón de correo y valide su registro en el Blog.";
	}
	else
		echo "ERROR: Sus datos de acceso son incorrectos.";
}
?>
<link rel="stylesheet" type="text/css" href="css/registro.css" />
<form class="formulario" action="" method="post" autocomplete="off">
	<ul>
		<li>
			<h2>Sign In Form</h2>
		</li>
		<li>
			<label for="nickname">Nickname:</label>
			<input type="text" name="nickname" id="nickname" placeholder="nickname" autofocus size="10" maxlength="20" value="<?php if (!empty($_POST['nickname'])) echo $_POST['nickname']; ?>"/>
		</li>
		<li>
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" size="10" maxlength="15" value="<?php if (!empty($_POST['password'])) echo $_POST['password']; ?>"/>
		</li>
		<li>
			<input type="reset" class="controles" value="Reset" />
			<input type="submit" class="controles" value="Sign In" />
		</li>
	</ul>
</form>