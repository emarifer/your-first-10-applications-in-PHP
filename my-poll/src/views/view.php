<?php

use Apps\MyPoll\models\Poll;

if (isset($_GET['id'])) {
    $uuid = $_GET['id'];

    $poll = Poll::find($uuid);
    $total = $poll->getTotalVotes();
    $percentage = 0;

    if (isset($_POST['option_id'])) {
        $optionId = $_POST['option_id'];

        $poll = $poll->vote($optionId);

        // IMPORTANTE: EVITAR REENVÍO DE FORMULARIO
        // https://es.stackoverflow.com/questions/33142/como-evitar-reenv%C3%ADo-del-formulario
        unset($_POST['option_id']);
        header("Location: ?view=view&id=$uuid");
    }
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
    <meta name="description" content="Application for creating and managing surveys">
    <link rel="shortcut icon" href="./src/resources/img/new-php-logo.svg" type="image/svg+xml">
    <meta name="google" content="notranslate" />
    <title><?= $poll->getTitle() ?></title>
    <link rel="stylesheet" href="src/resources/output.css">
</head>

<body>
    <header>
        <?php require 'src/views/components/navbar.php'; ?>

        <h1 class="text-center text-3xl font-bold mt-36 mb-6">
            <?= $poll->getTitle() ?>
        </h1>

        <h3 class="text-center text-amber-600 text-lg">
            Total votes: <?= $total ?>
        </h3>
    </header>

    <main class="w-4/5 max-w-xl mx-auto mt-6 mb-3 bg-zinc-800 p-8 rounded-xl">
        <?php foreach ($poll->getOptions() as $option) : ?>
            <?php $total !== 0 ? $percentage  = number_format(($option['votes'] / $total) * 100, 2) : $percentage ?>

            <div class="mb-4">
                <div class="text-blue-800 font-semibold bg-amber-500 rounded-md p-1 mb-1" style="width: <?= $percentage ?>%;">
                    <?= $percentage ?>%
                </div>
                <form action="" method="POST">
                    <input type="hidden" name="option_id" value="<?= $option['id'] ?>">
                    <input class="bg-sky-600 hover:bg-sky-400 rounded-md text-lg px-3 py-1" type="submit" value="Vote for <?= $option['title'] ?>">
                </form>
            </div>

        <?php endforeach; ?>
    </main>

    <?php require 'src/views/components/footer.php'; ?>
</body>

</html>