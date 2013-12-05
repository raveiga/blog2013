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
					$cadenaPaginas = 'index,registro,login,editprofile,uploadpicture,logout';

					// Comprueba que la variable exista.
					if (isset($_GET['cargar']) && $_GET['cargar'] != '')
					{
						// Busca la página en la cadena.
						if (strpos($cadenaPaginas, $_GET['cargar']))
						{
							$existePagina = 1;
							$paginaActiva = strtolower($_GET['cargar']);
						}
					}
					?>
					<a href="index.html"<?php if (($existePagina && $paginaActiva == 'index') || $existePagina == 0) echo $activarClase; ?>>Home</a>
					<?php
					// SI hay una sesión activa mostramos estas opciones de menú.
					if (!empty($_SESSION['nickname']))
					{
						?>
						<a href = "editprofile.html"<?php
						if ($existePagina && $paginaActiva == 'editprofile')
							echo $activarClase;
						?>>Edit Profile</a>
						<a href="uploadpicture.html"<?php if ($existePagina && $paginaActiva == 'uploadpicture') echo $activarClase; ?>>Upload Picture</a>
												<a href="logout.html"<?php if ($existePagina && $paginaActiva == 'logout') echo $activarClase; ?>>Logout (<?php echo $_SESSION['nickname'];?>)</a>
						
					<?php
					}
					else
					{
						?>
						<a href="registro.html"<?php if ($existePagina && $paginaActiva == 'registro') echo $activarClase; ?>>Sign Up</a>
						<a href="login.html"<?php if ($existePagina && $paginaActiva == 'registro') echo $activarClase; ?>>Sign In</a>
						<?php
					}
					?>
				</nav>
			</header>
		</div>
	</div>
</div>