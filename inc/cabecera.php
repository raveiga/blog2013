<div id="header-wrapper">
	<div class="5grid">
		<div class="12u-first">
			<header id="header">
				<h1><a href="#">PHP Blog</a></h1>
				<nav>
					<?php
					$activarClase = ' class="current-page-item"';

					// Página por defecto.
					$existePagina = 0;
					$paginaActiva = 'index';

					// Lista de las páginas validas separadas por coma.
					$cadenaPaginas = 'index,registro';

					// Comprueba que la variable exista.
					if ( isset($_GET['cargar']) && $_GET['cargar'] != '' )
					{
						// Busca la página en la cadena.
						if ( strpos($cadenaPaginas, $_GET['cargar']) )
						{
							$existePagina = 1;
							$paginaActiva = $_GET['cargar'];
						}
					}
					?>
					<a href="index.html"<?php if ( ($existePagina && $paginaActiva == 'index') || $existePagina == 0 ) echo $activarClase; ?>>Home</a>
					<a href="registro.html"<?php if ( $existePagina && $paginaActiva == 'registro' ) echo $activarClase; ?>>Sign Up</a>
					<a href="zzz.html">---</a>
					<a href="zzz.html">---</a>
				</nav>
			</header>
		</div>
	</div>
</div>