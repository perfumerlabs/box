<?php

namespace Box\Repository;

use Box\Model\Client;

class ClientRepository
{
    public function format(?Client $obj): ?array
    {
        if (!$obj) {
            return null;
        }

        return [
            'id' => $obj->getId(),
            'name' => $obj->getName(),
            'description' => $obj->getDescription(),
            'secret' => $obj->getSecret(),
            'is_admin' => $obj->isAdmin(),
            'is_disabled' => $obj->isDisabled(),
        ];
    }

    /**
     * @param Client[] $objs
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