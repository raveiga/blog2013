<?php
session_destroy();
// Se puede comprobar si se han enviado cabeceras previamente al navegador con: headers_sent()
// will return FALSE if no HTTP headers have already been sent, or TRUE otherwise.
header("location: index.html");

// Si da algún tipo de error, activar las sesiones antes con session_start()
// mover el fichero a la carpeta web
// Y en la cabecera modificar el enlace por logout.php en lugar de logout.html
?>