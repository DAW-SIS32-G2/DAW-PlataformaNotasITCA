<?php
//$key es la llave que serivrá para cifrar y derscifrar los datos en cada vuelta,
// actualmente está en base64, debería guardarse en una BD
$key = "bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=";
/*
  ------- FUNCION PARA GENERAR CLAVES ---------
  $key = base64_encode(openssl_random_pseudo_bytes(32));
*/
function cifrar($datos) {
    // Quitamos la codificacion base64 de nuestra llave

    $clave_cifrado = base64_decode($key);
    // Generamos un vector de inicialización para nuestra clave
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    // Ciframos los datos utilizando AES 256 en modo CBC utilizando nuestra llave y nuestro IV generado
    $cifrado = openssl_encrypt($datos, 'aes-256-cbc', $clave_cifrado, 0, $iv);
    // El IV es importantísimo para poder descifrar nuestra clave, así que lo vamos a almacenar junto a nuestra clave cifrada usando el separador (::)
    return base64_encode($cifrado . '::' . $iv);
}

function descifrar($datos) {
    // Quitamos la codificacion base64 de nuestra llave
    // $key = "bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=";
    @$clave_cifrado = base64_decode($key);
    // Para poder descifrar debemos separar los datos de nuestra cdena del IV, nuestro separador es (::)
    @list($cifrado, $iv) = explode('::', base64_decode($datos), 2);
    //Por ultimo, se descifra con la llave y el IV obtenido
    return openssl_decrypt($cifrado, 'aes-256-cbc', $clave_cifrado, 0, $iv);
}
