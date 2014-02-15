<?php

function encriptar($password, $vueltas = 7) {
     $caracteres = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

     // http://php.net/manual/es/function.crypt.php
     // Para BlowFish, la cabecera es: $2a$ + coste + 22 caracteres del alfabeto de caracteres.
     // %02d -> es para que ponga el número con dos dígitos.
     // $vueltas -> número entre 04 y 31, Se recomienda 7 por defecto por ejemplo

     $semilla = sprintf('$2a$%02d$', $vueltas);
     for ($i = 0; $i < 22; $i++)
          $semilla.=$caracteres[rand(0, 63)];


     return crypt($password, $semilla);
}

function cambiaf_mysql($fecha) {
     $fecha = str_replace('/', '-', $fecha);
     return date('Y-m-d', strtotime($fecha));
}

function cambiaf_normal($fecha) {
     return date('d/m/Y', strtotime($fecha));
}

//----------------------------------------------------------------------------------------------------
/**
 * Función chequearSpam.
 * Chequea caracteres de SPAM en el correo.
 * 
 * @param string $campo El campo a chequear.
 * @return boolean true si ha pasado correctamente el chequeo de spam o sale de la aplicación si se encontró spam imprimiendo un mensaje.
 */
function chequearSpam($campo) {
//Array con las posibles cabeceras a utilizar por un spammer
     $spam = array("Content-Type:",
         "MIME-Version:",
         "Content-Transfer-Encoding:",
         "Return-path:",
         "Subject:",
         "From:",
         "Envelope-to:",
         "To:",
         "bcc:",
         "cc:",
         "link=",
         "url=");

     //Comprobamos que entre los datos no se encuentre alguna de
     //las cadenas del array. Si se encuentra alguna cadena de SPAM muestra mensaje y sale de la aplicación.
     foreach ($spam as $patron) {
          // strpos(pajar,aguja) devuelve FALSE si no encuentra la cadena.
          if (strpos(strtolower($campo), strtolower($patron)) !== false) {
               echo "<br/><br/><h3><CENTER>!! Error: Caracteres SPAM detectados en el correo !! </h3>";
               echo "<h4><CENTER>!! Spammers no permitidos. Solicitud cancelada. !! </h4>.<br/></CENTER>";
               exit; // Sale de la aplicación.
          }
     }

     return true;
}

//----------------------------------------------------------------------------------------------------
/**
 * Función chequearEmail
 * Comprueba que el e-mail tenga un formato válido.
 * 
 * @param type $campo
 * @return boolean true si ha pasado el chequeo de e-mail  o sale de la aplicación si se encontró un e-mail incorrecto.
 */
function chequearEmail($campo) {
     if (!filter_var($campo, FILTER_VALIDATE_EMAIL)) {
          echo "<br/><br/><h3><CENTER>!! Error: Formato de e-mail incorrecto </font>!! </h3>";
          echo "<h4><CENTER>!! Solicitud cancelada !! </h4>.<br/></CENTER>";
          exit; // Sale de la aplicación.
     }
     return true;
}

function enviar_correo($nombreDestinatario, $emailDestinatario, $asunto, $contenido, $adjunto = '') {
     // Cargamos las librerias de phpmailer
     // cargamos las constantes por si acaso.
     require_once 'class.phpmailer.php';
     require_once 'constantes.php';


     if (!empty($emailDestinatario)) { // Enviamos el correo.
          // Validación de SPAM en el correo, por si enviamos correo con la función mail de php.
          if (chequearSpam($nombreDestinatario) && chequearSpam($emailDestinatario) && chequearSpam($asunto) && chequearSpam($contenido) && chequearEmail($emailDestinatario)) {
               // Creamos un objeto de la clase phpmailer.
               $correo = new PHPMailer();

               // Ahora configuramos ese objeto.
               $correo->IsSMTP(); // indicamos que enviamos por SMTP.
               $correo->SMTPAuth = true; // Nos autenticaremos en el servidor de correo.
               $correo->CharSet = 'UTF-8';
               $correo->Host = MAIL_SERVIDOR;
               $correo->Port = MAIL_PUERTO;

               // Si enviamos correo por GMAIL (chequeando el puerto),habilitamos
               // el protocolo SSL.
               if (MAIL_PUERTO == 465 || MAIL_PUERTO == 587)  //usamos GMAIL
                    $correo->SMTPSecure = 'ssl';

               // Si usais XAMPP, teneis que habilitar en \xampp\php\php.ini 
               // la siguiente extensión:   
               // extension= php_openssl.dll
               // Datos del correo.
               $correo->Username = MAIL_REMITENTE;
               $correo->Password = MAIL_PASSWORD;
               $correo->SetFrom(MAIL_REMITENTE, MAIL_NOMBRE_REMITENTE);
               $correo->AddReplyTo(MAIL_REMITENTE, MAIL_NOMBRE_REMITENTE);

               $correo->AddAddress($emailDestinatario, $nombreDestinatario);
               $correo->Subject = $asunto;
               $correo->AltBody = 'Cambia de cliente de correo, lo que usas es una basura';
               $correo->MsgHTML($contenido);
               $correo->IsHTML(true);

               if ($adjunto != '') // hay que adjuntar un archivo.
                    $correo->AddAttachment($adjunto);

               // Enviamos el correo.
               if ($correo->Send())
                    echo 'Se ha enviado correctamente un correo electrónico a ' . $emailDestinatario . '.';
               else
                    echo 'Error enviado correo: ' . $correo->ErrorInfo;
          }
     }
}

?>