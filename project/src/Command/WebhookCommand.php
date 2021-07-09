<?php

namespace Box\Command;

use Box\Domain\DocumentLogDomain;
use Box\Model\DocumentLogQuery;
use Box\Model\Map\DocumentLogTableMap;
use Box\Service\Database;
use Box\Service\Provider;
use Box\Service\Queue;
use Perfumer\Framework\Controller\PlainController;
use Propel\Runtime\ActiveQuery\Criteria;

class WebhookCommand extends PlainController
{
    /**
     * команда переотправляет документы на вебхуки
     */
    public function action()
    {
        /** @var DocumentLogDomain $document_log_domain */
        $document_log_domain = $this->s('domain.document_log');

        /** @var Queue $queue */
        $queue = $this->s('queue');

        /** @var Provider $provider */
        $provider = $this->s('provider');

        /** @var Database $database */
        $database = $this->s('database');

        while (true) {
            $document_logs = DocumentLogQuery::create()
                ->joinWithCollection()
                ->filterByWebhookRequestedAt(null, Criteria::ISNULL)
                ->_or()
                ->filterByWebhookRequestedAt((new \DateTime())->modify('-5 min'), Criteria::LESS_THAN)
                ->filterByStatus(DocumentLogTableMap::COL_STATUS_WEBHOOK_NO_RESPONSE)
                ->limit(100)
                ->find();

            foreach ($document_logs as $document_log) {
                $collection = $document_log->getCollection();

                if (!$collection->isAsync()) {
                    $document_log_domain->saveStatus($document_log, DocumentLogTableMap::COL_STATUS_UNEXPECTED);
                    continue;
                }
                if (
                    $document_log->getProviderRespondAt() &&
                    $document_log->getProviderRespondAt() < (new \DateTime())->modify('-1 day')
                ) {
                    $document_log_domain->saveStatus($document_log, DocumentLogTableMap::COL_STATUS_WEBHOOK_FAILED);
                    continue;
                }

                $document_log_domain->requestWebhook($document_log);

                $document = $database->getDocument($document_log->getCollection()->getName(), $document_log->getDocumentId());

                if (!$document) {
                    $document_log_domain->saveStatus($document_log, DocumentLogTableMap::COL_STATUS_DOCUMENT_NOT_FOUND);
                    continue;
                }

                if ($document['response_status_code'] < 500) {
                    $content = [
                        'document' => $document,
                        'response' => [
                            'status_code' => $document['response_status_code'],
                            'body' => $document['response_body'],
                        ],
                    ];

                    $webhook_response = $provider->responseWebhook($document_log, $document['webhook'], $content);

                    if ($webhook_response->status_code < 500) {
                        $document_log_domain->saveStatus($document_log, DocumentLogTableMap::COL_STATUS_SUCCESS);
                    } else {
                        $document_log_domain->saveStatus($document_log, DocumentLogTableMap::COL_STATUS_WEBHOOK_NO_RESPONSE);
                    }
                } else {
                    $queue->sendAsyncRequest($document_log);
                }
            }

            sleep(10);
        }
    }
}
