<?php

if (isset($_GET['view'])) {
    $view = $_GET['view'];

    require "src/views/$view.php";
    die;
}

require 'src/views/home.php';

/* 
ENTRAR EN MARIADB POR LÍNEA DE COMANDOS CON DOCKER:
docker exec -it apps-db mariadb --user root -p

password: my-secret-pw

====================================================

https://www.schmengler-se.de/en/2017/04/php-7-type-safe-arrays-of-objects/
https://psalm.dev/docs/annotating_code/type_syntax/array_types/

MODO DE SESIÓN ESTRICTA. VER:
https://www.php.net/manual/en/session.configuration.php#ini.session.use-strict-mode
*/