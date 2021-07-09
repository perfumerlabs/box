<?php

namespace Box\Command;

use Box\Domain\DocumentLogDomain;
use Box\Model\DocumentLogQuery;
use Box\Model\Map\DocumentLogTableMap;
use Box\Service\Queue;
use Perfumer\Framework\Controller\PlainController;
use Propel\Runtime\ActiveQuery\Criteria;

class ProviderCommand extends PlainController
{
    /**
     * команда переотправляет документы на асинхронного провайдера, если провайдер не отвечает
     */
    public function action()
    {
        /** @var DocumentLogDomain $document_log_domain */
        $document_log_domain = $this->s('domain.document_log');

        /** @var Queue $queue */
        $queue = $this->s('queue');

        while (true) {
            $document_logs = DocumentLogQuery::create()
                ->joinWithCollection()
                ->filterByProviderRequestedAt(null, Criteria::ISNULL)
                ->_or()
                ->filterByProviderRequestedAt((new \DateTime())->modify('-5 min'), Criteria::LESS_THAN)
                ->filterByStatus(DocumentLogTableMap::COL_STATUS_WAITING)
                ->limit(100)
                ->find();

            foreach ($document_logs as $document_log) {
                $collection = $document_log->getCollection();

                if (!$collection->isAsync()) {
                    $document_log_domain->saveStatus($document_log, DocumentLogTableMap::COL_STATUS_UNEXPECTED);
                    continue;
                }

                if (
                    $document_log->getCreatedAt() &&
                    $document_log->getCreatedAt() < (new \DateTime())->modify('-1 day')
                ) {
                    $document_log_domain->saveStatus($document_log, DocumentLogTableMap::COL_STATUS_PROVIDER_FAILED);
                    continue;
                }

                $document_log_domain->requestProvider($document_log);

                $queue->sendAsyncRequest($document_log);
            }

            sleep(10);
        }
    }
}
