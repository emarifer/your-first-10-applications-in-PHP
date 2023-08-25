<?php

namespace Apps\Expense\models;

use Apps\Expense\lib\Database;
use PDO;

class Category extends Database
{
    private int $id;

    public function __construct(private string $name)
    {
        parent::__construct();
    }

    public function save(): void
    {
        $query = $this->connect()->prepare("INSERT INTO categories (name) VALUES (:name)");
        $query->execute(['name' => $this->name]);
    }

    public static function getAll(): array
    {
        $db = new Database();
        // Si el string de la query no tiene values/placeholders
        // entonces se usa el método query directamente
        $query = $db->connect()->query("SELECT * FROM categories");

        $categories = [];

        while ($record = $query->fetch(PDO::FETCH_ASSOC)) {
            $category = self::createFromArray($record);
            array_push($categories, $category);
        }

        return $categories;
    }

    public static function get(int $id): self
    {
        $db = new Database();
        $query = $db->connect()->prepare("SELECT * FROM categories WHERE id = :id");
        $query->execute(['id' => $id]);

        $record = $query->fetch(PDO::FETCH_ASSOC);
        $category = self::createFromArray($record);

        return $category;
    }

    public static function exists(string $name): bool
    {
        $db = new Database();
        $query = $db->connect()->prepare('SELECT * FROM categories WHERE name = :name');
        $query->execute(['name' => $name]);

        return $query->rowCount() > 0;
    }

    public static function createFromArray(array $arr): self
    {
        $category = new Category($arr['name']);
        $category->setId($arr['id']);

        return $category;
    }

    // getters & setters

    public function setId(int $value): void
    {
        $this->id = $value;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
