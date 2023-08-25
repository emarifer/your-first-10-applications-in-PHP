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
*/
