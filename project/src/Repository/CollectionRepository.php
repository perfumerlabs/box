<?php

namespace Box\Repository;

use Box\Model\Coll;

class CollectionRepository
{
    public function format(?Coll $obj): ?array
    {
        if (!$obj) {
            return null;
        }

        return [
            'id' => $obj->getId(),
            'description' => $obj->getDescription(),
            'name' => $obj->getName(),
            'handler' => $obj->getHandler(),
            'type' => $obj->getType(),
            'created_at' => $obj->getCreatedAt('Y-m-d H:i:s'),
            'updated_at' => $obj->getUpdatedAt('Y-m-d H:i:s'),
            'is_disabled' => $obj->isDisabled(),
        ];
    }

    /**
     * @param Coll[] $objs
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