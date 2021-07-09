<?php

namespace Box\Domain;

use Box\Model\Client;
use Box\Model\Coll;
use Box\Model\DocumentLog;
use Box\Model\Map\DocumentLogTableMap;

class DocumentLogDomain
{
    public function create(Client $client, Coll $coll, $id, array $data): ?DocumentLog
    {
        $uuid = $data['uuid'] ?? null;
        $event = $data['event'] ?? null;
        $status = $data['status'] ?? DocumentLogTableMap::COL_STATUS_WAITING;

        $obj = new DocumentLog();
        $obj->setUuid($uuid);
        $obj->setClient($client);
        $obj->setCollection($coll);
        $obj->setDocumentId($id);
        $obj->setEvent($event);
        $obj->setStatus($status);
        $obj->save();

        return $obj;
    }

    public function saveStatus(DocumentLog $document_log, $status)
    {
        if (in_array($status, DocumentLogTableMap::getValueSet(DocumentLogTableMap::COL_STATUS))) {
            $document_log->setStatus($status);
            $document_log->save();
        }
    }

    public function requestProvider(DocumentLog $document_log)
    {
        $document_log->setProviderRequestedAt(new \DateTime());
        $document_log->save();
    }

    public function respondProvider(DocumentLog $document_log)
    {
        $document_log->setProviderRespondAt(new \DateTime());
        $document_log->save();
    }

    public function requestWebhook(DocumentLog $document_log)
    {
        $document_log->setWebhookRequestedAt(new \DateTime());
        $document_log->save();
    }
}