<?php

use Apps\Blog\model\Post;

$post = new Post($_GET['post'] . '.md');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="description" content="Simple blog made using posts with markdown">
    <link rel="shortcut icon" href="./src/resources/img/new-php-logo.svg" type="image/svg+xml">
    <title><?php echo $post->getContent()['title']; ?></title>
    <link rel="stylesheet" href="src/resources/post.css">
</head>

<body>
    <?php require 'src/components/navbar.php'; ?>

    <header>My Blog</header>

    <main>
        <?php echo $post->getContent()['content']; ?>
    </main>

    <?php require 'src/components/footer.php'; ?>
</body>

</html>