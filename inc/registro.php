<link rel="stylesheet" type="text/css" href="css/registro.css" />
<?php

// Información sobre cómo validar un formulario en PHP en cuanto a temas de seguridad.
// MUY RECOMENDABLE: http://www.w3schools.com/php/php_form_validation.asp
// Expresiones regulares: http://webcheatsheet.com/php/regular_expressions.php
// Si quieres usar code-folding escribe [fcom] y pulsa [TAB]
// <editor-fold defaultstate="collapsed" desc="Función depurar">
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
// Otra forma puede ser:
$errores = array();

if ( $_SERVER['REQUEST_METHOD'] == "POST" ) // estamos recibiendo datos por POST
{ // Aqui dentro validaremos todo y grabaremos en la base de datos.


	// Primero depuramos los campos, luego los validaremos.
	//$_POST['nickname']=depurar($_POST['nickname']);
	foreach ($_POST as $clave => $valor)
	{
		$_POST[$clave] = depurar($valor);
	}

	// Como todos los campos son de texto podemos comprobar rápidamente que todos los campos tengan datos.
	// Damos por supuesto que todos los campos en el formulario son obligatorios.
	foreach ($_POST as $clave => $valor)
	{
		if ( empty($valor) )
			$errores[] = "The field $clave is mandatory.";
	}

	// Comenzamos la validación usando expresiones regulares.

	// Validación del nickname. min 4 caracteres y máximo 20.
	// letras y números y no caracteres especiales.
	if ( !preg_match('/^[a-zA-Z0-9_\-]{4,20}$/', $_POST['nickname']) )
	{
		$errores[] = 'The nickname should have minimum 4 characters and maximum 20. No speciall characters allowed.';
	}

	// El nombre = que nickname y máximo 20 caracteres.
	if ( !preg_match('/^[a-zA-Z0-9_\- ]{4,20}$/', $_POST['name']) )
	{
		$errores[] = 'The name should have maximum 20 chars. No special characters allowed.';
	}
	// Los apellidos = que nickname y máximo 100 caracteres.
	if ( !preg_match('/^[a-zA-Z0-9_\- ]{4,100}$/', $_POST['surname']) )
	{
		$errores[] = 'The surname should have maximum 100 chars. No special characters allowed.';
	}

	// La contraseña debe contener de 6 a 15 caracteres (cualquier tipo de caracter), al menos 1 letra minúscula, 1 Mayúscula, al menos 1 número
	// Check your expressions at: http://www.phpliveregex.com/
	

	
	
	
	
	// Validar e-mail
	if ( !preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $_POST['email']) )
	{
		$errores[] = 'The e-mail address doesn\'t have a valid format.';
	}

	// Validar fecha que sea en formato dd/mm/aaaa
	// <editor-fold defaultstate="collapsed" desc="DIV Errores.">
	// Mostramos a continuación el contenedor errores y cubrimos su contenido con el array de errores.
	echo '<div class="errores"><ul>';
	for ($i = 0; $i < count($errores); $i++)
		echo "<li>{$errores[$i]}</li>";
	echo '</ul></div>';
	// </editor-fold>
	// <editor-fold defaultstate="collapsed" desc="Ejemplo impresión del contenido de $_POST">
	/* Forma de imprimir el contenido de un $_POST formateado:
	  echo "<pre>";
	  print_r($_POST);
	  echo "</pre>";
	 */
	// </editor-fold>

	// Comprobamos si hay errores o no, y si está todo OK insertamos en la tabla.
	if (count($errores)==0)
	{
		// Insertamos en la tabla.
		// Preparamos la SQL.
		$sql=sprintf("insert into users(nickname,name,surname,password,email,birthday,datecreated,ipaddress,privilege) values('%s','%s','%s','%s','%s','%s','%s','%s',%b)",$_POST['nickname'],$_POST['name'],$_POST['surname'],encriptar($_POST['password']),$_POST['email'],cambiaf_mysql($_POST['birthday']),time(),$_SERVER['REMOTE_ADDR'],1);
		
		// Ejecutamos la consulta.
		mysql_query($sql,$conexion) or die(mysql_error());
		
		// Mostramos mensaje
		echo "Datos insertados correctamente";
	}
}
if (count($errores)!=0 || empty($_POST)) // Mostramos el formulario.
{
?>
<form class="formulario" action="" method="post" autocomplete="off">
	<ul>
		<li>
			<h2>Registration Form</h2>
		</li>
		<li>
			<label for="nickname">Nickname:</label>
			<input type="text" name="nickname" id="nickname" placeholder="nickname" autofocus size="10" maxlength="20" value="<?php if ( !empty($_POST['nickname']) ) echo $_POST['nickname']; ?>"/>
		</li>
		<li>
			<label for="name">Name:</label>
			<input type="text" name="name" id="name" placeholder="Your name" size="10" maxlength="20" value="<?php if ( !empty($_POST['name']) ) echo $_POST['name']; ?>"/>
		</li>
		<li>
			<label for="surname">Surname:</label>
			<input type="text" name="surname" id="surname" placeholder="Your surname here" size="20" maxlength="100" value="<?php if ( !empty($_POST['surname']) ) echo $_POST['surname']; ?>"/>
		</li>
		<li>
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" size="10" maxlength="15" value="<?php if ( !empty($_POST['password']) ) echo $_POST['password']; ?>"/>
		</li>
		<li>
			<label for="email">E-mail address:</label>
			<input type="text" name="email" id="email" placeholder="test@info.local" size="20" maxlength="50" value="<?php if ( !empty($_POST['email']) ) echo $_POST['email']; ?>"/>
		</li>
		<li>
			<label for="birthday">Birthday:</label>
			<input type="date" name="birthday" id="birthday" />
		</li>
		<!--- ESTA SECCIÓN SE UTILIZARÁ PARA VALIDAR EN CLASE DE DWEC --->





		<!--- ESTA SECCIÓN SE UTILIZARÁ PARA VALIDAR EN CLASE DE DWEC --->
		<li>
			<input type="reset" class="controles" value="Reset" />
			<input type="submit" class="controles" value="Sign Up" />
		</li>
	</ul>
</form>
<?php
}
?>