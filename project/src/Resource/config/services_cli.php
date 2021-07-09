<?php

return [
    'box.request' => [
        'class' => 'Perfumer\\Framework\\Proxy\\Request',
        'arguments' => ['$0', '$1', '$2', '$3', [
            'prefix' => 'Box\\Command',
            'suffix' => 'Command'
        ]]
    ]
];
