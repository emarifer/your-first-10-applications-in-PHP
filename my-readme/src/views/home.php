<?php

use Apps\Readme\Model\Generator;

$readme = null;

if (count($_POST) > 0) {
    $readme = new Generator($_POST);

    $readme->generate();
}

// Razón por la que se usa un método estático (getValue) para obtener
// el valor del input, en un lugar de usar p.ej $readme->getTitle():
// https://youtu.be/w8CZFQZV_8Y?t=23957
$vTitle = Generator::getValue($readme, 'getTitle');
$vDescription = Generator::getValue($readme, 'getDescription');
$vAuthors = Generator::getValue($readme, 'getAuthorsAndLinks');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="README.md file generator for GitHub">
    <link rel="shortcut icon" href="./src/resources/img/new-php-logo.svg" type="image/svg+xml">
    <meta name="google" content="notranslate" />
    <title>README Generator</title>
    <link rel="stylesheet" href="src/resources/output.css">
</head>

<body>
    <header>
        <?php require 'src/views/components/navbar.php'; ?>

        <h1 class="text-center text-3xl font-bold mt-36 mb-6">
            README Generator
        </h1>
    </header>

    <main class="grid grid-cols-3 gap-8 p-12 mb-4">
        <form class="bg-zinc-800 p-8 rounded-xl flex flex-col gap-4" action="" method="post">
            <span class="text-sm text-sky-600">[<i>generate</i>]</span>
            <details>
                <summary>Title</summary>
                <div>
                    <input class="rounded-md focus:outline-none focus:ring focus:ring-blue-400 w-full text-xl px-4 py-2 mt-2 bg-slate-700" type="text" name="title" required placeholder="Enter title…" value="<?= $vTitle ?>" />
                </div>
            </details>
            <details>
                <summary>Description</summary>
                <div>
                    <input class="rounded-md focus:outline-none focus:ring focus:ring-blue-400 w-full text-xl px-4 py-2 mt-2 bg-slate-700" type="text" name="description" required placeholder="Enter description…" value="<?= $vDescription ?>" />
                </div>
            </details>
            <details>
                <summary>Authors</summary>
                <?php if (is_array($vAuthors)) : ?>
                    <div>
                        <?php foreach ($vAuthors as $author) : ?>
                            <div class="flex justify-between gap-2">
                                <input class="rounded-md focus:outline-none focus:ring focus:ring-blue-400 w-full text-xl px-4 py-2 mt-2 bg-slate-700" type="text" name="authors[]" required placeholder="Enter author…" value="<?= $author['author'] ?>" />
                                <input class="rounded-md focus:outline-none focus:ring focus:ring-blue-400 w-full text-xl px-4 py-2 mt-2 bg-slate-700" type="url" name="author_links[]" required placeholder="Enter link…" value="<?= $author['link'] ?>" title="<?= $author['link'] ?>" />
                            </div>
                            <!-- ↑ Hacemos los inputs required para emparejar author/link y que no nos dé error -->
                        <?php endforeach; ?>
                    </div>
                    <!-- ↓ Este sería el caso inicial cuando el array $vAuthors está vacío -->
                <?php else : ?>
                    <div>
                        <div class="flex justify-between gap-2">
                            <input class="rounded-md focus:outline-none focus:ring focus:ring-blue-400 w-full text-xl px-4 py-2 mt-2 bg-slate-700" type="text" name="authors[]" required placeholder="Enter author…" value="" />
                            <input class="rounded-md focus:outline-none focus:ring focus:ring-blue-400 w-full text-xl px-4 py-2 mt-2 bg-slate-700" type="url" name="author_links[]" required placeholder="Enter link…" value="" />
                        </div>
                    </div>
                <?php endif; ?>

                <div id="moreAuthors">
                    <!-- Aquí van las parejas author/link que se crean dinámicament con JavaScript -->
                </div>
                <button class="bg-amber-700 hover:bg-amber-500 rounded-md text-xl px-4 py-2 mt-3" id="bAddAuthor" type="button">
                    Add Author
                </button>
            </details>

            <input class="bg-sky-600 hover:bg-sky-400 rounded-md text-xl px-4 py-2" type="submit" value="Generate Markdown">
        </form>

        <?php if (isset($readme)) : ?>
            <div class="overflow-auto bg-zinc-800 p-8 rounded-xl">
                <span class="text-sm text-sky-600">[<i>markdown</i>]</span>
                <pre>
                    <code>
                        <?= trim($readme->getMarkdown()) ?>                    
                    </code>
                </pre>
            </div>

            <div class="overflow-auto bg-zinc-800 p-8 rounded-xl">
                <span class="text-sm text-sky-600">[<i>preview</i>]</span>
                <?= $readme->getHTML() ?>
            </div>
        <?php endif; ?>
    </main>

    <?php require 'src/views/components/footer.php'; ?>

    <!-- JavaScript necesario para la generación dinámica de los
inputs relativos a los autores -->
    <script>
        const bAddAuthor = document.querySelector('#bAddAuthor');
        bAddAuthor.addEventListener('click', e => {
            e.preventDefault();

            // Contenedor de los inputs
            const authorDiv = document.createElement('div');
            authorDiv.classList.add('author');

            // Input de autor
            const authorInput = document.createElement('input');
            authorInput.classList.add('input-author');
            authorInput.type = 'text';
            authorInput.name = 'authors[]';
            authorInput.placeholder = 'Enter author…';
            authorInput.required = true;
            // ↑ Hacemos required para emparejar author/link y que no nos dé error

            // Input de link
            const linkInput = document.createElement('input');
            linkInput.classList.add('input-author');
            linkInput.type = 'url';
            linkInput.name = 'author_links[]';
            linkInput.placeholder = 'Enter link…';
            linkInput.required = true;
            // ↑ Hacemos required para emparejar author/link y que no nos dé error

            // Agregando los inputs en su contenedor
            authorDiv.appendChild(authorInput);
            authorDiv.appendChild(linkInput);

            // Agregando el contenedor en 'moreAuthors'
            document.querySelector('#moreAuthors').appendChild(authorDiv);
        });
    </script>
</body>

</html>