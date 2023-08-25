<?php

use Apps\Stock\model\Stock;

if (isset($_POST['name'])) {
    $name = $_POST['name'];

    if (strlen($name) != 0 && !Stock::exists($name)) {
        $stock = new Stock($name);
        // echo $name;

        // Chequeamos que existe la empresa con ese nombre en la API
        if ($stock->isStockReal()) {
            // Entonces guardamos el performanceId, ticker y nombre en DB
            $stock->save();
        }
    }
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
    <title>My Stocks</title>
    <link rel="stylesheet" href="src/resources/output.css">
</head>

<body>
    <header>
        <?php require 'src/views/components/navbar.php'; ?>

        <h1 class="text-center text-3xl font-bold mt-36 mb-6">My Stocks</h1>
    </header>

    <main>
        <form class="m-24 w-4/5 mx-auto bg-zinc-800 p-8 rounded-xl flex flex-col gap-4" action="" method="post">
            <!-- action="" method="post" -->
            <input class="rounded-md focus:outline-none focus:ring focus:ring-blue-400 w-56 md:w-full text-xl px-4 py-2 bg-slate-700" type="text" name="name" placeholder="Name…" autofocus>
            <input class="bg-sky-600 hover:bg-sky-400 rounded-md text-xl px-4 py-2" type="submit" value="Add Stock">
        </form>

        <div class="stocks w-4/5 mx-auto p-4 flex flex-col gap-4 bg-zinc-800 rounded-xl">
            <?php $stocks = Stock::getAll();
            foreach ($stocks as $stock) : ?>

                <div class="stock p-4 w-56 md:w-full flex justify-between bg-amber-700 rounded-xl">
                    <div>
                        <?= $stock->getTicker() ?></div>
                    <div>
                        <?= $stock->getName() ?></div>
                    <div>$ <?= $stock->getInfo()->lastPrice ?></div>
                </div>

                <!-- <div class="stock p-4 w-56 md:w-full flex justify-between bg-amber-700 rounded-xl">
                <div>TSLA</div>
                <div>Tesla Inc</div>
                <div>$ 228.5</div>
            </div>

            <div class="stock p-4 w-56 md:w-full flex justify-between bg-amber-700 rounded-xl">
                <div>IBM</div>
                <div>International Business Machines Corp</div>
                <div>$ 141.4532</div>
            </div> -->

            <?php endforeach; ?>
        </div>
    </main>

    <?php require 'src/views/components/footer.php'; ?>
</body>

</html>