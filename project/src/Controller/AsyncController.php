<?php

namespace Box\Controller;

use Box\Domain\DocumentLogDomain;
use Box\Model\DocumentLogQuery;
use Box\Model\Map\DocumentLogTableMap;
use Box\Service\Database;
use Box\Service\Provider;
use Box\Service\ProviderResponse;
use Perfumer\Framework\Controller\PlainController;
use Perfumer\Framework\Router\Http\FastRouteRouterControllerHelpers;

class AsyncController extends PlainController
{
    use FastRouteRouterControllerHelpers;

    public function action()
    {
        $id = $this->f('id');

        $document_log = DocumentLogQuery::create()
            ->joinWithCollection()
            ->findPk((int) $id);

        if (
            !$document_log ||
            $document_log->getStatus() !== DocumentLogTableMap::COL_STATUS_WAITING ||
            !$document_log->getCollection()->isAsync()
        ) {
            return;
        }

        /** @var Database $database */
        $database = $this->s('database');
        $document = $database->getDocument($document_log->getCollection()->getName(), $document_log->getDocumentId());

        /** @var Provider $provider */
        $provider = $this->s('provider');

        /** @var DocumentLogDomain $document_log_domain */
        $document_log_domain = $this->s('domain.document_log');

        if (!$document) {
            $document_log_domain->saveStatus($document_log, DocumentLogTableMap::COL_STATUS_DOCUMENT_NOT_FOUND);
            return;
        }

        if ($document['response_status_code'] && $document['response_status_code'] < 500) {
            $response = new ProviderResponse();
            $response->status_code = $document['response_status_code'];
            $response->body = $document['response_body'];
        } else {
            $document_log_domain->requestProvider($document_log);

            $response = $provider->request($document_log, $document['data']);
        }

        if ($response->status_code < 500) {
            $database->updateDocumentWithResponse($document_log->getCollection()->getName(), $document_log->getDocumentId(), $response->status_code, $response->body);

            $content = [
                'document' => $document,
                'response' => [
                    'status_code' => $response->status_code,
                    'body' => $response->body,
                ],
            ];

            $document_log_domain->respondProvider($document_log);

            $webhook_response = $provider->responseWebhook($document_log, $document['webhook'], $content);

            if ($webhook_response->status_code < 500) {
                $document_log_domain->saveStatus($document_log, DocumentLogTableMap::COL_STATUS_SUCCESS);
            } else {
                $document_log_domain->saveStatus($document_log, DocumentLogTableMap::COL_STATUS_WEBHOOK_NO_RESPONSE);
            }
        }
    }
}
