<?php

namespace Box\Domain;

use Box\Model\Access;
use Box\Model\AccessQuery;
use Box\Model\Client;
use Box\Model\ClientQuery;
use Box\Model\Coll;
use Box\Model\CollQuery;
use Box\Model\Map\AccessTableMap;

class AccessDomain
{
    /**
     * @param Coll|string $collection
     * @param Client|string $client
     * @param string $level
     * @return Access|null
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function create($collection, $client, $level): ?Access
    {
        if (is_string($collection)) {
            $collection = CollQuery::create()->findOneByName($collection);
        }

        if (is_string($client)) {
            $client = ClientQuery::create()->findOneByName($client);
        }

        $access = AccessQuery::create()
            ->filterByClient($client)
            ->filterByCollection($collection)
            ->findOneOrCreate();

        if (in_array($level, AccessTableMap::getValueSet(AccessTableMap::COL_LEVEL))) {
            $access->setLevel($level);
        }

        $access->save();

        return $access;
    }

    public function delete(Access $obj)
    {
        $obj->delete();
    }

    /**
     * @param Coll|string $collection
     * @param Client|string $client
     */
    public function deleteByNames($collection, $client)
    {
        if (is_string($collection)) {
            $collection = CollQuery::create()->findOneByName($collection);
        }

        if (is_string($client)) {
            $client = ClientQuery::create()->findOneByName($client);
        }

        $access = AccessQuery::create()
            ->filterByClient($client)
            ->filterByCollection($collection)
            ->findOne();

        if ($access) {
            $access->delete();
        }
    }
}