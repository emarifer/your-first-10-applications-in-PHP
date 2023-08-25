<?php

namespace Apps\Suggestions\Model;

use Apps\Suggestions\lib\Database;
use PDO;

// Si todos los métodos van a ser estáticos no hay nada
// que heredar, por lo tanto, esta clase no tiene porqué extender de Database
class Suggestion
{
    public static function saveSearch(string $q): void
    {
        $common_words = ['de', 'el', 'la', 'para', 'por',  'a'];

        $db = new Database();

        $words = explode(' ', $q);

        foreach ($words as $word) {
            // Añadimos un condicional para que nos excluya palabras comunes
            if (!array_search($word, $common_words)) {
                $query = $db->connect()->prepare("INSERT INTO search (q, session_id) VALUES (:q, :session_id)");

                $query->execute(['q' => $word, 'session_id' => $_SESSION['session_id']]);
            }
        }
    }

    public static function getSuggestion(): array
    {
        $ids = [];
        $res = [];

        $db = new Database();

        $query = $db->connect()->prepare("SELECT * FROM search JOIN products ON products.categories LIKE concat('%', search.q, '%') WHERE session_id = :session_id LIMIT 0,10");

        $query->execute(['session_id' => $_SESSION['session_id']]);

        $records = $query->fetchAll(PDO::FETCH_ASSOC);

        // Explicación de la mecánica de esta función:
        // https://youtu.be/w8CZFQZV_8Y?si=S13KQibet0tJgxYC&t=26911
        // Se trata de evitar las repeticiones de productos, porque el
        // JOIN/LIKE nos puede traer 2 o más veces el mismo registro (producto)
        // porque las palabras introducidas en categorías macheen 2 o más veces
        // con las palabras que introduzca el usuario en su búsqueda
        foreach ($records as $suggestion) {
            // $sugestion es un array asociativo que contiene las columnas del
            // query JOIN/LIKE (id, q, session_id, id, title, categories)
            $exists = array_search($suggestion['id'], $ids);
            // Razón por la que se usa un comparador estricto (===):
            // https://www.php.net/manual/es/function.array-search.php#refsect1-function.array-search-returnvalues
            // https://www.php.net/manual/es/function.array-search.php#refsect1-function.array-search-returnvalues
            if ($exists === false) {
                array_push($ids, $suggestion['id']);
                array_push($res, $suggestion);
            }
        }

        // print_r($ids);

        return $res;
    }
}

/* 

MariaDB [appdb]> SELECT * FROM search JOIN products ON products.categories LIKE concat('%', 'ipad', '%') WHERE session_id = 't2nu127okh1b1kf1r8asvdotg8' LIMIT 0,10;
+----+--------+----------------------------+----+-----------------+------------------------------+
| id | q      | session_id                 | id | title           | categories                   |
+----+--------+----------------------------+----+-----------------+------------------------------+
|  9 | tablet | t2nu127okh1b1kf1r8asvdotg8 |  1 | iPad 512GB Gold | tablet, apple, tableta, ipad |
| 16 | ipad   | t2nu127okh1b1kf1r8asvdotg8 |  1 | iPad 512GB Gold | tablet, apple, tableta, ipad |
+----+--------+----------------------------+----+-----------------+------------------------------+


*/
