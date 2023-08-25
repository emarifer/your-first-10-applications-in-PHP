<?php
ini_set('session.use_strict_mode', 1);

session_start();

if (isset($_SESSION['session_id'])) {
    // echo $_SESSION['session_id'];
} else {
    $newSessionId = session_create_id();
    $_SESSION['session_id'] = $newSessionId;

    // echo $newSessionId;
}

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require 'src/app.php';
