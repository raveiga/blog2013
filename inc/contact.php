<link rel="stylesheet" type="text/css" href="css/registro.css" />
<section>
     <?php
     if (!empty($_POST['email'])) { // Enviamos el formulario.
          // Enviamos el correo.
          $contenido='Email received from the website contact form\n';
          $contenido.='----------------------------------------------\n\n';
          $contenido.='IP address: '.$_SERVER['REMOTE_ADDR'].'\n';
          $contenido.='Date: '.date('d/m/Y',time()).'\n';
          $contenido.='Name: '.$_POST['name'].'\n';
          $contenido.='Email: '.$_POST['email'].'\n';
          $contenido.='Comments: '.$_POST['comments'].'\n';
		enviar_correo('Webmaster', MAIL_CONTACTO, "Message from Website Form", $contenido);
     } else {
          ?>
          <h2>Contact Form</h2>
          <form class="formulario" action="" method="post" autocomplete="off">
               <ul>
                    <li>
                         <label for="name">Name:</label>
                         <input type="text" name="name" id="name" placeholder="Your name" size="10" maxlength="20" value="<?php if (!empty($_POST['name'])) echo $_POST['name']; ?>"/>
                    </li>
                    <li>
                         <label for="email">E-mail address:</label>
                         <input type="email" name="email" id="email" placeholder="test@info.local" size="20" maxlength="50" value="<?php if (!empty($_POST['email'])) echo $_POST['email']; ?>"/>
                    </li>
                    <li>
                         <label for="comments">Write your comments here:</label>
                         <textarea id="comments" name="comments"></textarea>
                    </li>
                    <li>
                         <input type="reset" class="controles" value="Reset" />
                         <input type="submit" class="controles" value="Send Comments" />
                    </li>
               </ul>
          </form>

          <img src='email.php' alt='Email address to contact with us'/>

     <?php
}
?>
</section>