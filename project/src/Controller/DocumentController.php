<?php

namespace Box\Controller;

use Box\Domain\DocumentLogDomain;
use Box\Model\CollQuery;
use Box\Model\Map\DocumentLogTableMap;
use Box\Service\Database;
use Box\Service\Provider;
use Box\Service\ProviderResponse;
use Box\Service\Queue;

class DocumentController extends LayoutController
{
    public function get()
    {
        $id = $this->f('id');
        $collection = $this->f('collection');

        $this->assertReadAccess($collection);

        $coll = CollQuery::create()
            ->filterByName($collection)
            ->findOne();

        if (!$coll) {
            $this->forward('error', 'badRequest', ["Collection was not found"]);
        }

        if ($coll->isDisabled()) {
            $this->forward('error', 'badRequest', ["Collection is disabled"]);
        }

        /** @var Database $database */
        $database = $this->s('database');

        $document = $database->getDocument($collection, $id);

        if (!$document) {
            $this->forward('error', 'pageNotFound', ['Document was not found']);
        }

        $this->setContent(['document' => $document]);
    }

    public function post()
    {
        $collection = $this->f('collection');
        $event = $this->f('event');
        $uuid = $this->f('uuid');
        $data = $this->f('data');
        $webhook = $this->f('webhook');

        $this->validateNotEmpty($collection, 'collection');
        $this->validateRegex($collection, 'collection', '/^[a-z0-9_]+$/');
        $this->validateNotEmpty($event, 'event');
        $this->validateNotEmpty($uuid, 'uuid');

        $collection = CollQuery::create()
            ->filterByName($collection)
            ->findOne();

        if (!$collection) {
            $this->forward('error', 'badRequest', ["Collection was not found"]);
        }

        if ($collection->isDisabled()) {
            $this->forward('error', 'badRequest', ["Collection is disabled"]);
        }

        if (($collection->isSync() || $collection->isAsync()) && !$collection->getHandler()) {
            $this->forward('error', 'badRequest', ["Handler is not defined for collection"]);
        }

        if ($collection->isAsync() && !$webhook) {
            $this->forward('error', 'badRequest', ["Webhook must be specified for async collections"]);
        }

        $this->assertWriteAccess($collection->getName());

        $encoded_data = null;

        if ($data) {
            $encoded_data = json_encode($data);

            if ($encoded_data === false) {
                $this->forward('error', 'badRequest', ["\"data\" parameter must be json-serializable"]);
            }
        }

        $id = null;
        $document_log = null;

        /** @var DocumentLogDomain $document_log_domain */
        $document_log_domain = $this->s('domain.document_log');

        /** @var Database $database */
        $database = $this->s('database');

        $inserted_document = $database->getDocumentByUuid($collection->getName(), $uuid);

        if ($inserted_document) {
            error_log(sprintf('Existing document: collection - %s, event - %s, uuid  - %s, inserted id - %s', $collection->getName(), $event, $uuid, $id));

            $id = $inserted_document['id'];

            $content = [
                'document' => [
                    'id' => $inserted_document['id'],
                    'collection' => $collection->getName(),
                    'event' => $inserted_document['event'],
                    'uuid' => $inserted_document['uuid'],
                    'webhook' => $inserted_document['webhook'],
                    'data' => $inserted_document['data'],
                ]
            ];
        } else {
            try {
                $id = $database->insertDocument($this->getClient(), $collection->getName(), $event, $uuid, $encoded_data, $webhook);

                if (!$id) {
                    $this->forward('error', 'badRequest', ["Document was not inserted due to unknown issue"]);
                }

                error_log(sprintf('New document: collection - %s, event - %s, uuid  - %s, inserted id - %s', $collection->getName(), $event, $uuid, $id));
            } catch (\Throwable $e) {
                $this->forward('error', 'internalServerError', [$e]);
            }

            $content = [
                'document' => [
                    'id' => $id,
                    'collection' => $collection->getName(),
                    'event' => $event,
                    'uuid' => $uuid,
                    'webhook' => $webhook,
                    'data' => $data,
                ]
            ];
        }

        $document_log_data = [
            'uuid' => $uuid,
            'event' => $event,
        ];

        if ($collection->isStorage()) {
            $document_log_data['status'] = 'success';
        }

        $document_log = $document_log_domain->create($this->getClient(), $collection, $id, $document_log_data);

        if ($collection->isSync()) {
            /** @var Provider $provider */
            $provider = $this->s('provider');

            if ($inserted_document && $inserted_document['response_status_code']) {
                $response = new ProviderResponse();
                $response->status_code = $inserted_document['response_status_code'];
                $response->body = $inserted_document['response_body'];
            } else {
                $document_log_domain->requestProvider($document_log);

                $response = $provider->request($document_log, $data);

                $database->updateDocumentWithResponse($collection->getName(), $id, $response->status_code, $response->body);

                $document_log_domain->respondProvider($document_log);
            }

            $response_content = [
                'status_code' => $response->status_code,
                'body' => $response->body,
            ];

            $content['response'] = $response_content;

            if ($response->status_code < 500) {
                $document_log_domain->saveStatus($document_log, DocumentLogTableMap::COL_STATUS_SUCCESS);
            } else {
                $document_log_domain->saveStatus($document_log, DocumentLogTableMap::COL_STATUS_PROVIDER_FAILED);
            }
        }

        if ($collection->isAsync()) {
            /** @var Queue $queue */
            $queue = $this->s('queue');
            $queue->sendAsyncRequest($document_log);
        }

        $this->getExternalResponse()->setStatusCode(201);

        $this->setContent($content);
    }
}
