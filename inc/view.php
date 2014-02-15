<?php
// Borrado de Post.
if (!empty($_GET['postid']) && !empty($_GET['delete'])) {
     // Borramos el post y todos sus hijos.
     $sql = sprintf("delete from messages where id='%s' and nickname='%s'", $_GET['postid'], $_SESSION['nickname']);

     mysql_query($sql) or die(mysql_error());
     if (mysql_affected_rows() == 1) { // Se ha borrado correctamente el post de ese nickname.
          // Entonces borramos todos los hijos de ese post.
          $sql = sprintf("delete from messages where fatherid='%s'", $_GET['postid']);
          mysql_query($sql) or die(mysql_error());
          header("location: index.html");
     }
}

// Actualización de Post.
if (!empty($_POST['id'])) {
     $sql = sprintf("update messages set title='%s', content='%s', tags='%s' where id='%s' and nickname='%s'", $_POST['title'], $_POST['content'], $_POST['tags'], $_POST['id'], $_SESSION['nickname']);
     mysql_query($sql) or die(mysql_error());
}

// Edición de Post.
if (!empty($_GET['postid']) && !empty($_GET['edit'])) {
     $sql = sprintf("select * from messages where id='%s' and nickname='%s'", $_GET['postid'], $_SESSION['nickname']);
     $recordset = mysql_query($sql) or die(mysql_error());
     $fila = mysql_fetch_assoc($recordset);
     ?>
     <form class="formulario" action="view.html?postid=<?php echo $_GET['postid']; ?>" method="post" autocomplete="off">
          <ul>
               <li>
                    <h2>Edit your Post</h2>
               </li>
               <li>
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="title" placeholder="Your Post title here" autofocus size="50" maxlength="150" value="<?php echo $fila['title']; ?>"/>
               </li>
               <li>
                    <label for="content">Content:</label>
                    <textarea name="content" id="content" placeholder="Your message here"><?php echo $fila['content']; ?></textarea>
               </li>
               <li>
                    <label for="tags">Tags:</label>
                    <input type="text" name="tags" id="tags" placeholder="Tags with spaces in between" size="30" maxlength="250" value="<?php echo $fila['tags']; ?>"/>
               </li>

               <li>
                    <input type="hidden" name="id" value="<?php echo $fila['id']; ?>"/>
                    <input type="reset" class="controles" value="Reset" />
                    <input type="submit" class="controles" value="Post Comment" />
               </li>
          </ul>
     </form>
     <?php
}
?>

<?php
// Mostramos el contenido del post seleccionado.

if (!empty($_GET['postid']) && !isset($_GET['edit']) && !isset($_GET['delete'])) {
     $sql = sprintf("select * from messages where id='%s'", mysql_real_escape_string($_GET['postid']));

     $recordset = mysql_query($sql) or die(mysql_error());

     if (mysql_num_rows($recordset) == 0)
          echo "<br/>Sorry I can't find the post you are requesting.";
     else {
          echo '<link rel="stylesheet" type="text/css" href="css/raphaelicons.css"/>';
          echo '<h1>Post Content</h1>';
          // Mostramos los títulos de los posts.
          echo '<br/><ul class="posts">';
          while ($fila = mysql_fetch_assoc($recordset)) {
               // ICONOS: http://www.flaticon.com/
               // O bien usando tipo de letra. raphael icons. http://icons.marekventur.de/
               echo "<li><a href='view.html?postid={$fila['id']}'>{$fila['title']}.</a> (posted " . date("d/m/Y - H:m:s", $fila['date']) . ") by ".$fila['nickname'].".";

               // Si hay una sesión abierta y es nuestro post.
               if (isset($_SESSION['nickname'])) 
               {
                    if ($fila['nickname'] == $_SESSION['nickname'])
                         echo " <a class='raphael' href='view.html?postid={$fila['id']}&edit={$fila['id']}'><span class='icon'>></span></a> | <a class='raphael' href='view.html?postid={$fila['id']}&delete={$fila['id']}'><span class='icon'>Â</span></a>";
                    else // Si no es post nuestro nos da la opción a responder siempre y cuando ya no sea otra respuesta. Sólo se permite 1 nivel de respuestas.
                    {
                         if ($fila['fatherid']==NULL)
                              echo " <a class='raphael' href='publish.html?fid={$fila['id']}'><span class='icon'>+</span></a>";
                    }
               }
               echo '</li><br/>' . nl2br($fila['content']);
          }
          echo '</ul>';
     }
}
?>