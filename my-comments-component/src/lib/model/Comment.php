<?php

namespace Apps\Comments\lib\model;

use PDO;
use Apps\Comments\lib\Database;

class Comment extends Database
{

    private string $uuid;
    private string $date;

    public function __construct(private string $username, private string $text, private string $url)
    {
        parent::__construct();
        $this->uuid = uniqid();
    }

    public function save(): void
    {
        $query = $this->connect()->prepare("INSERT INTO comments (uuid, username, text, url, date) VALUES(:uuid, :username, :text, :url, NOW())");
        $query->execute(['uuid' => $this->uuid, 'username' => $this->username, 'text' => $this->text, 'url' => $this->url]);
    }

    public  static function getAll(string $url): array
    {
        $db = new Database();
        $query = $db->connect()->prepare("SELECT * FROM comments WHERE url = :url");
        $query->execute(['url' => $url]);

        $comments = [];

        while ($record = $query->fetch(PDO::FETCH_ASSOC)) {
            $comment = Comment::createFromArray($record);
            array_push($comments, $comment);
        }

        return $comments;
    }

    public static function createFromArray(array $arr): self
    {
        $comment = new Comment($arr['username'], $arr['text'], $arr['url']);
        $comment->setUuid($arr['uuid']);
        $comment->setDate($arr['date']);

        return $comment;
    }

    // getters & setters

    public function setUuid(string $value): void
    {
        $this->uuid = $value;
    }

    public function setDate(string $value): void
    {
        $this->date = $value;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getDate(): string
    {
        return $this->date;
    }
}
