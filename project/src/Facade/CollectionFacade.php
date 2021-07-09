<?php

namespace Box\Facade;

use Box\Domain\CollectionDomain;
use Box\Model\Client;
use Box\Model\Coll;
use Box\Repository\CollectionRepository;
use Box\Service\Database;
use Ramsey\Uuid\Uuid;

class CollectionFacade
{
    protected $database;

    protected $collection_domain;

    protected $collection_repository;

    protected $is_system;

    public function __construct(
        Database $database,
        CollectionDomain $collection_domain,
        CollectionRepository $collection_repository,
        $is_system
    )
    {
        $this->database = $database;
        $this->collection_domain = $collection_domain;
        $this->collection_repository = $collection_repository;
        $this->is_system = $is_system;
    }

    public function create(Client $client, array $data): ?Coll
    {
        $name = $data['name'] ?? null;

        $created = $this->database->createTable($name);

        if ($created) {
            $obj = $this->collection_domain->create($data);

            if ($this->is_system) {
                // Кидаем данные в таблицу system, чтобы другой инстанс шины мог их забрать и накатить у себя
                $uuid = Uuid::uuid4()->toString();

                $formatted_collection = $this->collection_repository->format($obj);

                $this->database->insertDocument(
                    $client,
                    'system',
                    'collection.create',
                    $uuid,
                    json_encode($formatted_collection),
                    null
                );
            }
        }

        return $obj;
    }

    public function update(Client $client, Coll $obj, array $data): ?Coll
    {
        $obj = $this->collection_domain->update($obj, $data);

        if ($this->is_system) {
            // Кидаем данные в таблицу system, чтобы другой инстанс шины мог их забрать и накатить у себя
            $uuid = Uuid::uuid4()->toString();

            $formatted_collection = $this->collection_repository->format($obj);

            $this->database->insertDocument(
                $client,
                'system',
                'collection.update',
                $uuid,
                json_encode($formatted_collection),
                null
            );
        }

        return $obj;
    }
}