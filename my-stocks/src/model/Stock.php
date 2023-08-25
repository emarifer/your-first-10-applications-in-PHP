<?php

namespace Apps\Stock\model;

use PDO;
use Apps\Stock\lib\Database;
use Error;

class Stock extends Database
{

    private string $ticker;
    private string $performanceId;
    private mixed $info;

    public function __construct(private string $name)
    {
        parent::__construct();
    }

    // Guarda el name, ticker y performanceId en la DB para no tener
    // que repetir una petición a la API
    public function save(): void
    {
        try {
            $query = $this->connect()->prepare("INSERT INTO stock (name, ticker, performanceId) VALUES (:name, :ticker, :performanceId)");
            $query->execute(['name' => $this->name, 'ticker' => $this->ticker, 'performanceId' => $this->performanceId]);
        } catch (\Throwable $e) {
            # code...
        }
    }

    // Chequea que existe en la API una empresa que cotiza en bolsa con
    // el nombre dado (true/false)
    public function isStockReal(): bool
    {
        try {
            $this->loadProvider();

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    // Chequea que tenemos los datos de la empresa dado su nombre, sobre
    // todo el performanceId, guardados en la DB
    public static function exists(string $name): bool
    {
        $db = new Database();
        $query = $db->connect()->prepare("SELECT * FROM stock WHERE ticker = :name");
        $query->execute(['name' => $name]);

        return $query->rowCount() > 0;
    }

    // $_ENV['API_KEY']
    private function loadProvider(): void
    {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://ms-finance.p.rapidapi.com/market/v2/auto-complete?q=" . $this->name,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: ms-finance.p.rapidapi.com",
                "X-RapidAPI-Key: {$_ENV['API_KEY']}"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            // echo "cURL Error #:" . $err;
            throw new Error($err);
        } else {
            $json = json_decode($response);
            $this->performanceId = $json->results[0]->performanceId;
            $this->name = $json->results[0]->name;
            $this->ticker = $json->results[0]->ticker;
        }
    }

    // Hace la petición a la API, con el dato del performanceId,
    // para traer la info de la cotización de la empresa dada
    // $_ENV['API_KEY']
    private function loadStock(): void
    {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://ms-finance.p.rapidapi.com/stock/v2/get-realtime-data?performanceId=" . $this->performanceId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: ms-finance.p.rapidapi.com",
                "X-RapidAPI-Key: {$_ENV['API_KEY']}"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            // echo "cURL Error #:" . $err;
            throw new Error($err);
        } else {
            // echo $response;
            $this->info = json_decode($response);
        }
    }

    public static function getAll(): array
    {
        $db = new Database();
        // Si el string de la query no tiene values/placeholders
        // entonces se usa el método query directamente
        $query = $db->connect()->query("SELECT * FROM stock");

        $stocks = [];

        while ($record = $query->fetch(PDO::FETCH_ASSOC)) {
            $stock = self::createFromArry($record);
            array_push($stocks, $stock);
        }

        return $stocks;
    }

    public static function createFromArry(array $arr): self
    {
        $stock = new Stock($arr['name']);
        $stock->setTicker($arr['ticker']);
        $stock->setPerformanceId($arr['performanceId']);

        $stock->loadStock();

        return $stock;
    }

    // getters & setters

    public function setTicker(string $value): void
    {
        $this->ticker = $value;
    }

    public function setPerformanceId(string $value): void
    {
        $this->performanceId = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTicker(): string
    {
        return $this->ticker;
    }

    public function getInfo(): mixed
    {
        return $this->info;
    }
}
