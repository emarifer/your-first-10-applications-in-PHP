<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="Simple blog made using posts with markdown">
    <link rel="shortcut icon" href="./src/resources/img/new-php-logo.svg" type="image/svg+xml">
    <title>Home</title>
    <link rel="stylesheet" href="src/resources/output.css">
</head>

<body>
    <header>
        <?php require 'src/components/navbar.php'; ?>

        <h1 class="text-center text-3xl font-bold mt-36 mb-12">
            Welcome to my blog!!
        </h1>
        <p class="underline underline-offset-4 text-amber-700 text-center mb-12">
            Post Index
        </p>
    </header>

    <main class="flex flex-col justify-center mt-12">
        <?php

        use Apps\Blog\model\Post;

        $posts = Post::getPosts();

        foreach ($posts as $post) {
            echo "<div class='text-lg hover:text-amber-400 hover:bg-purple-700 px-4 py-2 mx-auto rounded-md'><a class='block md:w-96 text-start' href='{$post->getUrl()}'>{$post->getPostName()}</a></div>";
        }
        ?>
    </main>

    <?php require 'src/components/footer.php'; ?>
</body>

</html>