<?php

namespace Apps\MyPoll\models;

use PDO;

class Poll extends Database
{
    private string $uuid;
    private int $id;
    private array $options;

    public function __construct(private string $title, $createUuid = true)
    {
        parent::__construct();

        $this->options = [];

        if ($createUuid) {
            $this->uuid = uniqid();
        }
    }

    public function save(): void
    {
        $query = $this->connect()->prepare("INSERT INTO polls (uuid, title) VALUES(:uuid, :title)");
        $query->execute(['uuid' => $this->uuid, 'title' => $this->title]);

        // Obteniendo el id de la "poll" creada
        $query = $this->connect()->prepare("SELECT * FROM polls WHERE uuid = :uuid");
        $query->execute(['uuid' => $this->uuid]);

        // Por defecto fetchColumn devuelve la columna "0",
        // es decir la primera columna, que en nuestro caso el id
        $this->id = $query->fetchColumn();
    }

    public function insertOtiopns(array $options): void
    {
        foreach ($options as $option) {
            $query = $this->connect()->prepare("INSERT INTO options (poll_id, title, votes) VALUES(:poll_id, :title, 0)");
            $query->execute(['poll_id' => $this->id, 'title' => $option]);
        }
    }

    public function vote(int $optionId): Poll
    {
        $query = $this->connect()->prepare("UPDATE options SET votes = votes + 1 WHERE id = :id");
        $query->execute(['id' => $optionId]);

        $poll = self::find($this->uuid);

        return $poll;
    }

    public function getTotalVotes(): int
    {
        $total = 0;

        foreach ($this->options as $option) {
            $total = $total + $option['votes'];
        }

        return $total;
    }

    public function includeOptions(array $arr): void
    {
        array_push($this->options, $arr);
    }

    // ¿Cuándo hace falta un método stático. VER:
    // https://youtu.be/w8CZFQZV_8Y?t=7561
    public static function getPolls(): array
    {
        $db = new Database();

        // Cuando no se necesita insertar valores, no hace falta el "prepare";
        // sólo hay que llamar al método "query"
        $query = $db->connect()->query("SELECT * FROM polls");

        $polls = [];

        // "self hace referencia a la clase para así mandar llamar funciones
        // estáticas. this hace referencia a un objeto ya instanciado para
        // mandar llamar funciones de cualquier otro tipo". VER:
        // https://es.stackoverflow.com/questions/130249/para-qu%C3%A9-sirve-self-y-this-en-php#:~:text=self%20hace%20referencia%20a%20la,funciones%20de%20cualquier%20otro%20tipo.
        while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
            $poll = self::createFromArray($r);
            array_push($polls, $poll);
        }

        return $polls;
    }

    public static function find(string $uuid): Poll
    {
        $db = new Database();

        $query = $db->connect()->prepare("SELECT * FROM polls WHERE uuid = :uuid");
        $query->execute(['uuid' => $uuid]);
        // Obtenemos un array asociativo del único elemento que obtendremos
        // dado que el uuid es único
        $r = $query->fetch();
        $poll = self::createFromArray($r);

        // Consulta de opciones.
        // Aquí hacemos un INNER JOIN (cruzamos las tablas polls y options).
        // Es decir, nos traemos de la DB una encuesta en concreto (por su uuid)
        // con todas la options que le correspondan.
        // VER: http://sql.11sql.com/sql-inner-join.htm
        $query = $db->connect()->prepare("SELECT * FROM polls INNER JOIN options ON polls.id = options.poll_id WHERE polls.uuid = :uuid");
        $query->execute(['uuid' => $uuid]);

        while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
            $poll->includeOptions($r);
        }

        return $poll;
    }

    public static function createFromArray(array $arr): Poll
    {
        $poll = new Poll($arr['title'], false);
        $poll->setUUID($arr['uuid']);
        $poll->setId($arr['id']);

        return $poll;
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

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $value)
    {
        $this->id = $value;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $value)
    {
        $this->title = $value;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
