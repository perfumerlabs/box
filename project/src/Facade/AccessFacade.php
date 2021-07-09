<?php

namespace Box\Facade;

use Box\Domain\AccessDomain;
use Box\Model\Access;
use Box\Model\Client;
use Box\Model\Coll;
use Box\Repository\AccessRepository;
use Box\Service\Database;
use Ramsey\Uuid\Uuid;

class AccessFacade
{
    protected $database;

    protected $access_domain;

    protected $access_repository;

    protected $is_system;

    public function __construct(
        Database $database,
        AccessDomain $access_domain,
        AccessRepository $access_repository,
        $is_system
    )
    {
        $this->database = $database;
        $this->access_domain = $access_domain;
        $this->access_repository = $access_repository;
        $this->is_system = $is_system;
    }

    /**
     * @param Client $creator
     * @param Coll|string $collection
     * @param Client|string $client
     * @param string $level
     * @return Access|null
     */
    public function create(Client $creator, $collection, $client, $level): ?Access
    {
        $obj = $this->access_domain->create($collection, $client, $level);

        if ($this->is_system) {
            // Кидаем данные в таблицу system, чтобы другой инстанс шины мог их забрать и накатить у себя
            $uuid = Uuid::uuid4()->toString();

            $this->database->insertDocument(
                $creator,
                'system',
                'access.create',
                $uuid,
                json_encode([
                    'collection' => $collection instanceof Coll ? $collection->getName() : $collection,
                    'client' => $client instanceof Client ? $client->getName() : $client,
                    'level' => $level,
                ]),
                null
            );
        }

        return $obj;
    }

    public function delete(Client $creator, Access $obj): void
    {
        $this->access_domain->delete($obj);

        if ($this->is_system) {
            // Кидаем данные в таблицу system, чтобы другой инстанс шины мог их забрать и накатить у себя
            $uuid = Uuid::uuid4()->toString();

            $this->database->insertDocument(
                $creator,
                'system',
                'access.delete',
                $uuid,
                json_encode([
                    'collection' => $obj->getCollection()->getName(),
                    'client' => $obj->getClient()->getName(),
                ]),
                null
            );
        }
    }
}