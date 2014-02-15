<?php 
//Start the session so we can store what the security code actually is
session_start();

//Send a generated image to the browser 
create_image(); 
exit(); 

function create_image() 
{ 
    //Generamos un string aleatorio con md5.
    $md5_hash = md5(time()); 
    
    //Recortamos a 5 caracteres la longitud.
    $security_code = substr($md5_hash, 15, 5); 

    //Set the session to store the security code
    $_SESSION["captcha"] = $security_code;

    //Set the image width and height 
    $width = 100; 
    $height = 25;  

    //Creamos la imagen sobre la que vamos a escribir.
    $image = imagecreate($width, $height);  

    //We are making three colors, white, black and gray 
    $yellow= imagecolorallocate($image, 255, 255, 0); 
    $white = imagecolorallocate($image, 255, 255, 255); 
    $black = imagecolorallocate($image, 0, 0, 0); 
    $grey = imagecolorallocate($image, 204, 204, 204); 
    $palegolden = imagecolorallocate($image, 238, 232, 170); 
    

    //Make the background black 
    imagefill($image, 0, 0, $palegolden); 

    //Add randomly generated string in white to the image
    imagestring($image,5, 30, 3, $security_code, $black); 

    // Dibuja un rectángulo.
    imagerectangle($image,0,0,$width-1,$height-1,$black); 
    
    // Coordenadas
    // x1,y1 top left (0,0)
    // x2,y2 bottom right 
    // 
    // Dibujamos 3 líneas al azar
    // Una línea de izquierda a derecha cruzando
    // imageline($image, 0, 0,100,20, $grey); 
    imageline($image, 0, intval(rand(0,$height)),$width,intval(rand(0,$height)), $black);
       
    // Dibujamos unos pixels al azar:
    for ($i=0;$i<=150;$i++)
		imagesetpixel ($image , rand(0,$width),rand(0,$height), $black);
    
    //Tell the browser what kind of file is come in 
    header("Content-Type: image/jpeg"); 

    //Sacamos la nueva imagen en formato JPG.
    imagejpeg($image); 
    
    //Free up resources
    imagedestroy($image); 
} 
?>