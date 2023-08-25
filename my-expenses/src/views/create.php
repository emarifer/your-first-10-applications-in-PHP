<?php

use Apps\Expense\models\{Category, Expense};

$categories = Category::getAll();

if (isset($_POST['title']) && isset($_POST['expense']) && isset($_POST['category_id'])) {
    $title = $_POST['title'];
    $expenseValue = $_POST['expense'];
    $categoryId = $_POST['category_id'];

    $expense = new Expense($title, $categoryId, $expenseValue);
    $expense->save();

    // IMPORTANTE: EVITAR REENVÍO DE FORMULARIO
    // https://es.stackoverflow.com/questions/33142/como-evitar-reenv%C3%ADo-del-formulario
    unset($_POST['title']);
    unset($_POST['expense']);
    unset($_POST['category_id']);
    header("Location: ?view=create"); // Se puede redirigir a Home
    die;
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
    <title>Create Expense</title>
    <link rel="stylesheet" href="src/resources/output.css">
</head>

<body>
    <header>
        <?php require 'src/views/components/navbar.php'; ?>

        <h1 class="text-center text-3xl font-bold mt-36 mb-6">
            Create Expense
        </h1>
    </header>

    <main>
        <form class="m-24 w-fit md:w-[400px] mx-auto bg-zinc-800 p-8 rounded-xl flex flex-col gap-4" action="?view=create" method="post">
            <input class="rounded-md focus:outline-none focus:ring focus:ring-blue-400 w-56 md:w-full text-xl px-4 py-2 bg-slate-700" type="text" name="title" id="" required autofocus placeholder="Name of Expense…">
            <!-- Permitir que un input type="number" tome valores decimales:
            https://isotoma.com/blog/2012/03/02/html5-input-typenumber-and-decimalsfloats-in-chrome/
             -->
            <input class="rounded-md focus:outline-none focus:ring focus:ring-blue-400 w-56 md:w-full text-xl px-4 py-2 bg-slate-700" type="number" name="expense" step="any" required placeholder="Value of Expense…">

            <div>
                <select class="classic" name="category_id" id="">
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category->getId() ?>">
                            <?= $category->getName() ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>



            <input class="bg-sky-600 hover:bg-sky-400 rounded-md text-xl px-4 py-2" type="submit" value="Create Expense">
        </form>
    </main>

    <?php require 'src/views/components/footer.php'; ?>
</body>

</html>