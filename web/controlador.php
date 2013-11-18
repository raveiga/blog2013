<!DOCTYPE html>
<?php require '../lib/constantes.php'; ?>
<html lang="en">
	<?php require RUTA_INC . 'head.php'; ?>
	<body>
		<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		require RUTA_INC . 'cabecera.php';

// Inicializamos variables por defecto.
		$izquierdo = 'izquierdo.php';
		$central = 'index.php';
		$derecho = 'derecho.php';

		// Programamos lo que queremos cargar en los diferentes contenedores.
		if ( isset($_GET['cargar']) && !empty($_GET['cargar']) )
		{
			// La parte central se cargará con $_GET['cargar']
			$central = $_GET['cargar'] . '.php';

			// Programamos con la instrucción switch el resto de los contenedores.
			// Lo utilizamos para cargar menús específicos en izquierdo y derecho.
			switch ($_GET['cargar'])
			{
				case 'registro':
					// Aquí pondríamos los menús específicos que queremos cargar en izquierdo y derecho
					// para una parte central determinada.
					break;
				// más opciones por aqui....
			}
		}
		?>

		<div id="main">
			<div class="5grid">
				<div class="main-row">
					<div class="3u-first">

						<?php
						if ( file_exists(RUTA_INC . $izquierdo) )
							require RUTA_INC . $izquierdo;
						else
							require RUTA_INC . 'izquierdo.php';
						?>

					</div>
					<div class="6u">

						<?php
						if ( file_exists(RUTA_INC . $central) )
							require RUTA_INC . $central;
						else
							require RUTA_INC . 'index.php';
						?>

					</div>
					<div class="3u">

						<?php
						if ( file_exists(RUTA_INC . $derecho) )
							require RUTA_INC . $derecho;
						else
							require RUTA_INC . 'derecho.php';
						?>

					</div>
				</div>
			</div>
		</div>
		<?php require RUTA_INC . 'pie.php'; ?>
	</body>
</html>