<?php

use Apps\Comments\lib\model\Comment;

// https://www.php.net/manual/es/reserved.variables.server.php
// https://www.php.net/manual/es/function.explode.php
$params = explode('&', $_SERVER['QUERY_STRING']);

$url = '';

foreach ($params as $param) {
    if (strpos($param, 'view=') == 0) {
        // ['view', 'page-1']
        $url = explode('=', $param)[1];
    }
}

if (isset($_POST['username']) && isset($_POST['text']) && $url != '') {
    $username = $_POST['username'];
    $text = $_POST['text'];

    $comment = new Comment($username, $text, $url);
    $comment->save();

    // IMPORTANTE: EVITAR REENVÍO DE FORMULARIO
    // https://es.stackoverflow.com/questions/33142/como-evitar-reenv%C3%ADo-del-formulario
    unset($_POST['username']);
    unset($_POST['text']);
    header("Location: ?view={$_GET['view']}");
}

if (!isset($url)) {
    header('Location: ?view=page-1');
}

?>

<link rel="stylesheet" href="src/lib/css/main.css">

<div class="comments-container">
    <form action="" method="post">
        <input type="text" name="username" placeholder="Username…" required autofocus>
        <textarea name="text" id="" rows="5" required placeholder="Your comment…"></textarea>
        <input type="submit" value="Submit comment">
    </form>

    <div class="comments">
        <?php if (count(Comment::getAll($url)) == 0) : ?>
            <p class="empty">No comments yet</p>
        <?php endif; ?>

        <?php foreach (Comment::getAll($url) as $comment) : ?>
            <div class="comment">
                <div class="username"><?= $comment->getUsername() ?></div>
                <div class="text"><?= $comment->getText() ?></div>
                <div class="date"><?= $comment->getDate() ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- HACIENDO USO DE LA SINTAXIS ALTERNATIVA DE LAS ESTRUCTURAS DE CONTROL:
https://styde.net/como-combinar-html-y-php/
https://www.php.net/manual/es/control-structures.alternative-syntax.php -->