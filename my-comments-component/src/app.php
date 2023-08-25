<?php

if (isset($_GET['view'])) {
    $view = $_GET['view'];

    require 'src/views/' . $view . '.php';
    die;
}

require 'src/views/page-1.php';

/* 
Emmet Documentation - Abbreviations Syntax. VER:
https://docs.emmet.io/abbreviations/syntax/
*/
