<?php

namespace Apps\Notes\model;

use Apps\Notes\lib\Database;
use PDO;

class Note extends Database
{
    private string $uuid;

    public function __construct(private string $title, private string $content)
    {
        parent::__construct();

        $this->uuid = uniqid();
    }

    public function save()
    {
        $query = $this->connect()->prepare("INSERT INTO notes (uuid, title, content, updated) VALUES(:uuid, :title, :content, NOW())");
        $query->execute(['uuid' => $this->uuid, 'title' => $this->title, 'content' => $this->content]);
    }

    public function update()
    {
        $query = $this->connect()->prepare("UPDATE notes SET title = :title, content = :content, updated = NOW() WHERE uuid = :uuid");
        $query->execute(['uuid' => $this->uuid, 'title' => $this->title, 'content' => $this->content]);
    }

    public function delete()
    {
        $query = $this->connect()->prepare("DELETE FROM notes WHERE uuid = :uuid");
        $query->execute(['uuid' => $this->uuid]);
    }

    public static function get(string $uuid): Note
    {
        $db = new Database();
        $query = $db->connect()->prepare("SELECT * FROM notes WHERE uuid = :uuid");
        $query->execute(['uuid' => $uuid]);

        $note = Note::createFromArray($query->fetch(PDO::FETCH_ASSOC));

        return $note;
    }

    public static function getAll()
    {
        $db = new Database();
        $query = $db->connect()->query("SELECT * FROM notes ORDER BY id DESC");

        $notes = [];

        while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
            $note = Note::createFromArray($r);
            array_push($notes, $note);
        }

        return $notes;
    }

    public static function createFromArray(array $arr): Note
    {
        $note = new Note($arr['title'], $arr['content']);
        $note->setUUID($arr['uuid']);

        return $note;
    }

    // getters & setters

    public function getUUID(): string
    {
        return $this->uuid;
    }

    public function setUUID(string $value)
    {
        $this->uuid = $value;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $value)
    {
        $this->title = $value;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $value)
    {
        $this->content = $value;
    }
}
