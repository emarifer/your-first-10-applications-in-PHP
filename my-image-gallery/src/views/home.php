<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Application to upload image files and display them">
    <link rel="shortcut icon" href="./src/resources/img/new-php-logo.svg" type="image/svg+xml">
    <meta name="google" content="notranslate" />
    <title>Upload your images!!</title>
    <link rel="stylesheet" href="src/resources/css/output.css">
</head>

<body>
    <header>
        <?php require 'src/views/components/navbar.php'; ?>

        <h1 class="text-center text-3xl font-bold mt-36 mb-6">
            Upload your images!!
        </h1>
    </header>

    <main>
        <form class="mx-auto w-fit h-fit bg-sky-600 hover:bg-sky-500 px-4 py-2 rounded-lg cursor-pointer" action="?view=upload" method="post" enctype="multipart/form-data">
            <label class="w-32 text-sm font-semibold cursor-pointer">
                Select an image and upload it!
                <input class="hidden" type="file" id="file" name="file" multiple accept="image/*">
            </label>
            <!-- Cuando se delega en JS el envío del formulario no es necesario el submit -->
            <!-- <input class="text-lg bg-sky-600 hover:bg-sky-500 px-4 py-2 rounded-lg" type="submit" value="Upload"> -->
        </form>

        <div class="flex gap-3 flex-wrap mx-auto my-16" id="files-container">

        </div>
    </main>

    <?php require 'src/views/components/footer.php'; ?>

    <script src="src/resources/js/app.js"></script>
</body>

</html>