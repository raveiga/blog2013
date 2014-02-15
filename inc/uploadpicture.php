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

if (!empty($_FILES)) {
	if ($_FILES['mifichero']['size'] / 1024 <= $maximo) {
		if ($_FILES['mifichero']['type'] == 'image/jpeg') {

			$nombrefinal = md5("semillakillerblog" . $_SESSION['nickname']) . ".jpg";
			// Movemos el fichero temporal a su ruta definitiva.
			if (move_uploaded_file($_FILES['mifichero']['tmp_name'], RUTA_FOTOS . $nombrefinal)) {
				// Una vez movida la redimensionamos y le ponemos marca de agua.
				// Ejemplo con texto.
				/*
				  $imagen=  imagecreatefromjpeg("../fotos/".$nombrefinal);
				  $nueva = imagecreatetruecolor(75,75);
				  imagecopyresized($nueva, $imagen, 0,0,0,0, 75,75, imagesx($imagen),imagesy($imagen));

				  $gris = imagecolorallocate($nueva, 255, 255, 255);
				  imagestring($nueva,3, 10, 60,"PHP Blog", $gris);
				  imagejpeg($nueva, RUTA_FOTOS.$nombrefinal,100);
				  imagedestroy($imagen);
				  imagedestroy($nueva);
				 */

				// Una vez movida la redimensionamos y le ponemos marca de agua.
				// Ejemplo con otra imagen.

				$imagen = imagecreatefromjpeg("../fotos/" . $nombrefinal);
				$logo = imagecreatefrompng("../web/img/logo-16.png");
				$nueva = imagecreatetruecolor(75, 75);

//bool imagecopyresized ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
				// Copiamos sobre la imagen nueva la imagen redimensionada
				imagecopyresized($nueva, $imagen, 0, 0, 0, 0, 75, 75, imagesx($imagen), imagesy($imagen));

				// Copiamos sobre la imagen nueva el logo en una esquina.
				imagecopyresized($nueva, $logo, 55, 55, 0, 0, imagesx($logo), imagesy($logo), imagesx($logo), imagesy($logo));
				imagejpeg($nueva, RUTA_FOTOS . $nombrefinal, 100);

				imagedestroy($imagen);
				imagedestroy($nueva);
				imagedestroy($logo);

				echo "Your picture has been updated successfully.";
				echo "<br/><br/><a href='index.html'>If you don't see the picture updated click here.</a>";
			}
		} else {
			echo "ERROR: Your file format is not JPG.";
		}
	} else
		echo "ERROR: Your file size " . round($_FILES['mifichero']['size'] / 1024) . " KB exceeds the maximum size allowed of $maximo KB. ";
}
else if (!empty($_POST['campofoto'])) {
	$nombrefinal = md5("semillakillerblog" . $_SESSION['nickname']) . ".jpg";
	define('UPLOAD_DIR', RUTA_FOTOS . $nombrefinal);
	$img = $_POST['campofoto'];
	// Sacamos data:image/png;base64,
	$img = str_replace('data:image/png;base64,', '', $img);

	// Sustituimos el ' ' por el símbolo +.
	$img = str_replace(' ', '+', $img);

	//Pasamos el formato ASCII recibido a binario.
	$data = base64_decode($img);
	$success = @file_put_contents(UPLOAD_DIR, $data);
	echo "Your drawing has been uploaded successfully.";
	echo "<br/><br/><a href='index.html'>If you don't see the picture updated click here.</a>";
} else {
	?>
	<h2>Upload picture to your profile.</h2>
	<form action="" method="post" enctype="multipart/form-data"> 
		<fieldset>
			<label for="mifichero">Picture:</label>
			<input name="mifichero" type="file"> 
			<br/><br/>
			<input type="submit" value="Send Picture..."> 
		</fieldset>
	</form>

	<style type="text/css">
		#coordenadas{
			display: inline;
		}
	</style>
	<script>
		// Canvas Tutorial:
		// https://developer.mozilla.org/en-US/docs/Web/Guide/HTML/Canvas_tutorial?redirectlocale=en-US&redirectslug=Canvas_tutorial
		// http://creativejs.com/2011/08/31-days-of-canvas-tutorials/
		window.addEventListener('load', function() {

			////////////////////////////////////////////////////////////////	
			////////////////////PROGRAMACION GRAFICA EN CANVAS HTML5 ////////
			////////////////////////////////////////////////////////////////
			marco = document.getElementById('marco');
			coordenadas = document.getElementById('coordenadas');

			// Creamos el contexto de dibujo.
			lienzo = marco.getContext('2d');

			// Definimos color, tipo brocha, y grosor por defecto.
			lienzo.strokeStyle = 'black';
			lienzo.lineJoin = 'round';
			lienzo.lineWidth = 2;

			pintar = false;
			marco.setAttribute('style', 'border: 1px solid black;');

			lienzo.fillStyle = "#FFFFFF";
			lienzo.fillRect(0, 0, marco.width, marco.height);

			//Programos el evento de click sobre los botones de colores.
			for (i = 0; i < document.getElementsByClassName('colores').length; i++)
			{
				document.getElementsByClassName('colores')[i].addEventListener('click', function() {
					lienzo.strokeStyle = this.id;
				});
			}

			// Método para limpiar el canvas con el botón de limpiar.
			document.getElementById('limpiar').addEventListener('click', function()
			{
				lienzo.clearRect(0, 0, marco.width, marco.height);
			});

			//Método para limpiar el canvas pulsando Alt + K
			document.body.addEventListener('keydown', function(mievento) {
				// alert(evento.keyCode);
				// 75 K
				// Cuando se pulse la tecla ALT y K

				if (mievento.altKey && mievento.keyCode == 75)
					lienzo.clearRect(0, 0, marco.width, marco.height);
			});

			//// MÁS EVENTOS DEL RATÓN //////
			// Poner la mano al pasar encima del canvas.
			marco.addEventListener('mouseover', function()
			{
				marco.style.cursor = 'pointer';
			});

			// Sacar la mano al salir del canvas.
			// No hace falta programarlo por que lo hace automáticamente.

			// Vamos a pintar con el botón del ratón pulsado (mousedown).
			marco.addEventListener('mousedown', function()
			{
				pintar = true;
				// Activamos el comienzo de dibujo de una línea.
				lienzo.beginPath();
			});

			// Vamos a pintar con el botón del ratón pulsado (mousedown).
			marco.addEventListener('mouseout', function()
			{
				pintar = false;

			});

			// Continuamos con el dibujo de una línea en el evento mousemouse.
			marco.addEventListener('mousemove', function(mievento) {
				if (pintar == true)
				{
					// Coordenadas donde se encuentra el ratón.
					var mouseX = mievento.pageX - this.offsetLeft;
					var mouseY = mievento.pageY - this.offsetTop;

					// Mostramos las coordenadas en el div coordenadas.
					coordenadas.innerHTML = '(' + mouseX + ',' + mouseY + ')';

					// Definimos coordenada destino de la línea
					lienzo.lineTo(mouseX, mouseY);

					// Dibujamos la linea hasta esa coordenada.
					lienzo.stroke();
				}
			});

			// Cuando levantamos el botón del ratón , para de pintar.
			marco.addEventListener('mouseup', function() {
				pintar = false;
			});

			// Botones de cambio de grosor
			for (i = 0; i < document.getElementsByClassName('grosor').length; i++)
			{
				document.getElementsByClassName('grosor')[i].addEventListener('click', function() {
					lienzo.lineWidth = this.id;
				});
			}

			///////////// GUARDAR LA FOTOGRAFÍA EN EL SERVIDOR. /////////////////
			document.getElementById('guardar').addEventListener('click', function() {
				document.getElementById('campofoto').value = marco.toDataURL();
				document.getElementById('formulario').submit();
			});

		});
	</script>

	<br/>	
	<h2>Or draw your own avatar below.</h2>
	<canvas id="marco" width="78" height="78"></canvas><br/>
	<h4>Mouse coordinates: <div id="coordenadas"></div></h4>
	<input type="button" name="guardar" id="guardar"  value="Upload your drawing"/>
	<input type="button" name="black" id="black"  value="Black" class="colores"/>
	<input type="button" name="blue" id="blue"  value="Blue" class="colores"/>
	<input type="button" name="red" id="red"  value="Red" class="colores"/>
	<input type="button" name="green" id="green"  value="Green" class="colores"/>
	<input type="button" name="yellow" id="yellow"  value="Yellow" class="colores"/>
	<h4>Select your pixel width:</h4>
	<input type="button" name="1" id="1"  value="Small" class="grosor"/>
	<input type="button" name="3" id="3"  value="Regular" class="grosor"/>
	<input type="button" name="5" id="5"  value="Big" class="grosor"/>
	<input type="button" name="7" id="7"  value="Super Big" class="grosor"/>
	<input type="button" name="limpiar" id="limpiar"  value="Clear canvas Alt+K"/>

	<form id="formulario" name="formulario" method="post" action="">
		<input type="hidden" name="campofoto" id="campofoto"/>
	</form>
	<?php
}
?>