<?php
/*
 * Add enctype in the form to enctype="multipart/form-data"
 * Add type="file" field in the form
 * 
 * $_FILES 
 * Check tipo de imagen y tamaño < 250KB.
 * 
 * carpeta temporal --> movemos a carpeta definitiva
 * 
 * move_uploaded_file(nombre_fichero_temporal,ruta_destino_con_nombre_definitivo)
 * 
 * pathinfo
 * 
 * file_exists()
 * 
 * Acordarse de poner permisos RWX para el grupo en la carpeta de fotos: (RUTA_FOTOS)
 * 
 * Ejemplo de Array $_FILES:
  (
  [mifichero] => Array
  (
  [name] => the-killers18347.jpg
  [type] => image/jpeg
  [tmp_name] => /var/www/clients/client2/web2/tmp/phpJhP9rI
  [error] => 0
  [size] => 630922  (en bytes).
  )

  )
 * 

  echo "<pre>";
  print_r($_FILES);
  echo "</pre>";
 */


// Tamaño máximo permitido en KB.
$maximo = 256;

if (!empty($_FILES))
{
	if ($_FILES['mifichero']['size'] / 1024 <= $maximo)
	{
		if ($_FILES['mifichero']['type'] == 'image/jpeg')
		{

			$nombrefinal = md5("semillakillerblog" . $_SESSION['nickname']) . ".jpg";
			// Movemos el fichero temporal a su ruta definitiva.
			if (move_uploaded_file($_FILES['mifichero']['tmp_name'], RUTA_FOTOS . $nombrefinal))
			{
				echo "Your picture has been updated successfully.";
				echo "<br/><br/><a href='index.html'>If you don't see the picture updated click here.</a>";
			}
		}
		else
		{
			echo "ERROR: Your file format is not JPG.";
		}
	}
	else
		echo "ERROR: Your file size " . round($_FILES['mifichero']['size'] / 1024) . " KB exceeds the maximum size allowed of $maximo KB. ";
}
else
{
	?>
	<h2>Upload picture to your profile</h2>
	<form action="" method="post" enctype="multipart/form-data"> 
		<fieldset>
			<label for="mifichero">Picture:</label>
			<input name="mifichero" type="file"> 
			<br/><br/>
			<input type="submit" value="Send Picture..."> 
		</fieldset>
	</form>

	<?php
}
?>