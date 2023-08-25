<?php

use Apps\Notes\model\Note;

if (count($_POST) > 0) {
    # update note
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';
    $uuid = $_POST['uuid'];

    $note = Note::get($uuid);
    $note->setTitle($title);
    $note->setContent($content);

    $note->update();
    header('Location: ?view=home');
} else if (isset($_GET['id'])) {
    $note = Note::get($_GET['id']);
} else {
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
    <title>Note View</title>
    <link rel="stylesheet" href="src/views/resources/output.css">
</head>

<body>
    <?php require 'components/navbar.php' ?>

    <h1 class="text-center text-3xl font-bold mt-20">Note View</h1>

    <form class="m-24 bg-zinc-800 p-8 rounded-xl flex flex-col gap-4" action="?view=view&id=<?php echo $note->getUUID(); ?>" method="POST">
        <input class="rounded-md focus:outline-none focus:ring focus:ring-blue-400 w-56 md:w-full text-xl px-4 py-2 bg-slate-700" type="text" name="title" placeholder="Title…" value="<?php echo $note->getTitle(); ?>" autofocus>
        <input type="hidden" name="uuid" value="<?php echo $note->getUUID(); ?>">
        <textarea class="rounded-md focus:outline-none focus:ring focus:ring-blue-400 w-56 md:w-full text-xl px-4 py-2 bg-slate-700" name="content" rows="5" placeholder="Content…"><?php echo $note->getContent(); ?></textarea>

        <div class="flex justify-between">
            <div>
                <input class="bg-amber-600 hover:bg-amber-500 rounded-md text-xl px-4 py-2 cursor-pointer" type="submit" value="Update Note">
            </div>
            <a class="bg-red-600 hover:bg-red-500 block rounded-md text-xl px-4 py-2" href="?view=delete&id=<?php echo $note->getUUID(); ?>">Delete Note</a>
        </div>
    </form>
</body>

</html>