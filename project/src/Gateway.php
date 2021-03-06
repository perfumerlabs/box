<?php

namespace Project;

use Perfumer\Framework\Gateway\CompositeGateway;

class Gateway extends CompositeGateway
{
    protected function configure(): void
    {
        $this->addModule('box', null,  null, 'http');
        $this->addModule('box', 'box', null, 'cli');
    }
}
