<?php

namespace Box\Controller;

use Box\Facade\CollectionFacade;
use Box\Model\CollQuery;
use Box\Repository\CollectionRepository;
use Box\Service\Database;
use Perfumer\Helper\Arr;

class CollectionController extends LayoutController
{
    public function get()
    {
        $this->assertAdmin();

        $id = $this->f('id');
        $name = $this->f('name');
        $obj = null;

        if ($name) {
            $obj = CollQuery::create()->findOneByName($name);
        }

        if ($id) {
            $obj = CollQuery::create()->findPk((int) $id);
        }

        if (!$obj) {
            $this->forward('error', 'pageNotFound', ['Collection was not found']);
        }

        /** @var CollectionRepository $collection_repository */
        $collection_repository = $this->s('repository.collection');

        $this->setContent(['collection' => $collection_repository->format($obj)]);
    }

    public function post()
    {
        $this->assertAdmin();

        $name = $this->f('name');

        $this->validateNotEmpty($name, 'name');
        $this->validateRegex($name, 'name', '/^[a-z0-9_]+$/');

        if (in_array($name, ['system'])) {
            $this->forward('error', 'badRequest', ["This name is reserved"]);
        }

        $exists = CollQuery::create()
            ->filterByName($name)
            ->exists();

        if ($exists) {
            $this->forward('error', 'badRequest', ["Collection with name \"" . $name . "\" already exists"]);
        }

        /** @var Database $database */
        $database = $this->s('database');

        /** @var CollectionFacade $collection_facade */
        $collection_facade = $this->s('facade.collection');

        /** @var CollectionRepository $collection_repository */
        $collection_repository = $this->s('repository.collection');

        $con = $database->getPdo();
        $con->beginTransaction();

        try {
            $obj = $collection_facade->create($this->getClient(), Arr::fetch($this->f(), [
                'name',
                'type',
                'handler',
                'is_disabled',
                'description'
            ]));

            $formatted_collection = $collection_repository->format($obj);

            $this->setContent(['collection' => $formatted_collection]);

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

        $obj = CollQuery::create()->findPk((int) $id);

        if (!$obj) {
            $this->forward('error', 'pageNotFound', ['Collection was not found']);
        }

        /** @var Database $database */
        $database = $this->s('database');

        /** @var CollectionFacade $collection_facade */
        $collection_facade = $this->s('facade.collection');

        /** @var CollectionRepository $collection_repository */
        $collection_repository = $this->s('repository.collection');

        $con = $database->getPdo();
        $con->beginTransaction();

        try {
            $obj = $collection_facade->update($this->getClient(), $obj, Arr::fetch($this->f(), [
                'handler',
                'is_disabled',
                'description'
            ]));

            $formatted_collection = $collection_repository->format($obj);

            $this->setContent(['collection' => $formatted_collection]);

            $con->commit();
        } catch (\Throwable $e) {
            $con->rollBack();

            $this->forward('error', 'internalServerError', [$e]);
        }
    }
}
