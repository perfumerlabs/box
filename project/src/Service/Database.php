<?php

namespace Box\Service;

use Box\Model\Client;

class Database
{
    private $db;

    private $schema;

    private $host;

    private $port;

    private $username;

    private $password;

    private $fetch_limit;

    private $pdo;

    public function __construct(
        $db,
        $schema,
        $host,
        $port,
        $username,
        $password,
        $fetch_limit
    )
    {
        $this->db = $db;
        $this->schema = $schema;
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

            if (
                $this->schema !== 'public' &&
                $this->schema !== 'PG_SCHEMA' &&
                $this->schema
            ) {
                $this->pdo->exec('SET search_path TO ' . $this->schema);
            }
        }

        return $this->pdo;
    }

    public function getCollectionName($collection)
    {
        return 'box_data_' . preg_replace('/[^a-zA-Z0-9_]/', '', $collection);
    }

    public function insertDocument(Client $client, string $collection, string $event, string $uuid, $data, ?string $webhook): ?int
    {
        $pdo = $this->getPdo();
        $collection = $this->getCollectionName($collection);

        /** @noinspection SqlDialectInspection */
        /** @noinspection SqlNoDataSourceInspection */
        $query = "
            INSERT INTO \"$collection\" (
                \"client_id\",
                \"event\",
                \"uuid\",
                \"data\", 
                \"webhook\", 
                \"created_at\", 
                \"updated_at\"
            )
            VALUES (:client_id, :event, :uuid, :data, :webhook, :created_at, :updated_at)
            ON CONFLICT (\"uuid\") DO UPDATE SET uuid=EXCLUDED.uuid RETURNING id
        ";

        $created_at = date("Y-m-d H:i:s");
        $updated_at = date("Y-m-d H:i:s");
        $client_id = $client->getId();

        $stmt = $pdo->prepare($query);
        $stmt->bindParam('event', $event);
        $stmt->bindParam('uuid', $uuid);
        $stmt->bindParam('data', $data);
        $stmt->bindParam('webhook', $webhook);
        $stmt->bindParam('created_at', $created_at);
        $stmt->bindParam('updated_at', $updated_at);
        $stmt->bindParam('client_id', $client_id);
        $stmt->execute();

        $id = $stmt->fetchColumn(0);

        return (int) $id;
    }

    public function updateDocumentWithResponse($collection, $id, $response_status_code, $response_body)
    {
        $pdo = $this->getPdo();
        $collection = $this->getCollectionName($collection);

        /** @noinspection SqlDialectInspection */
        /** @noinspection SqlNoDataSourceInspection */
        $query = "
            UPDATE \"$collection\" SET
                \"response_status_code\" = :response_status_code,
                \"response_body\" = :response_body
            WHERE \"id\" = :id
        ";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam('id', $id);
        $stmt->bindParam('response_status_code', $response_status_code);
        $stmt->bindParam('response_body', $response_body);
        $stmt->execute();
    }

    public function getDocumentByUuid(string $collection, $uuid): ?array
    {
        $collection_name = $this->getCollectionName($collection);

        $pdo = $this->getPdo();

        /** @noinspection SqlNoDataSourceInspection */
        $query = "
                SELECT 
                       \"id\", 
                       \"uuid\", 
                       \"event\", 
                       \"data\", 
                       \"webhook\", 
                       \"response_status_code\", 
                       \"response_body\" 
                FROM \"$collection_name\"
                WHERE \"uuid\" = :uuid
            ";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam('uuid', $uuid);
        $stmt->execute();

        $result = $stmt->fetchAll();

        $array = null;

        if ($result) {
            $item = $result[0];

            $array = [
                'id' => $item['id'],
                'collection' => $collection,
                'uuid' => $item['uuid'],
                'event' => $item['event'],
                'webhook' => $item['webhook'],
                'response_status_code' => $item['response_status_code'],
                'response_body' => $item['response_body'],
                'data' => json_decode($item['data'], true),
            ];
        }

        return $array;
    }

    public function getDocument(string $collection, $id): ?array
    {
        $collection_name = $this->getCollectionName($collection);

        $pdo = $this->getPdo();

        /** @noinspection SqlNoDataSourceInspection */
        $query = "
                SELECT 
                       \"id\", 
                       \"uuid\", 
                       \"event\", 
                       \"data\", 
                       \"webhook\", 
                       \"response_status_code\", 
                       \"response_body\" 
                FROM \"$collection_name\"
                WHERE \"id\" = :id
            ";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam('id', $id);
        $stmt->execute();

        $result = $stmt->fetchAll();

        $array = null;

        if ($result) {
            $item = $result[0];

            $array = [
                'id' => $item['id'],
                'collection' => $collection,
                'uuid' => $item['uuid'],
                'event' => $item['event'],
                'webhook' => $item['webhook'],
                'response_status_code' => $item['response_status_code'],
                'response_body' => $item['response_body'],
                'data' => json_decode($item['data'], true),
            ];
        }

        return $array;
    }

    public function getDocuments(string $collection, $from_id, $limit = null): array
    {
        $from_id = (int) $from_id;
        $collection_name = $this->getCollectionName($collection);
        $limit = (int) $limit;

        if ($limit <= 0 || $limit > $this->fetch_limit) {
            $limit = $this->fetch_limit;
        }

        $pdo = $this->getPdo();

        /** @noinspection SqlNoDataSourceInspection */
        $query = "
                SELECT \"id\", \"uuid\", \"event\", \"data\", \"webhook\" FROM \"$collection_name\"
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
                'collection' => $collection,
                'uuid' => $item['uuid'],
                'event' => $item['event'],
                'webhook' => $item['webhook'],
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
        $query = 'CREATE TABLE IF NOT EXISTS "' . $name . '"
            (
                "id" bigserial NOT NULL,
                "client_id" INTEGER NOT NULL,
                "uuid" VARCHAR(255) NOT NULL,
                "event" VARCHAR(255) NOT NULL,
                "data" JSONB,
                "response_status_code" INTEGER,
                "response_body" TEXT,
                "webhook" VARCHAR(255),
                "created_at" TIMESTAMP,
                "updated_at" TIMESTAMP,
                PRIMARY KEY ("id"),
                CONSTRAINT "' . $name . '_uuid" UNIQUE ("uuid")
            );'
        ;

        $stmt = $pdo->prepare($query);

        return $stmt->execute();
    }
}