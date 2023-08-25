<?php

use Apps\MyPoll\models\Poll;

if (isset($_POST['title'])) {
    if (isset($_POST['option'])) {
        $title = $_POST['title'];
        $options = $_POST['option'];

        $poll = new Poll($title);
        $poll->save();
        $poll->insertOtiopns($options);

        header('Location: ?view=home');
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
    <title>Options</title>
    <link rel="stylesheet" href="src/resources/output.css">
</head>

<body>
    <header>
        <?php require 'src/views/components/navbar.php'; ?>

        <h1 class="text-center text-3xl font-bold mt-36 mb-12">Options</h1>
    </header>

    <main>
        <form class="m-24 bg-zinc-800 p-8 rounded-xl flex flex-col gap-4" action="?view=options" method="POST">
            <h3 class="text-xl text-amber-600">Questions</h3>

            <input type="hidden" name="title" value="<?php echo $_POST['title'] ?>">

            <input class="rounded-md focus:outline-none focus:ring focus:ring-blue-400 w-56 md:w-full text-xl px-4 py-2 bg-slate-700" type="text" name="option[]" id="" autofocus placeholder="Enter an option…">
            <input class="rounded-md focus:outline-none focus:ring focus:ring-blue-400 w-56 md:w-full text-xl px-4 py-2 bg-slate-700" type="text" name="option[]" id="" placeholder="Enter an option…">

            <div class="flex flex-col gap-4" id="more-inputs">

            </div>

            <button id="bAdd" class="bg-purple-600 hover:bg-purple-500 rounded-md text-xl px-4 py-2">
                Add another option
            </button>

            <div>
                <input class="bg-sky-600 hover:bg-sky-400 rounded-md text-xl px-4 py-2" type="submit" value="Create Poll">
            </div>
        </form>
    </main>

    <?php require 'src/views/components/footer.php'; ?>

    <!-- Manejar «Add another option» (JavaScript) -->
    <script>
        const bAdd = document.querySelector('#bAdd');
        const container = document.querySelector('#more-inputs');

        bAdd.addEventListener('click', e => {
            e.preventDefault();

            const wrapper = document.createElement('div');
            wrapper.classList.add('wrapper');

            const bDelete = document.createElement('button');
            bDelete.append('Delete');
            bDelete.classList.add('bDelete');
            bDelete.addEventListener('click', e => {
                e.preventDefault();
                wrapper.remove();
            });

            const input = document.createElement('input');
            input.name = 'option[]';
            input.type = 'text';
            input.id = crypto.randomUUID();
            input.classList.add('input');
            input.placeholder = 'Enter an option…';

            wrapper.appendChild(input);
            wrapper.appendChild(bDelete);
            container.appendChild(wrapper);
        });
    </script>
</body>

</html>