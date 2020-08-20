<?php

namespace Box\Module;

use Perfumer\Framework\Controller\Module;

class CommandModule extends Module
{
    public $name = 'box';

    public $router = 'router.console';

    public $request = 'box.request';
}