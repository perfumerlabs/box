<?php

namespace Box\Controller;

use Box\Service\Database;

class DocumentController extends LayoutController
{
    public function post()
    {
        $collection = $this->f('collection');
        $data = $this->f('data');

        $this->validateNotEmpty($collection, 'collection');
        $this->validateNotEmpty($data, 'data');
        $this->validateRegex($collection, 'collection', '/^[a-z0-9_]+$/');

        $this->assertWriteAccess($collection);

        $data = json_encode($data);

        if ($data === false) {
            $this->forward('error', 'badRequest', ["\"data\" parameter must be json-serializable"]);
        }

        $key = null;

        try {
            /** @var Database $database */
            $database = $this->s('database');
            $key = $database->insertDocument($this->getClient(), $collection, $data);
        } catch (\Throwable $e) {
            $this->forward('error', 'internalServerError', [$e]);
        }

        $this->setContent([
            'key' => $key
        ]);
    }
}
