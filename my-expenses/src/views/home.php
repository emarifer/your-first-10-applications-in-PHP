<?php

use Apps\Expense\models\Expense;

$expenses = Expense::getAll();

$total = Expense::getTotal($expenses);

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
    <title>My Expenses</title>
    <link rel="stylesheet" href="src/resources/output.css">
</head>

<body>
    <header>
        <?php require 'src/views/components/navbar.php'; ?>

        <h1 class="text-center text-3xl font-bold mt-36 mb-6">My Expenses</h1>
    </header>

    <main class="m-24 w-fit md:w-[600px] mx-auto bg-zinc-800 p-8 rounded-xl flex flex-col gap-4">
        <p class="text-amber-700 mb-6">Total: <?= $total ?>€</p>

        <div class="bg-sky-500 rounded-lg p-4 flex flex-col gap-2">
            <?php foreach ($expenses as $expense) : ?>
                <div class="bg-slate-400 text-slate-800 flex justify-between px-4 py-2 rounded-md shadow-md shadow-slate-800 items-center">
                    <p class="w-[33%]"><?= $expense->getTitle() ?></p>
                    <p class="text-center">
                        <?= $expense->getCategory()->getName() ?>
                    </p>
                    <p class="font-bold text-right w-[33%]"><?= $expense->getExpense() ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <?php require 'src/views/components/footer.php'; ?>
</body>

</html>