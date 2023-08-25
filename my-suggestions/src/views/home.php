<?php

use Apps\Suggestions\Model\Suggestion;

$suggestions = Suggestion::getSuggestion();

if (isset($_POST['q'])) {
    $q = trim($_POST['q']);

    if ($q !== '') {
        Suggestion::saveSearch($q);
    }

    unset($_POST['q']);
    header("Location: ?view=home");
}

// print_r($suggestions);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="Finder app with suggestions">
    <link rel="shortcut icon" href="./src/resources/img/new-php-logo.svg" type="image/svg+xml">
    <meta name="google" content="notranslate" />
    <title>My Suggestions</title>
    <link rel="stylesheet" href="src/resources/output.css">
</head>

<body>
    <header>
        <?php require 'src/views/components/navbar.php'; ?>

        <h1 class="text-center text-3xl font-bold mt-36 mb-6">
            My Suggestions
        </h1>
    </header>

    <main>
        <form class="m-24 w-fit md:w-[400px] mx-auto bg-zinc-800 p-8 rounded-xl flex flex-col" action="" method="post">

            <input class="rounded-md focus:outline-none focus:ring focus:ring-blue-400 w-56 md:w-full text-xl px-4 py-2 bg-slate-700 mt-1" type="text" name="q" placeholder="Enter a word to search…" autofocus>

            <div class="flex flex-col gap-0.5 text-emerald-500 text-xs mt-3">
                <?php if (count($suggestions) > 0) : ?>
                    <?php foreach ($suggestions as $suggestion) : ?>
                        <span class="block">
                            <?= $suggestion['title'] ?>
                        </span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- <input class="bg-sky-600 hover:bg-sky-400 rounded-md text-xl px-4 py-2" type="submit" value="Validate"> -->
        </form>
    </main>

    <?php require 'src/views/components/footer.php'; ?>
</body>

</html>