<?php

namespace Box\Controller;

use Box\Facade\AccessFacade;
use Box\Model\AccessQuery;
use Box\Model\ClientQuery;
use Box\Model\CollQuery;
use Box\Repository\AccessRepository;
use Box\Service\Database;

class AccessController extends LayoutController
{
    public function get()
    {
        $this->assertAdmin();

        $id = $this->f('id');

        $obj = AccessQuery::create()->findPk((int) $id);

        if (!$obj) {
            $this->forward('error', 'pageNotFound', ['Access was not found']);
        }

        /** @var AccessRepository $repository */
        $repository = $this->s('repository.access');

        $this->setContent(['access' => $repository->format($obj)]);
    }

    public function post()
    {
        $this->assertAdmin();

        $client = $this->f('client');
        $collection = $this->f('collection');
        $level = $this->f('level');

        $client = ClientQuery::create()->findPk((int) $client);

        if (!$client) {
            $this->forward('error', 'pageNotFound', ['Client was not found']);
        }

        $collection = CollQuery::create()->findPk((int) $collection);

        if (!$collection) {
            $this->forward('error', 'pageNotFound', ['Collection was not found']);
        }

        /** @var AccessFacade $facade */
        $facade = $this->s('facade.access');

        /** @var Database $database */
        $database = $this->s('database');

        $con = $database->getPdo();
        $con->beginTransaction();

        try {
            $facade->create($this->getClient(), $collection, $client, $level);

            $this->getExternalResponse()->setStatusCode(201);

            $con->commit();
        } catch (\Throwable $e) {
            $con->rollBack();

            $this->forward('error', 'internalServerError', [$e]);
        }
    }

    public function delete()
    {
        $this->assertAdmin();

        $id = $this->f('id');
        $client = $this->f('client');
        $collection = $this->f('collection');

        if ($id) {
            $obj = AccessQuery::create()->findPk((int) $id);
        } else {
            $client = ClientQuery::create()->findPk((int) $client);

            if (!$client) {
                $this->forward('error', 'pageNotFound', ['Client was not found']);
            }

            $collection = CollQuery::create()->findPk((int) $collection);

            if (!$collection) {
                $this->forward('error', 'pageNotFound', ['Collection was not found']);
            }

            $obj = AccessQuery::create()
                ->filterByClient($client)
                ->filterByCollection($collection)
                ->findOne();
        }

        if (!$obj) {
            $this->forward('error', 'pageNotFound', ['Access was not found']);
        }

        /** @var AccessFacade $facade */
        $facade = $this->s('facade.access');

        /** @var Database $database */
        $database = $this->s('database');

        $con = $database->getPdo();
        $con->beginTransaction();

        try {
            $facade->delete($this->getClient(), $obj);

            $con->commit();
        } catch (\Throwable $e) {
            $con->rollBack();

            $this->forward('error', 'internalServerError', [$e]);
        }
    }
}
