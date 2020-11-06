<?php

namespace Box\Controller;

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

        /** @var Database $database */
        $database = $this->s('database');

        $documents = $database->getDocuments($collection, $id, $limit);

        $this->setContent([
            'documents' => $documents
        ]);
    }
}
