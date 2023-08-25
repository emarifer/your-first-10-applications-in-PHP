<?php 

namespace Apps\Stock\lib;

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
        $this->host = $_ENV['HOST'];
        $this->dbname = $_ENV['DBNAME'];
        $this->user = $_ENV['DBUSER'];
        $this->password = $_ENV['PASSWORD'];
        $this->charset = $_ENV['CHARSET'];
        $this->port = $_ENV['PORT'];
    }

    public function connect(): PDO
    {
        try {
            $connection = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset};port={$this->port}";

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            return new PDO($connection, $this->user, $this->password, $options);
        } catch (PDOException $e) {
            print_r('Error $connection: ' . $e->getMessage());
        }
    }
}
