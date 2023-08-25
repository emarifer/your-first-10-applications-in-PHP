<?php

if (isset($_GET['view'])) {
    $view = $_GET['view'];

    require 'src/views/' . $view . '.php';
    die;
}

require 'src/views/home.php';

/* 
ENTRAR EN MARIADB POR LÍNEA DE COMANDOS CON DOCKER:
docker exec -it apps-db mariadb --user root -p

password: my-secret-pw

HACIENDO USO DE LA SINTAXIS ALTERNATIVA DE LAS ESTRUCTURAS DE CONTROL:
https://styde.net/como-combinar-html-y-php/
https://www.php.net/manual/es/control-structures.alternative-syntax.php

6 SIMPLES PASOS PARA LIMPIAR TU CÓDIGO PHP. VER:
https://academy.leewayweb.com/simples-pasos-limpiar-codigo-php/
*/
