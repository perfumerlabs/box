<?php

namespace Box\Controller\Documents;

use Box\Controller\LayoutController;
use Box\Service\Database;

class CountController extends LayoutController
{
    public function get()
    {
        $collection = $this->f('collection');
        $id = $this->f('id', 0);

        $this->validateNotEmpty($collection, 'collection');
        $this->validateRegex($collection, 'collection', '/^[a-z0-9_]+$/');

        $this->assertReadAccess($collection);

        /** @var Database $database */
        $database = $this->s('database');

        $documents = $database->countDocuments($collection, $id);

        $this->setContent([
            'documents' => $documents
        ]);
    }
}
