<?php

return [
    'propel' => [
        'database' => [
            'connections' => [
                'box' => [
                    'adapter' => 'pgsql',
                    'dsn' => 'pgsql:host=db;port=5432;dbname=box',
                    'user' => 'postgres',
                    'password' => 'postgres',
                    'settings' => [
                        'charset' => 'utf8',
                        'queries' => [
                            'utf8' => "SET NAMES 'UTF8'"
                        ]
                    ],
                    'attributes' => []
                ]
            ]
        ],
        'runtime' => [
            'defaultConnection' => 'box',
            'connections' => ['box']
        ],
        'generator' => [
            'defaultConnection' => 'box',
            'connections' => ['box']
        ]
    ]
];
