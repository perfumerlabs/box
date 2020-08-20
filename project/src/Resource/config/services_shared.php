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
            '@database/db',
            '@database/host',
            '@database/port',
            '@database/username',
            '@database/password',
            '@box/fetch_limit',
        ]
    ]
];