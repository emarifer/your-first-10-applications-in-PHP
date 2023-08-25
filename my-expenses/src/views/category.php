<?php

use Apps\Expense\models\Category;

$categories = Category::getAll();

if (isset($_POST['name'])) {
    $name = $_POST['name'];

    if (!Category::exists($name)) {
        $category = new Category($name);

        $category->save();
    }
    // IMPORTANTE: EVITAR REENVÍO DE FORMULARIO
    // https://es.stackoverflow.com/questions/33142/como-evitar-reenv%C3%ADo-del-formulario
    unset($_POST['name']);
    header("Location: ?view=category"); // Se puede redirigir a Home
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
    <title>Create Category</title>
    <link rel="stylesheet" href="src/resources/output.css">
</head>

<body>
    <header>
        <?php require 'src/views/components/navbar.php'; ?>

        <h1 class="text-center text-3xl font-bold mt-36 mb-6">Create Category</h1>
    </header>

    <main>
        <form class="m-24 w-fit md:w-[400px] mx-auto bg-zinc-800 p-8 rounded-xl flex flex-col gap-4" action="?view=category" method="post">
            <input class="rounded-md focus:outline-none focus:ring focus:ring-blue-400 w-56 md:w-full text-xl px-4 py-2 bg-slate-700" type="text" name="name" id="" required autofocus placeholder="Name of Category…">
            <input class="bg-sky-600 hover:bg-sky-400 rounded-md text-xl px-4 py-2" type="submit" value="Create Category">
        </form>

        <div class="m-24 w-fit md:w-[400px] mx-auto bg-zinc-800 p-4 rounded-xl">
            <?php foreach ($categories as $category) : ?>
                <p class="bg-amber-700 rounded-md w-56 md:w-full pl-16 py-2 mx-auto my-4 shadow-md shadow-slate-500"><?= $category->getName() ?></p>
            <?php endforeach; ?>
        </div>
    </main>

    <?php require 'src/views/components/footer.php'; ?>
</body>

</html>