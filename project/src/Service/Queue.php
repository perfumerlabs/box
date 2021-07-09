<?php

namespace Box\Service;

use Box\Model\DocumentLog;
use GuzzleHttp\Client;

class Queue
{
    private $queue_url;

    private $back_url;

    private $worker;

    public function __construct(
        $back_url,
        $queue_url,
        $worker
    )
    {
        $this->queue_url = $queue_url;
        $this->back_url = $back_url;
        $this->worker = $worker;
    }

    public function sendAsyncRequest(DocumentLog $document_log): ProviderResponse
    {
        $provider_response = new ProviderResponse();

        try {
            $client = new Client();
            $client->post($this->queue_url . '/task',
                [
                    'connect_timeout' => 15,
                    'read_timeout'    => 15,
                    'timeout'         => 15,
                    'json' => [
                        'url' => sprintf('%s/async', $this->back_url),
                        'method' => 'action',
                        'worker' => $this->worker,
                        'json' => [
                            'id' => $document_log->getId()
                        ]
                    ]
                ]
            );
        } catch (\Exception $e) {
            throw $e;
        }

        return $provider_response;
    }
}