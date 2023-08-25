<?php

use Apps\Validator\Model\Validator;

$errors = [];

if (isset($_POST['value'])) {
    $validator = new Validator($_POST['value']);

    $validator
        ->minLength(6)
        ->isEmail()
        ->isNumber()
        ->isUrl()
        ->isDate()
        ->contains(['Enrique', 'Marín']);

    $errors = $validator->getResult();
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
    <title>Validator</title>
    <link rel="stylesheet" href="src/resources/output.css">
</head>

<body>
    <header>
        <?php require 'src/views/components/navbar.php'; ?>

        <h1 class="text-center text-3xl font-bold mt-36 mb-6">Validator</h1>
    </header>

    <main>
        <!-- Test -->

        <!-- <//?php

                use Apps\Validator\Model\Validator;

                $validator = new Validator('http:/www.google.com');
                $validator2 = new Validator(59);
                $validator3 = new Validator('21-08-2023');
                $validator4 = new Validator('21/08/2023');

                $validator
                    ->isNumber()
                    ->isEmail()
                    ->isUrl()
                    ->contains(['google', 'www'])
                    ->isDate();

                $validator2
                    ->isNumber()
                    ->isEmail()
                    ->minLength(3)
                    ->contains(['hola', 'this', 'adios'])
                    ->isDate();

                $validator3->isDate();

                if (count($validator->getResult()) > 0) {
                    echo 'There are errors in validator 1:<br>';

                    foreach ($validator->getResult() as $error) {
                        echo "{$error['value']}: {$error['message']}<br>";
                    }
                }

                if (count($validator2->getResult()) > 0) {
                    echo 'There are errors in validator 2:<br>';

                    foreach ($validator2->getResult() as $error) {
                        echo "{$error['value']}: {$error['message']}<br>";
                    }
                }

                if (count($validator3->getResult()) > 0) {
                    echo 'There are errors in validator 3:<br>';

                    foreach ($validator3->getResult() as $error) {
                        echo "{$error['value']}: {$error['message']}<br>";
                    }
                }

                if (count($validator4->getResult()) > 0) {
                    echo 'There are errors in validator 3:<br>';

                    foreach ($validator4->getResult() as $error) {
                        echo "{$error['value']}: {$error['message']}<br>";
                    }
                }

                ?> -->

        <form class="m-24 w-fit md:w-[400px] mx-auto bg-zinc-800 p-8 rounded-xl flex flex-col" action="" method="post">

            <div class="flex flex-col gap-[2px] text-red-600 text-xs">
                <?php if (count($errors) > 0) : ?>
                    <?php foreach ($errors as $error) : ?>
                        <span class="block">
                            <?= $error['value'] ?>: <?= $error['message'] ?>
                        </span>
                    <?php endforeach; ?>
                    <!-- <//?php $errors = [];
                    unset($_POST['value']); ?> -->
                <?php endif; ?>
            </div>

            <input class="rounded-md focus:outline-none focus:ring focus:ring-blue-400 w-56 md:w-full text-xl px-4 py-2 bg-slate-700 mt-1" type="text" name="value" placeholder="Enter the value to validate…" autofocus>

            <!-- <input class="bg-sky-600 hover:bg-sky-400 rounded-md text-xl px-4 py-2" type="submit" value="Validate"> -->
        </form>
    </main>

    <?php require 'src/views/components/footer.php'; ?>

</body>

</html>

<!-- 
    https://es.stackoverflow.com/questions/81788/c%C3%B3mo-refrescar-una-p%C3%A1gina-con-php

    http://programandolo.blogspot.com/2013/07/redireccionamiento-php.html

    https://dev.to/karleb/return-types-in-php-3fip
    https://www.php.net/manual/es/control-structures.foreach.php
    https://www.php.net/manual/en/language.types.type-juggling.php
 -->