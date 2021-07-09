<?php

namespace Box\Domain;

use Box\Model\DocumentLog;
use Box\Model\RequestLog;

class RequestLogDomain
{
    public function create(DocumentLog $document_log, $data): ?RequestLog
    {
        $request_headers = $data['request_headers'] ?? null;
        $request_body = $data['request_body'] ?? null;
        $request_url = $data['request_url'] ?? null;
        $request_method = $data['request_method'] ?? null;
        $response_status_code = $data['response_status_code'] ?? null;
        $response_headers = $data['response_headers'] ?? null;
        $response_body = $data['response_body'] ?? null;
        $response_error = $data['response_error'] ?? null;
        $type = $data['type'] ?? null;

        $request_body = is_string($request_body) || $request_body === null ? $request_body : json_encode($request_body);
        $request_headers = is_string($request_headers) || $request_headers === null ? $request_headers : json_encode($request_headers);
        $response_headers = is_string($response_headers) || $response_headers === null ? $response_headers : json_encode($response_headers);
        $response_body = is_string($response_body) || $response_body === null ? $response_body : json_encode($response_body);

        $obj = new RequestLog();
        $obj->setType($type);
        $obj->setDocumentLog($document_log);
        $obj->setRequestUrl($request_url);
        $obj->setRequestMethod($request_method);
        $obj->setRequestHeaders($request_headers);
        $obj->setRequestBody($request_body);
        $obj->setResponseStatusCode($response_status_code);
        $obj->setResponseHeaders($response_headers);
        $obj->setResponseBody($response_body);
        $obj->setResponseError($response_error);
        $obj->save();

        return $obj;
    }

    public function update(RequestLog $obj, $data): RequestLog
    {
        if (array_key_exists('request_headers', $data)) {
            $request_headers = $data['request_headers'];

            if (!is_string($request_headers) && $request_headers !== null) {
                $request_headers = json_encode($request_headers);
            }

            $obj->setRequestHeaders($request_headers);
        }

        if (array_key_exists('request_body', $data)) {
            $request_body = $data['request_body'];

            if (!is_string($request_body) && $request_body !== null) {
                $request_body = json_encode($request_body);
            }

            $obj->setRequestBody($request_body);
        }

        if (array_key_exists('request_url', $data)) {
            $obj->setRequestUrl($data['request_url']);
        }

        if (array_key_exists('request_method', $data)) {
            $obj->setRequestMethod($data['request_method']);
        }

        if (array_key_exists('response_status_code', $data)) {
            $obj->setResponseStatusCode($data['response_status_code']);
        }

        if (array_key_exists('response_headers', $data)) {
            $response_headers = $data['response_headers'];

            if (!is_string($response_headers) && $response_headers !== null) {
                $response_headers = json_encode($response_headers);
            }

            $obj->setResponseHeaders($response_headers);
        }

        if (array_key_exists('response_body', $data)) {
            $response_body = $data['response_body'];

            if (!is_string($response_body) && $response_body !== null) {
                $response_body = json_encode($response_body);
            }

            $obj->setResponseBody($response_body);
        }

        if (array_key_exists('response_error', $data)) {
            $obj->setResponseError($data['response_error']);
        }

        $obj->save();

        return $obj;
    }
}