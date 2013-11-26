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


function cambiaf_mysql($fecha)
{
	$fecha=str_replace('/','-',$fecha);
	return date('Y-m-d',strtotime($fecha));
}

function cambiaf_normal($fecha)
{
	return date('d/m/Y',strtotime($fecha));
}

?>