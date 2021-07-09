<?php

namespace Box\Controller\Document;

use Box\Controller\LayoutController;
use Box\Model\DocumentLogQuery;
use Box\Repository\DocumentLogRepository;
use Box\Service\Database;

class LogController extends LayoutController
{
    public function get()
    {
        $this->assertAdmin();

        $id = $this->f('id');

        $obj = DocumentLogQuery::create()->findPk((int) $id);

        if (!$obj) {
            $this->forward('error', 'pageNotFound', ['Document log was not found']);
        }

        /** @var Database $database */
        $database = $this->s('database');

        $document = $database->getDocument($obj->getCollection()->getName(), $obj->getDocumentId());

        if (!$document) {
            $this->forward('error', 'pageNotFound', ['Document was not found']);
        }

        /** @var DocumentLogRepository $repository */
        $repository = $this->s('repository.document_log');

        $this->setContent(['log' => $repository->format($obj, $document)]);
    }
}
