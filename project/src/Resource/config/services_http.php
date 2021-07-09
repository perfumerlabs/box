<?php

return [
    'fast_router' => [
        'shared' => true,
        'init' => function(\Perfumer\Component\Container\Container $container) {
            return \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) {
                $r->addRoute('GET', '/clients', 'clients.get');
                $r->addRoute('GET', '/client', 'client.get');
                $r->addRoute('POST', '/client', 'client.post');
                $r->addRoute('PATCH', '/client', 'client.patch');

                $r->addRoute('GET', '/collections', 'collections.get');
                $r->addRoute('GET', '/collection', 'collection.get');
                $r->addRoute('POST', '/collection', 'collection.post');
                $r->addRoute('PATCH', '/collection', 'collection.patch');

                $r->addRoute('GET', '/access', 'access.get');
                $r->addRoute('GET', '/accesses', 'accesses.get');
                $r->addRoute('POST', '/access', 'access.post');
                $r->addRoute('DELETE', '/access', 'access.delete');

                $r->addRoute('GET', '/document', 'document.get');
                $r->addRoute('POST', '/document', 'document.post');
                $r->addRoute('GET', '/documents', 'documents.get');
                $r->addRoute('GET', '/documents/count', 'documents/count.get');

                $r->addRoute('GET', '/document/log', 'document/log.get');
                $r->addRoute('GET', '/document/logs', 'document/logs.get');

                $r->addRoute('POST', '/mock', 'mock.post');
                $r->addRoute('ACTION', '/async', 'async.action');
            });
        }
    ],

    'box.router' => [
        'shared' => true,
        'class' => 'Perfumer\\Framework\\Router\\Http\\FastRouteRouter',
        'arguments' => ['#gateway.http', '#fast_router', [
            'data_type' => 'json',
            'allowed_actions' => ['get', 'post', 'delete', 'patch', 'action'],
        ]]
    ],

    'box.request' => [
        'class' => 'Perfumer\\Framework\\Proxy\\Request',
        'arguments' => ['$0', '$1', '$2', '$3', [
            'prefix' => 'Box\\Controller',
            'suffix' => 'Controller'
        ]]
    ]
];
