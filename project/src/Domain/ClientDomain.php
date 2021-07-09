<?php

namespace Box\Domain;

use Box\Model\Client;
use Box\Model\ClientQuery;

class ClientDomain
{
    public function create(array $data): ?Client
    {
        $name = $data['name'] ?? null;
        $description = $data['description'] ?? null;
        $secret = $data['secret'] ?? null;
        $is_admin = $data['is_admin'] ?? false;
        $is_disabled = $data['is_disabled'] ?? false;

        $obj = new Client();
        $obj->setSecret($secret);
        $obj->setName($name);
        $obj->setDescription($description);
        $obj->setIsAdmin((bool) $is_admin);
        $obj->setIsDisabled((bool) $is_disabled);
        $obj->save();

        return $obj;
    }

    public function upsert(array $data)
    {
        $name = $data['name'] ?? null;

        $obj = ClientQuery::create()
            ->filterByName($name)
            ->findOneOrCreate();

        if ($obj->isNew()) {
            return $this->create($data);
        } else {
            return $this->update($obj, $data);
        }
    }

    public function update(Client $obj, array $data): ?Client
    {
        if (array_key_exists('is_admin', $data) && is_bool($data['is_admin'])) {
            $obj->setIsAdmin($data['is_admin']);
        }

        if (array_key_exists('is_disabled', $data) && is_bool($data['is_disabled'])) {
            $obj->setIsDisabled($data['is_disabled']);
        }

        if (array_key_exists('secret', $data) && $data['secret']) {
            $obj->setSecret($data['secret']);
        }

        if (array_key_exists('description', $data)) {
            $obj->setDescription($data['description']);
        }

        $obj->save();

        return $obj;
    }
}