<?php

namespace Box\Controller;

use Box\Model\CollQuery;
use Box\Service\Database;

class DocumentsController extends LayoutController
{
    public function get()
    {
        $collection = $this->f('collection');
        $id = $this->f('id', 0);
        $limit = $this->f('limit');

        $this->validateNotEmpty($collection, 'collection');
        $this->validateRegex($collection, 'collection', '/^[a-z0-9_]+$/');

        $this->assertReadAccess($collection);

        $collection = CollQuery::create()
            ->filterByName($collection)
            ->findOne();

        if (!$collection) {
            $this->forward('error', 'badRequest', ["Collection was not found"]);
        }

        if ($collection->isDisabled()) {
            $this->forward('error', 'badRequest', ["Collection is disabled"]);
        }

        /** @var Database $database */
        $database = $this->s('database');

        $documents = $database->getDocuments($collection->getName(), $id, $limit);

        $this->setContent([
            'documents' => $documents
        ]);
    }
}
