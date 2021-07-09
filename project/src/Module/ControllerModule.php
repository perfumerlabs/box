<?php

namespace Box\Module;

use Perfumer\Framework\Controller\Module;

class ControllerModule extends Module
{
    public $name = 'box';

    public $router = 'box.router';

    public $request = 'box.request';

    public $components = [
        'view' => 'view.status'
    ];
}