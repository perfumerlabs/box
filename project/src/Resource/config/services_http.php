<?php

return [
    'fast_router' => [
        'shared' => true,
        'init' => function(\Perfumer\Component\Container\Container $container) {
            return \FastRoute\simpleDispatcher(function(\FastRoute\RouteCollector $r) {
                $r->addRoute('POST', '/collection', 'collection.post');
                $r->addRoute('POST', '/document', 'document.post');
                $r->addRoute('GET', '/documents', 'documents.get');
                $r->addRoute('GET', '/documents/count', 'documents/count.get');
            });
        }
    ],

    'box.router' => [
        'shared' => true,
        'class' => 'Perfumer\\Framework\\Router\\Http\\FastRouteRouter',
        'arguments' => ['#gateway.http', '#fast_router', [
            'data_type' => 'json',
            'allowed_actions' => ['get', 'post', 'delete', 'patch'],
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
