<section>
     <?php
     if (!empty($_SESSION['nickname'])) {
          $nombrefinal = md5("semillakillerblog" . $_SESSION['nickname']) . ".jpg";
          if (file_exists(RUTA_FOTOS . $nombrefinal)) {
               echo "<h2>Your profile picture</h2>";
               echo '<ul class="small-image-list">';
               echo '<li><img src="../fotos/' . $nombrefinal . '?t=' . time() . '" alt="' . $_SESSION['nickname'] . '" class="left" />';
               // El parametro t=time() se utiliza para que cada vez
               // que se actualice la página recargue siempre la
               // fotografía del servidor.
               // Ejemplo: img src=fotografia.jpg?t=234234234
               //          img src=fotografia.jpg?t=234234256
               echo '<h4>' . $_SESSION['personalinfo'] . '</h4>';
               echo '<p>IP address: ' . $_SERVER['REMOTE_ADDR'];
               echo '<br/>Registration date: ' . $_SESSION['datecreated'] . '</p>';
               echo '</li></ul>';
          }
     } else {
          ?>
          <section>
               <h2>About this blog</h2>
               <h1>PHP Blog 2013-2014.</h1>
               Welcome to our Blog System developed using PHP and MySQL.<br/>
               Be gentle and enjoy your stay here.<br/>
               <br/>
               IES San Clemente.<br/>
               Santiago de Compostela<br/>
               (A Coruña)<br/>
               Spain.
          </section>
     <?php
}
?>
</section>