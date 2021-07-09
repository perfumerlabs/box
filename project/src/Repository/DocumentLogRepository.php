<?php

namespace Box\Repository;

use Box\Model\DocumentLog;

class DocumentLogRepository
{
    protected $collection_repository;

    protected $client_repository;

    public function __construct(CollectionRepository $collection_repository, ClientRepository $client_repository)
    {
        $this->collection_repository = $collection_repository;
        $this->client_repository = $client_repository;
    }

    public function format(?DocumentLog $obj, $document = null): ?array
    {
        if (!$obj) {
            return null;
        }

        $array = [
            'id' => $obj->getId(),
            'collection' => $this->collection_repository->format($obj->getCollection()),
            'client' => $this->client_repository->format($obj->getClient()),
            'uuid' => $obj->getUuid(),
            'document_id' => $obj->getDocumentId(),
            'event' => $obj->getEvent(),
            'status' => $obj->getStatus(),
            'created_at' => $obj->getCreatedAt('Y-m-d H:i:s'),
            'provider_requested_at' => $obj->getProviderRequestedAt('Y-m-d H:i:s'),
            'provider_respond_at' => $obj->getProviderRespondAt('Y-m-d H:i:s'),
            'webhook_requested_at' => $obj->getWebhookRequestedAt('Y-m-d H:i:s'),
        ];

        if ($document) {
            $array['response_status_code'] = $document['response_status_code'] ?? null;
            $array['response_body'] = $document['response_body'] ?? null;
        }

        return $array;
    }

    /**
     * @param DocumentLog[] $objs
     * @return array|null
     */
    public function formatCollection($objs): ?array
    {
        if (!$objs) {
            return null;
        }

        $result = [];

        foreach ($objs as $obj) {
            $result[] = $this->format($obj);
        }

        return $result;
    }
}