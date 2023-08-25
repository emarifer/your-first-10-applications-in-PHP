<?php

use Apps\Notes\model\Note;

if (isset($_POST['uuid'])) {
    # delete note
    $uuid = $_POST['uuid'];

    $note = Note::get($uuid);
    $note->delete();

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
    <title>Delete Note</title>
    <link rel="stylesheet" href="src/views/resources/output.css">
</head>

<body>
    <?php require 'components/navbar.php' ?>

    <h1 class="text-center text-3xl font-bold mt-20">Delete Note</h1>

    <form class="m-24 bg-zinc-800 p-8 rounded-xl flex flex-col gap-4" action="?view=delete&id=<?php echo $note->getUUID(); ?>" method="POST">

        <h3 class="text-center text-lg text-amber-600">Do you really want to delete the note with the title:</h3>
        <p class="text-base font-semibold italic text-sky-500 text-center">
            <?php echo "«{$note->getTitle()}»" ?>
        </p>

        <input type="hidden" name="uuid" value="<?php echo $note->getUUID(); ?>">

        <div class="flex justify-between">
            <a class="bg-indigo-600 hover:bg-indigo-500 block rounded-md text-xl px-4 py-2" href="?view=home">Cancel</a>
            <div>
                <input class="bg-rose-600 hover:bg-rose-500 rounded-md text-xl px-4 py-2 cursor-pointer" type="submit" value="Delete Note">
            </div>
        </div>
    </form>
</body>

</html>