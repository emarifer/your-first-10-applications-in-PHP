<?php

use Apps\Notes\model\Note;

$notes = Note::getAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="App with PHP for creating and editing notes">
    <link rel="shortcut icon" href="./src/views/resources/img/new-php-logo.svg" type="image/svg+xml">
    <title>Home</title>
    <link rel="stylesheet" href="src/views/resources/output.css">
</head>

<body>
    <?php require 'components/navbar.php' ?>

    <h1 class="text-center text-3xl font-bold mt-20">Home</h1>

    <div class="m-24 bg-zinc-800 p-8 rounded-xl grid md:grid-cols-2 lg:grid-cols-3 gap-2">

        <?php
        foreach ($notes as $note) {
        ?>
            <a href="?view=view&id=<?php echo $note->getUUID(); ?>">
                <div class="bg-primary shadow-lg shadow-black border border-gray-600 px-6 py-3 rounded-md hover:-translate-y-1.5 ease-in duration-300">
                    <p class="text-base md:text-lg text-amber-600 max-w-full w-fit whitespace-nowrap text-ellipsis overflow-hidden" title="<?php echo $note->getTitle(); ?>">
                        <?php echo $note->getTitle(); ?>
                    </p>
                </div>
            </a>
        <?php
        }
        ?>

    </div>
</body>

</html>