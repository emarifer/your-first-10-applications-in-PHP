<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Application to upload image files and display them">
    <link rel="shortcut icon" href="./src/resources/img/new-php-logo.svg" type="image/svg+xml">
    <meta name="google" content="notranslate" />
    <title>My Images</title>
    <link rel="stylesheet" href="src/resources/css/output.css">
</head>

<body>
    <header>
        <?php require 'src/views/components/navbar.php'; ?>

        <h1 class="text-center text-3xl font-bold mt-36 mb-6">
            These are your images:
        </h1>
    </header>

    <main class="flex flex-wrap gap-6 px-8 mt-12">
        <?php

        $files = array_slice(scandir(substr(__DIR__, 0, strpos(__DIR__, 'src')) . 'img/thumbnail'), 2);
        // var_dump(array_slice($files, 2));
        // echo count($files);
        foreach ($files as $file) {
            echo '<div class="hover:-translate-y-1.5 ease-in duration-300">
                      <a href="img/original/' . $file . '" target="_blank" rel="noreferrer noopener">
                          <img src="img/thumbnail/' . $file . '" />
                      </a>
                  </div>';
        }

        ?>
    </main>

    <?php require 'src/views/components/footer.php'; ?>

</body>

</html>