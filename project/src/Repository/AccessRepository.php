<?php

namespace Box\Repository;

use Box\Model\Access;

class AccessRepository
{
    protected $collection_repository;

    protected $client_repository;

    public function __construct(CollectionRepository $collection_repository, ClientRepository $client_repository)
    {
        $this->collection_repository = $collection_repository;
        $this->client_repository = $client_repository;
    }

    public function format(?Access $obj): ?array
    {
        if (!$obj) {
            return null;
        }

        return [
            'id' => $obj->getId(),
            'collection' => $this->collection_repository->format($obj->getCollection()),
            'client' => $this->client_repository->format($obj->getClient()),
            'level' => $obj->getLevel(),
        ];
    }

    /**
     * @param Access[] $objs
     * @return array|null
     */
    public function formatCollection($objs): ?array
    {
        if (!$objs) {
            return null;
        }

        $result = [];

        foreach ($objs as $obj) {
            $result[] = $this->format($obj);
        }

        return $result;
    }
}