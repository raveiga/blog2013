<link rel="stylesheet" type="text/css" href="css/registro.css" />
<?php

// Información sobre cómo validar un formulario en PHP en cuanto a temas de seguridad.
// MUY RECOMENDABLE: http://www.w3schools.com/php/php_form_validation.asp
// Expresiones regulares: http://webcheatsheet.com/php/regular_expressions.php
// Si quieres usar code-folding escribe [fcom] y pulsa [TAB]
// <editor-fold defaultstate="collapsed" desc="function depurar($data)">
function depurar($data)
{
	$data = trim($data); // Elimina espacios al principio y final.
	//$data = stripslashes($data); // Elimina las barras de escape
	$data = htmlspecialchars($data); // Convierte los caracteres HTML a su literal correspondiente.
	return $data;
}

// </editor-fold>
// VALIDACIÓN DE LOS DATOS DEL FORMULARIO AQUI.
// Para comprobar si estamos recibiendo datos del formulario se puede utilizar:
// if (!empty($_POST)) // estamos recibiendo datos por POST
// empty() es esencialmente el equivalente conciso de !isset($var) || $var == false.
// Inicializamos el array de errores.
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == "POST") // estamos recibiendo datos por POST
{	// Aqui dentro realizaremos la actualización de los datos y validaciones.
	// Primero depuramos los campos, luego los validaremos.
	//$_POST['nickname']=depurar($_POST['nickname']);
	foreach ($_POST as $clave => $valor)
	{
		// Mediante la función depurar estamos evitando inyección XSS. (Cross Site Scripting).
		$_POST[$clave] = depurar($valor);
	}

	// Como todos los campos son de texto podemos comprobar rápidamente que todos los campos tengan datos.
	// Damos por supuesto que todos los campos en el formulario son obligatorios.
	foreach ($_POST as $clave => $valor)
	{
		if (empty($valor))
			$errores[] = "The field <strong>$clave</strong> is mandatory.";
	}

	// El nombre = que nickname y máximo 20 caracteres.
	if (!preg_match('/^[a-zA-Z0-9_\- ]{4,20}$/', $_POST['name']))
	{
		$errores[] = 'The <strong>name</strong> should have maximum 20 chars. No special characters allowed.';
	}
	// Los apellidos = que nickname y máximo 100 caracteres.
	if (!preg_match('/^[a-zA-Z0-9_\- ]{4,100}$/', $_POST['surname']))
	{
		$errores[] = 'The <strong>surname</strong> should have maximum 100 chars. No special characters allowed.';
	}

	// La contraseña debe contener de 6 a 15 caracteres (cualquier tipo de caracter), al menos 1 letra minúscula, 1 Mayúscula, al menos 1 número
	// Check your expressions at: http://www.phpliveregex.com/
	// Have a look at: http://www.rexegg.com/ for more info!!.
	if (!preg_match('/(?=^[\w\W]{6,8}$)(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d).*/', $_POST['password']))
	{
		$errores[] = '<strong>Password</strong> requirements not accomplished. Minimum 6 characters, 1 Capital Letter, 1 regular letter, 1 number';
	}

	// <editor-fold defaultstate="collapsed" desc="Mostramos el DIV con los errores.">
	// Mostramos a continuación el contenedor errores y cubrimos su contenido con el array de errores.
	echo '<div class="errores"><ul>';
	for ($i = 0; $i < count($errores); $i++)
		echo "<li>{$errores[$i]}</li>";
	echo '</ul></div>';
	// </editor-fold>
	// Comprobamos si hay errores o no, y si está todo OK insertamos en la tabla.
	if (count($errores) == 0)
	{
		$validacion = md5($_POST['nickname'] . time() . $_SERVER['REMOTE_ADDR']);
		// Insertamos en la tabla.
		// Preparamos la SQL.
		// Utilizamos mysql_real_escape_string() para escapar aquellos caracteres susceptibles de inyección MySQL.
		$sql = sprintf("insert into users(name,surname,password,birthday,datecreated,ipaddress,privilege) values(%s','%s','%s','%s','%s',%b,'%s')", mysql_real_escape_string($_POST['name']), mysql_real_escape_string($_POST['surname']), encriptar($_POST['password']), cambiaf_mysql($_POST['birthday']), time(), $_SERVER['REMOTE_ADDR'], 1);

		// Ejecutamos la consulta.
		mysql_query($sql, $conexion) or die(mysql_error());
	}
}
if (count($errores) != 0 || empty($_POST)) // Mostramos el formulario.
{
	
	// Obtenemos los datos del usuario conectado.
	$sql=sprintf("select * from users where nickname='%s'",$_SESSION['nickname']);
	$recordset=mysql_query($sql,$conexion) or die(mysql_error());
	$fila=mysql_fetch_assoc($recordset);
	?>
	<form class="formulario" action="" method="post" autocomplete="off">
		<ul>
			<li>
				<h2>User Profile</h2>
			</li>
			<li>
				<label for="nickname">Nickname:</label>
				<input type="text" name="nickname" id="nickname" placeholder="nickname"  size="10" maxlength="20" disabled value="<?php echo $fila['nickname']; ?>"/>
			</li>
			<li>
				<label for="name">Name:</label>
				<input type="text" name="name" id="name" placeholder="Your name" size="10" maxlength="20" value="<?php if (!empty($_POST['name'])) echo $_POST['name'];  ?>"/>
			</li>
			<li>
				<label for="surname">Surname:</label>
				<input type="text" name="surname" id="surname" placeholder="Your surname here" size="20" maxlength="100" value="<?php if (!empty($_POST['surname'])) echo $_POST['surname']; ?>"/>
			</li>
			<li>
				<label for="password">Password:</label>
				<input type="password" name="password" id="password" size="10" maxlength="15" value="<?php if (!empty($_POST['password'])) echo $_POST['password']; ?>"/>
				<input type="hidden" name="oldpassword" id="oldpassword" size="10" maxlength="15" value="<?php if (!empty($_POST['password'])) echo $_POST['password']; ?>"/>
			</li>
			<li>
				<label for="email">E-mail address:</label>
				<input type="email" name="email" id="email" placeholder="test@info.local" size="20" maxlength="50" disabled value="<?php if (!empty($_POST['email'])) echo $_POST['email']; ?>"/>
			</li>
			<li>
				<label for="birthday">Birthday:</label>
				<input type="date" name="birthday" id="birthday" value="<?php if (!empty($_POST['birthday'])) echo $_POST['birthday']; ?>"/>
			</li>
			<li>
				<input type="reset" class="controles" value="Reset" />
				<input type="submit" class="controles" value="Update" />
			</li>
		</ul>
	</form>
	<?php
}
?>