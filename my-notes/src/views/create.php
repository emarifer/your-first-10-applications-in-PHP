<?php

use Apps\Notes\model\Note;

if (count($_POST) > 0) {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';

    $note = new Note($title, $content);
    $note->save();

    header('Location: ?view=home');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="App with PHP for creating and editing notes">
    <link rel="shortcut icon" href="./src/views/resources/img/new-php-logo.svg" type="image/svg+xml">
    <title>Create New Note</title>
    <link rel="stylesheet" href="src/views/resources/output.css">
</head>

<body>
    <?php require 'components/navbar.php' ?>

    <h1 class="text-center text-3xl font-bold mt-20">Create Note</h1>

    <form class="m-24 bg-zinc-800 p-8 rounded-xl flex flex-col gap-4" action="?view=create" method="POST">
        <input class="rounded-md focus:outline-none focus:ring focus:ring-blue-400 w-56 md:w-full text-xl px-4 py-2 bg-slate-700" type="text" name="title" placeholder="Title…" autofocus>
        <textarea class="rounded-md focus:outline-none focus:ring focus:ring-blue-400 w-56 md:w-full text-xl px-4 py-2 bg-slate-700" name="content" rows="5" placeholder="Content…"></textarea>
        <div>
            <input class="bg-sky-600 hover:bg-sky-400 rounded-md text-xl px-4 py-2" type="submit" value="Create Note">
        </div>
    </form>
</body>

</html>