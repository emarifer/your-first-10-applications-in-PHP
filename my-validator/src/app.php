<?php

if (isset($_GET['view'])) {
    $view = $_GET['view'];

    require "src/views/$view.php";
    die;
}

require 'src/views/home.php';
