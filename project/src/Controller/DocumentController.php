<?php

namespace Box\Controller;

use Box\Service\Database;

class DocumentController extends LayoutController
{
    public function post()
    {
        $collection = $this->f('collection');
        $event = $this->f('event');
        $code = $this->f('code');
        $data = $this->f('data');

        $this->validateNotEmpty($collection, 'collection');
        $this->validateRegex($collection, 'collection', '/^[a-z0-9_]+$/');
        $this->validateNotEmpty($event, 'event');
        $this->validateNotEmpty($code, 'code');
        $this->validateNotEmpty($data, 'data');

        $this->assertWriteAccess($collection);

        $data = json_encode($data);

        if ($data === false) {
            $this->forward('error', 'badRequest', ["\"data\" parameter must be json-serializable"]);
        }

        $id = null;

        try {
            /** @var Database $database */
            $database = $this->s('database');
            $id = $database->insertDocument($this->getClient(), $collection, $event, $code, $data);

            error_log(sprintf('New document: collection - %s, event - %s, code  - %s, inserted id - %s', $collection, $event, $code, $id));
        } catch (\Throwable $e) {
            $this->forward('error', 'internalServerError', [$e]);
        }

        $this->setContent([
            'id' => $id
        ]);
    }
}
