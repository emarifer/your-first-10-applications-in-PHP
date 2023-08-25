<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="Application for creating and managing surveys">
    <link rel="shortcut icon" href="./src/resources/img/new-php-logo.svg" type="image/svg+xml">
    <meta name="google" content="notranslate" />
    <title>Home</title>
    <link rel="stylesheet" href="src/resources/output.css">
</head>

<body>
    <header>
        <?php require 'src/views/components/navbar.php'; ?>

        <h1 class="text-center text-3xl font-bold mt-36 mb-6">
            Welcome to your favorite polls!!
        </h1>

        <a class="block text-lg font-medium italic text-center text-purple-400" href="?view=create">
            Do you want to create a new poll?
        </a>
    </header>

    <main>
        <p class="underline underline-offset-4 text-amber-700 text-center my-12">
            Polls created
        </p>

        <ul class="w-4/5 max-w-xl mx-auto bg-zinc-800 p-8 rounded-xl">
            <?php

            use Apps\MyPoll\models\Poll;

            $polls = Poll::getPolls();

            foreach ($polls as $poll) {
                echo "<li class='text-left px-4 py-2 rounded-lg mb-2 text-emerald-400 hover:font-bold hover:bg-purple-600 hover:text-amber-400'>
                          <a href='?view=view&id={$poll->getUUID()}'>
                            ▷&nbsp;&nbsp;{$poll->getTitle()}
                          </a>
                      </li>";
            }

            ?>
        </ul>
    </main>

    <?php require 'src/views/components/footer.php'; ?>
</body>

</html>