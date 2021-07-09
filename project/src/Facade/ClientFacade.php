<?php

namespace Box\Facade;

use Box\Domain\ClientDomain;
use Box\Model\Client;
use Box\Repository\ClientRepository;
use Box\Service\Database;
use Ramsey\Uuid\Uuid;

class ClientFacade
{
    protected $database;

    protected $client_domain;

    protected $client_repository;

    protected $is_system;

    public function __construct(
        Database $database,
        ClientDomain $client_domain,
        ClientRepository $client_repository,
        $is_system
    )
    {
        $this->database = $database;
        $this->client_domain = $client_domain;
        $this->client_repository = $client_repository;
        $this->is_system = $is_system;
    }

    public function create(Client $creator, array $data): ?Client
    {
        $obj = $this->client_domain->create($data);

        if ($this->is_system) {
            // Кидаем данные в таблицу system, чтобы другой инстанс шины мог их забрать и накатить у себя
            $uuid = Uuid::uuid4()->toString();

            $formatted_client = $this->client_repository->format($obj);

            $this->database->insertDocument(
                $creator,
                'system',
                'client.create',
                $uuid,
                json_encode($formatted_client),
                null
            );
        }

        return $obj;
    }

    public function update(Client $creator, Client $obj, array $data): ?Client
    {
        $obj = $this->client_domain->update($obj, $data);

        if ($this->is_system) {
            // Кидаем данные в таблицу system, чтобы другой инстанс шины мог их забрать и накатить у себя
            $uuid = Uuid::uuid4()->toString();

            $formatted_client = $this->client_repository->format($obj);

            $this->database->insertDocument(
                $creator,
                'system',
                'client.update',
                $uuid,
                json_encode($formatted_client),
                null
            );
        }

        return $obj;
    }
}