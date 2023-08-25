<?php

if (isset($_GET['view'])) {
    $view = $_GET['view'];

    require "src/views/$view.php";
    die;
}

require 'src/views/home.php';

/* 
https://docstore.mik.ua/orelly/webprog/php/ch02_03.htm#:~:text=A%20symbol%20table%20is%20an,of%20their%20values%20in%20memory.&text=By%20delaying%20the%20allocation%20and,is%20copy%2Don%2Dwrite.
https://www.php.net/manual/es/language.references.whatare.php
https://es.wikipedia.org/wiki/Copy-on-write
https://www.geeksforgeeks.org/symbol-table-compiler/

https://www.php.net/manual/en/class.stringable.php

https://www.srcodigofuente.es/tutoriales/ver-tutorial/if-else-alternativo-php-html
*/