<?php

if (isset($_GET['view'])) {
    $view = $_GET['view'];

    require 'src/views/' . $view . '.php';
} else {
    require 'src/views/home.php';
}

/* 
ENTRAR EN MARIADB POR LÍNEA DE COMANDOS CON DOCKER:
docker exec -it apps-db mariadb --user root -p

INSTALACIÓN DE TAILWINDCSS EN PHP:
https://www.geeksforgeeks.org/installation-setup-guide-of-tailwind-css-with-php/

CONFIGURACIÓN DE TAILWIND INTELLESENSE EN VSCODE:
https://marketplace.visualstudio.com/items?itemName=bradlc.vscode-tailwindcss
https://javascript.plainenglish.io/how-to-fix-tailwind-css-intellisense-in-visual-studio-code-3dede794df21

PHP y la función header(location: ):
https://es.stackoverflow.com/questions/19791/php-y-la-funci%C3%B3n-headerlocation

Diferencia entre fetch y fetchall en PHP?:
https://es.stackoverflow.com/questions/184341/diferencia-entre-fetch-y-fetchall-en-php

MariaDB Order By:
https://www.mariadbtutorial.com/mariadb-basics/mariadb-order-by/

How to Comment in VS Code - The VSCode Comment Shortcut;
https://vscode.one/comment-vscode/

https://github.com/marcosrivasr/10-apps-php/tree/main/01-notas
*/