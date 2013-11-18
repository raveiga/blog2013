<link rel="stylesheet" type="text/css" href="css/registro.css" />
<?php
// Información sobre cómo validar un formulario en PHP en cuanto a temas de seguridad.
// MUY RECOMENDABLE: http://www.w3schools.com/php/php_form_validation.asp

// Expresiones regulares: http://webcheatsheet.com/php/regular_expressions.php

// VALIDACIÓN DE LOS DATOS DEL FORMULARIO AQUI.




?>
<form class="formulario" action="" method="post" autocomplete="off">
	<ul>
		<li>
			<h2>Registration Form</h2>
		</li>
		<li>
			<label for="nickname">Nickname:</label>
			<input type="text" name="nickname" id="nickname" placeholder="nickname" required autofocus size="10" maxlength="20" value=""/>
		</li>
		<li>
			<label for="name">Name:</label>
			<input type="text" name="name" id="name" placeholder="Your name" required size="10" maxlength="20" value=""/>
		</li>
		<li>
			<label for="surname">Surname:</label>
			<input type="surname" name="surname" id="surname" placeholder="Your surname here" required size="20" maxlength="100" value=""/>
		</li>
		<li>
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" required size="10" maxlength="130" value=""/>
		</li>
		<li>
			<label for="email">E-mail address:</label>
			<input type="email" name="email" id="email" placeholder="test@info.local" required size="20" maxlength="30" value=""/>
		</li>
		<li>
			<label for="birthday">Birthday:</label>
			<input type="date" name="birthday" id="birthday" value=""/>
		</li>
		<!--- ESTA SECCIÓN SE UTILIZARÁ PARA VALIDAR EN CLASE DE DWEC --->





		<!--- ESTA SECCIÓN SE UTILIZARÁ PARA VALIDAR EN CLASE DE DWEC --->
		<li>
			<input type="reset" class="controles" value="Reset" />
			<input type="submit" class="controles" value="Sign Up" />
		</li>
	</ul>
</form>