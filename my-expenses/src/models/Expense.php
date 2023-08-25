<?php

namespace Apps\Expense\models;

use Apps\Expense\lib\Database;
use PDO;

class Expense extends Database
{
    private Category $category;
    private string $date;

    public function __construct(private string $title, private int $categoryId, private float $expense)
    {
        parent::__construct();
    }

    public function save(): void
    {
        $query = $this->connect()->prepare("INSERT INTO expenses (title, category_id, expense, date) VALUES (:title, :category_id, :expense, NOW())");
        $query->execute(['title' => $this->title, 'category_id' => $this->categoryId, 'expense' => $this->expense]);
    }

    public static function getAll(): array
    {
        $db = new Database();
        // Si el string de la query no tiene values/placeholders
        // entonces se usa el método query directamente
        $query = $db->connect()->query("SELECT * FROM expenses");

        $expenses = [];

        while ($record = $query->fetch(PDO::FETCH_ASSOC)) {
            $expense = self::createFromArray($record);
            array_push($expenses, $expense);
        }

        return $expenses;
    }

    public static function createFromArray(array $arr): self
    {
        $expense = new Expense($arr['title'], $arr['category_id'], $arr['expense']);
        $expense->setDate($arr['date']);
        $expense->setCategory(Category::get($arr['category_id']));

        return $expense;
    }

    public static function getTotal(array $expenses): float
    {
        $total = 0.0;
        foreach ($expenses as $expense) {
            $total += $expense->getExpense();
        }

        return $total;
    }

    // getters & setters

    public function setDate(string $value): void
    {
        $this->date = $value;
    }

    public function setCategory(Category $value): void
    {
        $this->category = $value;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getExpense(): float
    {
        return $this->expense;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
