<h1>Blog Messages</h1>
<?php
// Chequeamos la lista de los últimos mensajes en el blog.

$sql = "select * from messages  where fatherid is NULL  order by date desc";
$recordset = mysql_query($sql) or die(mysql_error());

if (mysql_num_rows($recordset) == 0)
     echo "<br/>Sorry there are no post messages in this blog.";
 else
     {
      // Mostramos los títulos de los posts.
      echo '<br/><ul class="posts">';
      while ($fila=  mysql_fetch_assoc($recordset))
      {
           echo "<li><a href='view.html?postid={$fila['id']}'/>{$fila['title']}.</a> (".date("d/m/Y H:m:s",$fila['date']).") by ".$fila['nickname'].".";
           
           // Para cada post miramos si tiene respuestas y  las publicamos.
           $sql = sprintf("select * from messages where fatherid=%s  order by date desc",$fila['id']);
           $respuestas = mysql_query($sql) or die(mysql_error());
           if (mysql_num_rows($respuestas)!=0)
           {
                echo '<ul class="posts">';
                while ($fila2=mysql_fetch_assoc($respuestas))
                {
                     echo "<li><a href='view.html?postid={$fila2['id']}'/>{$fila2['title']}.</a> (".date("d/m/Y H:m:s",$fila2['date']).") by ".$fila2['nickname'].".</li>";
                }
                echo '</ul>';
           }
           
           echo '</li>';

      }
      echo '</ul>';
}
?>