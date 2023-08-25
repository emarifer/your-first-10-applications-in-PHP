<?php

use Intervention\Image\ImageManager;

$fileName = uniqid() . '-' . $_FILES['file']['name'];
// echo $fileName;

$tmpFile = $_FILES['file']['tmp_name'];
// echo $tmpFile;

$manager = new ImageManager(['driver' => 'imagick']);

$img = $manager->make($tmpFile);
$img->save(substr(__DIR__, 0, strpos(__DIR__, 'src')) . 'img/original/' . $fileName);
// echo substr(__DIR__, 0, strpos(__DIR__, 'src')) . 'img/original/' . $fileName;

$img->resize(300, 300, function ($constraint) {
    $constraint->aspectRatio();
    $constraint->upsize();
});

// Guardamos el thumbnail en su carpeta homónima,
// que tiene todos los permisos de lectura/escritua, como original
$img->save(substr(__DIR__, 0, strpos(__DIR__, 'src')) . 'img/thumbnail/' . $fileName);
