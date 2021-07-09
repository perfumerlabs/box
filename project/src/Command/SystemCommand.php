<?php

namespace Box\Command;

use Box\Domain\AccessDomain;
use Box\Domain\ClientDomain;
use Box\Domain\CollectionDomain;
use Box\Service\Database;
use Perfumer\Component\Container\Storage\DatabaseStorage;
use Perfumer\Framework\Controller\PlainController;
use Perfumer\Microservices\Box\Box;
use Perfumer\Microservices\Box\Request\Documents\GetDocumentsRequest;

class SystemCommand extends PlainController
{
    /**
     * команда забирает лог измнений на другом инстансе box и накатывает себе
     */
    public function action()
    {
        /** @var DatabaseStorage $storage */
        $storage = $this->getContainer()->getStorage('database');

        $admin_secret = $this->getContainer()->getParam('box/admin_secret');
        $instances = $this->getContainer()->getParam('box/instances');
        $system = $this->getContainer()->getParam('box/is_system');

        if (is_string($instances)) {
            $instances = explode(',', $instances);
        }

        /** @var Database $database */
        $database = $this->s('database');

        /** @var CollectionDomain $collection_domain */
        $collection_domain = $this->s('domain.collection');

        /** @var ClientDomain $client_domain */
        $client_domain = $this->s('domain.client');

        /** @var AccessDomain $access_domain */
        $access_domain = $this->s('domain.access');

        $con = $database->getPdo();

        while (true) {
            if (count($instances) === 0 || $system !== true) {
                sleep(86400);
            }

            foreach ($instances as $instance) {
                $storage->flush();

                $last_id = $storage->getParam($instance, 'system_last_id');

                if (!$last_id) {
                    $last_id = 0;
                }

                $box = new Box($instance, $admin_secret);

                $request = new GetDocumentsRequest();
                $request->collection = 'system';
                $request->id = $last_id;

                $response = $box->getDocuments($request);

                if ($response->_http_status_code === 200) {
                    $documents = $response->documents;

                    foreach ($documents as $document) {
                        $event = $document['event'] ?? null;
                        $id = $document['id'] ?? null;

                        $con->beginTransaction();

                        $processed = false;

                        try {
                            switch ($event) {
                                case 'collection.create':
                                    $data = $document['data'];
                                    $collection_name = $data['name'] ?? null;
                                    $collection_type = $data['type'] ?? null;

                                    if ($collection_name && $collection_type) {
                                        $created = $database->createTable($collection_name);

                                        if ($created) {
                                            $collection_domain->upsert($data);

                                            $processed = true;
                                        }
                                    }
                                    break;
                                case 'collection.update':
                                    $data = $document['data'];
                                    $collection_name = $data['name'] ?? null;
                                    $collection_type = $data['type'] ?? null;

                                    if ($collection_name && $collection_type) {
                                        $collection_domain->upsert($data);

                                        $processed = true;
                                    }
                                    break;
                                case 'client.create':
                                    $data = $document['data'];
                                    $client_name = $data['name'] ?? null;
                                    $client_secret = $data['secret'] ?? null;

                                    if ($client_name && $client_secret) {
                                        $client_domain->upsert($data);

                                        $processed = true;
                                    }
                                    break;
                                case 'client.update':
                                    $data = $document['data'];
                                    $client_name = $data['name'] ?? null;

                                    if ($client_name) {
                                        $client_domain->upsert($data);

                                        $processed = true;
                                    }
                                    break;
                                case 'access.create':
                                    $data = $document['data'];
                                    $access_client = $data['client'] ?? null;
                                    $access_collection = $data['collection'] ?? null;
                                    $access_level = $data['level'] ?? null;

                                    if ($access_client && $access_collection && $access_level) {
                                        $access_domain->create($access_collection, $access_client, $access_level);

                                        $processed = true;
                                    }
                                    break;
                                case 'access.delete':
                                    $data = $document['data'];
                                    $access_client = $data['client'] ?? null;
                                    $access_collection = $data['collection'] ?? null;

                                    if ($access_client && $access_collection) {
                                        $access_domain->deleteByNames($access_collection, $access_client);

                                        $processed = true;
                                    }
                                    break;
                                default:
                                    break;
                            }

                            if (!$processed) {
                                break;
                            } else {
                                $storage->saveParam($instance, 'system_last_id', $id);
                            }

                            $con->commit();
                        } catch (\Throwable $e) {
                            $con->rollBack();

                            error_log($e);
                        }
                    }
                }
            }

            sleep(3);
        }
    }
}
