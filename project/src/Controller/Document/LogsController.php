<?php

namespace Box\Controller\Document;

use Box\Controller\LayoutController;
use Box\Model\DocumentLogQuery;
use Box\Model\Map\DocumentLogTableMap;
use Box\Repository\DocumentLogRepository;
use Propel\Runtime\ActiveQuery\Criteria;

class LogsController extends LayoutController
{
    public function get()
    {
        $this->assertAdmin();

        $client = $this->f('client');
        $collection = $this->f('collection');
        $status = $this->f('status');
        $uuid = $this->f('uuid');
        $event = $this->f('event');
        $document_id = $this->f('document_id');
        $limit = (int)$this->f('limit');
        $offset = (int)$this->f('offset');
        $count = $this->f('count', false);

        if (!$limit) {
            $limit = 0;
        }

        if (!$offset) {
            $offset = 0;
        }

        if (!in_array($status, DocumentLogTableMap::getValueSet(DocumentLogTableMap::COL_STATUS))) {
            $status = null;
        }

        /** @var DocumentLogRepository $repository */
        $repository = $this->s('repository.document_log');

        $objs = DocumentLogQuery::create()
            ->joinWithCollection()
            ->joinWithClient()
            ->orderById(Criteria::DESC);

        if ($client) {
            $objs = $objs->filterByClientId((int)$client);
        }

        if ($collection) {
            $objs = $objs->filterByCollectionId((int)$collection);
        }

        if ($uuid) {
            $objs = $objs->filterByUuid($uuid);
        }

        if ($event) {
            $objs = $objs->filterByEvent($event);
        }

        if ($document_id) {
            $objs = $objs->filterByDocumentId($document_id);
        }

        if ($status) {
            $objs = $objs->filterByStatus($status);
        }

        if ($count) {
            $nb_results_query = clone $objs;
            $nb_results = $nb_results_query->count();
        }

        if ($limit) {
            $objs = $objs->limit($limit);
        }

        if ($offset) {
            $objs = $objs->offset($offset);
        }

        $objs = $objs->find();

        $content = [
            'logs' => $repository->formatCollection($objs),
        ];

        if ($count) {
            $content['nb_results'] = (int)$nb_results;
        }

        $this->setContent($content);
    }
}
