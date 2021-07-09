<?php

namespace Box\Domain;

use Box\Model\Coll;
use Box\Model\CollQuery;
use Box\Model\Map\CollTableMap;

class CollectionDomain
{
    public function create(array $data): ?Coll
    {
        $name = $data['name'] ?? null;
        $description = $data['description'] ?? null;
        $type = $data['type'] ?? CollTableMap::COL_TYPE_STORAGE;
        $handler = $data['handler'] ?? null;
        $is_disabled = $data['is_disabled'] ?? false;

        if (!in_array($type, CollTableMap::getValueSet(CollTableMap::COL_TYPE))) {
            $type = CollTableMap::COL_TYPE_STORAGE;
        }

        $obj = new Coll();
        $obj->setName($name);
        $obj->setType($type);
        $obj->setDescription($description);
        $obj->setHandler($handler);
        $obj->setIsDisabled((bool) $is_disabled);

        if ($obj->isProtected()) {
            $obj->setIsDisabled(false);
        }

        $obj->save();

        return $obj;
    }

    public function upsert(array $data)
    {
        $name = $data['name'] ?? null;

        $obj = CollQuery::create()
            ->filterByName($name)
            ->findOneOrCreate();

        if ($obj->isNew()) {
            return $this->create($data);
        } else {
            return $this->update($obj, $data);
        }
    }

    public function update(Coll $obj, array $data): ?Coll
    {
        if (array_key_exists('handler', $data) && $data['handler']) {
            $obj->setHandler($data['handler']);
        }

        if (array_key_exists('is_disabled', $data) && is_bool($data['is_disabled'])) {
            $obj->setIsDisabled($data['is_disabled']);
        }

        if (array_key_exists('description', $data)) {
            $obj->setDescription($data['description']);
        }

        if ($obj->isProtected()) {
            $obj->setIsDisabled(false);
        }

        $obj->save();

        return $obj;
    }
}