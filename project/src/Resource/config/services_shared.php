<?php

return [
    'gateway' => [
        'shared' => true,
        'class' => 'Project\\Gateway',
        'arguments' => ['#application', '#gateway.http', '#gateway.console']
    ],

    'database' => [
        'shared' => true,
        'class' => 'Box\\Service\\Database',
        'arguments' => [
            '@pg/database',
            '@pg/schema',
            '@pg/host',
            '@pg/port',
            '@pg/user',
            '@pg/password',
            '@box/fetch_limit',
        ]
    ],

    'provider' => [
        'shared' => true,
        'class' => 'Box\\Service\\Provider',
        'arguments' => ['#domain.request_log']
    ],

    'queue' => [
        'shared' => true,
        'class' => 'Box\\Service\\Queue',
        'arguments' => [
            '@box/queue_back_url',
            '@box/queue_url',
            '@box/queue_worker',
        ]
    ],

    'facade.collection' => [
        'shared' => true,
        'class' => 'Box\\Facade\\CollectionFacade',
        'arguments' => [
            '#database',
            '#domain.collection',
            '#repository.collection',
            '@box/is_system',
        ]
    ],

    'facade.client' => [
        'shared' => true,
        'class' => 'Box\\Facade\\ClientFacade',
        'arguments' => [
            '#database',
            '#domain.client',
            '#repository.client',
            '@box/is_system',
        ]
    ],

    'facade.access' => [
        'shared' => true,
        'class' => 'Box\\Facade\\AccessFacade',
        'arguments' => [
            '#database',
            '#domain.access',
            '#repository.access',
            '@box/is_system',
        ]
    ],

    'domain.client' => [
        'shared' => true,
        'class' => 'Box\\Domain\\ClientDomain',
    ],

    'domain.collection' => [
        'shared' => true,
        'class' => 'Box\\Domain\\CollectionDomain',
    ],

    'domain.access' => [
        'shared' => true,
        'class' => 'Box\\Domain\\AccessDomain',
    ],

    'domain.document_log' => [
        'shared' => true,
        'class' => 'Box\\Domain\\DocumentLogDomain',
    ],

    'domain.request_log' => [
        'shared' => true,
        'class' => 'Box\\Domain\\RequestLogDomain',
    ],

    'repository.collection' => [
        'shared' => true,
        'class' => 'Box\\Repository\\CollectionRepository',
    ],

    'repository.client' => [
        'shared' => true,
        'class' => 'Box\\Repository\\ClientRepository',
    ],

    'repository.access' => [
        'shared' => true,
        'class' => 'Box\\Repository\\AccessRepository',
        'arguments' => ['#repository.collection', '#repository.client'],
    ],

    'repository.document_log' => [
        'shared' => true,
        'class' => 'Box\\Repository\\DocumentLogRepository',
        'arguments' => ['#repository.collection', '#repository.client'],
    ],

    'propel.connection_manager' => [
        'init' => function(\Perfumer\Component\Container\Container $container) {
            $dsn_slaves = $container->getParam('db/slaves');

            if ($dsn_slaves) {
                return $container->get('propel.connection_manager_master_slave');
            } else {
                return $container->get('propel.connection_manager_single');
            }
        }
    ],

    'propel.connection_manager_single' => [
        'class' => 'Propel\\Runtime\\Connection\\ConnectionManagerSingle',
        'after' => function(\Perfumer\Component\Container\Container $container, \Propel\Runtime\Connection\ConnectionManagerSingle $connection_manager) {
            $configuration = [
                'dsn' => $container->getParam('propel/dsn'),
                'user' => $container->getParam('propel/db_user'),
                'password' => $container->getParam('propel/db_password'),
                'settings' => [
                    'charset' => 'utf8',
                ]
            ];

            $schema = $container->getParam('propel/db_schema');

            if ($schema !== 'public' && $schema !== null) {
                $configuration['settings']['queries'] = [
                    'schema' => "SET search_path TO " . $schema
                ];
            }

            $connection_manager->setConfiguration($configuration);
        }
    ],

    'propel.connection_manager_master_slave' => [
        'class' => 'Propel\\Runtime\\Connection\\ConnectionManagerMasterSlave',
        'after' => function(\Perfumer\Component\Container\Container $container, \Propel\Runtime\Connection\ConnectionManagerMasterSlave $connection_manager) {
            $dsn_master = $container->getParam('propel/dsn');
            $dsn_slaves = $container->getParam('db/slaves');
            $user = $container->getParam('propel/db_user');
            $password = $container->getParam('propel/db_password');
            $schema = $container->getParam('propel/db_schema');

            $default_connection = [
                'user' => $user,
                'password' => $password,
                'settings' => [
                    'charset' => 'utf8',
                ]
            ];

            if ($schema !== 'public' && $schema !== null) {
                $default_connection['settings']['queries'] = [
                    'schema' => "SET search_path TO " . $schema
                ];
            }

            $write_configuration = $default_connection;
            $write_configuration['dsn'] = $dsn_master;

            $connection_manager->setWriteConfiguration($write_configuration);

            if ($dsn_slaves) {
                $connections = [];

                if (is_string($dsn_slaves)) {
                    $dsn_slaves = explode(',', $dsn_slaves);
                }

                foreach ($dsn_slaves as $dsn_slave) {
                    $read_configuration = $default_connection;
                    $read_configuration['dsn'] = $dsn_slave;

                    $connections[] = $read_configuration;
                }

                if ($connections) {
                    $connection_manager->setReadConfiguration($connections);
                }
            }
        }
    ],
];
