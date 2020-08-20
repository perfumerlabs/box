<?php

namespace Box\Controller\Documents;

use Box\Controller\LayoutController;
use Box\Service\Database;

class CountController extends LayoutController
{
    public function get()
    {
        $collection = $this->f('collection');
        $key = $this->f('key');

        $this->validateNotEmpty($collection, 'collection');
        $this->validateRegex($collection, 'collection', '/^[a-z0-9_]+$/');

        $this->assertReadAccess($collection);

        /** @var Database $database */
        $database = $this->s('database');

        $from_id = 0;

        if ($key) {
            $from_id = $database->getDocumentIdByKey($collection, $key);

            if ($from_id === null) {
                $this->forward('error', 'pageNotFound', ["Key \"$key\" was not found in the collection \"$collection\""]);
            }
        }

        $documents = $database->countDocuments($collection, $from_id);

        $this->setContent([
            'documents' => $documents
        ]);
    }
}