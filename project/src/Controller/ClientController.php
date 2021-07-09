<?php

namespace Box\Controller;

use Box\Facade\ClientFacade;
use Box\Model\ClientQuery;
use Box\Repository\ClientRepository;
use Box\Service\Database;
use Perfumer\Helper\Arr;
use Propel\Runtime\ActiveQuery\Criteria;

class ClientController extends LayoutController
{
    public function get()
    {
        $this->assertAdmin();

        $id = $this->f('id');
        $name = $this->f('name');
        $obj = null;

        if ($name) {
            $obj = ClientQuery::create()->findOneByName($name);
        }

        if ($id) {
            $obj = ClientQuery::create()->findPk((int) $id);
        }

        if (!$obj) {
            $this->forward('error', 'pageNotFound', ['Client was not found']);
        }

        /** @var ClientRepository $repository */
        $repository = $this->s('repository.client');

        $this->setContent(['client' => $repository->format($obj)]);
    }

    public function post()
    {
        $this->assertAdmin();

        $name = $this->f('name');
        $secret = $this->f('secret');

        $this->validateNotEmpty($name, 'name');
        $this->validateNotEmpty($secret, 'secret');

        $exists = ClientQuery::create()
            ->filterBySecret($secret)
            ->exists();

        if ($exists) {
            $this->forward('error', 'badRequest', ["Client with secret \"" . $secret . "\" already exists"]);
        }

        /** @var ClientFacade $facade */
        $facade = $this->s('facade.client');

        /** @var ClientRepository $repository */
        $repository = $this->s('repository.client');

        /** @var Database $database */
        $database = $this->s('database');

        $con = $database->getPdo();
        $con->beginTransaction();

        try {
            $obj = $facade->create($this->getClient(), Arr::fetch($this->f(), [
                'name',
                'secret',
                'is_admin',
                'is_disabled',
                'description'
            ]));

            $formatted_client = $repository->format($obj);

            $this->setContent(['client' => $formatted_client]);

            $this->getExternalResponse()->setStatusCode(201);

            $con->commit();
        } catch (\Throwable $e) {
            $con->rollBack();

            $this->forward('error', 'internalServerError', [$e]);
        }
    }

    public function patch()
    {
        $this->assertAdmin();

        $id = $this->f('id');
        $secret = $this->f('secret');

        $client = ClientQuery::create()->findPk((int) $id);

        if (!$client) {
            $this->forward('error', 'pageNotFound', ['Client was not found']);
        }

        if ($secret) {
            $exists = ClientQuery::create()
                ->filterBySecret($secret)
                ->filterById($client->getId(), Criteria::NOT_EQUAL)
                ->exists();

            if ($exists) {
                $this->forward('error', 'badRequest', ["Client with secret \"" . $secret . "\" already exists"]);
            }
        }

        /** @var ClientFacade $facade */
        $facade = $this->s('facade.client');

        /** @var ClientRepository $repository */
        $repository = $this->s('repository.client');

        /** @var Database $database */
        $database = $this->s('database');

        $con = $database->getPdo();
        $con->beginTransaction();

        try {
            $obj = $facade->update($this->getClient(), $client, Arr::fetch($this->f(), [
                'name',
                'secret',
                'is_admin',
                'is_disabled',
                'description'
            ]));

            $formatted_client = $repository->format($obj);

            $this->setContent(['client' => $formatted_client]);

            $con->commit();
        } catch (\Throwable $e) {
            $con->rollBack();

            $this->forward('error', 'internalServerError', [$e]);
        }
    }
}
