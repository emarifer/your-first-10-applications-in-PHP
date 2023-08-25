<?php

namespace Apps\Notes\lib;

use PDO;
use PDOException;

class Database
{
    private string $host;
    private string $dbname;
    private string $user;
    private string $password;
    private string $charset;
    private string $port;

    public function __construct()
    {
        $this->host = '127.0.0.1';
        $this->dbname = 'appdb';
        $this->user = 'root';
        $this->password = 'my-secret-pw';
        $this->charset = 'utf8mb4';
        $this->port = '3306';
    }

    public function connect()
    {
        try {
            $connection = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset};port={$this->port}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            return new PDO($connection, $this->user, $this->password, $options);
        } catch (PDOException $th) {
            throw $th;
        }
    }
}
