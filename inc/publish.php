<link rel="stylesheet" type="text/css" href="css/registro.css" />
<?php

// Información sobre cómo validar un formulario en PHP en cuanto a temas de seguridad.
// MUY RECOMENDABLE: http://www.w3schools.com/php/php_form_validation.asp
// Expresiones regulares: http://webcheatsheet.com/php/regular_expressions.php
// Si quieres usar code-folding escribe [fcom] y pulsa [TAB]
// <editor-fold defaultstate="collapsed" desc="function depurar($data)">
function depurar($data) {
     $data = trim($data); // Elimina espacios al principio y final.
     //$data = stripslashes($data); // Elimina las barras de escape
     $data = htmlspecialchars($data); // Convierte los caracteres HTML a su literal correspondiente.
     return $data;
}

// </editor-fold>
// VALIDACIÓN DE LOS DATOS DEL FORMULARIO AQUI.
// Para comprobar si estamos recibiendo datos del formulario se puede utilizar:
// if (!empty($_POST)) // estamos recibiendo datos por POST
// empty() es esencialmente el equivalente conciso de !isset($var) || $var == false.
// Inicializamos el array de errores.
$errores = array();

if ($_SERVER['REQUEST_METHOD'] == "POST") { // estamos recibiendo datos por POST // Aqui dentro validaremos todo y grabaremos en la base de datos.
     // Primero depuramos los campos, luego los validaremos.
     //$_POST['nickname']=depurar($_POST['nickname']);
     foreach ($_POST as $clave => $valor) {
          // Mediante la función depurar estamos evitando inyección XSS. (Cross Site Scripting).
          $_POST[$clave] = depurar($valor);
     }

     if (empty($_POST['title'])) {
          $errores[] = "The title is mandatory.";
     }

     if (empty($_POST['content'])) {
          $errores[] = "Please write something in the content area.";
     }

     // <editor-fold defaultstate="collapsed" desc="Mostramos el DIV con los errores.">
     // Mostramos a continuación el contenedor errores y cubrimos su contenido con el array de errores.
     echo '<div class="errores"><ul>';
     for ($i = 0; $i < count($errores); $i++)
          echo "<li>{$errores[$i]}</li>";
     echo '</ul></div>';
     // </editor-fold>
     // Comprobamos si hay errores o no, y si está todo OK insertamos en la tabla.
     if (count($errores) == 0) {
          // Insertamos en la tabla.
          // Preparamos la SQL.
          // Utilizamos mysql_real_escape_string() para escapar aquellos caracteres susceptibles de inyección MySQL.
          if (empty($_POST['fid']))     // Es un post general.
               $sql = sprintf("insert into messages(nickname,title,content, tags,date) values('%s','%s','%s','%s',%s)", $_SESSION['nickname'], mysql_real_escape_string($_POST['title']), mysql_real_escape_string($_POST['content']), mysql_real_escape_string($_POST['tags']), time());
          else // Es una respuesta a un post.
               $sql = sprintf("insert into messages(fatherid,nickname,title,content, tags,date) values('%s','%s','%s','%s','%s',%s)", mysql_real_escape_string($_POST['fid']), $_SESSION['nickname'], mysql_real_escape_string($_POST['title']), mysql_real_escape_string($_POST['content']), mysql_real_escape_string($_POST['tags']), time());

          // Ejecutamos la consulta.
          mysql_query($sql, $conexion) or die(mysql_error());

          // Mostramos mensaje
          echo "Your message has been posted correctly.";
     }
}

if (count($errores) != 0 || empty($_POST)) { // Mostramos el formulario.
     ?>
     <form class="formulario" action="" method="post" autocomplete="off">
          <ul>
               <li>
                    <?php
                    if (!empty($_GET['fid'])) {
                         echo '<h2>Post your Reply</h2>';
                         echo "<input type='hidden' name='fid' value='{$_GET['fid']}'/>";
                    } else
                         echo "<h2>Post your comments in the Blog</h2>";
                    ?>

               </li>
               <li>
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="title" placeholder="Your Post title here" autofocus size="50" maxlength="150" value="<?php
                    if (!empty($_POST['title']))
                         echo $_POST['title'];
                    ?>"/>
               </li>
               <li>
                    <label for="content">Content:</label>
                    <textarea name="content" id="content" placeholder="Your message here"><?php if (!empty($_POST['content'])) echo $_POST['content']; ?></textarea>
               </li>
               <li>
                    <label for="tags">Tags:</label>
                    <input type="text" name="tags" id="tags" placeholder="Tags with spaces in between" size="30" maxlength="250" />
               </li>

               <li>
                    <input type="reset" class="controles" value="Reset" />
                    <input type="submit" class="controles" value="Post Comment" />
               </li>
          </ul>
     </form>
     <?php
}
?>