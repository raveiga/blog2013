<section>
	<?php
	if (!empty($_SESSION['nickname']))
	{
		$nombrefinal = md5("semillakillerblog" . $_SESSION['nickname']) . ".jpg";
		if (file_exists(RUTA_FOTOS.$nombrefinal))
		{
			echo "<h2>Your profile picture</h2>";
			echo '<ul class="small-image-list">';
			echo '<li><img src="../fotos/'.$nombrefinal.'?t='.time().'" alt="'.$_SESSION['nickname'].'" class="left" />';
			// El parametro t=time() se utiliza para que cada vez
			// que se actualice la página recargue siempre la
			// fotografía del servidor.
			// Ejemplo: img src=fotografia.jpg?t=234234234
			//          img src=fotografia.jpg?t=234234256
			echo '<h4>'.$_SESSION['personalinfo'].'</h4>';
			echo '<p>IP address: '.$_SERVER['REMOTE_ADDR'];
			echo '<br/>Registration date: '.$_SESSION['datecreated'].'</p>';
			echo '</li></ul>';
		}
			
	}
	else
	{
	?>
	<h2>People Online</h2>
	<ul class="small-image-list">
		<li>
			<a href="#"><img src="css/images/pic2.jpg" alt="" class="left" /></a>
			<h4>Jane Anderson</h4>
			<p>Varius nibh. Suspendisse vitae magna eget et amet mollis justo facilisis amet quis.</p>
		</li>
		<li>
			<a href="#"><img src="css/images/pic1.jpg" alt="" class="left" /></a>
			<h4>James Doe</h4>
			<p>Vitae magna eget odio amet mollis justo facilisis amet quis. Sed sagittis consequat.</p>
		</li>
	</ul>
	<?php
	}
	?>
</section>