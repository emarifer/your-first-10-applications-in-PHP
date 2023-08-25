<?php

if (isset($_GET['post'])) {

    require 'src/post/index.php';
    die;
}

if (isset($_GET['view'])) {
    $view = $_GET['view'];

    require 'src/' . $view . '.php';
    die;
}

require 'src/home.php';
