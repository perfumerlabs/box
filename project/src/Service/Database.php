<?php

namespace Box\Service;

use Box\Model\Client;
use Envms\FluentPDO\Query;

class Database
{
    private $db;

    private $host;

    private $port;

    private $username;

    private $password;

    private $fetch_limit;

    private $pdo;

    public function __construct(
        $db,
        $host,
        $port,
        $username,
        $password,
        $fetch_limit
    )
    {
        $this->db = $db;
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->fetch_limit = (int) $fetch_limit;
    }

    public function getPdo()
    {
        if (!$this->pdo) {
            $this->pdo = new \PDO("pgsql:host={$this->host};port={$this->port};dbname={$this->db}", $this->username, $this->password);
        }

        return $this->pdo;
    }

    public function getQuery()
    {
        return new Query($this->pdo);
    }

    public function getCollectionName($collection)
    {
        return 'box_data_' . preg_replace('/[^a-zA-Z0-9_]/', '', $collection);
    }

    public function insertDocument(Client $client, string $collection, string $event, string $code, $data): ?int
    {
        $pdo = $this->getPdo();
        $collection = $this->getCollectionName($collection);

        /** @noinspection SqlDialectInspection */
        /** @noinspection SqlNoDataSourceInspection */
        $query = "
            INSERT INTO \"$collection\" (
                \"client_id\",
                \"event\",
                \"code\",
                \"data\", 
                \"created_at\")
            VALUES (:client_id, :event, :code, :data, :created_at)
            ON CONFLICT (\"code\") DO UPDATE SET code=EXCLUDED.code RETURNING id
        ";

        $created_at = date("Y-m-d H:i:s");
        $client_id = $client->getId();

        $stmt = $pdo->prepare($query);
        $stmt->bindParam('event', $event);
        $stmt->bindParam('code', $code);
        $stmt->bindParam('data', $data);
        $stmt->bindParam('created_at', $created_at);
        $stmt->bindParam('client_id', $client_id);
        $stmt->execute();

        $id = $stmt->fetchColumn(0);

        return (int) $id;
    }

    public function getDocuments(string $collection, $from_id, $limit = null): array
    {
        $from_id = (int) $from_id;
        $collection = $this->getCollectionName($collection);
        $limit = (int) $limit;

        if ($limit <= 0 || $limit > $this->fetch_limit) {
            $limit = $this->fetch_limit;
        }

        $pdo = $this->getPdo();

        /** @noinspection SqlNoDataSourceInspection */
        $query = "
                SELECT \"id\", \"code\", \"event\", \"data\" FROM \"$collection\"
                WHERE \"id\" > :from_id
                LIMIT {$limit}
            ";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam('from_id', $from_id);
        $stmt->execute();

        $result = $stmt->fetchAll();

        $array = [];

        foreach ($result as $item) {
            $array[] = [
                'id' => $item['id'],
                'code' => $item['code'],
                'event' => $item['event'],
                'data' => json_decode($item['data'], true),
            ];
        }

        return $array;
    }

    public function countDocuments(string $collection, $from_id): int
    {
        $from_id = (int) $from_id;
        $collection = $this->getCollectionName($collection);

        $pdo = $this->getPdo();

        /** @noinspection SqlNoDataSourceInspection */
        /** @noinspection SqlDialectInspection */
        $query = "
                SELECT COUNT(\"id\") AS nb_documents FROM \"$collection\"
                WHERE \"id\" > :from_id
            ";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam('from_id', $from_id);
        $stmt->execute();

        $result = $stmt->fetchAll();

        return count($result) > 0 ? $result[0]['nb_documents'] : 0;
    }

    public function createTable(string $name): bool
    {
        $name = $this->getCollectionName($name);

        $pdo = $this->getPdo();

        /** @noinspection SqlDialectInspection */
        /** @noinspection SqlNoDataSourceInspection */
        $query = 'CREATE TABLE IF NOT EXISTS "public"."' . $name . '"
            (
                "id" bigserial NOT NULL,
                "client_id" INTEGER NOT NULL,
                "code" VARCHAR(255) NOT NULL,
                "event" VARCHAR(255) NOT NULL,
                "data" JSONB NOT NULL,
                "created_at" TIMESTAMP,
                PRIMARY KEY ("id"),
                CONSTRAINT "' . $name . '_code" UNIQUE ("code")
            );'
        ;

        $stmt = $pdo->prepare($query);

        return $stmt->execute();
    }
}