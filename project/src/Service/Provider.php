<?php

namespace Box\Service;

use Box\Domain\RequestLogDomain;
use Box\Model\DocumentLog;
use GuzzleHttp\Exception\RequestException;

class Provider
{
    /**
     * @var RequestLogDomain
     */
    private $request_log_domain;

    public function __construct(RequestLogDomain $request_log_domain)
    {
        $this->request_log_domain = $request_log_domain;
    }

    public function request(DocumentLog $document_log, $data): ProviderResponse
    {
        $provider_response = new ProviderResponse();

        $url = $document_log->getCollection()->getHandler();

        $json = [
            'event' => $document_log->getEvent(),
            'data' => $data,
        ];

        $request_log = $this->request_log_domain->create($document_log, [
            'request_url' => $url,
            'request_body' => $json,
            'request_method' => 'post',
            'type' => 'provider',
        ]);

        try {
            $options = [
                'connect_timeout' => 20,
                'read_timeout' => 20,
                'timeout' => 20,
                'debug' => false,
                'json' => $json,
            ];

            $client = new \GuzzleHttp\Client();

            $response = $client->request('post', $url, $options);

            $provider_response->body = $response->getBody()->getContents();
            $provider_response->status_code = $response->getStatusCode();

            $this->request_log_domain->update($request_log, [
                'response_status_code' => $response->getStatusCode(),
                'response_headers' => $response->getHeaders(),
                'response_body' => $provider_response->body,
            ]);
        } catch (RequestException $e) {
            $response = $e->getResponse();

            $provider_response->body = $response->getBody()->getContents();
            $provider_response->status_code = $response->getStatusCode();

            $this->request_log_domain->update($request_log, [
                'response_status_code' => $response->getStatusCode(),
                'response_headers' => $response->getHeaders(),
                'response_body' => $response->getBody()->getContents(),
                'response_error' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            $provider_response->status_code = 502;

            $this->request_log_domain->update($request_log, [
                'response_status_code' => 502,
                'response_error' => $e->getMessage(),
            ]);
        }

        return $provider_response;
    }

    public function responseWebhook(DocumentLog $document_log, $webhook, $data): ProviderResponse
    {
        $provider_response = new ProviderResponse();

        $document_log->setWebhookRequestedAt(new \DateTime());
        $document_log->save();

        $request_log = $this->request_log_domain->create($document_log, [
            'request_url' => $webhook,
            'request_body' => $data,
            'request_method' => 'post',
            'type' => 'webhook',
        ]);

        try {
            $options = [
                'connect_timeout' => 20,
                'read_timeout' => 20,
                'timeout' => 20,
                'debug' => false,
                'json' => $data,
            ];

            $client = new \GuzzleHttp\Client();
            $response = $client->request('post', $webhook, $options);

            $provider_response->body = $response->getBody()->getContents();
            $provider_response->status_code = $response->getStatusCode();

            $this->request_log_domain->update($request_log, [
                'response_status_code' => $response->getStatusCode(),
                'response_headers' => $response->getHeaders(),
                'response_body' => $provider_response->body,
            ]);
        } catch (RequestException $e) {
            $response = $e->getResponse();

            $provider_response->body = $response->getBody()->getContents();
            $provider_response->status_code = $response->getStatusCode();

            $this->request_log_domain->update($request_log, [
                'response_status_code' => $response->getStatusCode(),
                'response_headers' => $response->getHeaders(),
                'response_body' => $response->getBody()->getContents(),
                'response_error' => $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            $provider_response->status_code = 502;

            $this->request_log_domain->update($request_log, [
                'response_status_code' => 502,
                'response_error' => $e->getMessage(),
            ]);
        }

        return $provider_response;
    }
}