<?php

if (isset($_GET['view'])) {
    $view = $_GET['view'];

    require 'src/views/' . $view . '.php';
    die;
}

require 'src/views/home.php';

/* 
SUBIR ARCHIVOS GRANDES EN NGINX. CONFIGURACIÓN. VER:
Nginx: 413 – Request Entity Too Large Error and Solution
https://www.cyberciti.biz/faq/linux-unix-bsd-nginx-413-request-entity-too-large/

ESCRIBIR CON VIM EN FICHEROS DEL SISTEMA SIN SUDO (en /etc/nginx/nginx.conf). VER: https://www.cyberciti.biz/faq/vim-vi-text-editor-save-file-without-root-permission/

HAY QUE DAR PERMISOS DE ESCRITURA A LA CARPETA DONDE SE SUBIRAN LOS ARCHIVOS:
con sudo chmod -R 777. VER:
https://stackoverflow.com/questions/31198379/cannot-save-image-intervention-image-notwritableexception-in-image-php-line-138#31199608

INSTALAR IMAGICK EN PHP SI NO LO ESTÁ (VER php info) Y DOCUMENTACIÓN:
https://www.geeksforgeeks.org/how-to-install-imagick-for-php-in-linux/
https://image.intervention.io/v2/introduction/installation
https://www.php.net/manual/es/book.imagick.php
https://desarrolloweb.com/articulos/intro-imagick-php.html

SE PUEDE VER SI IMAGICK ESTÁ ACTIVA EN PHP INFO Y SI ESTÁ INSTALADO
CON EL COMANDO: php -m | grep -i magic (SALIDA imagick)
VER: https://ma.ttias.be/install-phps-imagick-extension-on-mac-with-brew/

AJAX, File y FileReader, Utilizar ficheros desde aplicaciones web, etc:
https://es.javascript.info/xmlhttprequest#progreso-de-carga
https://es.javascript.info/file
https://developer.mozilla.org/es/docs/Web/API/FileReader
https://developer.mozilla.org/es/docs/Web/API/File_API/Using_files_from_web_applications
*/
